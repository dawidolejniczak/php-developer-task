<?php

namespace App\Http\Controllers;

use Bueltge\Marksimple\Marksimple;
use Illuminate\View\View;

final class PagesController extends Controller
{
    /**
     * @return View
     * @throws \Bueltge\Marksimple\Exception\InvalideFileException
     */
    public function welcome(): View
    {
        $ms = new Marksimple();

        return view('hello', [
            'content' => $ms->parseFile('../README.md'),
        ]);
    }
}
