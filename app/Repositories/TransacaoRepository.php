<?php

namespace App\Repositories;

use App\Models\Transacao;
use Illuminate\Support\Facades\DB;

class TransacaoRepository
{
    const ESTADO_TRANSACAO_REJEITADA = 2;
    const ESTADO_TRANSACAO_RESOLVIDA = 4;
    const ESTADO_TRANSACAO_CANCELADA = 3;

    public function getTransactionsDetail($conta_id)
    {
        return Transacao::where('conta_id', $conta_id)
                        ->where('transacao_estado_id', self::ESTADO_TRANSACAO_RESOLVIDA)
                        ->get();
    }

    public function getTransactionType($conta_id, $categoria_id = 1)
    {
        return Transacao::where('conta_id', $conta_id)
                        ->where('categoria_id', $categoria_id)
                        ->where('transacao_estado_id', self::ESTADO_TRANSACAO_RESOLVIDA)
                        ->get();
    }

    public function getValorTransaction($conta_id, $categoria_id = 1)
    {
        $valor = Transacao::where('conta_id', $conta_id)
                          ->where('transacao_estado_id', self::ESTADO_TRANSACAO_RESOLVIDA)
                          ->where('categoria_id', $categoria_id)
                          ->sum('valor');

        return $valor;
    }

    public function getDashboardInit($conta_id)
    {
        return [
            'totalTransacoes' => $this->getTransactionsDetail($conta_id)->count(),
            'countPoupancas' => 0, // Você pode adicionar lógica para poupanças se necessário
            'valorPoupancas' => 0, // Adicionar lógica para o valor de poupanças
            'countReceitas' => $this->getTransactionType($conta_id, 1)->count(),
            'valorReceitas' => $this->getValorTransaction($conta_id, 1),
            'countDespesas' => $this->getTransactionType($conta_id, 2)->count(),
            'valorDespesas' => $this->getValorTransaction($conta_id, 2),
        ];
    }

    public function atualizarEstadoTransacao($transacaoId, $transacaoEstado)
    {
        $transacao = Transacao::find($transacaoId);
        if ($transacao) {
            $transacao->transacao_estado_id = $transacaoEstado;
            $transacao->save();
        }

        return $transacao;
    }

    public function RejeitarTransacao($transacaoId)
    {
        return $this->atualizarEstadoTransacao($transacaoId, self::ESTADO_TRANSACAO_REJEITADA);
    }

    public function ResolverTransacao($transacaoId)
    {
        return $this->atualizarEstadoTransacao($transacaoId, self::ESTADO_TRANSACAO_RESOLVIDA);
    }

    public function CancelarTransacao($transacaoId)
    {
        return $this->atualizarEstadoTransacao($transacaoId, self::ESTADO_TRANSACAO_CANCELADA);
    }
}
