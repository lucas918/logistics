<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function index()
    {
    	
    	
        return view('general/car', array());
    }
}