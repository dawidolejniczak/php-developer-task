<?php

namespace App\Http\Controllers;


use App\Repositories\StudentsRepository;
use Illuminate\View\View;

final class StudentsController extends Controller
{
    /**
     * @var StudentsRepository
     */
    private $studentsRepository;

    /**
     * StudentsController constructor.
     * @param StudentsRepository $studentsRepository
     */
    public function __construct(StudentsRepository $studentsRepository)
    {
        $this->studentsRepository = $studentsRepository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $students = $this->studentsRepository->with('course')->getAll();

        return view('view_students', compact(['students']));
    }

}
