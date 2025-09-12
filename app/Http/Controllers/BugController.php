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
        // Only QA can access for now
        if (Auth::user()->role !== 'QA') {
            abort(403);
        }
        $bugs = Bug::with('assignedTo')->where('created_by', Auth::id())->get();
        return view('bugs.index', compact('bugs'));
    }
    // Add relationship for assignedTo in Bug model

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only QA can access
        if (Auth::user()->role !== 'QA') {
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
        // Only QA can create
        if (Auth::user()->role !== 'QA') {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            'assigned_to' => 'required|exists:users,id',
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
        ]);

        // TODO: Notify assigned Dev (email/notification)

        return redirect()->route('bugs.index')->with('success', 'Bug created and assigned to developer.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bug $bug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bug $bug)
    {
        $user = Auth::user();
        // Only assigned Dev or QA can edit
        if ($user->role === 'Dev') {
            if ($bug->assigned_to !== $user->id) abort(403);
        } elseif ($user->role === 'QA') {
            // Allow QA to edit file if they created the bug
            if ($bug->created_by !== $user->id) abort(403);
        } else {
            abort(403);
        }
        // For QA, allow edit file if ?editfile=1
        return view('bugs.edit', compact('bug'));
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
                'status' => 'required|in:inprogress,review',
            ]);
            $bug->status = $request->status;
            $bug->save();
            return redirect()->route('dev.dashboard')->with('success', 'Bug status updated.');
        } elseif ($user->role === 'QA') {
            // Only QA who created can update file
            if ($bug->created_by !== $user->id) abort(403);
            if ($request->hasFile('attachment')) {
                $request->validate([
                    'attachment' => 'file|mimes:png,jpg,jpeg,pdf|max:2048',
                ]);
                $path = $request->file('attachment')->store('attachments', 'public');
                $bug->attachment = $path;
                $bug->save();
            }
            return redirect()->route('bugs.index')->with('success', 'File updated.');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bug $bug)
    {
        //
    }
}
