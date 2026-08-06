<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Kiwi Batangas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include SortableJS for Drag and Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans text-sm selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col">
        
        <!-- TOP NAVIGATION BAR -->
        <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 px-8 py-4 flex justify-between items-center shadow-2xs">
            <div class="flex items-center space-x-10">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="w-10 h-10 rounded-full object-cover border border-emerald-500 shadow-xs" id="brand-logo">
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
                    <a href="#subscribers" onclick="switchTab('subscribers')" id="nav-subscribers" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-users"></i> Subscribers
                    </a>
                    <a href="#ads" onclick="switchTab('ads')" id="nav-ads" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn"></i> Ads Management
                    </a>
                    <a href="#analytics" onclick="switchTab('analytics')" id="nav-analytics" class="nav-tab px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-chart-line"></i> Analytics
                    </a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 px-3.5 py-2 rounded-2xl">
                    <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Administrator" class="w-8 h-8 rounded-full object-cover border border-emerald-600" onerror="this.src='https://via.placeholder.com/40'">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- CARD 1: KABUUANG BALITA -->
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

                    <!-- CARD 2: TOTAL CATEGORIES -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Categories</span>
                                <h3 class="text-4xl font-black mt-2 text-slate-900">{{ isset($totalCategories) ? $totalCategories : (isset($categories) ? count($categories) : 0) }}</h3>
                            </div>
                            <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                                <i class="fa-solid fa-folder"></i>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full w-fit text-xs font-bold">
                            <i class="fa-solid fa-check"></i> Standard Data
                        </div>
                    </div>

                    <!-- CARD 3: TOTAL SUBSCRIBERS -->
                    <div onclick="switchTab('subscribers')" class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between cursor-pointer hover:border-emerald-500 transition-all">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Newsletter Subscribers</span>
                                <h3 class="text-4xl font-black mt-2 text-slate-900">{{ isset($totalSubscribers) ? $totalSubscribers : 0 }}</h3>
                            </div>
                            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full w-fit text-xs font-bold">
                            <i class="fa-solid fa-envelope"></i> Active Email Subscribers
                        </div>
                    </div>
                </div>

                <!-- STATISTICS & REPORTS PERFORMANCE -->
                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider">Statistics & Reports Performance</h3>
                            <p class="text-xs text-slate-400 mt-1">Real-time click/view counts ng bawat balita tuwing ito ay binubuksan ng user.</p>
                        </div>
                        <div class="flex items-center bg-slate-100 p-1.5 rounded-2xl gap-1 text-xs font-bold">
                            <button onclick="switchPerformance('daily')" id="btn-daily" class="perf-btn px-4 py-2 rounded-xl bg-slate-900 text-white transition-all cursor-pointer">Daily</button>
                            <button onclick="switchPerformance('weekly')" id="btn-weekly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Weekly</button>
                            <button onclick="switchPerformance('monthly')" id="btn-monthly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Monthly</button>
                            <button onclick="switchPerformance('yearly')" id="btn-yearly" class="perf-btn px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer">Yearly</button>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/60">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Performance Overview Graph</span>
                            <span id="graph-label-badge" class="text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-md">Daily Views</span>
                        </div>
                        <div class="h-64 relative">
                            <canvas id="performanceChart"></canvas>
                        </div>
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
                                            <td class="py-4 px-5">
                                                <span class="bg-slate-100 text-slate-700 px-3 py-1.5 rounded-xl font-bold">
                                                    {{ $art->categoryRecord->name ?? $art->category }}
                                                </span>
                                            </td>
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

            <!-- TAB 3: CATEGORIES MANAGEMENT (DRAG & DROP) -->
            <div id="tab-categories" class="tab-content hidden space-y-6">
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider text-emerald-700 flex items-center gap-2.5">
                                <i class="fa-solid fa-folder-tree text-emerald-600 text-base"></i> Pamahalaan ang mga Kategorya
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">I-drag ang mga kahon para baguhin ang pagkakasunod-sunod, pagkatapos ay i-save.</p>
                        </div>
                        <button type="button" onclick="saveCategoryOrder()" class="bg-slate-900 hover:bg-slate-800 active:scale-95 text-white font-bold px-5 py-3 rounded-2xl text-xs transition-all shadow-md cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk text-emerald-400"></i> I-save ang Pagkakasunod-sunod
                        </button>
                    </div>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3.5 mb-8 bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                        @csrf
                        <input type="text" name="name" placeholder="Pangalan ng Bagong Kategorya (Hal: Nation, Isports)" required class="flex-1 bg-white border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 transition-all">
                        <input type="hidden" name="sort_order" value="99">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold px-6 py-3 rounded-xl text-xs transition-all cursor-pointer shadow-xs">Magdagdag</button>
                    </form>

                    <!-- Draggable Grid Container -->
                    <div id="sortable-categories" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @isset($categories)
                            @foreach($categories->sortBy('sort_order') as $cat)
                                <div data-id="{{ $cat->id }}" class="category-card bg-slate-50 hover:bg-white border-2 border-dashed border-slate-300 hover:border-emerald-500 p-4 rounded-2xl flex justify-between items-center shadow-2xs cursor-grab active:cursor-grabbing transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="text-slate-400 hover:text-slate-600">
                                            <i class="fa-solid fa-grip-vertical text-base"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-slate-800 block">{{ $cat->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button type="button" onclick="openEditCategoryModal({{ $cat->id }}, '{{ $cat->name }}', {{ $cat->sort_order ?? 0 }})" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold cursor-pointer p-2 transition-all" title="I-edit"><i class="fa-solid fa-pen-to-square text-sm"></i></button>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Sigurado ka bang gusto mong burahin ang kategoryang ito?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-600 text-xs font-bold cursor-pointer p-2 transition-all" title="Burahin"><i class="fa-solid fa-trash text-sm"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>

            <!-- TAB 4: SUBSCRIBERS MANAGEMENT -->
            <div id="tab-subscribers" class="tab-content hidden space-y-6">
                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider text-emerald-700 flex items-center gap-2">
                                <i class="fa-solid fa-users text-emerald-600"></i> Mga Subscriber ng Newsletter
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">Pamahalaan ang mga subscriber. Maaaring i-block o tanggalin ang kanilang subscription.</p>
                        </div>
                        <span class="bg-emerald-100 text-emerald-800 text-xs px-3.5 py-1.5 rounded-full font-bold">
                            {{ isset($totalSubscribers) ? $totalSubscribers : 0 }} Total Subscribers
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 uppercase text-[11px] tracking-wider border-b border-slate-200">
                                    <th class="py-3.5 px-4 font-bold">Email Address</th>
                                    <th class="py-3.5 px-4 font-bold">Status</th>
                                    <th class="py-3.5 px-4 font-bold">Petsa ng Pag-subscribe</th>
                                    <th class="py-3.5 px-4 font-bold text-right">Aksyon</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @isset($subscribers)
                                    @forelse($subscribers as $sub)
                                        <tr class="hover:bg-slate-50/60 transition-all text-xs">
                                            <td class="py-3.5 px-4 font-bold text-slate-800 flex items-center gap-2">
                                                <i class="fa-regular fa-envelope text-emerald-600"></i>
                                                {{ $sub->email }}
                                            </td>
                                            <td class="py-3.5 px-4">
                                                @if(isset($sub->is_blocked) && $sub->is_blocked)
                                                    <span class="bg-rose-100 text-rose-800 text-[10px] px-2.5 py-1 rounded-md font-bold">
                                                        <i class="fa-solid fa-ban mr-1"></i> Blocked
                                                    </span>
                                                @else
                                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] px-2.5 py-1 rounded-md font-bold">
                                                        <i class="fa-solid fa-check mr-1"></i> Active
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-slate-500 font-medium">
                                                {{ $sub->created_at ? $sub->created_at->format('M d, Y - h:i A') : 'N/A' }}
                                            </td>
                                            <td class="py-3.5 px-4 text-right space-x-2">
                                                <!-- TOGGLE BLOCK / UNBLOCK -->
                                                <form action="{{ route('admin.subscribers.toggle-block', $sub->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Sigurado ka bang gusto mong baguhin ang status ng subscriber na ito?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if(isset($sub->is_blocked) && $sub->is_blocked)
                                                        <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[11px] font-bold px-3 py-1.5 rounded-xl border border-emerald-200 transition-all cursor-pointer">
                                                            <i class="fa-solid fa-unlock mr-1"></i> Unblock
                                                        </button>
                                                    @else
                                                        <button type="submit" class="bg-amber-50 hover:bg-amber-100 text-amber-700 text-[11px] font-bold px-3 py-1.5 rounded-xl border border-amber-200 transition-all cursor-pointer">
                                                            <i class="fa-solid fa-ban mr-1"></i> Block Account
                                                        </button>
                                                    @endif
                                                </form>

                                                <!-- STOP SUBSCRIPTION / DELETE -->
                                                <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Sigurado ka bang gusto mong alisin/ipahinto ang subscription ng email na ito?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 text-[11px] font-bold px-3 py-1.5 rounded-xl border border-rose-200 transition-all cursor-pointer" title="I-unsubscribe / Burahin">
                                                        <i class="fa-solid fa-user-xmark mr-1"></i> Unsubscribe
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-slate-400 font-medium text-xs">Wala pang nag-susubscribe.</td>
                                        </tr>
                                    @endforelse
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 5: ADS MANAGEMENT (WITH ADS INQUIRIES & ACTIVE ADS) -->
<div id="tab-ads" class="tab-content hidden space-y-8">
    
    <!-- SECTION 1: ADS INQUIRIES PAGE (MGA HILING / INQUIRIES NG SPONSOR) -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-5">
            <div>
                <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider text-emerald-700 flex items-center gap-2.5">
                    <i class="fa-solid fa-envelope-open-text text-emerald-600 text-base"></i> Mga Inquiry sa Ads & Sponsorship
                </h3>
                <p class="text-xs text-slate-400 mt-1">Suriin ang mga humihiling na magpa-ad, magpadala ng application form, mag-email, o i-reject ang inquiry.</p>
            </div>
            <span class="bg-emerald-100 text-emerald-800 text-xs px-3.5 py-1.5 rounded-full font-bold flex items-center gap-1.5">
                <i class="fa-solid fa-inbox text-emerald-600"></i>
                {{ isset($inquiries) ? count($inquiries) : 0 }} Bagong Inquiry
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <th class="py-4 px-5 font-bold">Nag-inquire / Negosyo</th>
                        <th class="py-4 px-5 font-bold">Mensahe / Detalye</th>
                        <th class="py-4 px-5 font-bold">Petsa</th>
                        <th class="py-4 px-5 font-bold">Status</th>
                        <th class="py-4 px-5 font-bold text-right">Aksyon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $allInquiries = isset($inquiries) ? $inquiries : \App\Models\AdInquiry::latest()->get();
                    @endphp
                    @forelse($allInquiries as $inquiry)
                        <tr class="hover:bg-slate-50/60 transition-all text-xs">
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900 text-sm">{{ $inquiry->name }}</div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <i class="fa-regular fa-envelope text-slate-400"></i> {{ $inquiry->email }}
                                </div>
                                @if($inquiry->business_name)
                                    <div class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded w-fit mt-1 border border-emerald-200/60">
                                        {{ $inquiry->business_name }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-600 max-w-xs">
                                <p class="line-clamp-2 text-xs leading-relaxed">{{ $inquiry->message ?? 'Walang nakalagay na karagdagang mensahe.' }}</p>
                            </td>
                            <td class="py-4 px-5 text-slate-500 font-medium text-[11px]">
                                {{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y - h:i A') : 'N/A' }}
                            </td>
                            <td class="py-4 px-5">
                                @if($inquiry->status == 'form_sent')
                                    <span class="bg-blue-100 text-blue-800 text-[10px] px-2.5 py-1 rounded-md font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-paper-plane"></i> Form Sent
                                    </span>
                                @elseif($inquiry->status == 'rejected')
                                    <span class="bg-rose-100 text-rose-800 text-[10px] px-2.5 py-1 rounded-md font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-xmark"></i> Rejected
                                    </span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-[10px] px-2.5 py-1 rounded-md font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right space-x-1.5">
                                <!-- OPTION 1: SEND AD FORM VIA EMAIL -->
                                <button onclick="openSendFormModal('{{ $inquiry->email }}', '{{ $inquiry->name }}', {{ $inquiry->id }})" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-xl border border-emerald-200 text-[11px] transition-all cursor-pointer inline-flex items-center gap-1" title="Ipadala ang Ad Registration Form">
                                    <i class="fa-solid fa-file-signature text-emerald-600"></i> Send Form
                                </button>

                                <!-- OPTION 2: MESSAGE USER VIA EMAIL -->
                                <button onclick="openMessageUserModal('{{ $inquiry->email }}', '{{ $inquiry->name }}')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-xl border border-slate-200 text-[11px] transition-all cursor-pointer inline-flex items-center gap-1" title="Mag-email sa User">
                                    <i class="fa-solid fa-envelope text-slate-600"></i> Email
                                </button>

                                <!-- OPTION 3: REJECT INQUIRY -->
                                <form action="{{ route('admin.ads.inquiries.reject', $inquiry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Sigurado ka bang gusto mong i-reject ang inquiry na ito?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold p-1.5 rounded-xl border border-rose-200 text-xs transition-all cursor-pointer" title="I-reject ang Inquiry">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium text-sm">
                                <i class="fa-solid fa-inbox text-2xl mb-2 text-slate-300 block"></i>
                                Wala pang natatanggap na inquiry para sa Ads.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION 2: ACTIVE & PUBLISHED ADS TABLE -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider text-emerald-700 flex items-center gap-2.5">
                    <i class="fa-solid fa-bullhorn text-emerald-600 text-base"></i> Pamamahala ng mga Aktibong Ads (Kiwi Partner Promo)
                </h3>
                <p class="text-xs text-slate-400 mt-1">Magdagdag, mag-edit, at magtakda ng expiration/time remaining para sa mga sponsored ads.</p>
            </div>
            <button onclick="openAdModal()" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold px-5 py-3 rounded-2xl transition-all shadow-md shadow-emerald-600/20 cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-plus text-sm"></i> Magdagdag ng Ad
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <th class="py-4 px-5 font-bold">Banner / Title</th>
                        <th class="py-4 px-5 font-bold">Badge / Promo</th>
                        <th class="py-4 px-5 font-bold">Time Remaining (Expiration)</th>
                        <th class="py-4 px-5 font-bold">Status</th>
                        <th class="py-4 px-5 font-bold text-right">Aksyon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $allAds = isset($ads) ? $ads : \App\Models\Ad::latest()->get();
                    @endphp
                    @forelse($allAds as $ad)
                        <tr class="hover:bg-slate-50/60 transition-all text-xs">
                            <td class="py-4 px-5 font-bold text-slate-900 flex items-center gap-3">
                                @if($ad->image_url)
                                    <img src="{{ $ad->image_url }}" class="w-12 h-10 rounded-lg object-cover border border-slate-200 shadow-2xs" alt="Ad Image" onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';">
                                @else
                                    <div class="w-12 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-image text-xs"></i>
                                    </div>
                                @endif
                                <div class="max-w-xs">
                                    <div class="font-bold text-slate-900 line-clamp-1 text-sm">{{ $ad->title }}</div>
                                    <a href="{{ $ad->button_link }}" target="_blank" class="text-[10px] text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                                        <i class="fa-solid fa-link text-[9px]"></i> {{ \Illuminate\Support\Str::limit($ad->button_link, 30) }}
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                @if($ad->badge_text)
                                    <span class="bg-amber-100 text-amber-800 text-[10px] px-2.5 py-1 rounded-md font-bold inline-block">{{ $ad->badge_text }}</span>
                                @else
                                    <span class="text-slate-400 text-[10px] italic">Walang badge</span>
                                @endif

                                @if($ad->promo_code)
                                    <div class="text-[10px] text-slate-500 mt-1">Code: <span class="font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60">{{ $ad->promo_code }}</span></div>
                                @endif
                            </td>
                            <td class="py-4 px-5 font-medium text-slate-600">
                                @if($ad->expires_at)
                                    @php
                                        $expiry = \Carbon\Carbon::parse($ad->expires_at);
                                        $isExpired = $expiry->isPast();
                                    @endphp
                                    @if($isExpired)
                                        <span class="text-rose-600 font-bold bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-md text-[10px] inline-flex items-center gap-1">
                                            <i class="fa-solid fa-clock-rotate-left"></i> Expired na
                                        </span>
                                    @else
                                        <span class="text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-md text-[10px] inline-flex items-center gap-1">
                                            <i class="fa-regular fa-clock"></i> {{ $expiry->diffForHumans() }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400 bg-slate-100 px-2 py-0.5 rounded text-[10px]">Walang expiration</span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                @if($ad->is_active)
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] px-2.5 py-1 rounded-md font-bold inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                                    </span>
                                @else
                                    <span class="bg-slate-200 text-slate-600 text-[10px] px-2.5 py-1 rounded-md font-bold inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right space-x-1">
                                <button onclick="openEditAdModal({{ $ad->id }})" class="text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg font-bold p-2 transition-all cursor-pointer text-sm" title="I-edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.ads.destroy', $ad->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Sigurado ka bang gusto mong burahin ang ad na ito?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg font-bold p-2 transition-all cursor-pointer text-sm" title="Burahin">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium text-sm">Wala pang nakikitang ads.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

            <!-- TAB 6: SYSTEM ANALYTICS -->
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
                                        $percentage = (isset($totalArticles) && $totalArticles > 0) ? ($count / $totalArticles) * 100 : 0;
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

                <div class="grid grid-cols-1 gap-4 bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Mag-upload ng Larawan</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-white border border-slate-200 rounded-xl p-1 text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Mag-upload ng Video (Opsyonal)</label>
                        <input type="file" name="video_file" accept="video/*" class="w-full bg-white border border-slate-200 rounded-xl p-1 text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700">
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
                </div>

                <div class="flex justify-end gap-3.5 pt-5 border-t border-slate-200">
                    <button type="button" onclick="closeNewsModal()" class="bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 font-bold px-6 py-3 rounded-2xl text-xs transition-all cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold px-7 py-3 rounded-2xl text-xs transition-all cursor-pointer shadow-md shadow-emerald-600/20">I-publish ang Balita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT CATEGORY MODAL -->
    <div id="editCategoryModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
            <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5">
                    <i class="fa-solid fa-pen-to-square text-base"></i> I-edit ang Kategorya
                </h3>
                <button onclick="closeEditCategoryModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
            </div>

            <form id="editCategoryForm" method="POST" class="p-8 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pangalan ng Kategorya</label>
                    <input type="text" id="edit_cat_name" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Sorting Order (Sequence)</label>
                    <input type="number" id="edit_cat_sort_order" name="sort_order" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeEditCategoryModal()" class="bg-slate-100 px-5 py-2.5 rounded-xl font-bold text-xs cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-xs cursor-pointer">I-save ang Pagbabago</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT ARTICLE MODAL -->
    <div id="editArticleModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
            <div class="bg-[#0b6623] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> I-EDIT ANG BALITA
                </h3>
                <button type="button" onclick="closeEditModal()" class="text-white hover:text-gray-200 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="editArticleForm" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-4 flex-1">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Pamagat (Title)</label>
                    <input type="text" name="title" id="edit_title" required class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#0b6623] focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Kategorya</label>
                    <select name="category" id="edit_category" required class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#0b6623] focus:outline-none">
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Mag-upload ng Larawan</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-white border border-gray-300 rounded-lg p-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Mag-upload ng Video (Opsyonal)</label>
                    <input type="file" name="video_file" accept="video/*" class="w-full bg-white border border-gray-300 rounded-lg p-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Maikling Buod (Excerpt)</label>
                    <textarea name="excerpt" id="edit_excerpt" rows="2" class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#0b6623] focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-gray-600 mb-1">Nilalaman ng Balita (Body)</label>
                    <textarea name="body" id="edit_body" rows="5" required class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#0b6623] focus:outline-none"></textarea>
                </div>

                <div class="flex items-center gap-6 pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" id="edit_is_featured" value="1" class="rounded text-[#0b6623] focus:ring-[#0b6623] w-4 h-4">
                        <span class="text-xs font-medium text-gray-700">Is Featured</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_breaking" id="edit_is_breaking" value="1" class="rounded text-[#0b6623] focus:ring-[#0b6623] w-4 h-4">
                        <span class="text-xs font-medium text-gray-700">Breaking News</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-xs font-bold transition">Kanselahin</button>
                    <button type="submit" class="bg-[#0b6623] hover:bg-emerald-800 text-white px-6 py-2 rounded-lg text-xs font-bold transition shadow-md">I-save ang Pagbabago</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CREATE AD MODAL -->
    <div id="adModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden my-8 border border-slate-100">
            <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5">
                    <i class="fa-solid fa-bullhorn text-base"></i> Magdagdag ng Bagong Ad
                </h3>
                <button onclick="closeAdModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('admin.ads.store') }}" method="POST" class="p-8 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Ad Title</label>
                    <input type="text" name="title" placeholder="Hal: Promo Diskwento Para sa Tricycle" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Image URL</label>
                    <input type="url" name="image_url" placeholder="https://example.com/banner.jpg" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Badge Text (Hal: Limited Offer)</label>
                    <input type="text" name="badge_text" value="Limited Offer" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Description / Promo details</label>
                    <textarea name="description" rows="2" placeholder="Maikling paglalarawan ng promo..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Promo Code</label>
                        <input type="text" name="promo_code" placeholder="HAL: KIWI2026" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Button Text</label>
                        <input type="text" name="button_text" value="Alamin Pa" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Button Link (URL)</label>
                    <input type="url" name="button_link" placeholder="https://paratricycleapp.com" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Expiration Date & Time (Time Remaining)</label>
                    <input type="datetime-local" name="expires_at" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="add_is_active" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 rounded">
                    <label for="add_is_active" class="text-xs font-bold text-slate-700 cursor-pointer select-none">Active agad sa Sidebar</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeAdModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-xs cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-xs cursor-pointer shadow-md">I-save ang Ad</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT AD MODAL -->
    <div id="editAdModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden my-8 border border-slate-100">
            <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5">
                    <i class="fa-solid fa-pen-to-square text-base"></i> I-edit ang Ad
                </h3>
                <button onclick="closeEditAdModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
            </div>

            <form id="editAdForm" method="POST" class="p-8 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Ad Title</label>
                    <input type="text" id="edit_ad_title" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Image URL</label>
                    <input type="url" id="edit_ad_image_url" name="image_url" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Badge Text</label>
                    <input type="text" id="edit_ad_badge_text" name="badge_text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Description</label>
                    <textarea id="edit_ad_description" name="description" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Promo Code</label>
                        <input type="text" id="edit_ad_promo_code" name="promo_code" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Button Text</label>
                        <input type="text" id="edit_ad_button_text" name="button_text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Button Link (URL)</label>
                    <input type="url" id="edit_ad_button_link" name="button_link" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Expiration Date & Time</label>
                    <input type="datetime-local" id="edit_ad_expires_at" name="expires_at" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="edit_ad_is_active" name="is_active" value="1" class="w-4 h-4 text-emerald-600 rounded">
                    <label for="edit_ad_is_active" class="text-xs font-bold text-slate-700 cursor-pointer select-none">Active Status</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeEditAdModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-xs cursor-pointer">Kanselahin</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-xs cursor-pointer shadow-md">I-save ang Pagbabago</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript & Chart Setup -->
    <script>
        // FUNCTION PARA SA TAB SWITCHING AT PAG-PERSIST NG CURRENT TAB STATE
        function switchTab(tabId) {
            let targetTab = document.getElementById('tab-' + tabId);
            if (!targetTab) return;

            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.nav-tab').forEach(el => {
                el.classList.remove('bg-slate-900', 'text-white', 'shadow-sm');
                el.classList.add('text-slate-600', 'hover:text-slate-900');
            });
            
            targetTab.classList.remove('hidden');
            
            let activeTab = document.getElementById('nav-' + tabId);
            if(activeTab) {
                activeTab.classList.remove('text-slate-600', 'hover:text-slate-900');
                activeTab.classList.add('bg-slate-900', 'text-white', 'shadow-sm');
            }

            localStorage.setItem('activeAdminTab', tabId);
            history.replaceState(null, null, '#' + tabId);
        }

        document.addEventListener("DOMContentLoaded", function () {
            let urlHash = window.location.hash.replace('#', '');
            let savedTab = localStorage.getItem('activeAdminTab');
            
            let tabToOpen = 'dashboard';

            if (urlHash && document.getElementById('tab-' + urlHash)) {
                tabToOpen = urlHash;
            } else if (savedTab && document.getElementById('tab-' + savedTab)) {
                tabToOpen = savedTab;
            }

            switchTab(tabToOpen);
        });

        // Initialize SortableJS for Category Drag & Drop
        document.addEventListener("DOMContentLoaded", function () {
            const el = document.getElementById('sortable-categories');
            if (el) {
                Sortable.create(el, {
                    animation: 150,
                    ghostClass: 'bg-emerald-100',
                    onEnd: function () {
                        document.querySelectorAll('#sortable-categories .category-card').forEach((card, index) => {
                            const badge = card.querySelector('.order-badge');
                            if (badge) badge.innerText = index + 1;
                        });
                    }
                });
            }
        });

        function saveCategoryOrder() {
            let orderData = [];
            document.querySelectorAll('#sortable-categories .category-card').forEach((card, index) => {
                orderData.push({
                    id: card.getAttribute('data-id'),
                    sort_order: index + 1
                });
            });

            fetch("{{ route('admin.categories.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ order: orderData })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showConfirmationModal("Matagumpay na na-save ang pagkakasunod-sunod ng kategorya!");
                } else {
                    showConfirmationModal("May naganap na error. Subukang muli.", true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showConfirmationModal("May naganap na error sa koneksyon.", true);
            });
        }

        function showConfirmationModal(message, isError = false) {
            let existing = document.getElementById('custom-alert-modal');
            if (existing) existing.remove();

            let modalHTML = `
                <div id="custom-alert-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 transition-all">
                    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden border border-slate-100 p-6 text-center space-y-4">
                        <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center ${isError ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600'}">
                            <i class="fa-solid ${isError ? 'fa-triangle-exclamation' : 'fa-check'} text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 text-base">Paalala</h4>
                            <p class="text-xs text-slate-500 mt-1">${message}</p>
                        </div>
                        <button type="button" onclick="reloadToCategoriesTab()" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-2xl text-xs transition-all cursor-pointer shadow-md">
                            OK
                        </button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        function reloadToCategoriesTab() {
            localStorage.setItem('activeAdminTab', 'categories');
            window.location.hash = 'categories';
            location.reload();
        }

        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chartData = {
            daily: {
                labels: {!! $dailyLabels ?? "['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" !!},
                data: [{{ $dailyValues ?? '0,0,0,0,0,0,0' }}],
                label: 'Daily Views'
            },
            weekly: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                data: [{{ $topWeekly ?? '0,0,0,0' }}],
                label: 'Weekly Views'
            },
            monthly: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                data: [{{ $topMonthly ?? '0,0,0,0,0,0,0,0,0,0,0,0' }}],
                label: 'Monthly Views'
            },
            yearly: {
                labels: ['2023', '2024', '2025', '2026'],
                data: [{{ $topYearly ?? '0,0,0,0' }}],
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
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        function switchPerformance(perfType) {
            performanceChart.data.labels = chartData[perfType].labels;
            performanceChart.data.datasets[0].data = chartData[perfType].data;
            performanceChart.update();
            document.getElementById('graph-label-badge').innerText = chartData[perfType].label;
        }

        function openNewsModal() { document.getElementById('newsModal').classList.remove('hidden'); }
        function closeNewsModal() { document.getElementById('newsModal').classList.add('hidden'); }

        function openEditCategoryModal(id, name, sortOrder) {
            document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
            document.getElementById('edit_cat_name').value = name;
            document.getElementById('edit_cat_sort_order').value = sortOrder;
            document.getElementById('editCategoryModal').classList.remove('hidden');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }

        function openEditModal(id) {
            fetch(`/admin/articles/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editArticleForm').action = `/admin/articles/${id}`;
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_category').value = data.category;
                    document.getElementById('edit_excerpt').value = data.excerpt || '';
                    document.getElementById('edit_body').value = data.body;
                    document.getElementById('edit_is_featured').checked = data.is_featured == 1;
                    document.getElementById('edit_is_breaking').checked = data.is_breaking == 1;
                    
                    document.getElementById('editArticleModal').classList.remove('hidden');
                })
                .catch(err => console.error('Error fetching article:', err));
        }

        function closeEditModal() {
            document.getElementById('editArticleModal').classList.add('hidden');
        }

        // AD MODALS & AJAX FUNCTIONS
        function openAdModal() { 
            document.getElementById('adModal').classList.remove('hidden'); 
        }
        function closeAdModal() { 
            document.getElementById('adModal').classList.add('hidden'); 
        }

        function openEditAdModal(id) {
            fetch(`/admin/ads/${id}/edit`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('editAdForm').action = `/admin/ads/${id}`;
                    document.getElementById('edit_ad_title').value = data.title || '';
                    document.getElementById('edit_ad_image_url').value = data.image_url || '';
                    document.getElementById('edit_ad_badge_text').value = data.badge_text || '';
                    document.getElementById('edit_ad_description').value = data.description || '';
                    document.getElementById('edit_ad_promo_code').value = data.promo_code || '';
                    document.getElementById('edit_ad_button_text').value = data.button_text || '';
                    document.getElementById('edit_ad_button_link').value = data.button_link || '';
                    
                    // Format expiration date properly for datetime-local input
                    if (data.expires_at) {
                        let dt = new Date(data.expires_at);
                        let localIso = new Date(dt.getTime() - (dt.getTimezoneOffset() * 60000)).toISOString().slice(0, 16);
                        document.getElementById('edit_ad_expires_at').value = localIso;
                    } else {
                        document.getElementById('edit_ad_expires_at').value = '';
                    }

                    document.getElementById('edit_ad_is_active').checked = (parseInt(data.is_active) === 1 || data.is_active === true);
                    document.getElementById('editAdModal').classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Error loading ad details:', err);
                    alert('Hindi ma-load ang datos ng ad. Pakisubukan muli.');
                });
        }

        function closeEditAdModal() { 
            document.getElementById('editAdModal').classList.add('hidden'); 
        }

        // INQUIRY MODAL FUNCTIONS
