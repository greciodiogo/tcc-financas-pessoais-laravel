<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransacaoTipo extends Model
{
    protected $fillable = [
        'descricao'
    ];

    public function transacoes()
    {
        return $this->hasMany(TransacaoTipo::class, 'transacao_tipos_id');
    }
}
