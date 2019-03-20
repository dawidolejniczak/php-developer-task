<?php

namespace App\Repository;


use App\Export;
use App\Extensions\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

final class ExportsRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return Export::query();
    }
}
