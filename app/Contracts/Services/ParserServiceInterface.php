<?php

namespace App\Contracts\Services;


interface ParserServiceInterface
{
    /**
     * @param string $path
     * @param int $offsetRow
     */
    public function open(string $path, int $offsetRow = 0);

    /**
     * @return array
     */
    public function extract() : array;

}