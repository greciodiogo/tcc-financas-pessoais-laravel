<?php

namespace App\Services;

use App\Models\Transacao;
use App\Repositories\BaseStorageRepository;
use App\Repositories\TransacaoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoService
{
    protected $baseRepo;

    public function __construct(Transacao $transacao)
    {
        $this->baseRepo = new BaseStorageRepository($transacao);
        // $this->transacaoRepo = new TransacaoRepository();
    }

    public function findAllTransacoes($request)
    {
        $search = $request->input('search', '');
        $transacoes = Transacao::with(['conta', 'categoria', 'transacaoTipo', 'transacaoEstado'])
                                ->where('transacao_estado_id', 4)
                                ->where(function ($query) use ($search) {
                                    if ($search) {
                                        $query->where('transacaoDescricao', 'like', "%{$search}%")
                                              ->orWhere('transacaoMotivo', 'like', "%{$search}%");
                                    }
                                })
                                ->orderBy('created_at', 'DESC')
                                ->paginate($request->input('perPage', 10));
    
        return $transacoes;
    }
    

    // public function findDetailedTransacoes($userId)
    // {
    //     $query = DB::select(DB::raw("
    //         SELECT 
    //             tt.descricao AS area,
    //             SUM(t.valor) AS total_alocado,
    //             ROUND((SUM(t.valor) / (SELECT SUM(valor) FROM transacaos WHERE categoria_id = 2) * 100), 1) AS percentual
    //         FROM 
    //             transacaos t
    //         JOIN 
    //             transacao_tipos tt ON t.transacao_tipos_id = tt.id
    //         JOIN 
    //             contas c ON t.conta_id = c.id AND c.user_id = $userId
    //         WHERE 
    //             t.categoria_id = 2
    //         GROUP BY 
    //             tt.descricao
    //         ORDER BY 
    //             total_alocado DESC;
    //     "));

    //     return $query;
    // }

    // public function findTotaisPerTempo($userId, $ano = 2024)
    // {
    //     $query = DB::select(DB::raw("
    //         SELECT 
    //             LEFT(MONTHNAME(t.created_at), 3) AS mes_name,
    //             MONTH(t.created_at) AS mes_code,
    //             cat.categoriaDescricao AS categoria,
    //             SUM(t.valor) AS total_alocado
    //         FROM 
    //             transacaos t
    //         JOIN 
    //             categorias cat ON t.transacao_tipos_id = cat.id
    //         JOIN 
    //             contas c ON t.conta_id = c.id AND c.user_id = $userId
    //         WHERE
    //             YEAR(t.created_at) = $ano
    //         GROUP BY 
    //             mes_code, mes_name, categoria
    //         ORDER BY 
    //             mes_code ASC;
    //     "));

    //     return $query;
    // }

        
    public function create($request)
    {
        $contaNumber = $request->input('contaNumber', '');
        $categoria_id = $request->input('categoria_id', '');
        $createdPayload = $request->input('createdPayload', '');
        $valor = $request->input('valor', '');
        $transacao_tipos_id = $request->input('transacao_tipos_id', '');

        $ESTADO_INCIAL_PENDENTE = 1;
        $data = Transacao::create([
            ...$createdPayload,
            'conta_id' => $contaNumber,
            'categoria_id' => $categoria_id,
            'transacao_estado_id' => $ESTADO_INCIAL_PENDENTE,
            'valor' => $valor,
            'transacao_tipos_id' => (int) $transacao_tipos_id,
        ]);

        $transacaoID = $data->id;
        // $this->resolverTransacao($transacaoID);

        return $data;
    }

    public function createMultiplasTransacoes($contaNumber, $createdMultiplePayload, $categoria_id)
    {
        $ESTADO_INCIAL_PENDENTE = 1;

        $payload = array_map(function($transacao) use ($contaNumber, $categoria_id, $ESTADO_INCIAL_PENDENTE) {
            return array_merge($transacao, [
                'conta_id' => $contaNumber,
                'categoria_id' => $categoria_id,
                'transacao_estado_id' => $ESTADO_INCIAL_PENDENTE,
            ]);
        }, $createdMultiplePayload);

        $data = Transacao::insert($payload);

        // foreach ($payload as $transacao) {
        //     $this->resolverTransacao($transacao['id']);
        // }

        return $data;
    }

    public function realizarTransacao($createdPayload, $auth_user_id)
    {
        return Transacao::create(array_merge($createdPayload, ['user_id' => $auth_user_id]));
    }

    public function getDashboardInit($conta_id)
    {
        // Implementar conforme necessário
    }

    public function rejeitarTransacao($transacaoID)
    {
        $this->atualizarEstadoTransacao($transacaoID, 2);
    }

    public function cancelarTransacao($transacaoID)
    {
        $this->atualizarEstadoTransacao($transacaoID, 3);
    }

    public function findById($detalhe_id)
    {
        return Transacao::with('conta')
                        ->with('categoria')
                        ->with('transacaoTipo')
                        ->findOrFail($detalhe_id);
    }

    public function update($detalhe_id, $updatedPayload)
    {
        $transacao = Transacao::findOrFail($detalhe_id);
        $transacao->update($updatedPayload);
        return $transacao;
    }

    public function delete($detalhe_id)
    {
        $transacao = Transacao::findOrFail($detalhe_id);
        $transacao->delete();
        return $transacao;
    }

    protected function atualizarEstadoTransacao($transacaoID, $transacaoEstado)
    {
        $transacao = Transacao::findOrFail($transacaoID);
        $transacao->transacao_estado_id = $transacaoEstado;
        $transacao->save();
        return $transacao;
    }
}
