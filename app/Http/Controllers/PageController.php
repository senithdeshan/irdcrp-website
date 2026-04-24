<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class PageController extends Controller
{
    public function home() {
        return view('home');
    }

    public function about() {
        return view('about');
    }

    public function components() {
        return view('components');
    }

    public function areas() {
        return view('areas');
    }

    public function news()
{
    $news = News::where('status', 'published')
        ->latest()
        ->get();

    return view('news', compact('news'));
}

    public function procurement() {
        return view('procurement');
    }

    public function downloads() {
        return view('downloads');
    }

    public function gallery() {
        return view('gallery');
    }

    public function grm() {
        return view('grm');
    }

    public function contact() {
        return view('contact');
    }

    public function showNews(News $news)
{
    return view('news-show', compact('news'));
}
}