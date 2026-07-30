<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Kiwi Batangas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="bg-emerald-700 text-white font-black px-2.5 py-1 rounded text-xs uppercase">Admin Panel</span>
                <span class="font-bold text-gray-800 text-sm">Kiwi Batangas News Portal</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/" target="_blank" class="text-xs text-gray-600 hover:text-emerald-700 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-globe"></i> Bisitahin ang Site
                </a>
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                        <i class="fa-solid fa-right-from-bracket"></i> Mag-logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Welcome Banner -->
        <div class="bg-emerald-800 text-white p-6 rounded-xl shadow-sm mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black mb-1">Mabuhay, Admin!</h1>
                <p class="text-xs text-emerald-100">Narito ang buod at pamamahala para sa mga balita at ulat sa Kiwi Batangas.</p>
            </div>
            <a href="#" class="bg-white text-emerald-900 hover:bg-emerald-50 text-xs font-bold px-4 py-2.5 rounded-lg shadow-xs transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Gumawa ng Bagong Balita
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Kabuuang Balita</span>
                <span class="text-2xl font-black text-gray-900">24</span>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Agrikultura Reports</span>
                <span class="text-2xl font-black text-emerald-700">8</span>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Negosyo Updates</span>
                <span class="text-2xl font-black text-emerald-700">6</span>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-2xs">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Chismis / Showbiz</span>
                <span class="text-2xl font-black text-amber-600">10</span>
            </div>
        </div>

        <!-- Recent Articles Table Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-black text-gray-900 text-sm uppercase tracking-wider">Mga Huling Inilathalang Balita</h3>
                <span class="text-xs text-gray-500">Ipinapakita ang pinakabago</span>
            </div>
            <div class="p-6 text-center text-gray-500 text-sm">
                Wala pang naidagdag na artikulo o nakakonekta sa database. Maaari mo nang simulan ang paggawa ng database migration para sa mga balita!
            </div>
        </div>
    </main>

</body>
</html>