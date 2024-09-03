<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'categoriaDescricao'
    ];

    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }
}
