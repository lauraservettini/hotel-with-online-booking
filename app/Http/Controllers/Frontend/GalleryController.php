<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function showGallery()
    {
        $galleries = Gallery::latest()->get();

        return view('frontend.gallery.all_gallery', compact('galleries'));
    }
}
