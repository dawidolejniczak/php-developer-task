<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseTableSeeder extends Seeder
{

    public function run()
    {
        factory(Course::class, 100)->create();
    }

}
