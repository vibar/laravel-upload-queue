<?php

namespace App\Repositories;


use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Product;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    /**
     * Specify Model class name
     * @return Product
     */
    function getModel()
    {
        return new Product();
    }
}