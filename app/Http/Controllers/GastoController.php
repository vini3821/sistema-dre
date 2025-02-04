<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GastoController extends Controller
{
    public function index($mes)
    {
        try {
            $user = auth()->user();
            return Gasto::where('mes', $mes)
                       ->where('sector_id', $user->sector_id)
                       ->get();
        } catch (\Exception $e) {
            Log::error('Erro ao buscar gastos:', [
                'message' => $e->getMessage(),
                'mes' => $mes
            ]);
            return response()->json([
                'message' => 'Erro ao buscar gastos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Log dos dados recebidos
            Log::info('Dados recebidos na requisição:', $request->all());

            // Validação dos dados
            $validatedData = $request->validate([
                'mes' => 'required|integer|between:1,12',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'sector_id' => 'required|exists:sectors,id'
            ]);

            Log::info('Dados após validação:', $validatedData);

            // Criar o gasto
            $gasto = new Gasto();
            $gasto->mes = $validatedData['mes'];
            $gasto->descricao = $validatedData['descricao'];
            $gasto->valor = $validatedData['valor'];
            $gasto->sector_id = $validatedData['sector_id'];

            // Tentar salvar
            if (!$gasto->save()) {
                throw new \Exception('Não foi possível salvar o gasto');
            }

            Log::info('Gasto criado com sucesso:', $gasto->toArray());

            return response()->json($gasto, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação:', [
                'errors' => $e->errors(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao criar gasto:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'Erro ao criar gasto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Gasto $gasto)
    {
        $validatedData = $request->validate([
            'descricao' => 'required|string',
            'valor' => 'required|numeric'
        ]);

        $gasto->update($validatedData);
        return response()->json($gasto);
    }

    public function destroy(Gasto $gasto)
    {
        $gasto->delete();
        return response()->json(['success' => true]);
    }
}
