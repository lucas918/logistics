<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
	// 后台
	public function index()
	{
		$user_info = \Session::get('user_info');
		$menu_list = isset($user_info['menu_list']) ? $user_info['menu_list'] : array();
		return view('home', array(
			'user_info' => array(
				'uid' => $user_info['uid'],
				'username' => $user_info['username'],
				'phone' => $user_info['phone'],
			),
			'menu_list' => $menu_list
		));
	}

	// home
	public function info()
	{
		return view('home_info');
	}
}