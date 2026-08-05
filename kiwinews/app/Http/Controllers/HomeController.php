<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        // Kunin ang mga kategorya na naka-sort base sa iyong Drag & Drop order sa Admin Dashboard
        $categories = Category::orderBy('sort_order', 'asc')->get();

        // Breaking news
        $breakingNews = Article::orderBy('created_at', 'desc')->take(5)->get();

        // Featured stories (kunin ang pinakabagong featured)
        $featuredStoriesQuery = Article::where('is_featured', 1)->orderBy('created_at', 'desc');
        $featuredStories = $featuredStoriesQuery->take(5)->get();
        $featuredStory = $featuredStories->first();
        $hasMoreFeatured = Article::where('is_featured', 1)->count() > 5;

        // Top Stories - Awtomatikong Top 5 pinakapanood o pinakabinisita (Most Viewed)
        $topStories = Article::orderBy('views', 'desc')->take(5)->get();

        // Regular articles / Search / Category filter
        $articlesQuery = Article::orderBy('created_at', 'desc');

        // 1. I-apply ang Search filter kung mayroon man
        if ($search) {
            $articlesQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // 2. I-apply ang Category filter kung may pinili (Maliban kung walang pinili o kaya ay 'All')
        if ($category && $category != '' && $category != 'All') {
            $articlesQuery->where('category', $category);
        }

        // 3. Logic para sa pagpapakita ng balita:
        // Kung may ginawang SEARCH, O KAYA ay pinili ang 'All', O KAYA ay may piniling specific category,
        // kunin na lahat nang walang limit/pagination para lumabas sabay-sabay at naka-latest sa itaas.
        if ($search || ($category && $category != '')) {
            $articles = $articlesQuery->get();
        } else {
            // Kung nasa mismong Homepage lamang (walang search at walang category)
            $articles = $articlesQuery->paginate(8)->withQueryString();
        }

        return view('home', compact(
            'categories',
            'breakingNews',
            'featuredStory',
            'featuredStories',
            'hasMoreFeatured',
            'topStories',
            'articles'
        ));
    }
}