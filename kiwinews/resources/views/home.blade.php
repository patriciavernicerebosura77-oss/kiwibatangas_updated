<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiwi Batangas | Digital News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- TOP INFO BAR: BSP Accurate Rates & Weather -->
    <div class="bg-gray-100 text-gray-700 text-xs py-2 px-4 border-b border-gray-200">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
            
            <!-- Left: Date & Weather -->
            <div class="flex items-center space-x-4">
                <span><i class="fa-regular fa-calendar mr-1"></i> {{ date('l, F j, Y') }}</span>
                <span class="flex items-center text-emerald-800 font-semibold">
                    <i class="fa-solid fa-cloud-sun text-amber-500 mr-1.5 text-sm"></i> 
                    Santo Tomas, Batangas: 31°C - Weather Update
                </span>
            </div>

            Right: Exact BSP Exchange Rate Rotator & Livestream Badge
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 bg-white px-3 py-1 rounded border border-gray-300 shadow-2xs">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">BSP FX:</span>
                    <div id="fx-rotator" class="font-medium text-xs text-emerald-800 transition-opacity duration-500">
                        <!-- Dynamic JS will inject here -->
                    </div>
                </div>
                <!-- <span class="bg-red-600 text-white px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Livestream
                </span> -->
            </div>

        </div>
    </div>

<!-- MAIN HEADER -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="h-12 w-12 rounded-full object-cover border-2 border-emerald-600 shadow-sm" onerror="this.src='https://via.placeholder.com/50'">
                <div>
                    <span class="text-xl font-black tracking-tight text-gray-900 block leading-none">Kiwi Batangas</span>
                    <span class="text-[11px] font-bold text-emerald-700 tracking-widest uppercase">Digital News Portal</span>
                </div>
            </a>

            <!-- Search Bar and Admin Login Container -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Search Bar -->
                <form action="/" method="GET" class="flex items-center w-full md:w-96">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Maghanap ng balita, paksa..." class="w-full bg-gray-50 border border-gray-300 rounded-full py-1.5 pl-4 pr-10 text-sm focus:outline-none focus:border-emerald-700">
                        <button type="submit" class="absolute right-3 top-2 text-gray-500 hover:text-emerald-700">
                            <i class="fa-solid fa-magnifying-glass"></i>
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
            <div class="max-w-7xl mx-auto px-4 flex items-center space-x-2 overflow-x-auto py-2.5 text-sm font-bold">
                <a href="/" class="px-4 py-1.5 rounded-full {{ request('category') == '' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Mga Balita</a>
                <a href="/?category=Agrikultura" class="px-4 py-1.5 rounded-full {{ request('category') == 'Agrikultura' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Agrikultura</a>
                <a href="/?category=Negosyo" class="px-4 py-1.5 rounded-full {{ request('category') == 'Negosyo' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Negosyo</a>
                <a href="/?category=Tech+%26+Innovation" class="px-4 py-1.5 rounded-full {{ request('category') == 'Tech & Innovation' ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Tech & Innovation</a>
                <a href="/?category=Chismis" class="px-4 py-1.5 rounded-full {{ request('category') == 'Chismis' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white' }} transition"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Chismis</a>
            </div>
        </div>
    </header>

   <!-- BREAKING NEWS TICKER -->
@if($breakingNews->count() > 0)
<div class="bg-emerald-50 border-y border-emerald-100 text-emerald-900 text-xs py-2 px-4 overflow-hidden">
    <div class="max-w-7xl mx-auto flex items-center space-x-3">
        <!-- Badge -->
        <span class="bg-emerald-700 text-white font-bold px-2 py-0.5 rounded uppercase text-[10px] whitespace-nowrap flex items-center gap-1 shrink-0 z-10">
            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Just In
        </span>
        
        <!-- Scrolling Container -->
        <div class="relative w-full overflow-hidden flex items-center whitespace-nowrap">
            <div class="inline-flex space-x-12" style="display: inline-flex; animation: marquee 25s linear infinite;" onmouseover="this.style.animationPlayState='paused';" onmouseout="this.style.animationPlayState='running';">
                
                <!-- Unang set ng mga balita -->
                @foreach($breakingNews as $item)
                    <div class="inline-flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 inline-block"></span>
                        <a href="#" class="hover:underline hover:text-emerald-700 font-medium text-gray-800">
                            {{ $item->title }}
                        </a>
                    </div>
                @endforeach

                <!-- Pangalawang set (Para sa seamless loop/walang putol na pag-ikot) -->
                @foreach($breakingNews as $item)
                    <div class="inline-flex items-center space-x-2" aria-hidden="true">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 inline-block"></span>
                        <span class="font-medium text-gray-800">
                            {{ $item->title }}
                        </span>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<!-- Keyframe para sa Inline Style -->
