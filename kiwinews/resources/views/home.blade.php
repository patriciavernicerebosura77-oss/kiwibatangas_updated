<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiwi Batangas | Digital News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
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
        .news-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-4px) scale(1.01);
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans">



    <!-- MAIN HEADER -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col md:flex-row justify-between items-center gap-3">
            <a href="/" class="flex items-center space-x-2.5">
                <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="h-11 w-11 rounded-full object-cover border-2 border-emerald-600 shadow-sm" onerror="this.src='https://via.placeholder.com/50'">
                <div>
                    <span class="text-xl font-black tracking-tight text-gray-900 block leading-none">Kiwi Batangas</span>
                    <span class="text-[10px] font-bold text-emerald-700 tracking-widest uppercase">Digital News Portal</span>
                </div>
            </a>

            <div class="bg-white-100 text-gray-700 text-xs py-1.5 px-3 border-b border-white-200">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex items-center space-x-4">
            <span><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::now('Asia/Manila')->format('l, F j, Y') }}</span>
            
            <!-- WEATHER SECTION (Non-redirecting, accurate live forecast) -->
            <div class="flex items-center space-x-1.5 bg-white px-2.5 py-0.5 rounded border border-gray-300 shadow-2xs">
                <i id="weather-icon" class="fa-solid fa-cloud-sun text-amber-500 text-sm"></i>
                <div class="flex items-center space-x-1 font-medium text-gray-800">
                    <span id="weather-location" class="font-bold text-gray-900">loading...</span>
                    <span id="weather-temp" class="text-emerald-700 font-black">--°C</span>
                    <span class="text-gray-400 font-normal text-[10px]">| Weather</span>
                </div>
            </div>
        </div>

        <!-- BSP FX RATES SECTION (Auto-updating live rates with direct official BSP link) -->
        <a href="https://www.bsp.gov.ph/SitePages/Statistics/ExchangeRate.aspx" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-2 bg-white px-2.5 py-0.5 rounded border border-gray-300 shadow-2xs hover:border-emerald-600 transition group">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-emerald-700">BSP FX Rates:</span>
            <div id="fx-rotator" class="font-medium text-xs text-emerald-800 transition-opacity duration-500">
                <span class="text-gray-400 italic">loading...</span>
            </div>
            <i class="fa-solid fa-external-link-alt text-[8px] text-gray-400 group-hover:text-emerald-700 ml-0.5"></i>
        </a>
    </div>
</div>

            <div class="flex items-center gap-2.5 w-full md:w-auto">
                <form action="/" method="GET" class="flex items-center w-full md:w-80">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Maghanap ng balita, paksa..." class="w-full bg-gray-50 border border-gray-300 rounded-full py-1.5 pl-3.5 pr-9 text-sm focus:outline-none focus:border-emerald-700">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <button type="submit" class="absolute right-3 top-2 text-gray-500 hover:text-emerald-700">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- DYNAMIC NAVIGATION BAR -->
        <div class="max-w-7xl mx-auto px-4 flex items-center space-x-2 overflow-x-auto py-2 text-sm font-bold">
            <a href="{{ route('home', array_filter(['search' => request('search')])) }}" class="px-3.5 py-1.5 rounded-full {{ (!request('category') || request('category') == '') ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">Mga Balita</a>
            
            @php
                $navCategories = \App\Models\Category::orderBy('sort_order', 'asc')->get();
            @endphp

            @foreach($navCategories as $cat)
                <a href="{{ route('home', array_filter(['category' => $cat->name, 'search' => request('search')])) }}" class="px-3.5 py-1.5 rounded-full {{ request('category') == $cat->name ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100 hover:text-emerald-800' }} transition">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </header>

    @if(isset($breakingNews) && $breakingNews->count() > 0)
