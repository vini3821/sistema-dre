@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-6">Login</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="password" class="block text-gray-700">Senha:</label>
            <input type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        @if ($errors->has('email'))
            <p class="text-red-600">{{ $errors->first('email') }}</p>
        @endif
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Login
            </button>
        </div>
    </form>
</div>
@endsection
