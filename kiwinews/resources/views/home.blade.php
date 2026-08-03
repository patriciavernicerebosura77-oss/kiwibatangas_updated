<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiwi Batangas | Digital News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS para sa Fade-in / Fade-out Scroll Animation */
        .scroll-fade {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: opacity, transform;
        }
        .scroll-fade.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth card hover zoom effects */
        .news-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-4px) scale(1.01);
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- TOP INFO BAR -->
<div class="bg-gray-100 text-gray-700 text-xs py-1.5 px-3 border-b border-gray-200">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        
        <!-- Left: Date & Clickable Dynamic Weather Widget -->
        <div class="flex items-center space-x-4">
            <span><i class="fa-regular fa-calendar mr-1"></i> {{ date('l, F j, Y') }}</span>
            
            <!-- Weather Widget (Auto-detect location & temperature) -->
            <a id="weather-link" href="https://www.google.com/search?q=weather" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-1.5 bg-white px-2.5 py-0.5 rounded border border-gray-300 shadow-2xs hover:border-emerald-600 transition group">
                <i id="weather-icon" class="fa-solid fa-cloud-sun text-amber-500 text-sm"></i>
                <div class="flex items-center space-x-1 font-medium text-gray-800">
                    <span id="weather-location" class="font-bold text-gray-900 group-hover:text-emerald-700 transition">Hinahanap ang lokasyon...</span>
                    <span id="weather-temp" class="text-emerald-700 font-black">--°C</span>
                    <span class="text-gray-400 font-normal text-[10px]">| Weather</span>
                </div>
                <i class="fa-solid fa-external-link-alt text-[8px] text-gray-400 group-hover:text-emerald-700 ml-0.5"></i>
            </a>
        </div>

        <!-- Right: Dynamic Exchange Rates Rotator -->
<!-- Right: Dynamic Exchange Rates Rotator -->
<a href="https://www.bsp.gov.ph/SitePages/Statistics/ExchangeRate.aspx" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-2 bg-white px-2.5 py-0.5 rounded border border-gray-300 shadow-2xs hover:border-emerald-600 transition group">
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-emerald-700">FX Rates:</span>
    <div id="fx-rotator" class="font-medium text-xs text-emerald-800 transition-opacity duration-500">
        <span class="text-gray-400 italic">Kumukuha ng live rates...</span>
    </div>
    <i class="fa-solid fa-external-link-alt text-[8px] text-gray-400 group-hover:text-emerald-700 ml-0.5"></i>
</a>

    </div>
