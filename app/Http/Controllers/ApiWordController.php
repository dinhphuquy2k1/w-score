<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiWordController extends Controller
{
    public function index()
    {
        return ['test' => 'message'];
    }
}