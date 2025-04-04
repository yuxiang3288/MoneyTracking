@extends('layouts.app')

@section('title', 'Personal Information')

@section('content')
    <h1 class="text-3xl font-semibold mb-6">Personal Information</h1>

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

        <!-- Editable Phone Number -->
        <div>
            <label for="phone_number" class="block text-sm font-medium mb-1">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number"
                value="{{ old('phone_number', Auth::user()->phone_number) }}"
                class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="text-right">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </form>
@endsection
