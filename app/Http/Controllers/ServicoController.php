<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServicoController extends Controller
{
    public function index($mes)
    {
        try {
            $user = auth()->user();
            return Servico::where('mes', $mes)
                         ->where('sector_id', $user->sector_id)
                         ->get();
        } catch (\Exception $e) {
            Log::error('Erro ao buscar serviços:', [
                'message' => $e->getMessage(),
                'mes' => $mes
            ]);
            return response()->json([
                'message' => 'Erro ao buscar serviços',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Log dos dados recebidos
            Log::info('Dados recebidos na requisição de serviço:', $request->all());

            // Validação dos dados
            $validatedData = $request->validate([
                'mes' => 'required|integer|between:1,12',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'sector_id' => 'required|exists:sectors,id'
            ]);

            Log::info('Dados após validação do serviço:', $validatedData);

            // Criar o serviço
            $servico = new Servico();
            $servico->mes = $validatedData['mes'];
            $servico->descricao = $validatedData['descricao'];
            $servico->valor = $validatedData['valor'];
            $servico->sector_id = $validatedData['sector_id'];

            // Tentar salvar
            if (!$servico->save()) {
                throw new \Exception('Não foi possível salvar o serviço');
            }

            Log::info('Serviço criado com sucesso:', $servico->toArray());

            return response()->json($servico, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação do serviço:', [
                'errors' => $e->errors(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao criar serviço:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'Erro ao criar serviço',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Servico $servico)
    {
        $validatedData = $request->validate([
            'descricao' => 'required|string',
            'valor' => 'required|numeric'
        ]);

        $servico->update($validatedData);
        return response()->json($servico);
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();
        return response()->json(['success' => true]);
    }
} 