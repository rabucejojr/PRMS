<?php

namespace App\Http\Controllers;

use App\Models\PressRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PressReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pressReleases = PressRelease::with('user')->orderByDesc('created_at')
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Admin/PressReleases/Index', [
            'pressReleases' => $pressReleases
        ]);
    }

    public function show($slug)
    {
        $release = PressRelease::where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/Show', [
            'release' => $release
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/PressReleases/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $pressRelease = PressRelease::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'slug' => Str::slug($validated['title']),
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('press-releases.index')
            ->with('success', 'Press release created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PressRelease $pressRelease)
    {
        $pressRelease->load('user');
        return Inertia::render('Admin/PressReleases/Edit', [
            'pressRelease' => $pressRelease
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PressRelease $pressRelease)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Update published_at if status changes to published
        if ($validated['status'] === 'published' && $pressRelease->status !== 'published') {
            $validated['published_at'] = now();
        }

        // Update the press release
        $pressRelease->update($validated);

        return redirect()->route('press-releases.index')
            ->with('success', 'Press release updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PressRelease $pressRelease)
    {
        //
    }

    public function publicIndex()
    {
        $releases = PressRelease::where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Public/PressReleases', ['releases' => $releases]);
    }

    public function publicShow($slug)
    {
        $release = PressRelease::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return Inertia::render('Public/Show', ['release' => $release]);
    }
}
