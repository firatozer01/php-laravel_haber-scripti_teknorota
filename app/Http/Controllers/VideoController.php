<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('is_active', true)->orderBy('order')->latest()->paginate(12);
        return view('videos.index', compact('videos'));
    }
}
