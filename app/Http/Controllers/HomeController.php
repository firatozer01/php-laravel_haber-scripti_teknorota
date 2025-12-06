<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();
        
        // Separated Queries
        $featuredNews = Article::news()->with(['category', 'user'])->where('is_active', true)->latest()->take(3)->get();
        $news = Article::news()->with(['category', 'user'])->where('is_active', true)->whereNotIn('id', $featuredNews->pluck('id'))->latest()->take(6)->get();
        $posts = Article::posts()->with(['user'])->where('is_active', true)->latest()->take(5)->get(); // Köşe Yazıları
        
        $videos = Video::where('is_active', true)->orderBy('order')->latest()->take(4)->get();

        return view('home', compact('sliders', 'featuredNews', 'news', 'posts', 'videos'));
    }
}
