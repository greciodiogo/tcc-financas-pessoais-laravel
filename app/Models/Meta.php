<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    // use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'conta_id', 'titulo', 'descricao', 'valorPretendido', 'estado'
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class)->select('id', 'contaDescricao', 'saldo_actual');
    }

}
