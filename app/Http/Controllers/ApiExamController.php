<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;

class ApiExamController extends Controller
{
    public function get()
    {
        return $this->sendResponseSuccess(Exam::all()->toArray());
    }

    public function getExamShifts(Request $request)
    {
        return $this->sendResponseSuccess(Exam::with('examShifts')->where('id', $request->id)->get()->toArray());
    }

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {

    }
    public function update()
    {

    }

    public function delete()
    {

    }
}
