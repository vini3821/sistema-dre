@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-6">Registro</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-gray-700">Nome:</label>
            <input type="text" id="name" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="password" class="block text-gray-700">Senha:</label>
            <input type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="password_confirmation" class="block text-gray-700">Confirme a Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Registrar
            </button>
        </div>
    </form>
</div>
@endsection
