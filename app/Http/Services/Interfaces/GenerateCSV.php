<?php

namespace App\Http\Services\Interfaces;


interface GenerateCSV
{
    /**
     * @return bool
     */
    public function generate(): bool;

}