<style>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>
@endif
    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 py-6 bg-white">

        <!-- HERO SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            
            <!-- Lead Featured Story -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm">
                @if($featuredStory)
                    <div class="relative">
                        <img src="{{ $featuredStory->image_url ?? 'https://via.placeholder.com/800x450' }}" alt="Lead Story" class="w-full h-80 object-cover">
                        <span class="absolute top-4 left-4 bg-emerald-700 text-white text-xs font-bold uppercase px-3 py-1 rounded shadow-sm">Featured</span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">{{ $featuredStory->category }}</span>
                        <h1 class="text-2xl font-black text-gray-900 hover:text-emerald-700 transition mt-1 mb-2">
                            <a href="#">{{ $featuredStory->title }}</a>
                        </h1>
                        <p class="text-gray-600 text-sm mb-4">{{ $featuredStory->excerpt }}</p>
                        <span class="text-xs text-gray-400 flex items-center">
                            <i class="fa-regular fa-clock mr-1"></i> {{ $featuredStory->published_at ? $featuredStory->published_at->diffForHumans() : 'Just now' }}
                        </span>
                    </div>
                @else
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=800&q=80" alt="Lead Story" class="w-full h-80 object-cover">
                        <span class="absolute top-4 left-4 bg-emerald-700 text-white text-xs font-bold uppercase px-3 py-1 rounded shadow-sm">Featured</span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Agrikultura & Teknolohiya</span>
                        <h1 class="text-2xl font-black text-gray-900 hover:text-emerald-700 transition mt-1 mb-2">
                            <a href="#">Makabagong Sistema sa Pagsasaka, Inilunsad sa mga Bayan ng Batangas</a>
                        </h1>
                        <p class="text-gray-600 text-sm mb-4">
                            Isinusulong ng lokal na pamahalaan at mga kooperatiba ang paggamit ng automated smart irrigation at digital marketplace upang mapataas ang ani ng mga magsasaka sa lalawigan.
                        </p>
                        <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> 15 minuto ang nakalipas</span>
                    </div>
                @endif
            </div>

            <!-- SIDEBAR -->
            <div class="flex flex-col gap-6">
                
                <!-- KIWI PARTNER PROMO / ADVERTISEMENT BOX -->
