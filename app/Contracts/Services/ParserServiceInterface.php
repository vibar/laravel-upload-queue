<?php

namespace App\Contracts\Services;


interface ParserServiceInterface
{
    /**
     * @param string $path
     * @param int $offsetRow
     * @return array
     */
    public function parse(string $path, int $offsetRow = 0) : array;

}