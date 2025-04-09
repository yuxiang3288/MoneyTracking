<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-gradient-to-br from-blue-50 to-white flex items-center justify-center font-sans">
    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">Reset Password</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Reset Password
            </button>
        </form>
    </div>
</body>
</html>
