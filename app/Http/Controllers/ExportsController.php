<?php

namespace App\Http\Controllers;

use App\Http\Services\GenerateStudentCSV;
use App\Http\Requests\ExportSelectedStudents;
use App\Repositories\StudentsRepository;
use App\Repository\ExportsRepository;

final class ExportController extends Controller
{
    /**
     * @var ExportsRepository
     */
    private $exportsRepository;

    /**
     * @var StudentsRepository
     */
    private $studentsRepository;

    /**
     * ExportController constructor.
     * @param ExportsRepository $exportsRepository
     * @param StudentsRepository $studentsRepository
     */
    public function __construct(ExportsRepository $exportsRepository, StudentsRepository $studentsRepository)
    {
        $this->exportsRepository = $exportsRepository;
        $this->studentsRepository = $studentsRepository;
    }

    /**
     * @param ExportSelectedStudents $request
     */
    public function store(ExportSelectedStudents $request)
    {
        $students = $this->studentsRepository
            ->with('address')
            ->whereIn('id', $request->get('studentId'))
            ->getAll();


        $file = new GenerateStudentCSV($students);
        $isSuccessful = $file->generate();

    }
}
