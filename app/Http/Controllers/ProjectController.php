<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        return view('admin.project-form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
        $data['created_by'] = Auth::id();
        Project::create($data);
        return redirect()->route('admin.projects')->with('status', 'Project created');
    }

    public function edit(Project $project)
    {
        return view('admin.project-form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
        $project->update($data);
        return redirect()->route('admin.projects')->with('status', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('status', 'Project deleted');
    }
}
