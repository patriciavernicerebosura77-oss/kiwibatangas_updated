<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($id) {
    $article = Article::findOrFail($id);
    
    // Tataas ang view count bawat click ng kahit sinong user (kahit paulit-ulit)
    $article->increment('daily_views');
    $article->increment('weekly_views');
    $article->increment('monthly_views');
    $article->increment('yearly_views');
    $article->increment('views'); // Total views kung meron man

    return view('news.show', compact('article'));
}
}