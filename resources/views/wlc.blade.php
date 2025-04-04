<!-- resources/views/wlc.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-gradient-to-br from-blue-100 to-white flex items-center justify-center font-sans">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-xl text-center">
        <h1 class="text-4xl font-bold text-blue-700 mb-4">Welcome to Your Finance Tracker 💰</h1>
        <p class="text-gray-600 mb-6">
            Manage your income and expenses easily. Track your spending, view reports, and stay financially aware.
        </p>

        <div class="space-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Go to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-red-500 underline">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="text-blue-700 underline hover:text-blue-900">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
