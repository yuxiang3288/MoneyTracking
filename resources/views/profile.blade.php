@extends('layouts.app')

@section('title', 'Personal Information')

@section('content')
    @push('scripts')
        @vite('resources/js/currency.js')
    @endpush

    <h1 class="text-3xl font-semibold mb-6">≡ Personal Information</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <!-- Read-only Name -->
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <p class="w-full border border-gray-300 rounded p-2 bg-gray-100 text-gray-700 select-none">
                {{ Auth::user()->name }}
            </p>
        </div>

        <!-- Read-only Email -->
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <p class="w-full border border-gray-300 rounded p-2 bg-gray-100 text-gray-700 select-none">
                {{ Auth::user()->email }}
            </p>
        </div>


        <!-- One Time Edit: Date of Birth -->
        <div>
            <label for="date_birth" class="block text-sm font-medium mb-1">Date of Birth</label>
            <input type="date" name="date_birth" id="date_birth" value="{{ old('date_birth', Auth::user()->date_birth) }}"
                {{ Auth::user()->date_birth ? 'readonly' : '' }}
                class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-100 {{ Auth::user()->date_birth ? 'cursor-not-allowed' : '' }}">
        </div>

        <!-- Editable Preferred Currency -->
        <div>
            <label for="preferred_currency" class="block text-sm font-medium mb-1">Preferred Currency</label>
            <select name="preferred_currency" id="preferred_currency"
                class="w-full border rounded p-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Currency --</option>
            </select>
        </div>

        <script>
            window.selectedCurrency = "{{ old('preferred_currency', Auth::user()->preferred_currency) }}";
        </script>

        <!-- Editable Phone Number -->
        <div>
            <label for="phone_number" class="block text-sm font-medium mb-1">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number"
                value="{{ old('phone_number', Auth::user()->phone_number) }}"
                class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </form>
@endsection