<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_active', true)->orderBy('sort_order')->latest()->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('projects.show', compact('project'));
    }
}