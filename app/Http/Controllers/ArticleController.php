<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_active', true)->with('category')->latest()->paginate(12);
        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if (!$article->is_active) {
            abort(404);
        }

        $article->increment('views');

        // Only load top level comments (parent_id is null)
        $comments = $article->comments()
            ->whereNull('parent_id')
            ->where('is_approved', true)
            ->with(['user', 'children' => function($query) {
                $query->where('is_approved', true)->with('user');
            }])
            ->latest()
            ->get();
            
        return view('articles.show', compact('article', 'comments'));
    }

    public function storeComment(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_approved' => false,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Yorumunuz onay için gönderildi.');
    }
}
