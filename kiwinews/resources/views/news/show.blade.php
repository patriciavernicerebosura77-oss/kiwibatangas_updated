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
            <!-- Dynamic Back Button sa Header -->
            <a href="{{ $previousUrl ?? route('home') }}" class="text-xs font-bold bg-gray-100 text-gray-700 px-3.5 py-1.5 rounded-full hover:bg-emerald-700 hover:text-white transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Bumalik
            </a>
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

        <!-- Featured Image (Fitted) -->
        @if($article->image_url)
            <div class="w-full bg-gray-950 rounded-xl overflow-hidden mb-6 flex items-center justify-center">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-auto object-contain max-h-[550px]">
            </div>
        @endif

        <!-- Article Body / Full Info -->
        <div class="prose max-w-none text-gray-800 text-base md:text-lg leading-relaxed space-y-4">
            {!! nl2br(e($article->body)) !!}
        </div>

        <!-- Share / Back Button Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between items-center">
            <!-- Dynamic Back Button sa Footer -->
            <a href="{{ $previousUrl ?? route('home') }}" class="text-xs font-bold bg-emerald-700 text-white px-4 py-2 rounded-lg hover:bg-emerald-800 transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Bumalik sa Kategorya
            </a>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-100 text-gray-700 py-6 border-t border-gray-200 text-xs text-center mt-12">
        <p>&copy; {{ date('Y') }} Kiwi Batangas. All Rights Reserved.</p>
    </footer>

</body>
</html>