<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseStorageRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create a row to model
     * 
     * @param array $modelPayload
     * @return Model
     */
    public function create(array $modelPayload): Model
    {
        return $this->model->create($modelPayload);
    }

    /**
     * Create multiple rows in model
     * 
     * @param array $modelPayload
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function createMany(array $modelPayload)
    {
        return $this->model->insert($modelPayload);
    }

    /**
     * Find or create a record
     * 
     * @param array $modelPayload
     * @param array $condition
     * @return Model
     */
    public function findOrCreate(array $modelPayload, array $condition = []): Model
    {
        return $this->model->firstOrCreate($condition, $modelPayload);
    }

    /**
     * Find a record by ID with optional relationships
     * 
     * @param int $id
     * @param array $selectColumn
     * @param array $withRelationships
     * @return Model|null
     */
    public function findById(int $id, array $selectColumn = ['*'], array $withRelationships = [])
    {
        $query = $this->model->select($selectColumn)->where('id', $id);

        if (!empty($withRelationships)) {
            $query->with($withRelationships);
        }

        return $query->first();
    }

    /**
     * Returns a list of elements with optional filters and relationships
     * 
     * @param string|null $search
     * @param array $options
     * @param array $selectColumn
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll(
        ?string $search,
        array $options = [],
        array $selectColumn = ['*']
    ) {
        $orderBy = $options['orderBy'] ?? 'id';
        $typeOrderBy = $options['typeOrderBy'] ?? 'ASC';
        $query = $this->model->select($selectColumn);

        if ($search && isset($options['searchBy']) && is_array($options['searchBy'])) {
            $query->where(function ($q) use ($search, $options) {
                foreach ($options['searchBy'] as $key) {
                    $q->orWhere($key, 'like', '%' . $search . '%');
                }
            });
        }

        if (isset($options['withRelationships']) && is_array($options['withRelationships'])) {
            $query->with($options['withRelationships']);
        }

        $query->orderBy($orderBy, $typeOrderBy);

        if ($options['isPaginate'] ?? false) {
            return $query->paginate($options['perPage'] ?? 10);
        }

        return $query->get();
    }

    /**
     * Return paginated results based on payload options
     * 
     * @param array $payload
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllOptions(array $payload)
    {
        $options = $this->setOptions($payload);
        return $this->findAll($options['search'] ?? null, $options);
    }

    /**
     * Set options based on payload
     * 
     * @param array $payload
     * @return array
     */
    protected function setOptions(array $payload): array
    {
        return [
            'page' => $payload['page'] ?? 1,
            'perPage' => $payload['perPage'] ?? 10,
            'orderBy' => $payload['orderBy'] ?? 'id',
            'typeOrderBy' => $payload['typeOrderBy'] ?? 'ASC',
            'searchBy' => $payload['searchBy'] ?? [],
            'isPaginate' => $payload['isPaginate'] ?? true,
            'withRelationships' => $payload['withRelationships'] ?? [],
        ];
    }
}
