<?php

namespace App\Services;

use App\Models\Meta;
use App\Repositories\BaseStorageRepository;
use App\Repositories\MetaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetaService
{
    protected $baseRepo;

    public function __construct(Meta $meta)
    {
        $this->baseRepo = new BaseStorageRepository($meta);
        // $this->metaRepo = new metaRepository();
    }

    public function findAllMetas($request)
    {
        $search = $request->input('search', '');
        $transacoes = Meta::with(['conta'])
                                ->where(function ($query) use ($search) {
                                    if ($search) {
                                        $query->where('metaDescricao', 'like', "%{$search}%")
                                              ->orWhere('metaMotivo', 'like', "%{$search}%");
                                    }
                                })
                                ->orderBy('created_at', 'DESC')
                                ->paginate($request->input('perPage', 10));
    
        return $transacoes;
    }

    public function create($request)
    {
        $contaNumber = $request->input('contaNumber', '');
        $titulo = $request->input('titulo', '');
        $descricao = $request->input('descricao', '');
        $valorPretendido = $request->input('valorPretendido', '');
        $estado = $request->input('estado', '');
        $data_conclusao = $request->input('data_conclusao', '');
        $data = Meta::create([
            'conta_id' => $contaNumber,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'valorPretendido' => $valorPretendido,
            'estado' => $estado,
            'data_conclusao' => $data_conclusao,
        ]);

        $metaID = $data->id;
        // $this->resolvermeta($metaID);

        return $data;
    }

    public function findById($detalhe_id)
    {
        return Meta::with('conta')
                        ->findOrFail($detalhe_id);
    }

    public function update($detalhe_id, $updatedPayload)
    {
        $meta = Meta::findOrFail($detalhe_id);
        $meta->update($updatedPayload);
        return $meta;
    }

    public function delete($detalhe_id)
    {
        $meta = Meta::findOrFail($detalhe_id);
        $meta->delete();
        return $meta;
    }

}
