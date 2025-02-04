<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes',
        'descricao',
        'valor',
        'sector_id'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'mes' => 'integer'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
