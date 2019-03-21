<?php

use Illuminate\Database\Seeder;
use App\Models\StudentAddress;

class StudentAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StudentAddress::class, 100)->create();
    }
}
