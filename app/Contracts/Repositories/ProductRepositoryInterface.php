<?php

namespace App\Contracts\Repositories;


interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Data import
     *
     * @param array $data
     * @param string $key
     */
    public function import(array $data, string $key);
}