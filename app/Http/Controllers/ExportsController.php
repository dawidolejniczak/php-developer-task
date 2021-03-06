<?php

namespace App\Http\Controllers;

use App\Exceptions\CVSNotCreatedException;
use App\Http\Services\GenerateStudentCSV;
use App\Http\Requests\ExportSelectedStudents;
use App\Repositories\StudentsRepository;
use App\Repositories\ExportsRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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


    public function index()
    {
        $exports = $this->exportsRepository->getAll();

        return view('exports.index', compact('exports'));
    }

    /**
     * @param ExportSelectedStudents $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
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

    /**
     * @param int $id
     * @return BinaryFileResponse
     */
    public function show(int $id): BinaryFileResponse
    {
        $export = $this->exportsRepository->find($id)->getOne();

        return response()->download(storage_path('app/' . $export->uniqid . '.csv'));

    }
}
