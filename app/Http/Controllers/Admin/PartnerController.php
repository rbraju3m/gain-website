<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\PartnerRequest;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $strategic    = Partner::ordered()->strategic()->get();
        $implementing = Partner::ordered()->implementing()->get();
        return view('admin.partners.index', compact('strategic', 'implementing'));
    }

    public function create()
    {
        $partner = new Partner([
            'is_published' => true,
            'group'        => Partner::GROUP_STRATEGIC,
            'sort_order'   => Partner::max('sort_order') + 1,
        ]);
        return view('admin.partners.create', compact('partner'));
    }

    public function store(PartnerRequest $request)
    {
        $data = $request->safe()->except(['logo', 'remove_logo']);
        $data['slug'] = Partner::generateSlug($data['name']);

        $partner = Partner::create($data);
        $this->syncLogo($partner, $request);

        return redirect()->route('admin.partners.index')
            ->with('status', "Partner “{$partner->name}” created.");
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $data = $request->safe()->except(['logo', 'remove_logo']);

        if (isset($data['name']) && $data['name'] !== $partner->name) {
            $data['slug'] = Partner::generateSlug($data['name'], $partner->id);
        }

        $partner->update($data);
        $this->syncLogo($partner, $request);

        return redirect()->route('admin.partners.index')
            ->with('status', "Partner “{$partner->name}” saved.");
    }

    public function destroy(Partner $partner)
    {
        $name = $partner->name;
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('status', "Partner “{$name}” deleted.");
    }

    private function syncLogo(Partner $partner, PartnerRequest $request): void
    {
        if ($request->boolean('remove_logo')) {
            $partner->clearMediaCollection('logo');
        }
        if ($request->hasFile('logo')) {
            $partner->clearMediaCollection('logo');
            $partner->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
    }
}