function openSendFormModal(email, name, inquiryId) {
    document.getElementById('inquiry_id').value = inquiryId;
    document.getElementById('email_action_type').value = 'send_form';
    document.getElementById('inquiry_recipient_email').value = email;
    document.getElementById('inquiryModalTitle').innerHTML = '<i class="fa-solid fa-file-signature text-base"></i> Magpadala ng Ad Form kay ' + name;
    document.getElementById('inquiry_email_subject').value = 'Kiwi Batangas - Ad Submission Form & Partnership';
    
    // Automatic Template for sending the "Magdagdag ng Ad Form" link
    let defaultFormLink = window.location.origin + '/partner/submit-ad?email=' + encodeURIComponent(email);
    document.getElementById('inquiry_email_body').value = 
`Magandang araw, ${name}!

Salamat sa iyong interes na maging bahagi ng Kiwi Partner Promo / Sponsored Ads sa Kiwi Batangas Digital News Portal.

Upang maipagpatuloy ang pagpaparehistro ng iyong Ad, mangyaring sagutan at i-upload ang detalye ng iyong advertisement sa link sa ibaba:

Form Link: ${defaultFormLink}

Kung mayroon kang karagdagang katanungan, maaari kang sumagot sa email na ito.

Maraming Salamat,
Kiwi Batangas Admin Team`;

    document.getElementById('inquiryEmailModal').classList.remove('hidden');
}

