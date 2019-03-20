<?php

namespace App\Http\Services;


use App\Http\Services\Interfaces\GenerateCSV;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateStudentCSV implements GenerateCSV
{
    /**
     * @var array
     */
    private $students;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * GenerateStudentCSV constructor.
     * @param Collection $students
     * @param string $delimiter
     */
    public function __construct(Collection $students, string $delimiter = ',')
    {
        $this->students = $students;
        $this->delimiter = $delimiter;
    }

    /**
     * @return bool
     */
    public function generate(): bool
    {
        try {
            $contents =
                'First Name' . $this->delimiter .
                'Surname' . $this->delimiter .
                'Email' . $this->delimiter .
                'Nationality' . $this->delimiter .
                'House Number' . $this->delimiter .
                'Address 1' . $this->delimiter .
                'Address 2' . $this->delimiter .
                'Postcode' . $this->delimiter .
                'City' .
                PHP_EOL;


            foreach ($this->students as $student) {
                $contents .=
                    $student->firstname . $this->delimiter .
                    $student->surname . $this->delimiter .
                    $student->email . $this->delimiter .
                    $student->nationality;

                if ($student->address) {
                    $contents .=
                        $this->delimiter . $student->address->houseNo . $this->delimiter .
                        $student->address->line_1 . $this->delimiter .
                        $student->address->line_2 . $this->delimiter .
                        $student->address->postcode . $this->delimiter .
                        $student->address->city;
                }

                $contents .= PHP_EOL;
            }

            Storage::disk('local')->put('export.csv', $contents);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }


        return true;
    }

}