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

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {


        Exam::insert($attribute);
    }
    public function update()
    {

    }

    public function delete()
    {

    }
}
