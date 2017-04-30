<?php

namespace App\Repositories;


use App\Contracts\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Repository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find data by id
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Retrieve all data of repository
     * @param string $orderBy
     * @param string $direction
     * @param array $columns
     * @return mixed
     */
    public function all(string $orderBy = 'id', string $direction = 'asc', array $columns = ['*'])
    {
        $data = $this->model
            ->select($columns)
            ->orderBy($orderBy, $direction)
            ->get();

        return $data;
    }

    /**
     * Update a entity in repository by id
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes)
    {
        $model = $this->find($id);
        $model->fill($attributes);
        return $model->save();
    }

    /**
     * Delete a entity in repository by id
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        $model = $this->find($id);
        return $model->delete();
    }
}