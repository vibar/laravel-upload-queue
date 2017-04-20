<?php

namespace App\Repositories;


use App\Product;

class ProductRepository extends Repository
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