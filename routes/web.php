<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use App\Http\Controllers\AdminController; // Removed with admin dashboard deletion
use App\Http\Controllers\BugController;
use App\Http\Controllers\AdminUserController;
use App\Models\Bug;

/* Admin routes removed */

// Secure download route for bug attachments
Route::get('/bugs/{bug}/download', function (App\Models\Bug $bug) {
    $user = Auth::user();
    // Only assigned Dev or QA creator can download
    if (
        ($user->role === 'Dev' && $bug->assigned_to === $user->id) ||
        ($user->role === 'QA' && $bug->created_by === $user->id)
    ) {
        if ($bug->attachment && Storage::disk('public')->exists($bug->attachment)) {
            $path = Storage::disk('public')->path($bug->attachment);
            return response()->download($path);
        } else {
            abort(404, 'File not found.');
        }
    }
    abort(403);
})->middleware('auth')->name('bugs.download');
// Developer: Edit Bug (Update Status)
Route::get('/dev/bugs/{bug}/edit', [App\Http\Controllers\BugController::class, 'edit'])
    ->middleware('auth')
    ->name('dev.bugs.edit');

// Admin toggle route removed

// Developer Dashboard
Route::get('/dev-dashboard', function () {
    if (!Auth::check() || Auth::user()->role !== 'Dev') abort(403);
    $bugs = Bug::where('assigned_to', Auth::id())->get();
    return view('dev-dashboard', compact('bugs'));
})->middleware('auth')->name('dev.dashboard');

// Admin Dashboard (new) — view only; actions occur in resource controllers
Route::get('/admin-dashboard', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    // Minimal data sample; wire real data as needed
    $metrics = [
        'open' => \App\Models\Bug::where('status', 'open')->count(),
        'assigned' => \App\Models\Bug::whereNotNull('assigned_to')->count(),
        'in_qa' => \App\Models\Bug::whereIn('status', ['in_progress', 'review', 'inprogress'])->count(),
        'resolved' => \App\Models\Bug::whereIn('status', ['done', 'completed'])->count(),
    ];
    $projects = collect();
    $bugs = \App\Models\Bug::with(['assignedTo', 'creator'])->latest()->limit(25)->get();
    $developers = \App\Models\User::where('role', 'Dev')->get();
    $qas = \App\Models\User::where('role', 'QA')->get();
    $pms = \App\Models\User::where('role', 'PM')->get();
    return view('admin.dashboard', compact('metrics', 'projects', 'bugs', 'developers', 'qas', 'pms'));
})->middleware('auth')->name('admin.dashboard');

// Admin: Assign QA/Dev to bug
Route::post('/admin/bugs/{bug}/assign', [BugController::class, 'adminAssign'])
    ->middleware('auth')
    ->name('admin.bugs.assign');

// Admin multi-page navigation
Route::get('/admin/overview', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $metrics = [
        'open' => \App\Models\Bug::where('status', 'open')->count(),
        'assigned' => \App\Models\Bug::whereNotNull('assigned_to')->count(),
        'in_qa' => \App\Models\Bug::whereIn('status', ['in_progress', 'review', 'inprogress'])->count(),
        'resolved' => \App\Models\Bug::whereIn('status', ['done', 'completed'])->count(),
    ];
    $developers = \App\Models\User::where('role', 'Dev')->get();
    $qas = \App\Models\User::where('role', 'QA')->get();
    $pms = \App\Models\User::where('role', 'PM')->get();
    return view('admin.overview', compact('metrics', 'developers', 'qas', 'pms'));
})->middleware('auth')->name('admin.overview');

Route::get('/admin/projects', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $projects = collect();
    return view('admin.projects', compact('projects'));
})->middleware('auth')->name('admin.projects');

Route::get('/admin/bugs', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $bugs = \App\Models\Bug::with(['assignedTo', 'creator'])->latest()->paginate(10);
    $developers = \App\Models\User::where('role', 'Dev')->get();
    $qas = \App\Models\User::where('role', 'QA')->get();
    return view('admin.bugs', compact('bugs', 'developers', 'qas'));
})->middleware('auth')->name('admin.bugs');

Route::get('/admin/users', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $developers = \App\Models\User::where('role', 'Dev')->get();
    $qas = \App\Models\User::where('role', 'QA')->get();
    $pms = \App\Models\User::where('role', 'PM')->get();
    return view('admin.users', compact('developers', 'qas', 'pms'));
})->middleware('auth')->name('admin.users');

Route::get('/admin/settings', function () {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $users = \App\Models\User::orderBy('name')->get();
    return view('admin.settings', compact('users'));
})->middleware('auth')->name('admin.settings');

// PM Dashboard
Route::get('/pm-dashboard', function () {
    if (!Auth::check() || Auth::user()->role !== 'PM') abort(403);
    $bugs = Bug::with(['assignedTo', 'creator'])->get();
    return view('pm-dashboard', compact('bugs'));
})->middleware('auth')->name('pm.dashboard');

// Removed duplicate admin dashboard & export routes (grouped above)

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::resource('bugs', App\Http\Controllers\BugController::class);

// Admin user management
Route::post('/admin/users', [AdminUserController::class, 'store'])->middleware('auth')->name('admin.users.store');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->middleware('auth')->name('admin.users.destroy');
