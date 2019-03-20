<?php

namespace App\Http\Services\Interfaces;


interface GenerateCSV
{
    /**
     * @param string|null $fileName
     * @return bool
     */
    public function generate(string $fileName = null): bool;

}