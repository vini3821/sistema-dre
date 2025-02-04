<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'monthly_budget', 'actual_spending'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }
}
