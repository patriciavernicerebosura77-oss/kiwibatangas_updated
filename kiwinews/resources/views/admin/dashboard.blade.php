<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Kiwi Batangas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans text-sm selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col">
        
        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 px-8 py-4 flex justify-between items-center shadow-2xs">
            <div class="flex items-center space-x-10">
                <div class="flex items-center space-x-3">
                    <img src="https://via.placeholder.com/40" alt="Kiwi Batangas Logo" class="w-10 h-10 rounded-full object-cover border border-emerald-500 shadow-xs" id="brand-logo">
                    <div class="flex flex-col">
                        <span class="text-base font-black tracking-tight text-slate-900 leading-tight">Kiwi Batangas</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">Digital News Portal</span>
                    </div>
                </div>

                <nav class="hidden md:flex items-center space-x-2 bg-slate-100/80 p-1.5 rounded-2xl border border-slate-200/60 font-semibold text-xs">
                    <a href="#dashboard" onclick="switchTab('dashboard')" id="nav-dashboard" class="nav-tab px-4 py-2 rounded-xl bg-slate-900 text-white shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                    <a href="#articles" onclick="switchTab('articles')" id="nav-articles" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-newspaper"></i> Pamamahala ng Balita
                    </a>
                    <a href="#categories" onclick="switchTab('categories')" id="nav-categories" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree"></i> Kategorya
                    </a>
                    <a href="#analytics" onclick="switchTab('analytics')" id="nav-analytics" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-chart-line"></i> Analytics
                    </a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 px-3.5 py-2 rounded-2xl">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-xs">A</div>
                    <span class="font-bold text-xs text-slate-700 hidden sm:inline">Administrator</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-bold px-4 py-2.5 rounded-2xl transition-all flex items-center gap-2 cursor-pointer shadow-2xs">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- MAIN CONTAINER -->
        <main class="max-w-7xl w-full mx-auto px-8 py-8 flex-1">
            
            <!-- HEADER SECTION -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">News Overview</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Real-time dynamic tracking ng bawat views at clicks ng balita.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openNewsModal()" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold px-5 py-3 rounded-2xl transition-all shadow-md shadow-emerald-600/20 cursor-pointer flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Gumawa ng Bagong Balita
                    </button>
                </div>
            </div>

            <!-- TAB 1: DASHBOARD OVERVIEW -->
            <div id="tab-dashboard" class="tab-content space-y-6">
                <!-- TOP CARDS GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-lime-400 to-emerald-500 text-slate-900 p-7 rounded-3xl shadow-xl shadow-lime-500/10 relative overflow-hidden flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-slate-900/70">Kabuuang Balita</span>
                                <h3 class="text-4xl font-black mt-2 text-slate-900">{{ isset($totalArticles) ? $totalArticles : 0 }}</h3>
                            </div>
                            <div class="w-9 h-9 bg-white/45 backdrop-blur-md rounded-xl flex items-center justify-center text-slate-900">
                                <i class="fa-solid fa-arrow-up-right"></i>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2 bg-white/30 backdrop-blur-md px-3 py-1.5 rounded-full w-fit text-xs font-bold text-slate-900">
                            <i class="fa-solid fa-arrow-trend-up"></i> Active & Live Database
                        </div>
                    </div>

                    <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Categories</span>
                                <h3 class="text-4xl font-black mt-2 text-slate-900">{{ isset($categories) ? count($categories) : 0 }}</h3>
                            </div>
                            <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                                <i class="fa-solid fa-folder"></i>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full w-fit text-xs font-bold">
                            <i class="fa-solid fa-check"></i> Standard Data
                        </div>
                    </div>
                </div>

                <!-- STATISTICS & REPORTS PERFORMANCE (Dynamic Views galing sa Database) -->
                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider">Statistics & Reports Performance</h3>
                            <p class="text-xs text-slate-400 mt-1">Real-time click/view counts ng bawat balita tuwing ito ay binubuksan ng user.</p>
                        </div>
                        <!-- Filter Buttons -->
                        <div class="flex items-center bg-slate-100 p-1.5 rounded-2xl gap-1 text-xs font-bold">
                            <button onclick="switchPerformance('daily')" id="btn-daily" class="perf-btn px-4 py-2 rounded-xl bg-slate-900 text-white transition-all cursor-pointer">Daily</button>
                            <button onclick="switchPerformance('weekly')" id="btn-weekly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Weekly</button>
                            <button onclick="switchPerformance('monthly')" id="btn-monthly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Monthly</button>
                            <button onclick="switchPerformance('yearly')" id="btn-yearly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Yearly</button>
                        </div>
                    </div>

                    <!-- BAR GRAPH SECTION -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/60">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Performance Overview Graph</span>
                            <span id="graph-label-badge" class="text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-md">Daily Views</span>
                        </div>
                        <div class="h-64 relative">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>

                    <!-- DAILY VIEWS LIST -->
                    <div id="perf-daily" class="perf-content space-y-3">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl inline-block">Ngayong Araw (Daily Click Counts)</span>
                        <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden">
                            @isset($articles)
                                @forelse($articles->sortByDesc('daily_views')->take(5) as $art)
                                    <div class="p-4 flex justify-between items-center bg-white hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs"><i class="fa-solid fa-newspaper"></i></span>
                                            <span class="font-bold text-slate-800 text-xs line-clamp-1">{{ $art->title }}</span>
                                        </div>
                                        <span class="bg-slate-100 text-slate-900 font-black text-xs px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                                            <i class="fa-solid fa-eye text-emerald-600"></i> {{ $art->daily_views ?? 0 }} views
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-slate-400">Walang datos.</div>
                                @endforelse
                            @endisset
                        </div>
                    </div>

                    <!-- WEEKLY VIEWS LIST -->
                    <div id="perf-weekly" class="perf-content space-y-3 hidden">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl inline-block">Ngayong Linggo (Weekly Click Counts)</span>
                        <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden">
                            @isset($articles)
                                @forelse($articles->sortByDesc('weekly_views')->take(5) as $art)
                                    <div class="p-4 flex justify-between items-center bg-white hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs"><i class="fa-solid fa-newspaper"></i></span>
                                            <span class="font-bold text-slate-800 text-xs line-clamp-1">{{ $art->title }}</span>
                                        </div>
                                        <span class="bg-slate-100 text-slate-900 font-black text-xs px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                                            <i class="fa-solid fa-eye text-emerald-600"></i> {{ $art->weekly_views ?? 0 }} views
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-slate-400">Walang datos.</div>
                                @endforelse
                            @endisset
                        </div>
                    </div>

                    <!-- MONTHLY VIEWS LIST -->
                    <div id="perf-monthly" class="perf-content space-y-3 hidden">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl inline-block">Ngayong Buwan (Monthly Click Counts)</span>
                        <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden">
                            @isset($articles)
                                @forelse($articles->sortByDesc('monthly_views')->take(5) as $art)
                                    <div class="p-4 flex justify-between items-center bg-white hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs"><i class="fa-solid fa-newspaper"></i></span>
                                            <span class="font-bold text-slate-800 text-xs line-clamp-1">{{ $art->title }}</span>
                                        </div>
                                        <span class="bg-slate-100 text-slate-900 font-black text-xs px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                                            <i class="fa-solid fa-eye text-emerald-600"></i> {{ $art->monthly_views ?? 0 }} views
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-slate-400">Walang datos.</div>
                                @endforelse
                            @endisset
                        </div>
                    </div>

                    <!-- YEARLY VIEWS LIST -->
                    <div id="perf-yearly" class="perf-content space-y-3 hidden">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl inline-block">Ngayong Taon (Yearly Click Counts)</span>
                        <div class="divide-y divide-slate-100 border border-slate-200/80 rounded-2xl overflow-hidden">
                            @isset($articles)
                                @forelse($articles->sortByDesc('yearly_views')->take(5) as $art)
                                    <div class="p-4 flex justify-between items-center bg-white hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs"><i class="fa-solid fa-newspaper"></i></span>
                                            <span class="font-bold text-slate-800 text-xs line-clamp-1">{{ $art->title }}</span>
                                        </div>
                                        <span class="bg-slate-100 text-slate-900 font-black text-xs px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                                            <i class="fa-solid fa-eye text-emerald-600"></i> {{ $art->yearly_views ?? 0 }} views
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-slate-400">Walang datos.</div>
                                @endforelse
                            @endisset
                        </div>
                    </div>
                </div>

                <!-- Recent Articles Table -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="px-7 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">Mga Huling Inilathalang Balita</h3>
                        <button onclick="switchTab('articles')" class="text-xs font-bold text-emerald-600 hover:underline">Tingnan ang Lahat</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-400 uppercase text-[11px] tracking-wider border-b border-slate-200">
                                    <th class="py-3.5 px-6 font-bold">Pamagat / Balita</th>
                                    <th class="py-3.5 px-6 font-bold">Kategorya</th>
                                    <th class="py-3.5 px-6 font-bold">Petsa Nailathala</th>
                                    <th class="py-3.5 px-6 font-bold text-right">Aksyon</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @isset($articles)
                                    @forelse($articles->take(5) as $art)
                                        <tr class="hover:bg-slate-50/60 transition-all text-xs">
                                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center gap-3.5">
                                                @if($art->image_url)
                                                    <img src="{{ $art->image_url }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shadow-2xs" alt="">
                                                @endif
                                                <span class="line-clamp-1 text-sm">{{ $art->title }}</span>
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-3 py-1.5 rounded-full font-bold text-xs uppercase">{{ $art->category }}</span>
                                            </td>
                                            <td class="py-4 px-6 text-slate-500 font-medium text-xs">{{ $art->created_at?->diffForHumans() }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <a href="{{ route('news.show', $art->id) }}" target="_blank" class="text-slate-400 hover:text-emerald-600 font-bold p-2 transition-all"><i class="fa-solid fa-eye text-base"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-slate-400 font-medium text-sm">Wala pang naidagdag na artikulo.</td>
                                        </tr>
                                    @endforelse
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 2: ARTICLES MANAGEMENT TABLE -->
            <div id="tab-articles" class="tab-content hidden space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-7">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider">Pamamahala ng mga Artikulo</h3>
                            <p class="text-xs text-slate-400 mt-1">Listahan ng lahat ng balitang na-publish sa sistema.</p>
                        </div>
                        <button onclick="openNewsModal()" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold px-5 py-3 rounded-2xl transition-all shadow-md shadow-emerald-600/20 cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-plus text-sm"></i> Bagong Balita
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase text-[11px] tracking-wider border-b border-slate-200">
                                    <th class="py-4 px-5 font-bold">ID</th>
                                    <th class="py-4 px-5 font-bold">Pamagat</th>
                                    <th class="py-4 px-5 font-bold">Kategorya</th>
                                    <th class="py-4 px-5 font-bold">Uri</th>
                                    <th class="py-4 px-5 font-bold text-right">Aksyon</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @isset($articles)
                                    @forelse($articles as $art)
                                        <tr class="hover:bg-slate-50/60 transition-all text-xs">
                                            <td class="py-4 px-5 font-bold text-slate-400">#{{ $art->id }}</td>
                                            <td class="py-4 px-5 font-bold text-slate-900 max-w-xs truncate text-sm">{{ $art->title }}</td>
                                            <td class="py-4 px-5"><span class="bg-slate-100 text-slate-700 px-3 py-1.5 rounded-xl font-bold">{{ $art->category }}</span></td>
                                            <td class="py-4 px-5">
                                                <div class="flex gap-2">
                                                    @if($art->is_featured)<span class="bg-emerald-100 text-emerald-800 text-[10px] px-2.5 py-1 rounded-md font-bold">Featured</span>@endif
                                                    @if($art->is_breaking)<span class="bg-rose-100 text-rose-800 text-[10px] px-2.5 py-1 rounded-md font-bold">Breaking</span>@endif
                                                </div>
                                            </td>
                                            <td class="py-4 px-5 text-right space-x-2">
                                                <a href="{{ route('news.show', $art->id) }}" target="_blank" class="text-slate-400 hover:text-emerald-600 p-1.5 transition-all text-sm" title="Tingnan"><i class="fa-solid fa-eye"></i></a>
                                                <button onclick="openEditModal({{ $art->id }})" class="text-emerald-600 hover:text-emerald-700 font-bold p-1.5 transition-all cursor-pointer text-sm" title="I-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Sigurado ka bang gusto mong burahin ang balitang ito?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold p-1.5 transition-all cursor-pointer text-sm" title="Burahin"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium text-sm">Walang makitang mga artikulo.</td>
                                        </tr>
                                    @endforelse
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: CATEGORIES MANAGEMENT -->
            <div id="tab-categories" class="tab-content hidden space-y-6">
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
                    <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider mb-6 text-emerald-700 flex items-center gap-2.5">
                        <i class="fa-solid fa-folder-plus text-emerald-600 text-base"></i> Pamahalaan ang mga Kategorya
                    </h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3.5 mb-6">
                        @csrf
                        <input type="text" name="name" placeholder="Pangalan ng Bagong Kategorya (Hal: Isports, Politika)" required class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold px-7 py-3.5 rounded-2xl text-xs transition-all shadow-md shadow-emerald-600/20 cursor-pointer">Magdagdag</button>
                    </form>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @isset($categories)
                            @foreach($categories as $cat)
                                <div class="bg-slate-50/80 border border-slate-200/80 p-4.5 rounded-2xl flex justify-between items-center shadow-2xs">
                                    <span class="text-xs font-bold text-slate-700"><i class="fa-solid fa-tag text-emerald-600 mr-2 text-sm"></i> {{ $cat->name }}</span>
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Sigurado ka bang gusto mong burahin ang kategoryang ito?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-600 text-xs font-bold cursor-pointer p-2 transition-all"><i class="fa-solid fa-trash text-sm"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>

            <!-- TAB 4: SYSTEM ANALYTICS -->
            <div id="tab-analytics" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
                        <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider mb-6 flex items-center gap-2.5">
                            <i class="fa-solid fa-chart-pie text-emerald-600 text-base"></i> Distribusyon ng Kategorya
                        </h3>
                        <div class="space-y-5 text-xs">
                            @isset($categories)
                                @foreach($categories as $cat)
                                    @php
                                        $count = isset($categoryCounts[$cat->name]) ? $categoryCounts[$cat->name] : 0;
                                        $percentage = ($totalArticles > 0) ? ($count / $totalArticles) * 100 : 0;
                                    @endphp
                                    <div>
                                        <div class="flex justify-between font-bold mb-2 text-slate-700 text-xs">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-emerald-600">{{ $count }} na ulat</span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-3.5 rounded-full overflow-hidden p-0.5">
                                            <div class="bg-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- CREATE NEWS MODAL -->
    <div id="newsModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden my-8 border border-slate-100">
            <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5">
                    <i class="fa-solid fa-pen-nib text-base"></i> Mag-post ng Bagong Balita
                </h3>
                <button onclick="closeNewsModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5 max-h-[75vh] overflow-y-auto">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Pamagat (Title)</label>
                    <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Kategorya</label>
                    <select name="category" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all">
                        <option value="">Pumili ng Kategorya</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Image URL (Opsyonal)</label>
                        <input type="url" name="image_url" placeholder="https://images.unsplash.com/..." class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Mag-upload ng Larawan</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-white border border-slate-200 rounded-xl p-1 text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Maikling Buod (Excerpt)</label>
                    <textarea name="excerpt" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 transition-all"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Nilalaman ng Balita (Body)</label>
                    <textarea name="body" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 transition-all"></textarea>
                </div>

                <div class="flex flex-wrap gap-6 text-xs font-semibold pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" name="is_featured" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Is Featured</label>
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" name="is_breaking" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Breaking News</label>
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" name="is_top_story" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Top Story</label>
                </div>

                <div class="flex justify-end gap-3.5 pt-5 border-t border-slate-200">
                    <button type="button" onclick="closeNewsModal()" class="bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold px-6 py-3 rounded-2xl text-xs transition-all cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold px-7 py-3 rounded-2xl text-xs transition-all cursor-pointer shadow-md shadow-emerald-600/20">I-publish ang Balita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT NEWS MODAL -->
    <div id="editNewsModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden my-8 border border-slate-100">
            <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5">
                    <i class="fa-solid fa-pen-to-square text-base"></i> I-edit ang Balita
                </h3>
                <button onclick="closeEditModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
            </div>

            <form id="editForm" method="POST" class="p-8 space-y-5 max-h-[75vh] overflow-y-auto">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Pamagat (Title)</label>
                    <input type="text" id="edit_title" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Kategorya</label>
                    <select id="edit_category" name="category" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition-all">
                        <option value="">Pumili ng Kategorya</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Image URL</label>
                    <input type="url" id="edit_image_url" name="image_url" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Maikling Buod (Excerpt)</label>
                    <textarea id="edit_excerpt" name="excerpt" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 transition-all"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Nilalaman ng Balita (Body)</label>
                    <textarea id="edit_body" name="body" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs text-slate-800 focus:outline-none focus:bg-white focus:border-emerald-600 transition-all"></textarea>
                </div>

                <div class="flex flex-wrap gap-6 text-xs font-semibold pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" id="edit_is_featured" name="is_featured" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Is Featured</label>
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" id="edit_is_breaking" name="is_breaking" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Breaking News</label>
                    <label class="flex items-center gap-2.5 cursor-pointer select-none"><input type="checkbox" id="edit_is_top_story" name="is_top_story" value="1" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4"> Top Story</label>
                </div>

                <div class="flex justify-end gap-3.5 pt-5 border-t border-slate-200">
                    <button type="button" onclick="closeEditModal()" class="bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold px-6 py-3 rounded-2xl text-xs transition-all cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold px-7 py-3 rounded-2xl text-xs transition-all cursor-pointer shadow-md shadow-emerald-600/20">I-save ang Pagbabago</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript & Chart Setup -->
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.nav-tab').forEach(el => {
                el.classList.remove('bg-slate-900', 'text-white', 'shadow-sm');
                el.classList.add('text-slate-600', 'hover:text-slate-900');
            });
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            
            let activeTab = document.getElementById('nav-' + tabId);
            if(activeTab) {
                activeTab.classList.remove('text-slate-600', 'hover:text-slate-900');
                activeTab.classList.add('bg-slate-900', 'text-white', 'shadow-sm');
            }
        }

        // Chart.js Configuration
        const ctx = document.getElementById('performanceChart').getContext('2d');
        
        const chartData = {
            daily: {
                labels: {!! $dailyLabels ?? "['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" !!},
                data: [{{ $dailyValues ?? '0,0,0,0,0,0,0' }}],
                label: 'Daily Views (Ayon sa Araw)'
            },
            weekly: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                data: [{{ $topWeekly }}],
                label: 'Weekly Views'
            },
            monthly: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                data: [{{ $topMonthly }}],
                label: 'Monthly Views'
            },
            yearly: {
                labels: ['2023', '2024', '2025', '2026'],
                data: [{{ $topYearly }}],
                label: 'Yearly Views'
            }
        };

        let performanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.daily.labels,
                datasets: [{
                    label: 'Views',
                    data: chartData.daily.data,
                    backgroundColor: '#10b981',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        function switchPerformance(perfType) {
            document.querySelectorAll('.perf-content').forEach(el => {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.perf-btn').forEach(el => {
                el.classList.remove('bg-slate-900', 'text-white');
                el.classList.add('text-slate-600', 'hover:text-slate-900');
            });
            
            document.getElementById('perf-' + perfType).classList.remove('hidden');
            
            let activeBtn = document.getElementById('btn-' + perfType);
            if(activeBtn) {
                activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900');
                activeBtn.classList.add('bg-slate-900', 'text-white');
            }

            performanceChart.data.labels = chartData[perfType].labels;
            performanceChart.data.datasets[0].data = chartData[perfType].data;
            performanceChart.update();

            document.getElementById('graph-label-badge').innerText = chartData[perfType].label;
        }

        function openNewsModal() {
            document.getElementById('newsModal').classList.remove('hidden');
        }
        function closeNewsModal() {
            document.getElementById('newsModal').classList.add('hidden');
        }

        function openEditModal(id) {
            fetch(`/admin/articles/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editForm').action = `/admin/articles/${id}`;
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_category').value = data.category;
                    document.getElementById('edit_image_url').value = data.image_url || '';
                    document.getElementById('edit_excerpt').value = data.excerpt || '';
                    document.getElementById('edit_body').value = data.body;
                    
                    document.getElementById('edit_is_featured').checked = data.is_featured == 1;
                    document.getElementById('edit_is_breaking').checked = data.is_breaking == 1;
                    document.getElementById('edit_is_top_story').checked = data.is_top_story == 1;

                    document.getElementById('editNewsModal').classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('editNewsModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            let newsModal = document.getElementById('newsModal');
            let editNewsModal = document.getElementById('editNewsModal');
            if (event.target == newsModal) closeNewsModal();
            if (event.target == editNewsModal) closeEditModal();
        }
    </script>
</body>
</html>