<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MvvCard\MvvCardRequest;
use App\Models\MvvCard;
use App\Support\HasAdminSorting;

class MvvCardController extends Controller
{
    use HasAdminSorting;

    protected function sortableModelClass(): string { return MvvCard::class; }

    public function index()
    {
        $cards = MvvCard::ordered()->get();
        return view('admin.mvv.index', compact('cards'));
    }

    public function create()
    {
        $card = new MvvCard([
            'tone'         => 'red',
            'is_published' => true,
            'sort_order'   => MvvCard::max('sort_order') + 1,
        ]);
        return view('admin.mvv.create', compact('card'));
    }

    public function store(MvvCardRequest $request)
    {
        $card = MvvCard::create($request->validated());
        return redirect()->route('admin.mvv.index')->with('status', "“{$card->title}” added.");
    }

    public function edit(MvvCard $mvv)
    {
        return view('admin.mvv.edit', ['card' => $mvv]);
    }

    public function update(MvvCardRequest $request, MvvCard $mvv)
    {
        $mvv->update($request->validated());
        return redirect()->route('admin.mvv.index')->with('status', "“{$mvv->title}” saved.");
    }

    public function destroy(MvvCard $mvv)
    {
        $title = $mvv->title;
        $mvv->delete();
        return redirect()->route('admin.mvv.index')->with('status', "“{$title}” deleted.");
    }
}