<div class="bg-emerald-50 border-y border-emerald-100 text-emerald-900 text-xs py-2 px-4 overflow-hidden scroll-fade">
    <div class="max-w-7xl mx-auto flex items-center space-x-3">
        <span class="bg-emerald-700 text-white font-bold px-2 py-0.5 rounded uppercase text-[10px] whitespace-nowrap flex items-center gap-1.5 shrink-0 z-10 shadow-2xs">
            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Just In
        </span>
        
        <div id="marquee-container" class="relative w-full overflow-hidden flex items-center whitespace-nowrap cursor-pointer">
            <div id="marquee-track" class="inline-flex items-center space-x-12 shrink-0">
                @foreach($breakingNews as $item)
                    <div class="inline-flex items-center space-x-2 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 inline-block"></span>
                        <a href="{{ route('news.show', $item->id) }}" class="hover:underline hover:text-emerald-700 font-semibold text-gray-900">{{ $item->title }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById('marquee-container');
    const track = document.getElementById('marquee-track');
    if (!container || !track) return;
    const originalContent = track.innerHTML;
    track.innerHTML = originalContent + originalContent + originalContent + originalContent + originalContent;
    let scrollPos = 0;
    const speed = 0.8; 
    let isPaused = false;
    function step() {
        if (!isPaused) {
            scrollPos += speed;
            let singleSetWidth = track.scrollWidth / 5;
            if (scrollPos >= singleSetWidth) { scrollPos -= singleSetWidth; }
            track.style.transform = `translateX(-${scrollPos}px)`;
        }
        requestAnimationFrame(step);
    }
    container.addEventListener('mouseenter', () => isPaused = true);
    container.addEventListener('mouseleave', () => isPaused = false);
    requestAnimationFrame(step);
});
</script>
@endif

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 py-8 bg-white">

       <!-- KUNG MAY NAG-SEARCH O MAY PINILING CATEGORY -->
       @if(request('search') || (request('category') && request('category') != ''))
       <div class="flex flex-col lg:flex-row gap-8 mb-8 scroll-fade">
           
<div class="w-full @if((request('category') && request('category') != 'All') || request('search')) lg:w-2/3 @else w-full @endif flex flex-col gap-8">               <section class="scroll-fade">
                   <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2 mb-6">
                       <div>
                           <p class="text-xs font-black uppercase tracking-wider text-gray-500">Resulta ng Salain</p>
                           <h2 class="text-2xl font-black uppercase text-emerald-900 mt-1">
                               @if(request('search') && request('category'))
                                   Search: "{{ request('search') }}" sa Kategoryang "{{ request('category') }}"
                               @elseif(request('search'))
                                   Search: "{{ request('search') }}"
                               @elseif(request('category') == 'All')
                                   Lahat ng Balita
                               @else
                                   Kategorya: {{ request('category') }}
                               @endif
                           </h2>
                       </div>
                       <!-- <a href="/" class="text-xs font-bold bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition">I-reset ang Salain</a> -->
                   </div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                           @forelse($articles as $article)
                           <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card">
                               @if($article->image_url)
    <div class="w-full h-48 relative overflow-hidden">
        <a href="{{ route('news.show', $article->id) }}" class="block w-full h-full">
            <img src="{{ $article->image_url }}" alt="Thumbnail" class="w-full h-full object-cover">
        </a>
        <span class="absolute top-3 left-3 bg-emerald-700 text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded shadow z-10">{{ $article->category }}</span>
    </div>
@endif
                               <div class="p-4 flex-1 flex flex-col justify-between">
                                   <div>
                                       <div class="flex items-center gap-2 mb-1">
                                           @if(!$article->image_url)
                                               <span class="text-xs font-bold text-emerald-700 uppercase">{{ $article->category }}</span>
                                           @endif
                                           @if($article->created_at && \Carbon\Carbon::parse($article->created_at)->diffInHours(\Carbon\Carbon::now()) <= 24)
                                               <span class="bg-emerald-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider animate-pulse shadow-2xs">NEW</span>
                                           @endif
                                       </div>
                                       <h3 class="font-bold text-base text-gray-900 hover:text-emerald-700 transition leading-snug mt-1 mb-2">
                                           <a href="{{ route('news.show', $article->id) }}">{{ $article->title }}</a>
                                       </h3>
                                       <p class="text-xs text-gray-600 line-clamp-2 mb-4">
                                           {{ $article->excerpt ?? Str::limit(strip_tags($article->body), 90) }}
                                       </p>
                                   </div>
                                   <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-500">
                                       <span class="flex items-center font-medium">
                                           <i class="fa-regular fa-clock text-emerald-700 mr-1.5"></i> 
                                           {{ $article->created_at ? \Carbon\Carbon::parse($article->created_at)->setTimezone('Asia/Manila')->format('M j, Y') : 'Kamakailan' }}
                                       </span>
                                       <a href="{{ route('news.show', $article->id) }}" class="font-bold text-emerald-700 hover:underline flex items-center gap-1">Basahin <i class="fa-solid fa-arrow-right text-[9px]"></i></a>
                                   </div>
                               </div>
                           </div>
                       @empty
                           <div class="col-span-full py-16 text-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                               <i class="fa-solid fa-triangle-exclamation text-3xl text-amber-500 mb-2 block"></i>
                               <p class="font-bold text-gray-800">Walang nakitang balita na tugma sa iyong hinahanap.</p>
                               <p class="text-xs text-gray-500 mt-1">Subukang mag-type ng ibang salita o i-clear ang paghahanap.</p>
                           </div>
                       @endforelse
                   </div>

                   @if(method_exists($articles, 'links'))
                       <div class="mt-8">
                           {{ $articles->links() }}
                       </div>
                   @endif
               </section>
           </div>

           <!-- Sidebar para sa Specific Category o Search results -->
           @if((request('category') && request('category') != 'All') || request('search'))
           <div class="w-full lg:w-1/3 flex flex-col gap-6">
               @php
    $activeAd = \App\Models\Ad::where('is_active', true)->latest()->first();
