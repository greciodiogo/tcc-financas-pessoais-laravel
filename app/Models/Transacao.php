<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    // use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'conta_id', 'categoria_id', 'transacao_tipos_id', 'transacao_estado_id', 'valor', 'transacaoDescricao', 'transacaoMotivo'
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class)->select('id', 'contaDescricao', 'saldo_actual');
    }

    public function categoria()
    {
        return $this->belongsTo(categoria::class)->select('id', 'categoriaDescricao');
    }

    public function transacaoTipo()
    {
        return $this->belongsTo(TransacaoTipo::class, 'transacao_tipos_id')->select('id', 'descricao');
    }

    public function transacaoEstado()
    {
        return $this->belongsTo(TransacaoEstado::class, 'transacao_estado_id')->select('id', 'descricao');
    }
}
