<?php

namespace App\Http\Controllers;

use App\Exceptions\CVSNotCreatedException;
use App\Http\Services\GenerateStudentCSV;
use App\Http\Requests\ExportSelectedStudents;
use App\Repositories\StudentsRepository;
use App\Repositories\ExportsRepository;
use Illuminate\Support\Facades\Log;

final class ExportsController extends Controller
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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function store(ExportSelectedStudents $request)
    {

        try {
            $students = $this->studentsRepository
                ->with('address')
                ->whereIn('id', $request->get('studentId'))
                ->getAll();


            $file = new GenerateStudentCSV($students);
            $uniqid = uniqid();

            $isSuccessful = $file->generate($uniqid);

            if (!$isSuccessful) {
                throw new CVSNotCreatedException();
            }

            $this->exportsRepository->create([
                'uniqid' => $uniqid
            ]);

            return response()->download(storage_path('app/' . $uniqid . '.csv'));
        } catch (\Exception $exception) {

            Log::error($exception->getMessage());
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }
}