@endphp

@php
    // Kunin ang mga active ads mula sa database
    $dynamicAds = \App\Models\Ad::latest()->get();
@endphp

@forelse($dynamicAds as $ad)
<div class="bg-white border border-amber-200 rounded-xl shadow-xs overflow-hidden news-card mb-4">
    <div class="bg-amber-50 px-4 py-2 border-b border-amber-100 flex justify-between items-center">
        <span class="text-xs font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
            <i class="fa-solid fa-bullhorn text-amber-600"></i> {{ $ad->badge_text ?? 'Kiwi Partner Promo' }}
        </span>
        <span class="text-[10px] bg-amber-200 text-amber-900 font-semibold px-2 py-0.5 rounded-full uppercase">Sponsored / Ad</span>
    </div>
    <div class="p-4">
        @if($ad->image_url)
        <div class="relative group overflow-hidden rounded-lg mb-3 bg-gray-900 flex items-center justify-center">
    <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="w-full h-auto object-contain max-h-64 transition-transform duration-500">
    <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[11px] font-medium px-2 py-0.5 rounded z-10">Limited Offer</span>
</div>
        @endif
        <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1 hover:text-emerald-700 transition-colors">{{ $ad->title }}</h4>
        
        @if($ad->description)
        <p class="text-xs text-gray-700 mb-2 leading-relaxed">
            {{ $ad->description }}
        </p>
        @endif

        @if($ad->promo_code)
        <p class="text-xs text-gray-700 mb-3 leading-relaxed">
            Gamitin ang promo code na <strong class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">{{ $ad->promo_code }}</strong>.
        </p>
        @endif

        <a href="{{ $ad->button_link ?? '#' }}" target="_blank" class="block w-full text-center bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold py-2.5 px-4 rounded-lg shadow-xs transition-all duration-200 flex items-center justify-center gap-2 group">
            <span>{{ $ad->button_text ?? 'Alamin Pa' }}</span>
            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>
