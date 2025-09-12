// Developer: Edit Bug (Update Status)
Route::get('/dev/bugs/{bug}/edit', [App\Http\Controllers\BugController::class, 'edit'])
    ->middleware('auth')
    ->name('dev.bugs.edit');

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Bug;

// Admin: Update developer permissions
Route::post('/admin/developer/{id}/toggle-qas', function($id) {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $dev = \App\Models\User::where('role', 'Dev')->findOrFail($id);
    $dev->can_access_qas = !$dev->can_access_qas;
    $dev->save();
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('admin.toggleQAs');

// Developer Dashboard
Route::get('/dev-dashboard', function() {
    if (!Auth::check() || Auth::user()->role !== 'Dev') abort(403);
    $bugs = Bug::where('assigned_to', Auth::id())->get();
    return view('dev-dashboard', compact('bugs'));
})->middleware('auth')->name('dev.dashboard');

// PM Dashboard
Route::get('/pm-dashboard', function() {
    if (!Auth::check() || Auth::user()->role !== 'PM') abort(403);
    $bugs = Bug::with(['assignedTo', 'creator'])->get();
    return view('pm-dashboard', compact('bugs'));
})->middleware('auth')->name('pm.dashboard');

// Admin Dashboard
Route::get('/admin-dashboard', function() {
    if (!Auth::check() || Auth::user()->role !== 'Admin') abort(403);
    $developers = \App\Models\User::where('role', 'Dev')->get();
    $qas = \App\Models\User::where('role', 'QA')->get();
    return view('admin-dashboard', compact('developers', 'qas'));
})->middleware('auth')->name('admin.dashboard');

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::resource('bugs', App\Http\Controllers\BugController::class);
