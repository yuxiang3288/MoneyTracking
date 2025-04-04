@extends('layouts.app')

@section('title', 'Upload TNG PDF')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Upload TnG eWallet PDF</h1>

        <form method="POST" action="{{ route('tng.parse') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_file" class="w-full border rounded p-2 mb-4" required>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload & Parse
            </button>
        </form>
    </div>
@endsection
