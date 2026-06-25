<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Achievement\AchievementRequest;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::ordered()->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        $achievement = new Achievement([
            'is_published' => true,
            'sort_order'   => Achievement::max('sort_order') + 1,
            'rows'         => [],
        ]);
        return view('admin.achievements.create', compact('achievement'));
    }

    public function store(AchievementRequest $request)
    {
        $achievement = Achievement::create($this->normalise($request));
        return redirect()->route('admin.achievements.index')->with('status', "“{$achievement->title}” added.");
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(AchievementRequest $request, Achievement $achievement)
    {
        $achievement->update($this->normalise($request));
        return redirect()->route('admin.achievements.index')->with('status', "“{$achievement->title}” saved.");
    }

    public function destroy(Achievement $achievement)
    {
        $title = $achievement->title;
        $achievement->delete();
        return redirect()->route('admin.achievements.index')->with('status', "“{$title}” deleted.");
    }

    /** Strip blank row slots before persisting. */
    private function normalise(AchievementRequest $request): array
    {
        $data = $request->validated();
        $data['rows'] = collect($data['rows'] ?? [])
            ->filter(fn ($r) => filled($r['label'] ?? null))
            ->map(fn ($r) => [
                'label' => trim($r['label']),
                'value' => trim((string) ($r['value'] ?? '')),
                'tone'  => $r['tone'] ?? 'red',
            ])
            ->values()
            ->all();

        return $data;
    }
}