function openMessageUserModal(email, name) {
    document.getElementById('inquiry_id').value = '';
    document.getElementById('email_action_type').value = 'general_message';
    document.getElementById('inquiry_recipient_email').value = email;
    document.getElementById('inquiryModalTitle').innerHTML = '<i class="fa-solid fa-envelope text-base"></i> Mag-email kay ' + name;
    document.getElementById('inquiry_email_subject').value = 'Tungkol sa iyong Ads Inquiry - Kiwi Batangas';
    document.getElementById('inquiry_email_body').value = 
`Magandang araw, ${name}!

Kaugnay ng iyong inquiry ukol sa advertisement sa Kiwi Batangas:

[Ilagay ang iyong mensahe dito]

Maraming salamat!`;

    document.getElementById('inquiryEmailModal').classList.remove('hidden');
}

function closeInquiryEmailModal() {
    document.getElementById('inquiryEmailModal').classList.add('hidden');
}
    </script>

    <!-- SEND AD FORM & MESSAGE EMAIL MODAL -->
<div id="inquiryEmailModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden overflow-y-auto">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden my-8 border border-slate-100">
        <div class="bg-emerald-700 text-white px-8 py-5 flex justify-between items-center" id="inquiryModalHeader">
            <h3 class="font-black text-sm uppercase tracking-wider flex items-center gap-2.5" id="inquiryModalTitle">
                <i class="fa-solid fa-paper-plane text-base"></i> Magpadala ng Ad Form sa Email
            </h3>
            <button onclick="closeInquiryEmailModal()" class="text-white hover:text-emerald-200 font-bold text-2xl cursor-pointer">&times;</button>
        </div>

        <form id="inquiryEmailForm" action="{{ route('admin.ads.inquiries.send-email') }}" method="POST" class="p-8 space-y-4">
            @csrf
            <input type="hidden" id="inquiry_id" name="inquiry_id" value="">
            <input type="hidden" id="email_action_type" name="action_type" value="send_form">

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Para kay (Recipient)</label>
                <input type="email" id="inquiry_recipient_email" name="email" required readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl p-3 text-xs text-slate-600 font-bold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Subject ng Email</label>
                <input type="text" id="inquiry_email_subject" name="subject" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Mensahe / Form Link Body</label>
                <textarea id="inquiry_email_body" name="message" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:border-emerald-600 focus:outline-none leading-relaxed"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="closeInquiryEmailModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-xs cursor-pointer">Kanselahin</button>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold text-xs cursor-pointer shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Ipadala na
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>