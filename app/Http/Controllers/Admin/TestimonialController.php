<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\TestimonialRequest;
use App\Models\Testimonial;
use App\Support\HasAdminSorting;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HasAdminSorting;

    protected function sortableModelClass(): string { return Testimonial::class; }

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $testimonials = Testimonial::ordered()
            ->when($q !== '', fn ($qb) => $qb->where('author_name', 'like', "%{$q}%"))
            ->paginate(20)
            ->withQueryString();
        return view('admin.testimonials.index', compact('testimonials', 'q'));
    }

    public function create()
    {
        $testimonial = new Testimonial([
            'is_published' => true,
            'sort_order'   => Testimonial::max('sort_order') + 1,
        ]);
        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function store(TestimonialRequest $request)
    {
        $testimonial = Testimonial::create($request->safe()->except(['photo', 'remove_photo']));
        $this->syncPhoto($testimonial, $request);

        return redirect()->route('admin.testimonials.index')
            ->with('status', "Testimonial from “{$testimonial->author_name}” created.");
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->safe()->except(['photo', 'remove_photo']));
        $this->syncPhoto($testimonial, $request);

        return redirect()->route('admin.testimonials.index')
            ->with('status', "Testimonial from “{$testimonial->author_name}” saved.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->author_name;
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('status', "Testimonial from “{$name}” deleted.");
    }

    private function syncPhoto(Testimonial $testimonial, TestimonialRequest $request): void
    {
        if ($request->boolean('remove_photo')) {
            $testimonial->clearMediaCollection('photo');
        }
        if ($request->hasFile('photo')) {
            $testimonial->clearMediaCollection('photo');
            $testimonial->addMediaFromRequest('photo')->toMediaCollection('photo');
        }
    }
}