@empty
<!-- Kung walang ads, hindi na magpapakita ng lumang hardcode kundi malinis na mawawala -->
@endforelse

               <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm news-card">
                   <h2 class="text-sm font-black border-b-2 border-emerald-700 pb-2 mb-3 uppercase tracking-wider text-gray-900 flex justify-between items-center">
                       <span>Top Stories (Hot Search)</span>
                       <i class="fa-solid fa-bolt text-emerald-700"></i>
                   </h2>
                   <div class="divide-y divide-gray-100">
                       @isset($topStories)
                           @forelse($topStories as $index => $story)
                               <div class="py-2.5 first:pt-0 last:pb-0 flex items-start space-x-3">
                                   <span class="flex items-center justify-center bg-emerald-100 text-emerald-800 font-black text-xs w-6 h-6 rounded-full shrink-0 mt-0.5">
                                       {{ $index + 1 }}
                                   </span>
                                   @if($story->image_url)
                                       <a href="{{ route('news.show', $story->id) }}" class="shrink-0">
                                           <img src="{{ $story->image_url }}" class="w-12 h-12 object-cover rounded-md" alt="Thumbnail">
                                       </a>
                                   @endif
                                   <div class="min-w-0 flex-1">
                                       <div class="flex items-center gap-1.5">
                                           <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $story->category }}</span>
                                           <!-- @if(isset($story->views))
                                               <span class="text-[9px] text-gray-400 font-semibold"><i class="fa-solid fa-eye mr-0.5"></i> {{ number_format($story->views) }}</span>
                                           @endif -->
                                       </div>
                                       <h3 class="font-bold text-xs text-gray-900 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                           <a href="{{ route('news.show', $story->id) }}">{{ $story->title }}</a>
                                       </h3>
                                   </div>
                               </div>
                           @empty
                               <div class="py-2 text-xs text-gray-500 text-center">Walang top stories.</div>
                           @endforelse
                       @endisset
                   </div>
               </div>
           </div>
           @endif

       </div>
       @endif


       <!-- KUNG WALA PANG SEARCH O CATEGORY (DEFAULT HOMEPAGE VIEW) -->
       @if(!request('search') && (!request('category') || request('category') == ''))
       <div class="flex flex-col lg:flex-row gap-8 mb-8 scroll-fade">
           
           <div class="w-full lg:w-2/3 flex flex-col gap-6">
               <section class="scroll-fade">
                   <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2 mb-6">
                       <div>
                           <p class="text-xs font-black uppercase tracking-wider text-gray-500">Pinakabagong Balita</p>
                           <h2 class="text-2xl font-black uppercase text-emerald-900 mt-1">Mga Balita</h2>
                       </div>
                   </div>

                   @php
                       $latestStory = $featuredStories->first();
                   @endphp

                   @if($latestStory)
                       <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card mb-6">
                           @if($latestStory->image_url)
                               <div class="w-full h-72 sm:h-96 relative overflow-hidden">
                                   <a href="{{ route('news.show', $latestStory->id) }}" class="block w-full h-full">
                                       <img src="{{ $latestStory->image_url }}" alt="Latest Thumbnail" class="w-full h-full object-cover">
                                   </a>
                                   <span class="absolute top-3 left-3 bg-emerald-700 text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded shadow z-10">{{ $latestStory->category }}</span>
                               </div>
                           @endif
                           <div class="p-5 flex-1 flex flex-col justify-between">
                               <div>
                                   <div class="flex items-center gap-2 mb-1">
                                       @if(!$latestStory->image_url)
                                           <span class="text-xs font-bold text-emerald-700 uppercase">{{ $latestStory->category }}</span>
                                       @endif
                                       @if($latestStory->created_at && \Carbon\Carbon::parse($latestStory->created_at)->diffInHours(\Carbon\Carbon::now()) <= 24)
                                           <span class="bg-emerald-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider animate-pulse shadow-2xs">NEW</span>
                                       @endif
                                   </div>
                                   <h3 class="font-black text-xl text-gray-900 hover:text-emerald-700 transition leading-snug mt-1 mb-2">
                                       <a href="{{ route('news.show', $latestStory->id) }}">{{ $latestStory->title }}</a>
                                   </h3>
                                   <p class="text-xs md:text-sm text-gray-600 line-clamp-3 mb-4">
                                       {{ $latestStory->excerpt ?? Str::limit(strip_tags($latestStory->body), 120) }}
                                   </p>
                               </div>
                               <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-500">
                                   <span class="flex items-center font-medium">
                                       <i class="fa-regular fa-clock text-emerald-700 mr-1.5"></i> 
                                       {{ $latestStory->created_at ? \Carbon\Carbon::parse($latestStory->created_at)->setTimezone('Asia/Manila')->format('F j, Y - g:i A') : 'Kamakailan' }}
                                   </span>
                                   <a href="{{ route('news.show', $latestStory->id) }}" class="font-bold text-emerald-700 hover:underline flex items-center gap-1">Basahin <i class="fa-solid fa-arrow-right text-[9px]"></i></a>
                               </div>
                           </div>
                       </div>
                   @endif

                   @if($featuredStories->count() > 1)
                       <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                           @foreach($featuredStories->slice(1) as $story)
                               <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card">
                                   @if($story->image_url)
                                       <div class="w-full h-48 relative overflow-hidden">
                                           <a href="{{ route('news.show', $story->id) }}" class="block w-full h-full">
                                               <img src="{{ $story->image_url }}" alt="Thumbnail" class="w-full h-full object-cover">
                                           </a>
                                           <span class="absolute top-3 left-3 bg-emerald-700 text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded shadow z-10">{{ $story->category }}</span>
                                       </div>
                                   @endif
                                   <div class="p-4 flex-1 flex flex-col justify-between">
                                       <div>
                                           <div class="flex items-center gap-2 mb-1">
                                               @if(!$story->image_url)
                                                   <span class="text-xs font-bold text-emerald-700 uppercase">{{ $story->category }}</span>
                                               @endif
                                               @if($story->created_at && \Carbon\Carbon::parse($story->created_at)->diffInHours(\Carbon\Carbon::now()) <= 24)
                                                   <span class="bg-emerald-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider animate-pulse shadow-2xs">NEW</span>
                                               @endif
                                           </div>
                                           <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                               <a href="{{ route('news.show', $story->id) }}">{{ $story->title }}</a>
                                           </h3>
                                           <p class="text-xs text-gray-600 line-clamp-2 mb-4">
                                               {{ $story->excerpt ?? Str::limit(strip_tags($story->body), 80) }}
                                           </p>
                                       </div>
                                       <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-500">
                                           <span class="flex items-center font-medium">
                                               <i class="fa-regular fa-clock text-emerald-700 mr-1.5"></i> 
                                               {{ $story->created_at ? \Carbon\Carbon::parse($story->created_at)->setTimezone('Asia/Manila')->format('M j, Y') : '' }}
                                           </span>
                                           <a href="{{ route('news.show', $story->id) }}" class="font-bold text-emerald-700 hover:underline">Basahin &rarr;</a>
                                       </div>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                   @endif
               </section>
           </div>

           <!-- Sidebar Homepage -->
           <div class="w-full lg:w-1/3 flex flex-col gap-6">
               @php
    // Kunin ang mga active ads mula sa database
    $dynamicAds = \App\Models\Ad::latest()->get();
