<?php

namespace App\Repositories;


use App\Extensions\AbstractRepository;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;

final class StudentsRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return Student::query();
    }
}