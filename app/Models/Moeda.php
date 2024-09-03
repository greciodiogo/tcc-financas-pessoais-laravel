<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moeda extends Model
{
    protected $table = 'moedas';

    protected $fillable = [
        'nome',
        'codigo_iso',
        'descricao',
    ];

    // Defina relacionamentos se necessário
}
