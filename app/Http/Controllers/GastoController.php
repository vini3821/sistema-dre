<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index($mes)
    {
        return Gasto::where('mes', $mes)->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mes' => 'required|integer',
            'descricao' => 'required|string',
            'valor' => 'required|numeric'
        ]);

        $gasto = Gasto::create($validatedData);
        return response()->json($gasto);
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
