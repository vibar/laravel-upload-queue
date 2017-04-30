<?php

namespace App\Contracts\Repositories;

/**
 * Eloquent Repository
 * @package App\Contracts\Repositories
 */
interface RepositoryInterface
{
    /**
     * Find data by id
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Retrieve all data of repository
     *
     * @param string $orderBy
     * @param string $direction
     * @param array $columns
     * @return mixed
     */
    public function all(string $orderBy = 'id', string $direction = 'asc', array $columns = ['*']);

    /**
     * Update a entity in repository by id
     *
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * Delete a entity in repository by id
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id);
}