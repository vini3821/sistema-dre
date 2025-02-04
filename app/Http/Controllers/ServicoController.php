<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index($mes)
    {
        return Servico::where('mes', $mes)->get();
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'mes' => 'required|integer|between:1,12',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0'
            ]);

            $servico = Servico::create($validatedData);
            
            return response()->json($servico, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar serviço',
                'error' => $e->getMessage()
            ], 422);
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