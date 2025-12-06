<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionImageController extends Controller
{
    /**
     * Handle the incoming image upload from Summernote.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB Limit
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('questions/images', $filename, 'public');

            return response()->json([
                'url' => Storage::url($path),
                'success' => true
            ]);
        }

        return response()->json(['error' => 'Image upload failed.'], 400);
    }
}
