<?php

use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Student;
use App\Models\StudentAddress;
use Illuminate\Support\Facades\Storage;
use App\Models\Export;

final class ExportsTest extends \Tests\TestCase
{
    use DatabaseMigrations;

    public function testStoreSuccess(): void
    {
        $this->_seedStudentsWithAddresses();

        $files = Storage::files();
        $filesCount = 0;
        if ($files !== false) {
            $filesCount = count($files);
        }

        $exportsCount = Export::count();

        $this
            ->post('/exports', [
                'studentId' => [1, 2]
            ])
            ->assertStatus(200);


        $this->assertEquals($exportsCount + 1, Export::count());
        $this->assertEquals($filesCount + 1, count(Storage::files()));
    }

    public function testStoreInvalid(): void
    {
        $this->_seedStudentsWithAddresses();

        $this
            ->post('/exports');

        $this->assertEquals('The student id field is required.',
            Session::get('errors')->getBag('default')->get('studentId')[0]);
    }

    /**
     * @return Collection
     */
    private function _seedStudentsWithAddresses(): Collection
    {
        $students = factory(Student::class, 100)->create()->each(function (Student $student) {
            $student->address()->save(factory(StudentAddress::class)->make());
        });

        return $students;
    }
}