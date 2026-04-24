<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'content_en' => 'required|string',
            'published_date' => 'nullable|date',
            'status' => 'required|string',
        ]);

        News::create($request->all());

        return redirect()->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }
}