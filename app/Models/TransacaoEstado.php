<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransacaoEstado extends Model
{
    protected $fillable = [
        'descricao'
    ];

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'transacao_estado_id');
    }
}
