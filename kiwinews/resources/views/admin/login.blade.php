<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Kiwi Batangas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-900 font-sans flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full mx-4">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 mb-2">
                <img src="{{ asset('images/logo.kiwi.jpg') }}" alt="Kiwi Batangas Logo" class="h-12 w-12 rounded-full object-cover border-2 border-emerald-600 shadow-sm" onerror="this.src='https://via.placeholder.com/50'">
            </a>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Admin Portal</h1>
            <p class="text-xs text-emerald-700 font-bold uppercase tracking-widest mt-1">Kiwi Batangas Digital News</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8">
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-emerald-700 transition" placeholder="admin@kiwibatangas.ph">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-emerald-700 transition" placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-xs mb-6">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-700 mr-2">
                        Tandaan Mo Ako
                    </label>
                    <a href="#" class="text-emerald-700 font-semibold hover:underline">Nakalimutan ang Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition duration-200 text-sm flex items-center justify-center gap-2">
                    <span>Mag-login sa Admin</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        <!-- Back to Home Link -->
        <div class="text-center mt-6">
            <a href="/" class="text-xs font-semibold text-gray-600 hover:text-emerald-700 transition flex items-center justify-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Bumalik sa Landing Page
            </a>
        </div>
    </div>

</body>
</html>