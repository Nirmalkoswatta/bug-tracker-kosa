<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bug;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'Admin') {
            abort(403);
        }

        // Basic metrics
        $totalBugs = Bug::count();
        $openBugs = Bug::where('status','open')->count();
    $inProgressBugs = Bug::where('status','inprogress')->count();
    $doneBugs = Bug::where('status','done')->count();

        // Team collections
        $developers = User::where('role','Dev')->get();
        $qas = User::where('role','QA')->get();
        $pms = User::where('role','PM')->get();

        // All bugs for frontend table (if dataset becomes large, reintroduce pagination with API)
        $allBugs = Bug::with(['assignedTo','creator'])->latest()->get();

        // Lightweight array consumed by Alpine
        $bugsSample = $allBugs->map(function($b){
            return [
                'id' => $b->id,
                'title' => $b->title,
                'status' => $b->status,
                'assigned' => optional($b->assignedTo)->name ?? '—',
                'creator' => optional($b->creator)->name ?? '—',
                'attachment' => (bool)$b->attachment,
            ];
        });

        return view('admin.dashboard', compact(
            'totalBugs','openBugs','inProgressBugs','doneBugs','developers','qas','pms','bugsSample'
        ));
    }

    public function exportCsv(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'Admin') abort(403);
        $bugs = Bug::with(['assignedTo','creator'])->get();
        $filename = 'bugs-export-'.now()->format('Ymd-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($bugs) {
            $out = fopen('php://output','w');
            fputcsv($out, ['ID','Title','Status','Assigned Dev','Creator','Has Attachment']);
            foreach ($bugs as $b) {
                fputcsv($out, [
                    $b->id,
                    $b->title,
                    $b->status,
                    optional($b->assignedTo)->name,
                    optional($b->creator)->name,
                    $b->attachment? 'Yes':'No'
                ]);
            }
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }
}
