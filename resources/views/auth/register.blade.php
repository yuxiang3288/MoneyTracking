<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-gradient-to-br from-blue-100 to-white flex items-center justify-center font-sans">

    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">Create an Account</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="name" id="name" placeholder="e.g. yuxiangchoo"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="you@example.com"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Register
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>

</body>
</html>
