<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['mes', 'descricao', 'valor'];

    protected $casts = [
        'valor' => 'decimal:2',
        'mes' => 'integer'
    ];
} 