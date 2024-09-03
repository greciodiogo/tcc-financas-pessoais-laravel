<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    // Define a tabela associada ao modelo
    protected $table = 'contas';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'saldo',
        // Adicione outros campos conforme necessário
    ];

    // Define os relacionamentos com outros modelos

    public function moeda()
    {
        return $this->belongsTo(Moeda::class, 'moeda_id', 'id')
                    ->select('id', 'nome', 'codigo_iso', 'descricao');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id')
                    ->select('id', 'nome', 'email', 'morada', 'telefone', 'renda_mensal');
    }

    public function user()
    {
        return $this->belongsTo(Usuario::class);
    }
}
