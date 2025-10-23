<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BugController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // QA sees only their created bugs; Admin sees all
        $user = Auth::user();
        if (!in_array($user->role, ['QA', 'Admin'])) {
            abort(403);
        }
        if ($user->role === 'Admin') {
            $bugs = Bug::with('assignedTo')->latest()->get();
        } else {
            $bugs = Bug::with('assignedTo')->where('created_by', $user->id)->latest()->get();
        }
        return view('bugs.index', compact('bugs'));
    }
    // Add relationship for assignedTo in Bug model

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // QA or Admin can access create form
        if (!in_array(Auth::user()->role, ['QA', 'Admin'])) {
            abort(403);
        }
        $devs = User::where('role', 'Dev')->get();
        return view('bugs.create', compact('devs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // QA or Admin can create
        if (!in_array(Auth::user()->role, ['QA', 'Admin'])) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            'assigned_to' => 'required|exists:users,id',
            'severity' => 'nullable|in:low,medium,high',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $bug = Bug::create([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $path,
            'created_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
            'status' => 'open',
            'severity' => $request->input('severity', 'low'),
        ]);

        // TODO: Notify assigned Dev (email/notification)

        // Redirect to bugs index (admin dashboard removed)
        return redirect()->route('bugs.index')->with('success', 'Bug created and assigned to developer.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bug $bug)
    {
        // Show the bug details page
        return view('bugs.show', compact('bug'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bug $bug)
    {
        $user = Auth::user();
        // Only assigned Dev, QA creator, or Admin can edit
        if ($user->role === 'Dev') {
            if ($bug->assigned_to !== $user->id) abort(403);
        } elseif ($user->role === 'QA') {
            if ($bug->created_by !== $user->id) abort(403);
        } elseif ($user->role === 'Admin') {
            // Admin can edit any bug
        } else {
            abort(403);
        }
        $devs = User::where('role', 'Dev')->get();
        return view('bugs.edit', compact('bug', 'devs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bug $bug)
    {
        $user = Auth::user();
        if ($user->role === 'Dev') {
            // Only assigned Dev can update status
            if ($bug->assigned_to !== $user->id) abort(403);
            $request->validate([
                'status' => 'required|in:inprogress,review,done',
            ]);
            $bug->status = $request->status;
            $bug->save();
            return redirect()->route('dev.dashboard')->with('success', 'Bug status updated.');
        } elseif ($user->role === 'QA') {
            // Only QA who created can update their own bug
            if ($bug->created_by !== $user->id) abort(403);
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:inprogress,review,done',
                'severity' => 'nullable|in:low,medium,high',
                'attachment' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);
            $bug->title = $validated['title'];
            $bug->description = $validated['description'] ?? '';
            $bug->status = $validated['status'];
            if (!empty($validated['severity'])) {
                $bug->severity = $validated['severity'];
            }
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments', 'public');
                $bug->attachment = $path;
            }
            $bug->save();
            return redirect()->route('bugs.index')->with('success', 'Bug updated.');
        } elseif ($user->role === 'Admin') {
            // Admin can change assigned developer
            $request->validate([
                'assigned_to' => 'required|exists:users,id',
            ]);
            $bug->assigned_to = $request->assigned_to;
            $bug->save();
            return redirect()->route('bugs.index')->with('success', 'Assigned developer updated.');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bug $bug)
    {
        $user = Auth::user();
        // Only QA who created the bug or Admin can delete
        if (!($user->role === 'QA' && $bug->created_by === $user->id) && $user->role !== 'Admin') {
            abort(403);
        }
        $bug->delete();
        return redirect()->route('bugs.index')->with('success', 'Bug deleted successfully.');
    }

    /**
     * Admin assigns/unassigns Developer and/or QA to a bug.
     */
    public function adminAssign(Request $request, Bug $bug)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'Admin') {
            abort(403);
        }

        $validated = $request->validate([
            'developer_id' => 'nullable|exists:users,id',
            'qa_id' => 'nullable|exists:users,id',
        ]);

        // Update developer assignment
        if ($request->has('developer_id')) {
            $bug->assigned_to = $validated['developer_id'] ?: null;
            if (!empty($validated['developer_id'])) {
                // Move to in progress when a developer is assigned
                if (!in_array($bug->status, ['inprogress', 'in_progress', 'review', 'done', 'completed'])) {
                    $bug->status = 'inprogress';
                }
            }
        }

        // Update QA reviewer assignment
        if ($request->has('qa_id')) {
            // Column reviewed_by used in codebase
            $bug->reviewed_by = $validated['qa_id'] ?: null;
        }

        $bug->save();

        return redirect()->route('admin.dashboard')->with('success', 'Assignment updated.');
    }
}
