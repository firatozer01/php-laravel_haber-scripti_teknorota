<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $articles = $category->articles()
            ->where('is_active', true)
            ->where('type', 'news') // Only show news in category, or both? Usually Categories apply to news.
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'articles'));
    }
}
