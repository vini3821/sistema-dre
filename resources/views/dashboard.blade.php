<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Seleção de Meses -->
                <div class="mb-4">
                    <label for="mes" class="block text-sm font-medium text-gray-700">Selecione o Mês:</label>
                    <select id="mes" name="mes" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Botão Adicionar -->
                <div class="flex justify-end mb-4">
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Adicionar
                    </button>
                </div>

                <!-- Layout flexível para tabelas lado a lado -->
                <div class="flex space-x-6">
                    <!-- Tabela de Gastos -->
                    <div class="w-full">
                        <h3 class="text-lg font-semibold mb-2">Gastos</h3>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2">Descrição</th>
                                    <th class="border border-gray-300 px-4 py-2">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Exemplo de gasto</td>
                                    <td class="border border-gray-300 px-4 py-2">R$ 100,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabela de Serviços -->
                    <div class="w-full">
                        <h3 class="text-lg font-semibold mb-2">Serviços</h3>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2">Serviço</th>
                                    <th class="border border-gray-300 px-4 py-2">Custo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">Exemplo de serviço</td>
                                    <td class="border border-gray-300 px-4 py-2">R$ 50,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
