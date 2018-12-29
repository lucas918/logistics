<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function index()
    {
        $user_info = \Session::get('user_info');
        $role_id = is_numeric($user_info['role_id']) ? intval($user_info['role_id']) : explode(',', $user_info['role_id']);

        if ()

        return view('general/car', array());
    }
}