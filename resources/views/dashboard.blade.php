@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-semibold mb-4">Bem-vindo(a), {{ Auth::user()->name }}!</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-700">Você está acessando o setor: <strong>{{ ucfirst(Auth::user()->sector) }}</strong></p>
        @if (Auth::user()->sector == 'financeiro')
            <p>Bem-vindo ao setor Financeiro!</p>
        @elseif (Auth::user()->sector == 'assessoria')
            <p>Bem-vindo ao setor Assessoria!</p>
        @elseif (Auth::user()->sector == 'criacao')
            <p>Bem-vindo ao setor de Criacao!</p>
        @elseif (Auth::user()->sector == 'vendas')
            <p>Bem-vindo ao setor de Vendas!</p>
        @elseif (Auth::user()->sector == 'trafego_pago')
            <p>Bem-vindo ao setor de Trafego Pago!</p>
        @elseif (Auth::user()->sector == 'rh')
            <p>Bem-vindo ao setor de RH!</p>
        @elseif (Auth::user()->sector == 'ti')
            <p>Bem-vindo ao setor de TI!</p>
        @endif

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Cards para dados do setor -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total de Despesas</h2>
                <p class="text-gray-700">R$ 10.000,00</p>
            </div>

            <div class="bg-green-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Receitas</h2>
                <p class="text-gray-700">R$ 15.000,00</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Lucro/Prejuízo</h2>
                <p class="text-gray-700">R$ 5.000,00</p>
            </div>
        </div>

        <!-- Botão para acessar detalhes do setor -->
        <div class="mt-6">
            <a href="{{ route('sector.' . Auth::user()->sector) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Ver Detalhes do Setor
            </a>
        </div>
    </div>
</div>
@endsection