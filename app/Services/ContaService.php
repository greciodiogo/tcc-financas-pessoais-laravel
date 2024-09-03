<?php

namespace App\Services;

use App\Repositories\ContaRepository;
use Illuminate\Http\Request;

class ContaService
{
    protected $contaRepo;

    public function __construct(
        ContaRepository $contaRepo
    ) {
        $this->contaRepo = $contaRepo;
    }

    public function findAllContas(Request $request)
    {
        $search = $request->input('search');
        $options = [
            'page' => $request->input('page', 1),
            'perPage' => $request->input('perPage', 10),
            'orderBy' => $request->input('orderBy', 'created_at'), // Valor padrão se não estiver presente no request
            'typeOrderBy' => $request->input('typeOrderBy', 'DESC'), // Valor padrão se não estiver presente no request
            'searchBy' => ['id'],
            'isPaginate' => true,
        ];

        return $this->contaRepo->findAll($search, $options);
    }

    public function findDefaultConta($userId)
    {
        return $this->contaRepo->findById($userId); // Adapte conforme necessário
    }

    public function findUserConta($userId)
    {
        return $this->contaRepo->findAll(['user_id' => $userId], []);
    }

    public function create($createdPayload, $authUserId)
    {
        return $this->contaRepo->create(array_merge($createdPayload, ['user_id' => $authUserId]));
    }

    public function updateSaldoConta($typeOperation, $valor, $auth)
    {
        return $this->contaRepo->updateSaldoConta($typeOperation, $valor, $auth);
    }

    public function findById($id)
    {
        return $this->contaRepo->findById($id);
    }

    public function update($id, $updatedPayload)
    {
        return $this->contaRepo->update($id, $updatedPayload);
    }

    public function delete($id)
    {
        return $this->contaRepo->delete($id);
    }
}
