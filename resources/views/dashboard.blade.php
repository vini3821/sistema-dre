@php
    use Carbon\Carbon;
    Carbon::setLocale('pt_BR');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sistema DRE') }} 
                <span class="ml-2 px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                    Setor: {{ $sectorName }}
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Seleção de Meses -->
                <div class="mb-4">
                    <label for="mes" class="block text-sm font-medium text-gray-700">Selecione o Mês:</label>
                    <select id="mes" name="mes" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $i == date('n') ?
                            'selected' : '' }}>
                                                {{Carbon::createFromFormat('!m', $i)->translatedFormat('F')}}
                                                <!-- {{ DateTime::createFromFormat('!m', $i)->format('F') }} -->
                                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Botão Adicionar (único) -->
                <div class="flex justify-end mb-4">
                    <button id="add-item" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transform transition-all duration-200 hover:scale-105">
                        Adicionar
                    </button>
                </div>

                <!-- Layout flexível para tabelas lado a lado -->
                <div class="flex space-x-6">
                    <!-- Tabela de Gastos -->
                    <div class="w-full">
                        <h3 class="text-lg font-semibold mb-2">Gastos</h3>
                        <table id="tabela-gastos" class="w-full border-collapse border border-gray-300">
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
                        <table id="tabela-servicos" class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2">Serviço</th>
                                    <th class="border border-gray-300 px-4 py-2">Valor</th>
                                    <th class="border border-gray-300 px-4 py-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .gasto-row {
            transition: all 0.3s ease;
        }
        
        .gasto-row:hover {
            background-color: rgba(243, 244, 246, 0.5);
        }

        .action-buttons {
            opacity: 0;
            transition: opacity 0.2s ease;
            pointer-events: none;
        }

        .gasto-row:hover .action-buttons {
            opacity: 1;
            pointer-events: auto;
        }

        .input-gasto {
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .input-gasto:hover, .input-gasto:focus {
            border-color: #e5e7eb;
            background-color: white;
            outline: none;
            border-radius: 0.375rem;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Pegar o token CSRF uma vez
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Função para fazer requisições com configurações padrão
            async function fetchWithConfig(url, options = {}) {
                const defaultOptions = {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json' // Importante: pede explicitamente JSON
                    },
                    credentials: 'same-origin' // Inclui cookies na requisição
                };

                return fetch(url, { ...defaultOptions, ...options });
            }

            const tabelaGastos = document.querySelector("#tabela-gastos tbody");
            const tabelaServicos = document.querySelector("#tabela-servicos tbody");
            const botaoAdicionar = document.getElementById("add-item");
            const selectMes = document.getElementById("mes");

            function atualizarTabela() {
                let mesSelecionado = selectMes.value;
                
                fetchWithConfig(`/gastos/${mesSelecionado}`)
                    .then(response => response.json())
                    .then(gastos => {
                        tabelaGastos.innerHTML = "";
                        
                        gastos.forEach((gasto) => {
                            let row = `
                                <tr class="gasto-row">
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="text" 
                                               class="w-full p-1 input-gasto bg-transparent" 
                                               value="${gasto.descricao}"
                                               placeholder="Descrição do gasto">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="number" 
                                               class="w-full p-1 input-gasto bg-transparent" 
                                               value="${gasto.valor}"
                                               placeholder="0.00">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <div class="flex space-x-2 justify-center action-buttons">
                                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded save-gasto transform transition-transform duration-200 hover:scale-105" 
                                                    data-id="${gasto.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded remove-gasto transform transition-transform duration-200 hover:scale-105" 
                                                    data-id="${gasto.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tabelaGastos.innerHTML += row;
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar gastos:', error);
                    });
            }

            function atualizarTabelaServicos() {
                let mesSelecionado = selectMes.value;
                
                fetchWithConfig(`/servicos/${mesSelecionado}`)
                    .then(response => response.json())
                    .then(servicos => {
                        tabelaServicos.innerHTML = "";
                        
                        servicos.forEach((servico) => {
                            let row = `
                                <tr class="gasto-row">
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="text" 
                                               class="w-full p-1 input-gasto bg-transparent" 
                                               value="${servico.descricao}"
                                               placeholder="Nome do serviço">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="number" 
                                               class="w-full p-1 input-gasto bg-transparent" 
                                               value="${servico.valor}"
                                               placeholder="0.00">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <div class="flex space-x-2 justify-center action-buttons">
                                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded save-servico transform transition-transform duration-200 hover:scale-105" 
                                                    data-id="${servico.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded remove-servico transform transition-transform duration-200 hover:scale-105" 
                                                    data-id="${servico.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tabelaServicos.innerHTML += row;
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar serviços:', error);
                    });
            }

            // Evento para adicionar novo item
            botaoAdicionar.addEventListener("click", async function () {
                let mesSelecionado = selectMes.value;
                
                try {
                    // Adicionar gasto
                    const gastoResponse = await fetchWithConfig('/gastos', {
                        method: 'POST',
                        body: JSON.stringify({
                            mes: parseInt(mesSelecionado),
                            descricao: "Novo Gasto",
                            valor: 0,
                            sector_id: {{ auth()->user()->sector_id ?? 'null' }}
                        })
                    });

                    if (!gastoResponse.ok) {
                        const errorData = await gastoResponse.json();
                        throw new Error(errorData.message || 'Erro ao criar gasto');
                    }

                    // Adicionar serviço
                    const servicoResponse = await fetchWithConfig('/servicos', {
                        method: 'POST',
                        body: JSON.stringify({
                            mes: parseInt(mesSelecionado),
                            descricao: "Novo Serviço",
                            valor: 0,
                            sector_id: {{ auth()->user()->sector_id ?? 'null' }}
                        })
                    });

                    if (!servicoResponse.ok) {
                        const errorData = await servicoResponse.json();
                        throw new Error(errorData.message || 'Erro ao criar serviço');
                    }

                    // Atualizar ambas as tabelas
                    await atualizarTabela();
                    await atualizarTabelaServicos();
                    
                    alert("Itens adicionados com sucesso!");
                } catch (error) {
                    console.error('Erro:', error);
                    alert(error.message);
                }
            });

            // Evento para mudar o mês
            selectMes.addEventListener("change", function() {
                atualizarTabela();
                atualizarTabelaServicos();
            });

            // Eventos delegados para a tabela de gastos
            tabelaGastos.addEventListener("click", function (event) {
                const button = event.target.closest('button');
                if (!button) return;

                const tr = button.closest('tr');
                const gastoId = button.dataset.id;

                if (button.classList.contains("save-gasto")) {
                    const descricao = tr.querySelector('input[type="text"]').value;
                    const valor = tr.querySelector('input[type="number"]').value;

                    if (!descricao || !valor) {
                        alert("Por favor, preencha todos os campos!");
                        return;
                    }

                    fetchWithConfig(`/gastos/${gastoId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            descricao: descricao,
                            valor: valor
                        })
                    })
                    .then(response => response.json())
                    .then(() => {
                        alert("Gasto atualizado com sucesso!");
                        atualizarTabela();
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert("Erro ao atualizar o gasto!");
                    });
                }

                if (button.classList.contains("remove-gasto")) {
                    if (confirm("Tem certeza que deseja remover este gasto?")) {
                        fetchWithConfig(`/gastos/${gastoId}`, {
                            method: 'DELETE'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro ao remover gasto');
                            }
                            alert("Gasto removido com sucesso!");
                            atualizarTabela();
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert("Erro ao remover o gasto!");
                        });
                    }
                }
            });

            // Eventos delegados para a tabela de serviços
            tabelaServicos.addEventListener("click", function (event) {
                const button = event.target.closest('button');
                if (!button) return;

                const tr = button.closest('tr');
                const servicoId = button.dataset.id;

                if (button.classList.contains("save-servico")) {
                    const descricao = tr.querySelector('input[type="text"]').value;
                    const valor = tr.querySelector('input[type="number"]').value;

                    if (!descricao || !valor) {
                        alert("Por favor, preencha todos os campos!");
                        return;
                    }

                    fetchWithConfig(`/servicos/${servicoId}`, {
                        method: 'PUT',
                        body: JSON.stringify({
                            descricao: descricao,
                            valor: valor
                        })
                    })
                    .then(response => response.json())
                    .then(() => {
                        alert("Serviço atualizado com sucesso!");
                        atualizarTabelaServicos();
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert("Erro ao atualizar o serviço!");
                    });
                }

                if (button.classList.contains("remove-servico")) {
                    if (confirm("Tem certeza que deseja remover este serviço?")) {
                        fetchWithConfig(`/servicos/${servicoId}`, {
                            method: 'DELETE'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro ao remover serviço');
                            }
                            alert("Serviço removido com sucesso!");
                            atualizarTabelaServicos();
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert("Erro ao remover o serviço!");
                        });
                    }
                }
            });

            // Carregar dados iniciais
            atualizarTabela();
            atualizarTabelaServicos();
        });
    </script>


</x-app-layout>