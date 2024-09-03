<?php

namespace App\Repositories;

use App\Models\Conta;

class ContaRepository
{
    public function findAll($search, $options)
    {
        $query = Conta::query();

        if ($search) {
            $query->where('id', $search);
        }
        $orderBy = $options['orderBy'] ?? 'created_at'; // Valor padrão se 'orderBy' não estiver definido
        $typeOrderBy = $options['typeOrderBy'] ?? 'DESC'; // Valor padrão se 'typeOrderBy' não estiver definido
        $perPage = $options['perPage'] ?? '5'; // Valor padrão se 'typeOrderBy' não estiver definido

        return $query->orderBy($orderBy, $typeOrderBy)
                     ->paginate($perPage);
    }

    public function findById($id)
    {
        return Conta::find($id);
    }

    public function create($data)
    {
        return Conta::create($data);
    }

    public function update($id, $data)
    {
        $conta = $this->findById($id);
        if ($conta) {
            $conta->update($data);
            return $conta;
        }

        return null;
    }

    public function delete($id)
    {
        $conta = $this->findById($id);
        if ($conta) {
            $conta->delete();
            return true;
        }

        return false;
    }

    public function updateSaldoConta($typeOperation, $valor, $auth)
    {
        // Lógica para atualizar o saldo da conta baseado no tipo de operação e valor
        // Dependendo da implementação, você pode precisar buscar a conta e atualizar seu saldo.
    }
}
