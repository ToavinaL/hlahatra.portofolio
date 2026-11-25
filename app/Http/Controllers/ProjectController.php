<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::query()
            ->with(['translations', 'technologies', 'images', 'category.translations'])
            ->published()
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category')->toString())))
            ->when($request->filled('technology'), fn ($query) => $query->whereHas('technologies', fn ($technology) => $technology->where('slug', $request->string('technology')->toString())))
            ->ordered()
            ->get();

        return view('pages.projects', [
            'projects' => $projects,
            'categories' => Category::query()->with('translations')->orderBy('sort_order')->get(),
            'technologies' => Technology::query()->orderBy('sort_order')->get(),
            'selectedCategory' => $request->string('category')->toString(),
            'selectedTechnology' => $request->string('technology')->toString(),
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->status?->value === 'published', 404);

        $project->load(['translations', 'technologies', 'images', 'category.translations']);

        return view('pages.project', compact('project'));
    }
}
