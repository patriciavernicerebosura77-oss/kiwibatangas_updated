<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Featured Story (May maganda at kaugnay na larawan)
        $featuredStory = (object)[
            'title' => 'Paghahanda para sa Bagong Taon at Turismo sa Batangas, Pinalalakas',
            'excerpt' => 'Nagpatupad ng mga bagong programa ang pamahalaang panlalawigan upang mas mapaganda ang karanasan ng mga turista at makiisa ang lokal na komunidad.',
            'category' => 'LOKAL',
            'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            'published_at' => Carbon::now()->subHours(2),
        ];

        // 2. Breaking News Ticker (Para sa gumagalaw na balita)
        $breakingNews = collect([
            (object)['title' => 'Lipa City ibinida ang pagpapalawak ng mga lokal na taniman ng kape at gulay'],
            (object)['title' => 'Mga bakasyonista dagsa na sa mga kilalang pasyalan sa Sto. Tomas at Tanauan'],
            (object)['title' => 'DOTr at lokal na pamahalaan tiniyak ang maayos na daloy ng trapiko ngayong linggo'],
        ]);

        // 3. Top Stories Sidebar (May magagandang litrato)
        $topStories = collect([
            (object)[
                'title' => 'Kape ng Batangas, patuloy ang pag-akit sa mga mamimili sa iba’t ibang rehiyon',
                'category' => 'NEGOSYO',
                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=150&q=80',
                'published_at' => Carbon::now()->subHours(3),
            ],
            (object)[
                'title' => 'Mga bagong small-to-medium enterprises sa probinsya, lumago ngayong taon',
                'category' => 'EKONOMIYA',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0a67d553c2a5?auto=format&fit=crop&w=150&q=80',
                'published_at' => Carbon::now()->subHours(5),
            ]
        ]);

        // 4. Articles Grid Section (Mga balita sa ibaba na may kaukulang pictures)
        $articles = collect([
            (object)[
                'title' => 'Paggamit ng makabagong teknolohiya sa agrikultura, isinusulong sa mga magsasaka',
                'category' => 'Agrikultura',
                'image_url' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80',
                'published_at' => Carbon::now()->subHours(4),
            ],
            (object)[
                'title' => 'Pista ng Sto. Tomas: Mga paghahanda at aktibidad, inilatag na ng lokal na pamunuan',
                'category' => 'Kultura',
                'image_url' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=400&q=80',
                'published_at' => Carbon::now()->subHours(6),
            ],
            (object)[
                'title' => 'Kabataang Batanguenyo, nagwagi sa isang pambansang tech innovation competition',
                'category' => 'Tech & Innovation',
                'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=400&q=80',
                'published_at' => Carbon::now()->subDay(),
            ],
            (object)[
                'title' => 'Patok ang mga lokal na lutuin at kakanin sa night market ng bayan',
                'category' => 'Chismis',
                'image_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=400&q=80',
                'published_at' => Carbon::now()->subDays(2),
            ]
        ]);

        return view('home', compact('featuredStory', 'breakingNews', 'topStories', 'articles'));
    }
}