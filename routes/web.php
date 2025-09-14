
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Bug;

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

// Admin: Update developer permissions
Route::post('/admin/developer/{id}/toggle-qas', function ($id) {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $dev = \App\Models\User::where('role', 'Dev')->findOrFail($id);
    $dev->can_access_qas = !$dev->can_access_qas;
    $dev->save();
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('admin.toggleQAs');

// Developer Dashboard
Route::get('/dev-dashboard', function () {
    if (!Auth::check() || Auth::user()->role !== 'Dev') abort(403);
    $bugs = Bug::where('assigned_to', Auth::id())->get();
    return view('dev-dashboard', compact('bugs'));
})->middleware('auth')->name('dev.dashboard');

// PM Dashboard
Route::get('/pm-dashboard', function () {
    if (!Auth::check() || Auth::user()->role !== 'PM') abort(403);
    $bugs = Bug::with(['assignedTo', 'creator'])->get();
    return view('pm-dashboard', compact('bugs'));
})->middleware('auth')->name('pm.dashboard');

// Admin Dashboard
Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');
    
// Admin CSV Export
Route::get('/admin/bugs/export-csv', [App\Http\Controllers\AdminController::class, 'exportCsv'])
    ->middleware('auth')
    ->name('admin.bugs.export.csv');

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::resource('bugs', App\Http\Controllers\BugController::class);
