<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | Kiwi Batangas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- HEADER -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2.5">
                <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="h-11 w-11 rounded-full object-cover border-2 border-emerald-600 shadow-sm">
                <div>
                    <span class="text-xl font-black tracking-tight text-gray-900 block leading-none">Kiwi Batangas</span>
                    <span class="text-[10px] font-bold text-emerald-700 tracking-widest uppercase">Digital News Portal</span>
                </div>
            </a>
            <!-- Dynamic Back Button sa Header na gumagamit ng JavaScript history.back() -->
            <button onclick="history.back()" class="text-xs font-bold bg-gray-100 text-gray-700 px-3.5 py-1.5 rounded-full hover:bg-emerald-700 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-arrow-left mr-1"></i> Bumalik
            </button>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Category & Date -->
        <div class="flex items-center gap-2 mb-3">
            <span class="bg-emerald-700 text-white text-xs font-bold uppercase px-2.5 py-1 rounded">{{ $article->category }}</span>
            <span class="text-xs text-gray-500 flex items-center">
                <i class="fa-regular fa-clock mr-1.5"></i> 
                {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->setTimezone('Asia/Manila')->format('F j, Y - g:i A') : '' }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4 leading-tight">
            {{ $article->title }}
        </h1>

        @php
            function resolveMediaUrl($url) {
                if (empty($url)) {
                    return null;
                }

                if (preg_match('/^https?:\/\//i', $url)) {
                    return $url;
                }

                return asset('storage/' . ltrim($url, '/'));
            }

            $carouselMedia = [];
            $seenMedia = [];

            if ($article->image_url) {
                $imageUrl = resolveMediaUrl($article->image_url);
                if ($imageUrl && !isset($seenMedia[$imageUrl])) {
                    $seenMedia[$imageUrl] = true;
                    $carouselMedia[] = ['type' => 'image', 'src' => $imageUrl];
                }
            }

            if (is_array($article->images)) {
                foreach ($article->images as $image) {
                    $imageUrl = resolveMediaUrl($image);
                    if ($imageUrl && !isset($seenMedia[$imageUrl])) {
                        $seenMedia[$imageUrl] = true;
                        $carouselMedia[] = ['type' => 'image', 'src' => $imageUrl];
                    }
                }
            }

            if (!empty($article->video_url)) {
                $videoUrl = resolveMediaUrl($article->video_url);
                $isYoutube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
                $videoType = 'video';
                $videoId = null;

                if ($isYoutube) {
                    if (str_contains($videoUrl, 'youtube.com')) {
                        parse_str(parse_url($videoUrl, PHP_URL_QUERY) ?? '', $queryParams);
                        $videoId = $queryParams['v'] ?? null;
                    }

                    if (!$videoId && str_contains($videoUrl, 'youtu.be')) {
                        $videoId = ltrim(parse_url($videoUrl, PHP_URL_PATH), '/');
                    }

                    if ($videoId) {
                        $videoType = 'youtube';
                    }
                }

                if ($videoUrl && !isset($seenMedia[$videoUrl])) {
                    $seenMedia[$videoUrl] = true;
                    $carouselMedia[] = ['type' => $videoType, 'src' => $videoUrl, 'videoId' => $videoId];
                }
            }
        @endphp

        @if(count($carouselMedia))
            <div class="relative w-full rounded-xl overflow-hidden mb-3">
                <div id="carouselTrack" class="flex transition-transform duration-500" style="transform: translateX(0%);">
                    @foreach($carouselMedia as $index => $media)
                        <div class="min-w-full flex items-center justify-center bg-gray-950">
                            @if($media['type'] === 'image')
                                <img src="{{ $media['src'] }}" alt="{{ $article->title }} media {{ $index + 1 }}" class="w-full h-auto object-contain max-h-[550px]">
                            @elseif($media['type'] === 'youtube')
                                <div class="relative w-full overflow-hidden rounded-3xl" style="padding-top:56.25%;">
                                    <iframe src="https://www.youtube.com/embed/{{ $media['videoId'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute inset-0 w-full h-full"></iframe>
                                </div>
                            @else
                                <video controls class="w-full rounded-3xl bg-black">
                                    <source src="{{ $media['src'] }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if(count($carouselMedia) > 1)
                    <button id="carouselPrev" type="button" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 text-gray-900 p-2 shadow-sm hover:bg-white focus:outline-none">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button id="carouselNext" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 text-gray-900 p-2 shadow-sm hover:bg-white focus:outline-none">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <div class="absolute inset-x-0 bottom-3 flex justify-center gap-2">
                        @foreach($carouselMedia as $index => $media)
                            <button type="button" class="w-2.5 h-2.5 rounded-full bg-white/50" data-carousel-index="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(count($carouselMedia) > 1)
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const track = document.getElementById('carouselTrack');
                        const indicators = Array.from(document.querySelectorAll('[data-carousel-index]'));
                        const totalSlides = {{ count($carouselMedia) }};
                        let currentSlide = 0;

                        const updateCarousel = (index) => {
                            if (index < 0) index = totalSlides - 1;
                            if (index >= totalSlides) index = 0;
                            currentSlide = index;
                            track.style.transform = `translateX(-${index * 100}%)`;
                            indicators.forEach((btn, btnIndex) => {
                                btn.classList.toggle('bg-white', btnIndex === index);
                                btn.classList.toggle('bg-white/40', btnIndex !== index);
                            });
                        };

                        document.getElementById('carouselPrev').addEventListener('click', () => updateCarousel(currentSlide - 1));
                        document.getElementById('carouselNext').addEventListener('click', () => updateCarousel(currentSlide + 1));
                        indicators.forEach((button) => button.addEventListener('click', () => updateCarousel(Number(button.dataset.carouselIndex))));

                        updateCarousel(0);
                    });
                </script>
            @endif
        @endif

        <!-- MAIKLING BUOD (EXCERPT) - Sakto sa ibaba ng larawan, maliit, hindi madilim ang kulay, at may malambot na estilo -->
        @if(!empty($article->excerpt))
            <p class="text-xs md:text-sm text-gray-500 italic mb-6 leading-relaxed border-l-2 border-emerald-600 pl-3">
                {{ $article->excerpt }}
            </p>
        @endif

        <!-- Article Body / Full Info -->
        <div class="prose max-w-none text-gray-800 text-base md:text-lg leading-relaxed space-y-4">
            {!! nl2br(e($article->body)) !!}
        </div>

        <!-- Share / Back Button Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between items-center">
            <!-- Dynamic Back Button sa Footer na gumagamit din ng JavaScript history.back() -->
            <button onclick="history.back()" class="text-xs font-bold bg-emerald-700 text-white px-4 py-2 rounded-lg hover:bg-emerald-800 transition cursor-pointer flex items-center">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Bumalik sa Nakaraang Pahina
            </button>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-100 text-gray-700 py-6 border-t border-gray-200 text-xs text-center mt-12">
        <p>&copy; {{ date('Y') }} Kiwi Batangas. All Rights Reserved.</p>
    </footer>

</body>
</html>