@endphp

@forelse($dynamicAds as $ad)
<div class="bg-white border border-amber-200 rounded-xl shadow-xs overflow-hidden news-card mb-4">
    <div class="bg-amber-50 px-4 py-2 border-b border-amber-100 flex justify-between items-center">
        <span class="text-xs font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
            <i class="fa-solid fa-bullhorn text-amber-600"></i> {{ $ad->badge_text ?? 'Kiwi Partner Promo' }}
        </span>
        <span class="text-[10px] bg-amber-200 text-amber-900 font-semibold px-2 py-0.5 rounded-full uppercase">Sponsored / Ad</span>
    </div>
    <div class="p-4">
        @if($ad->image_url)
        <div class="relative group overflow-hidden rounded-lg mb-3 bg-gray-900 flex items-center justify-center">
    <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="w-full h-auto object-contain max-h-64 transition-transform duration-500">
    <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[11px] font-medium px-2 py-0.5 rounded z-10">Limited Offer</span>
</div>
        @endif
        <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1 hover:text-emerald-700 transition-colors">{{ $ad->title }}</h4>
        
        @if($ad->description)
        <p class="text-xs text-gray-700 mb-2 leading-relaxed">
            {{ $ad->description }}
        </p>
        @endif

        @if($ad->promo_code)
        <p class="text-xs text-gray-700 mb-3 leading-relaxed">
            Gamitin ang promo code na <strong class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">{{ $ad->promo_code }}</strong>.
        </p>
        @endif

        <a href="{{ $ad->button_link ?? '#' }}" target="_blank" class="block w-full text-center bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold py-2.5 px-4 rounded-lg shadow-xs transition-all duration-200 flex items-center justify-center gap-2 group">
            <span>{{ $ad->button_text ?? 'Alamin Pa' }}</span>
            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>