<div class="bg-white border border-amber-200 rounded-xl shadow-xs overflow-hidden transition-all duration-300 hover:shadow-md">
    <!-- Header Label -->
    <div class="bg-amber-50 px-4 py-2 border-b border-amber-100 flex justify-between items-center">
        <span class="text-[11px] font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
            <i class="fa-solid fa-bullhorn text-amber-600"></i> Kiwi Partner Promo
        </span>
        <span class="text-[9px] bg-amber-200 text-amber-900 font-semibold px-2 py-0.5 rounded-full uppercase">Sponsored / Ad</span>
    </div>

    <!-- Ad Content -->
    <div class="p-4">
        <!-- Banner Image (Gamit ang tamang asset o placeholder na hindi nasisira) -->
        <div class="relative group overflow-hidden rounded-lg mb-3 bg-gray-100 aspect-video flex items-center justify-center">
            <!-- Halimbawa ng Banner Image (Palitan mo na lang ngstorage/url ng ad mo) -->
            <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=600&q=80" 
                 alt="Burger Promo" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            
            <!-- Overlay Tag -->
            <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[10px] font-medium px-2 py-0.5 rounded">
                Limited Offer
            </span>
        </div>

        <!-- Ad Details / Copy -->
        <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1 hover:text-emerald-700 transition-colors">
            Burger Bundle Special Deal!
        </h4>
        <p class="text-xs text-gray-600 mb-4 leading-relaxed">
            Gamitin ang promo code na <strong class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">KIWIBATANGAS</strong> para sa libreng delivery.
        </p>

        <!-- Call to Action Button -->
        <a href="#" target="_blank" 
           class="block w-full text-center bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold py-2.5 px-4 rounded-lg shadow-xs transition-all duration-200 flex items-center justify-center gap-2 group">
            <span>Alamin Pa</span>
            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>

                <!-- Top Stories -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex-1">
                    <h2 class="text-base font-black border-b-2 border-emerald-700 pb-2 mb-4 uppercase tracking-wider text-gray-900 flex justify-between items-center">
                        <span>Top Stories</span>
                        <i class="fa-solid fa-bolt text-emerald-700"></i>
                    </h2>
                    <div class="divide-y divide-gray-100">
                        @forelse($topStories as $story)
                            <div class="py-3 first:pt-0 last:pb-0 flex items-center space-x-3">
                                <img src="{{ $story->image_url ?? 'https://via.placeholder.com/80' }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0" alt="Thumbnail">
                                <div>
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $story->category }}</span>
                                    <h3 class="font-bold text-xs text-gray-800 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                        <a href="#">{{ $story->title }}</a>
                                    </h3>
                                    <span class="text-[10px] text-gray-400 mt-1 block"><i class="fa-regular fa-clock mr-1"></i> {{ $story->published_at ? $story->published_at->diffForHumans() : '' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-2 flex items-center space-x-3">
                                <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=150&q=80" class="w-16 h-16 object-cover rounded-md flex-shrink-0" alt="Thumbnail">
                                <div>
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase">Negosyo</span>
                                    <h3 class="font-bold text-xs text-gray-800 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                        <a href="#">Local coffee enterprises expand exports to international markets.</a>
                                    </h3>
                                    <span class="text-[10px] text-gray-400 mt-1 block"><i class="fa-regular fa-clock mr-1"></i> 2 oras ang nakalipas</span>
                                </div>
                            </div>
                            <div class="py-2 flex items-center space-x-3">
                                <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=150&q=80" class="w-16 h-16 object-cover rounded-md flex-shrink-0" alt="Thumbnail">
                                <div>
                                    <span class="text-[10px] font-bold text-emerald-700 uppercase">Tech & Innovation</span>
                                    <h3 class="font-bold text-xs text-gray-800 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                        <a href="#">New software framework approved for regional development.</a>
                                    </h3>
                                    <span class="text-[10px] text-gray-400 mt-1 block"><i class="fa-regular fa-clock mr-1"></i> 4 na oras ang nakalipas</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

        <!-- ARTICLES GRID SECTION -->
        <section class="mb-12">
            <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2 mb-6">
                <h2 class="text-xl font-black uppercase text-emerald-900">
                    {{ request('category') ? 'Kategorya: ' . request('category') : 'Mga Pinakahuling Balita' }}
                </h2>
                @if(request('search') || request('category'))
                    <a href="/" class="text-xs font-bold bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">I-reset ang Salain</a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($articles as $article)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm hover:shadow transition">
                        <img src="{{ $article->image_url ?? 'https://via.placeholder.com/400x250' }}" alt="Thumbnail" class="w-full h-44 object-cover">
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $article->category }}</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">{{ $article->title }}</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> {{ $article->published_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm hover:shadow transition">
                        <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80" alt="Thumbnail" class="w-full h-44 object-cover">
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase">Agrikultura</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">Pagpapalawak ng taniman ng kape sa Lipa City, sinimulan na</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> 1 oras ang nakalipas</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm hover:shadow transition">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=400&q=80" alt="Thumbnail" class="w-full h-44 object-cover">
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase">Negosyo</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">Mga bagong negosyo sa Sto. Tomas lumago ngayong taon</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> 3 oras ang nakalipas</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm hover:shadow transition">
                        <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=400&q=80" alt="Thumbnail" class="w-full h-44 object-cover">
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase">Tech & Innovation</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">Digital hubs itinatayo para sa mga kabataang tech innovators</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> 5 oras ang nakalipas</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm hover:shadow transition">
                        <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=400&q=80" alt="Thumbnail" class="w-full h-44 object-cover">
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-amber-700 uppercase">Chismis</span>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="#">Sino nga ba ang artistang nag-shopping sa Tanauan Public Market?</a>
                                </h3>
                            </div>
                            <span class="text-xs text-gray-400 flex items-center"><i class="fa-regular fa-clock mr-1"></i> Kahapon</span>
                        </div>
                    </div>
                @endforelse
            </div>
            
            
        </section>

        <!-- VIDEO & LIVESTREAM SPOTLIGHT ROW -->
        <div class="mb-12 bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3">
                <h3 class="font-black text-lg text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-play text-emerald-700"></i> Kiwi Video Reports & Livestream
                </h3>
                <span class="bg-red-600 text-white rounded-full px-3 py-0.5 text-xs font-bold uppercase">BALITANG BATANGAS</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-2xs">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=500&q=80" alt="Video" class="w-full h-36 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <i class="fa-solid fa-circle-play text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-3 text-xs font-bold text-gray-800">Ulat Panahon: Pag-ulan sa Lipa at Tanauan City</div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-2xs">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=500&q=80" alt="Video" class="w-full h-36 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <i class="fa-solid fa-circle-play text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-3 text-xs font-bold text-gray-800">Special Report: Pagsulong ng Agri-Tech sa Lalawigan</div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-2xs">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=500&q=80" alt="Video" class="w-full h-36 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <i class="fa-solid fa-circle-play text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-3 text-xs font-bold text-gray-800">Tech Spotlight: Bagong Sistema para sa Komunidad</div>
                </div>
            </div>
        </div>

        <!-- FULL-WIDTH NEWSLETTER SECTION -->
        <div class="mb-6 bg-emerald-800 text-white p-6 md:p-8 rounded-xl shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <div>
                    <span class="bg-white text-emerald-900 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider inline-block mb-2">
                        <i class="fa-solid fa-envelope-open-text mr-1"></i> Kiwi Batangas Express
                    </span>
                    <h3 class="text-xl font-black mb-2">Manatiling Huli at Updated sa mga Balita</h3>
                    <p class="text-xs text-emerald-100">
                        Mag-subscribe sa aming araw-araw na newsletter para sa pinakabagong balita sa Agrikultura, Negosyo, at Teknolohiya diretso sa iyong inbox.
                    </p>
                </div>
                <div>
                    <form class="flex flex-col sm:flex-row gap-2">
                        <input type="email" class="rounded-full py-2 px-4 text-xs text-gray-900 bg-white border-0 focus:outline-none w-full" placeholder="Ilagay ang iyong Email Address..." required>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white rounded-full px-6 py-2 text-xs font-bold transition whitespace-nowrap">
                            Sumali Na <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </form>
                    <small class="text-emerald-200 text-[10px] mt-2 block">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Walang spam. Maaari kang mag-unsubscribe anumang oras.
                    </small>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-100 text-gray-700 py-10 border-t border-gray-200 text-sm">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

        
            
            <!-- Col 1: About -->
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <img src="{{ asset('images/logo.kiwi.jpg') }}" class="w-8 h-8 rounded-full object-cover border border-emerald-600" onerror="this.src='https://via.placeholder.com/40'">
                    <span class="font-black text-gray-900 text-base">Kiwi Batangas</span>
                </div>
                <p class="text-xs text-gray-600 mb-4">Ang nangungunang pahayagang digital para sa mga pinakabagong balita, agrikultura, negosyo, at teknolohiya sa lalawigan ng Batangas.</p>
                <div class="flex space-x-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 hover:bg-emerald-700 hover:text-white transition"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 hover:bg-emerald-700 hover:text-white transition"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 hover:bg-emerald-700 hover:text-white transition"><i class="fa-brands fa-youtube text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 hover:bg-emerald-700 hover:text-white transition"><i class="fa-solid fa-envelope text-xs"></i></a>
                </div>
            </div>

            <!-- Col 2: Mga Kategorya -->
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Mga Kategorya</p>
                <ul class="text-xs space-y-2">
                    <li><a href="/?category=Pangunahing+Balita" class="hover:text-emerald-700 transition">Pangunahing Balita</a></li>
                    <li><a href="/?category=Agrikultura" class="hover:text-emerald-700 transition">Agrikultura</a></li>
                    <li><a href="/?category=Negosyo" class="hover:text-emerald-700 transition">Negosyo at Pamumuhunan</a></li>
                    <li><a href="/?category=Tech+%26+Innovation" class="hover:text-emerald-700 transition">Tech & Innovation</a></li>
                    <li><a href="/?category=Showbiz" class="hover:text-emerald-700 transition">Showbiz at Kultura</a></li>
                </ul>
            </div>

            <!-- Col 3: Tulong at Impormasyon -->
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Tulong at Impormasyon</p>
                <ul class="text-xs space-y-2">
                    <li><a href="#" class="hover:text-emerald-700 transition">Tungkol sa Amin</a></li>
                    <li><a href="#" class="hover:text-emerald-700 transition">Eskedyul ng Balita</a></li>
                    <li><a href="#" class="hover:text-emerald-700 transition">VoxGuard Safety</a></li>
                    <li><a href="#" class="hover:text-emerald-700 transition">Makipag-ugnayan</a></li>
                    <li><a href="#" class="hover:text-emerald-700 transition">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Col 4: Tanggapan at Ugnayan -->
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Tanggapan at Ugnayan</p>
                <p class="text-xs text-gray-600 mb-2 flex items-start gap-1"><i class="fa-solid fa-location-dot text-emerald-700 mt-0.5"></i> Lipa City, Batangas, Philippines</p>
                <p class="text-xs text-gray-600 mb-2 flex items-center gap-1"><i class="fa-solid fa-phone text-emerald-700"></i> (+63) 912-345-6789</p>
                <p class="text-xs text-gray-600 mb-3 flex items-center gap-1"><i class="fa-solid fa-envelope text-emerald-700"></i> news@kiwibatangas.ph</p>
                <span class="inline-block bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded border border-emerald-300">
                    <i class="fa-solid fa-shield-check mr-1"></i> Official Digital Press Verification
                </span>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-4 border-t border-gray-200 pt-4 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Kiwi Batangas. All Rights Reserved. Powered by Kiwi Digital Tech.</p>
            <div class="flex space-x-4 mt-2 md:mt-0">
                <a href="#" class="hover:underline">Terms of Service</a>
                <span>&bull;</span>
                <a href="#" class="hover:underline">Editorial Guidelines</a>
                <span>&bull;</span>
                <a href="#" class="hover:underline">Sitemap</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript para sa Exact BSP Reference Exchange Rate Rotator -->
    <script>
        const bspRates = [
            { symbol: 'USD/PHP', name: 'US Dollar', rate: '₱61.6750' },
            { symbol: 'JPY/PHP', name: 'Japanese Yen', rate: '₱0.3765' },
            { symbol: 'GBP/PHP', name: 'British Pound', rate: '₱81.9722' },
            { symbol: 'SGD/PHP', name: 'Singapore Dollar', rate: '₱47.7545' }
        ];
        let currentIndex = 0;
        const rotatorEl = document.getElementById('fx-rotator');

        function updateRate() {
            if (bspRates.length > 0) {
                let item = bspRates[currentIndex];
                rotatorEl.style.opacity = 0;
                setTimeout(() => {
                    rotatorEl.innerHTML = `<strong>${item.symbol}</strong>: <span class="text-gray-900 font-bold">${item.rate}</span>`;
                    rotatorEl.style.opacity = 1;
                }, 300);
                
                currentIndex = (currentIndex + 1) % bspRates.length;
            }
        }

        if (bspRates.length > 0) {
            updateRate();
            setInterval(updateRate, 3500);
        }
    </script>

    <script>
        // JavaScript para sa Breaking News Ticker Rotator
        document.addEventListener("DOMContentLoaded", function () {
            const newsItems = document.querySelectorAll("#breaking-news-slider .news-item");
            if (newsItems.length > 1) {
                let currentIndex = 0;

                setInterval(() => {
                    newsItems[currentIndex].classList.add("hidden");
                    newsItems[currentIndex].classList.remove("block");

                    currentIndex = (currentIndex + 1) % newsItems.length;

                    newsItems[currentIndex].classList.remove("hidden");
                    newsItems[currentIndex].classList.add("block");
                }, 4000); // Palitan ang balita kada 4 na segundo
            }
        });
    </script>

</body>
</html>