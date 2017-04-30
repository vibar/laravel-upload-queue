<?php

namespace App\Repositories;


use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Product;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     * Data import
     *
     * @param array $data
     * @param string $key
     */
    public function import(array $data, string $key)
    {
        foreach ($data as $row) {
            // TODO: validate
            $model = $this->model->firstOrNew([$key => $row[$key]]);
            $model->fill($row);
            $model->save();
        }
    }
}