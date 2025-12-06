<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::where('is_approved', true)
            ->with('user', 'comments') // Load comments if needed
            ->latest()
            ->paginate(15);
            
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Question::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_approved' => false, // Requires admin approval
        ]);

        return redirect()->route('questions.index')->with('success', 'Sorunuz gönderildi. Onaylandıktan sonra yayınlanacaktır.');
    }

    public function show(Question $question)
    {
        if (!$question->is_approved) {
             abort(404);
        }
        
        $comments = $question->comments()
            ->whereNull('parent_id')
            ->where('is_approved', true) // Assuming we use same approval flow
            ->with(['user', 'children' => function($query) {
                $query->where('is_approved', true);
            }])
            ->latest()
            ->get();

        return view('questions.show', compact('question', 'comments'));
    }

    public function storeComment(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $question->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_approved' => false,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Yorumunuz onay için gönderildi.');
    }
}
