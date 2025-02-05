<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        // Log para debug
        Log::info('User data:', [
            'id' => $user->id,
            'sector_id' => $user->sector_id
        ]);
        
        $sector = Sector::find($user->sector_id);
        $sectorName = $sector ? $sector->name : 'Sem setor';
        
        return view('dashboard', compact('sectorName'));
    }
}
