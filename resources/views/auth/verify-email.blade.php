<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    @vite('resources/css/app.css')
</head>

<body class="h-screen bg-gradient-to-br from-blue-50 to-white flex items-center justify-center font-sans">

    @if (session('message'))
        <div class="bg-yellow-100 text-yellow-700 p-3 rounded mb-4 text-sm">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-4">Verify Your Email</h1>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <p class="text-gray-700 mb-6 text-sm leading-relaxed">
            Before continuing, please check your email for a verification link. If you didn’t receive it, you can
            request another one below.
        </p>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first('email') }}
            </div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-red-600 underline">
                Logout
            </button>
        </form>
    </div>

</body>

</html>