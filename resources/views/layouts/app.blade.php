<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="min-h-screen font-sans bg-gray-100 ">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col p-4 justify-between">
            <div>
                <h2 class="text-2xl font-bold text-center mb-6 break-words">
                    Welcome, {{ Auth::user()->name }}
                </h2>

                <!-- Navigation links -->
                <nav class="flex flex-col gap-5 text-base">
                    <a href="{{ route('dashboard') }}" class="p-10 rounded hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('transactions.index') }}"
                        class="p-10 rounded hover:bg-gray-700">Transactions</a>
                    <a href="{{ route('profile') }}" class="p-10 rounded hover:bg-gray-700">Personal Info</a>
                    <a href="{{ route('settings') }}" class="p-10 rounded hover:bg-gray-700">Settings</a>
                </nav>
            </div>

            <!-- Bottom: Logout button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-10 py-4 hover:bg-red-600 rounded bg-red-500 text-white mt-6">
                    Logout
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
            @yield('content')
        </main>
    </div>
</body>


</html>