@empty
<!-- Kung walang ads, hindi na magpapakita ng lumang hardcode kundi malinis na mawawala -->
@endforelse

               <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm news-card">
                   <h2 class="text-sm font-black border-b-2 border-emerald-700 pb-2 mb-3 uppercase tracking-wider text-gray-900 flex justify-between items-center">
                       <span>Top Stories (Hot Search)</span>
                       <i class="fa-solid fa-bolt text-emerald-700"></i>
                   </h2>
                   <div class="divide-y divide-gray-100">
                       @isset($topStories)
                           @forelse($topStories as $index => $story)
                               <div class="py-2.5 first:pt-0 last:pb-0 flex items-start space-x-3">
                                   <span class="flex items-center justify-center bg-emerald-100 text-emerald-800 font-black text-xs w-6 h-6 rounded-full shrink-0 mt-0.5">
                                       {{ $index + 1 }}
                                   </span>

                                   @if($story->image_url)
                                       <a href="{{ route('news.show', $story->id) }}" class="shrink-0">
                                           <img src="{{ $story->image_url }}" class="w-12 h-12 object-cover rounded-md" alt="Thumbnail">
                                       </a>
                                   @endif
                                   <div class="min-w-0 flex-1">
                                       <div class="flex items-center gap-1.5">
                                           <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $story->category }}</span>
                                           <!-- @if(isset($story->views))
                                               <span class="text-[9px] text-gray-400 font-semibold"><i class="fa-solid fa-eye mr-0.5"></i> {{ number_format($story->views) }}</span>
                                           @endif -->
                                       </div>
                                       <h3 class="font-bold text-xs text-gray-900 hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                           <a href="{{ route('news.show', $story->id) }}">{{ $story->title }}</a>
                                       </h3>
                                       <span class="text-[10px] text-gray-500 mt-0.5 block"><i class="fa-regular fa-clock mr-1"></i> {{ $story->created_at ? \Carbon\Carbon::parse($story->created_at)->setTimezone('Asia/Manila')->format('M j, Y') : '' }}</span>
                                   </div>
                               </div>
                           @empty
                               <div class="py-2 text-xs text-gray-500 text-center">Walang top stories.</div>
                           @endforelse
                       @endisset
                   </div>
               </div>
           </div>
       </div>

       <!-- MGA PINAKAHULING BALITA SA HOMEPAGE -->
       <section class="mb-12 scroll-fade">
            <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2 mb-6">
                <h2 class="text-2xl font-black uppercase text-emerald-900">Mga Pinakahuling Balita</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $allLatestNews = \App\Models\Article::orderBy('created_at', 'desc')->take(8)->get();
                @endphp

                @forelse($allLatestNews as $article)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col shadow-sm news-card">
                        @if($article->image_url)
                            <div class="w-full h-44 relative overflow-hidden">
                                <a href="{{ route('news.show', $article->id) }}" class="block w-full h-full">
                                    <img src="{{ $article->image_url }}" alt="Thumbnail" class="w-full h-full object-cover">
                                </a>
                                <span class="absolute top-3 left-3 bg-emerald-700 text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded shadow z-10">{{ $article->category }}</span>
                            </div>
                        @endif
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    @if(!$article->image_url)
                                        <span class="text-xs font-bold text-emerald-700 uppercase">{{ $article->category }}</span>
                                    @endif
                                    @if($article->created_at && \Carbon\Carbon::parse($article->created_at)->diffInHours(\Carbon\Carbon::now()) <= 24)
                                        <span class="bg-emerald-600 text-white text-[10px] font-black px-1.5 py-0.2 rounded uppercase tracking-wider animate-pulse">NEW</span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-sm text-gray-900 hover:text-emerald-700 transition line-clamp-2 mt-1 mb-2">
                                    <a href="{{ route('news.show', $article->id) }}">{{ $article->title }}</a>
                                </h3>
                            </div>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                <span class="text-xs text-gray-500 flex items-center"><i class="fa-regular fa-clock mr-1"></i> {{ $article->created_at ? \Carbon\Carbon::parse($article->created_at)->setTimezone('Asia/Manila')->format('M j, Y') : '' }}</span>
                                <a href="{{ route('news.show', $article->id) }}" class="font-bold text-emerald-700 hover:underline text-xs">Basahin &rarr;</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        Walang nakitang mga balita.
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home', ['category' => 'All']) }}" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-8 py-3 rounded-full shadow-md transition-all duration-300 group">
                    <span>View All News</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </section>
        @endif

        <!-- FULL-WIDTH NEWSLETTER SECTION -->
        <div class="mb-6 bg-emerald-800 text-white p-6 md:p-8 rounded-xl shadow-sm scroll-fade">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <div>
                    <span class="bg-white text-emerald-900 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider inline-block mb-2">
                        <i class="fa-solid fa-envelope-open-text mr-1"></i> Kiwi Batangas Express
                    </span>
                    <h3 class="text-2xl font-black mb-2">Manatiling Huli at Updated sa mga Balita</h3>
                    <p class="text-sm text-emerald-100 leading-relaxed">
                        Mag-subscribe sa aming araw-araw na newsletter para sa pinakabagong balita sa iba't ibang kategorya direktang sa iyong inbox.
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
                <p class="text-xs text-gray-600 mb-4 leading-relaxed">Ang nangungunang pahayagang digital para sa mga pinakabagong balita sa lalawigan ng Batangas.</p>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3 border-b border-gray-300 pb-1">Mga Kategorya</p>
                <ul class="text-xs space-y-2">
                    @foreach(\App\Models\Category::orderBy('sort_order', 'asc')->get() as $cat)
                        <li><a href="{{ route('home', ['category' => $cat->name]) }}" class="hover:text-emerald-700 transition">{{ $cat->name }}</a></li>
                    @endforeach
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
                setInterval(displayNextRate, 4000);
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

    // FULLY DYNAMIC REAL-TIME WEATHER SCRIPT (No static hardcoded fallbacks)
    document.addEventListener("DOMContentLoaded", function () {
        const locationEl = document.getElementById('weather-location');
        const tempEl = document.getElementById('weather-temp');
        const weatherIconEl = document.getElementById('weather-icon');

        function fetchWeatherByCoords(lat, lon) {
            // Fetch live weather via Open-Meteo using real-time coordinates
            fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&temperature_unit=celsius`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.current) {
                        const temp = Math.round(data.current.temperature_2m);
                        tempEl.textContent = `${temp}°C`;

                        const wCode = data.current.weather_code;
                        if (wCode === 0) {
                            weatherIconEl.className = "fa-solid fa-sun text-amber-500 text-sm";
                        } else if (wCode >= 1 && wCode <= 3) {
                            weatherIconEl.className = "fa-solid fa-cloud-sun text-amber-500 text-sm";
                        } else if (wCode >= 51 && wCode <= 67) {
                            weatherIconEl.className = "fa-solid fa-cloud-rain text-blue-500 text-sm";
                        } else if (wCode >= 95) {
                            weatherIconEl.className = "fa-solid fa-cloud-bolt text-purple-500 text-sm";
                        }
                    }
                })
                .catch(err => console.error("Weather fetch error:", err));

            // Fetch live reverse geocoding to dynamically resolve exact location name on the fly
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=16&addressdetails=1`)
                .then(response => response.json())
                .then(geoData => {
                    if (geoData && geoData.address) {
                        let suburb = geoData.address.suburb || geoData.address.neighbourhood || geoData.address.village || '';
                        let town = geoData.address.city || geoData.address.municipality || geoData.address.town || '';
                        
                        let dynamicName = town;
                        if (suburb && town && suburb !== town) {
                            dynamicName = `${suburb}, ${town}`;
                        } else {
                            dynamicName = suburb || town || geoData.display_name.split(',')[0];
                        }
                        locationEl.textContent = dynamicName;
                    }
                })
                .catch(err => console.error("Geocoding error:", err));
        }

        function initLiveWeatherTracker() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        fetchWeatherByCoords(lat, lon);
                    }, 
                    function (error) {
                        // If user blocks location or GPS fails, dynamically detect location via IP-API live network lookup instead of hardcoding text
                        fetch('https://ipapi.co/json/')
                            .then(res => res.json())
                            .then(ipData => {
                                if (ipData && ipData.latitude && ipData.longitude) {
                                    locationEl.textContent = ipData.city || ipData.region;
                                    fetchWeatherByCoords(ipData.latitude, ipData.longitude);
                                } else {
                                    locationEl.textContent = "IP Location Unavailable";
                                }
                            })
                            .catch(() => {
                                locationEl.textContent = "Live Location Required";
                            });
                    }, 
                    { timeout: 12000, enableHighAccuracy: true, maximumAge: 0 }
                );
            } else {
                locationEl.textContent = "Geolocation Not Supported";
            }
        }

        // Run immediately on load
        initLiveWeatherTracker();

        // Automatically re-fetch and update live weather every 5 minutes dynamically
        setInterval(initLiveWeatherTracker, 300000);
    });
</script>
</body>
</html>