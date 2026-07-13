<?php

namespace App\Http\Controllers;

use App\Models\GalleryYear;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('gallery.index', ['years' => GalleryYear::forPublic()]);
    }
}