</div>

    <!-- MAIN HEADER -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col md:flex-row justify-between items-center gap-3">
            
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2.5">
                <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="h-11 w-11 rounded-full object-cover border-2 border-emerald-600 shadow-sm" onerror="this.src='https://via.placeholder.com/50'">
                <div>
                    <span class="text-xl font-black tracking-tight text-gray-900 block leading-none">Kiwi Batangas</span>
                    <span class="text-[10px] font-bold text-emerald-700 tracking-widest uppercase">Digital News Portal</span>
                </div>
            </a>

            <!-- Search Bar and Admin Login Container -->
            <div class="flex items-center gap-2.5 w-full md:w-auto">
                <!-- Search Bar -->
                <form action="/" method="GET" class="flex items-center w-full md:w-80">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Maghanap ng balita, paksa..." class="w-full bg-gray-50 border border-gray-300 rounded-full py-1.5 pl-3.5 pr-9 text-sm focus:outline-none focus:border-emerald-700">
                        <button type="submit" class="absolute right-3 top-2 text-gray-500 hover:text-emerald-700">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </div>
                </form>

                <!-- Admin Login Button -->
                <a href="{{ route('admin.login') }}" class="bg-gray-100 hover:bg-emerald-700 hover:text-white text-gray-700 border border-gray-300 rounded-full py-1.5 px-4 text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap shadow-2xs">
                    <i class="fa-solid fa-lock text-[10px]"></i>
                    <span>Admin</span>
                </a>
            </div>
        </div>

        <!-- NAVIGATION -->
        <div class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 flex items-center space-x-2 overflow-x-auto py-2 text-sm font-bold">
                <a href="/" class="px-3.5 py-1.5 rounded-full {{ request('category') == '' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Mga Balita</a>
                <a href="/?category=Agrikultura" class="px-3.5 py-1.5 rounded-full {{ request('category') == 'Agrikultura' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Agrikultura</a>
                <a href="/?category=Negosyo" class="px-3.5 py-1.5 rounded-full {{ request('category') == 'Negosyo' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Negosyo</a>
                <a href="/?category=Tech+%26+Innovation" class="px-3.5 py-1.5 rounded-full {{ request('category') == 'Tech & Innovation' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Tech & Innovation</a>
                <a href="/?category=Chismis" class="px-3.5 py-1.5 rounded-full {{ request('category') == 'Chismis' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white' }} transition"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Chismis</a>
            </div>
        </div>
    </header>

    <!-- BREAKING NEWS TICKER -->
    @if($breakingNews->count() > 0)
    <div class="bg-emerald-50 border-y border-emerald-100 text-emerald-900 text-xs py-2 px-4 overflow-hidden scroll-fade">
        <div class="max-w-7xl mx-auto flex items-center space-x-3">
            <span class="bg-emerald-700 text-white font-bold px-2 py-0.5 rounded uppercase text-[10px] whitespace-nowrap flex items-center gap-1.5 shrink-0 z-10">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Just In
            </span>
            <div class="relative w-full overflow-hidden flex items-center whitespace-nowrap">
                <div class="inline-flex space-x-12" style="display: inline-flex; animation: marquee 50s linear infinite;" onmouseover="this.style.animationPlayState='paused';" onmouseout="this.style.animationPlayState='running';">
                    @foreach($breakingNews as $item)
                        <div class="inline-flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 inline-block"></span>
                            <a href="#" class="hover:underline hover:text-emerald-700 font-semibold text-gray-900">{{ $item->title }}</a>
                        </div>
                    @endforeach
                    @foreach($breakingNews as $item)
                        <div class="inline-flex items-center space-x-2" aria-hidden="true">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 inline-block"></span>
                            <span class="font-semibold text-gray-900">{{ $item->title }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    </style>
    @endif

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 py-8 bg-white">

       <!-- HERO SECTION -->
<div class="flex flex-col lg:flex-row gap-6 mb-8 scroll-fade">
    <!-- Left Featured Story (Awtomatikong susunod sa haba ng nilalaman at hindi na hihigit sa sidebar) -->
    <div class="w-full lg:w-2/3 bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card self-start">
        @if($featuredStory)
            <div class="relative overflow-hidden">
                <img src="{{ $featuredStory->image_url ?? 'https://via.placeholder.com/800x450' }}" alt="Lead Story" class="w-full h-72 object-cover transition-transform duration-500 hover:scale-105">
                <span class="absolute top-4 left-4 bg-emerald-700 text-white text-xs font-bold uppercase px-2.5 py-1 rounded shadow-sm">Featured</span>
            </div>
            <div class="p-6">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">{{ $featuredStory->category }}</span>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 hover:text-emerald-700 transition mt-1.5 mb-2.5">
                    <a href="#">{{ $featuredStory->title }}</a>
                </h1>
                <p class="text-gray-700 text-sm md:text-base mb-4 leading-relaxed">{{ $featuredStory->excerpt }}</p>
                <span class="text-xs text-gray-500 flex items-center">
                    <i class="fa-regular fa-clock mr-1.5"></i> {{ $featuredStory->published_at ? $featuredStory->published_at->diffForHumans() : 'Just now' }}
                </span>
            </div>
        @else
            <div class="relative overflow-hidden">
                <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=800&q=80" alt="Lead Story" class="w-full h-72 object-cover transition-transform duration-500 hover:scale-105">
                <span class="absolute top-4 left-4 bg-emerald-700 text-white text-xs font-bold uppercase px-2.5 py-1 rounded shadow-sm">Featured</span>
            </div>
            <div class="p-6">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Agrikultura & Teknolohiya</span>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 hover:text-emerald-700 transition mt-1.5 mb-2.5">
                    <a href="#">Makabagong Sistema sa Pagsasaka, Inilunsad sa mga Bayan ng Batangas</a>
                </h1>
                <p class="text-gray-700 text-sm md:text-base mb-4 leading-relaxed">
                    Isinusulong ng lokal na pamahalaan at mga kooperatiba ang paggamit ng automated smart irrigation at digital marketplace upang mapataas ang ani ng mga magsasaka sa lalawigan.
                </p>
                <span class="text-xs text-gray-500 flex items-center"><i class="fa-regular fa-clock mr-1.5"></i> 15 minuto ang nakalipas</span>
            </div>
        @endif
    </div>

    <!-- SIDEBAR -->
    <div class="w-full lg:w-1/3 flex flex-col gap-6">
        <!-- KIWI PARTNER PROMO -->
        <div class="bg-white border border-amber-200 rounded-xl shadow-xs overflow-hidden news-card">
            <div class="bg-amber-50 px-4 py-2 border-b border-amber-100 flex justify-between items-center">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-bullhorn text-amber-600"></i> Kiwi Partner Promo
                </span>
                <span class="text-[10px] bg-amber-200 text-amber-900 font-semibold px-2 py-0.5 rounded-full uppercase">Sponsored / Ad</span>
            </div>
            <div class="p-4">
                <div class="relative group overflow-hidden rounded-lg mb-3 bg-gray-100 aspect-video flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=600&q=80" alt="Burger Promo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[11px] font-medium px-2 py-0.5 rounded">Limited Offer</span>
                </div>
                <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1 hover:text-emerald-700 transition-colors">Burger Bundle Special Deal!</h4>
                <p class="text-xs text-gray-700 mb-3 leading-relaxed">
                    Gamitin ang promo code na <strong class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">KIWIBATANGAS</strong> para sa libreng delivery.
                </p>
                <a href="#" target="_blank" class="block w-full text-center bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold py-2.5 px-4 rounded-lg shadow-xs transition-all duration-200 flex items-center justify-center gap-2 group">
                    <span>Alamin Pa</span>
                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Top Stories -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm news-card">
            <h2 class="text-sm font-black border-b-2 border-emerald-700 pb-2 mb-3 uppercase tracking-wider text-gray-900 flex justify-between items-center">
                <span>Top Stories</span>
                <i class="fa-solid fa-bolt text-emerald-700"></i>
            </h2>
            <div class="divide-y divide-gray-100">
                @forelse($topStories as $story)
                    <div class="py-2.5 first:pt-0 last:pb-0 flex items-center space-x-3">
                        <img src="{{ $story->image_url ?? 'https://via.placeholder.com/80' }}" class="w-12 h-12 object-cover rounded-md flex-shrink-0" alt="Thumbnail">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-bold text-emerald-700 uppercase block">{{ $story->category }}</span>
                            <h3 class="font-bold text-xs text-gray-900 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                <a href="#">{{ $story->title }}</a>
                            </h3>
                            <span class="text-[10px] text-gray-500 mt-0.5 block"><i class="fa-regular fa-clock mr-1"></i> {{ $story->published_at ? $story->published_at->diffForHumans() : '' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="py-2.5 flex items-center space-x-3">
                        <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=150&q=80" class="w-12 h-12 object-cover rounded-md flex-shrink-0" alt="Thumbnail">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-bold text-emerald-700 uppercase block">Negosyo</span>
                            <h3 class="font-bold text-xs text-gray-900 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                <a href="#">Local coffee enterprises expand exports to international markets.</a>
                            </h3>
                            <span class="text-[10px] text-gray-500 mt-0.5 block"><i class="fa-regular fa-clock mr-1"></i> 2 oras ang nakalipas</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

        <!-- ARTICLES GRID SECTION -->
        <section class="mb-12 scroll-fade">
            <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2 mb-6">
                <h2 class="text-2xl font-black uppercase text-emerald-900">
                    {{ request('category') ? 'Kategorya: ' . request('category') : 'Mga Pinakahuling Balita' }}
                </h2>
                @if(request('search') || request('category'))
                    <a href="/" class="text-xs font-bold bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">I-reset ang Salain</a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($articles as $article)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card">
                        <div class="overflow-hidden">
                            <img src="{{ $article->image_url ?? 'https://via.placeholder.com/400x250' }}" alt="Thumbnail" class="w-full h-44 object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 uppercase">{{ $article->category }}</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">{{ $article->title }}</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-500 flex items-center"><i class="fa-regular fa-clock mr-1"></i> {{ $article->published_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card">
                        <div class="overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80" alt="Thumbnail" class="w-full h-44 object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 uppercase">Agrikultura</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">Pagpapalawak ng taniman ng kape sa Lipa City, sinimulan na</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-500 flex items-center"><i class="fa-regular fa-clock mr-1"></i> 1 oras ang nakalipas</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- FULL-WIDTH NEWSLETTER SECTION -->
        <div class="mb-6 bg-emerald-800 text-white p-6 md:p-8 rounded-xl shadow-sm scroll-fade">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <div>
                    <span class="bg-white text-emerald-900 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider inline-block mb-2">
                        <i class="fa-solid fa-envelope-open-text mr-1"></i> Kiwi Batangas Express
                    </span>
                    <h3 class="text-2xl font-black mb-2">Manatiling Huli at Updated sa mga Balita</h3>
                    <p class="text-sm text-emerald-100 leading-relaxed">
                        Mag-subscribe sa aming araw-araw na newsletter para sa pinakabagong balita sa Agrikultura, Negosyo, at Teknolohiya diretso sa iyong inbox.
                    </p>
                </div>
                <div>
                    <form class="flex flex-col sm:flex-row gap-2.5">
                        <input type="email" class="rounded-full py-2.5 px-5 text-sm text-gray-900 bg-white border-0 focus:outline-none w-full" placeholder="Ilagay ang iyong Email Address..." required>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white rounded-full px-7 py-2.5 text-sm font-bold transition whitespace-nowrap">
                            Sumali Na <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </form>
                    <small class="text-emerald-200 text-xs mt-2.5 block">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Walang spam. Maaari kang mag-unsubscribe anumang oras.
                    </small>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-100 text-gray-700 py-10 border-t border-gray-200 text-sm scroll-fade">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <img src="{{ asset('images/logo.kiwi.jpg') }}" class="w-8 h-8 rounded-full object-cover border border-emerald-600" onerror="this.src='https://via.placeholder.com/40'">
                    <span class="font-black text-gray-900 text-base">Kiwi Batangas</span>
                </div>
                <p class="text-xs text-gray-600 mb-4 leading-relaxed">Ang nangungunang pahayagang digital para sa mga pinakabagong balita, agrikultura, negosyo, at teknolohiya sa lalawigan ng Batangas.</p>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Mga Kategorya</p>
                <ul class="text-xs space-y-2">
                    <li><a href="/?category=Agrikultura" class="hover:text-emerald-700 transition">Agrikultura</a></li>
                    <li><a href="/?category=Negosyo" class="hover:text-emerald-700 transition">Negosyo at Pamumuhunan</a></li>
                </ul>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Tulong at Impormasyon</p>
                <ul class="text-xs space-y-2">
                    <li><a href="#" class="hover:text-emerald-700 transition">Tungkol sa Amin</a></li>
                    <li><a href="#" class="hover:text-emerald-700 transition">Makipag-ugnayan</a></li>
                </ul>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Tanggapan at Ugnayan</p>
                <p class="text-xs text-gray-600 mb-2 flex items-start gap-1.5"><i class="fa-solid fa-location-dot text-emerald-700 mt-0.5"></i> Lipa City, Batangas, Philippines</p>
                <a href="https://www.bsp.gov.ph/SitePages/Statistics/ExchangeRate.aspx" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:underline mt-2">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Tingnan ang buong BSP FX rates
                </a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 border-t border-gray-200 pt-4 text-xs text-gray-500 text-center">
            <p>&copy; {{ date('Y') }} Kiwi Batangas. All Rights Reserved. Powered by Kiwi Digital Tech.</p>
        </div>
    </footer>

<script>
    // 1. Scroll Fade-in / Fade-out Observer Animation
    document.addEventListener("DOMContentLoaded", function () {
        const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                } else {
                    entry.target.classList.remove('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-fade').forEach(section => {
            observer.observe(section);
        });
    });

let liveRates = [];
let currentIndex = 0;
const rotatorEl = document.getElementById('fx-rotator');

async function fetchLiveExchangeRates() {
    try {
        // Kumukuha ng real-time market rates laban sa Philippine Peso (PHP) araw-araw
        const response = await fetch('https://open.er-api.com/v6/latest/PHP');
        const data = await response.json();
        
        if (data && data.rates) {
            const currencies = ['USD', 'EUR', 'JPY', 'GBP', 'SGD', 'AUD', 'CAD', 'CHF'];
            liveRates = currencies.map(curr => {
                if (data.rates[curr]) {
                    let rateVal = (1 / data.rates[curr]).toFixed(4);
                    return { symbol: `${curr}/PHP`, rate: `₱${rateVal}` };
                }
                return null;
            }).filter(item => item !== null);

            if (liveRates.length > 0) {
                displayNextRate();
                setInterval(displayNextRate, 4000); // Lumilipat kada 4 na segundo
            }
        }
    } catch (error) {
        rotatorEl.innerHTML = `<span class="text-gray-500">Hindi ma-load ang rates</span>`;
    }
}

function displayNextRate() {
    if (liveRates.length > 0) {
        let item = liveRates[currentIndex];
        rotatorEl.style.opacity = 0;
        setTimeout(() => {
            rotatorEl.innerHTML = `<strong>${item.symbol}</strong>: <span class="text-gray-900 font-bold">${item.rate}</span>`;
            rotatorEl.style.opacity = 1;
        }, 300);
        currentIndex = (currentIndex + 1) % liveRates.length;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    fetchLiveExchangeRates();
});

    // 3. Fully Automated Geolocation Weather Script (Walang hardcoded na lugar)
    document.addEventListener("DOMContentLoaded", function () {
        const weatherLinkEl = document.getElementById('weather-link');
        const locationEl = document.getElementById('weather-location');
        const tempEl = document.getElementById('weather-temp');

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(async function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                try {
                    // Kunin ang temperature base sa aktuwal na GPS coordinates ng user
                    const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m`);
                    const data = await response.json();
                    
                    // Kunin ang pangalan ng siyudad/bayan gamit ang reverse geocoding
                    const geoResponse = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
                    const geoData = await geoResponse.json();
                    
                    let placeName = "Kasalukuyang Lokasyon";
                    if (geoData && geoData.address) {
                        placeName = geoData.address.city || geoData.address.municipality || geoData.address.town || geoData.address.village || geoData.address.county || "Kasalukuyang Lokasyon";
                    }

                    if (data && data.current) {
                        const temp = Math.round(data.current.temperature_2m);
                        locationEl.textContent = placeName;
                        tempEl.textContent = `${temp}°C`;
                        weatherLinkEl.href = `https://www.google.com/search?q=${encodeURIComponent(placeName + ' weather')}`;
                    } else {
                        locationEl.textContent = placeName;
                        tempEl.textContent = "--°C";
                    }
                } catch (error) {
                    locationEl.textContent = "Hindi makuha ang panahon";
                    tempEl.textContent = "--°C";
                }
            }, function (error) {
                locationEl.textContent = "Naka-off ang GPS / Location";
                tempEl.textContent = "--°C";
            }, { timeout: 10000 });
        } else {
            locationEl.textContent = "Hindi suportado ang Geolocation";
            tempEl.textContent = "--°C";
        }
    });
</script>
</body>
</html>