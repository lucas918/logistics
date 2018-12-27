<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    public function index()
    {
        return view('general/driver', array());
    }
}