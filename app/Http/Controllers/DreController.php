<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use App\Models\Sector;
use Illuminate\Http\Request;

class DreController extends Controller
{
    // Mostrar todos os setores
    public function index()
    {
        $user = Auth::user();
        $allowedSectors = [
            'financeiro' => 'financeiro',
            'assessoria' => 'assessoria',
            'criacao' => 'criacao',
            'vendas' => 'vendas',
            'trafego_pago' => 'trafego_pago',
            'rh' => 'rh',
            'ti' => 'ti',
        ];
        if (array_key_exists($user->role, $allowedSectors)) {
            return view('dashboard', compact('user'));
        } else {
            return redirect()->route('unauthorized')->with('error', 'Você não tem permissão para acessar este setor.');

        }

        $sectors = Sector::all();
        return view('dre.index', compact('sectors'));
    }

    // Editar um setor específico
    public function edit($id)
    {
        $sector = Sector::findOrFail($id);
        return view('dre.edit', compact('sector'));
    }

    // Atualizar informações do setor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'monthly_budget' => 'required|numeric',
            'actual_spending' => 'required|numeric',
        ]);

        $sector = Sector::findOrFail($id);
        $sector->update($request->all());

        return redirect()->route('dre.index')->with('success', 'Setor atualizado com sucesso');
    }
}
