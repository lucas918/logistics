<?php
namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;

class MenuController extends Controller
{
    public function index()
    {
        // 用户信息
        $user_info = \Session::get('user_info');
        $role_info  = $user_info['role_info'];

        $menu_id = array();
        foreach($role_info as $val) {
            if (empty($val['menu_list'])) {
                continue;
            }
            else if ($val['menu_list'] = '*') {
                $menu_id = array('all');
                break;
            }

            $menu = explode(',', $val['menu_list']);
            $menu_id = array_merge($menu_id, $menu);
        }

        // 菜单栏
        $menu_model = new MenuModel;
        $menu_param = array('status'=>1, 'order'=>['parent_id', 'id']);
        if ($menu_id != array('all')) {
            $menu_param['id'] = $menu_id;
        }

        $menu_data = $menu_model->getMenu($menu_param);
        $menu_list = $this->getTree($menu_data, 0);

        return view('setting/menu', array(
            'menu_list' => $menu_list
        ));
    }
}