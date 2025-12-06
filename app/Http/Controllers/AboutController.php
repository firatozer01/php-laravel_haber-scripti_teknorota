<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SiteSetting;

class AboutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('about', [
            'aboutTitle' => SiteSetting::get('about.title', 'Hakkımda'),
            'aboutContent' => SiteSetting::get('about.content', '<p>İçerik hazırlanıyor...</p>'),
            'aboutImage' => SiteSetting::get('about.image'),
        ]);
    }
}
