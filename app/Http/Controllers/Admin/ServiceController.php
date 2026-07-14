<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Models\Service;
use App\Support\HasAdminSorting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HasAdminSorting;

    protected function sortableModelClass(): string { return Service::class; }

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $services = Service::ordered()
            ->when($q !== '', fn ($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->paginate(20)
            ->withQueryString();
        return view('admin.services.index', compact('services', 'q'));
    }

    public function create()
    {
        $service = new Service(['is_published' => true, 'sort_order' => Service::max('sort_order') + 1]);
        return view('admin.services.create', compact('service'));
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['slug'] = Service::generateSlug($data['title']);

        $service = Service::create($data);
        $this->syncImage($service, $request);

        return redirect()->route('admin.services.index')
            ->with('status', "Service “{$service->title}” created.");
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        if (isset($data['title']) && $data['title'] !== $service->title) {
            $data['slug'] = Service::generateSlug($data['title'], $service->id);
        }

        $service->update($data);
        $this->syncImage($service, $request);

        return redirect()->route('admin.services.index')
            ->with('status', "Service “{$service->title}” saved.");
    }

    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('status', "Service “{$title}” deleted.");
    }

    private function syncImage(Service $service, ServiceRequest $request): void
    {
        if ($request->boolean('remove_image')) {
            $service->clearMediaCollection('image');
        }
        if ($request->hasFile('image')) {
            $service->clearMediaCollection('image');
            $service->addMediaFromRequest('image')->toMediaCollection('image');
        }
    }
}
