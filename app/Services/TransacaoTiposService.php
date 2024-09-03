<?php

namespace App\Services;

use App\Models\TransacaoTipo;
use App\Repositories\BaseStorageRepository;

class TransacaoTiposService
{
    protected $baseRepo;

    public function __construct(TransacaoTipo $transacao)
    {
        $this->baseRepo = new BaseStorageRepository($transacao);
        // $this->transacaoRepo = new TransacaoRepository();
    }

    public function findAllTransacoesTipos($request)
    {
        $search = $request->input('search', '');
        $transacoes = TransacaoTipo::orderBy('created_at', 'DESC')
                                ->paginate($request->input('perPage', 10));
    
        return $transacoes;
    }
    }
