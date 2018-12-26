<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;
use App\Models\MenuModel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    // 登录页
    public function index()
    {
        $user_info = \Session::get('user_info');

        // Step1：是否登录
        if (!empty($user_info) && isset($user_info['uid'])) {
            return redirect()->route('home');
        }

        return view('auth/login');
    }

    // 登录信息处理
    public function login()
    {
        $phone = $this->request->input('phone', '');
        $passwd = $this->request->input('password', '');
        $remember = $this->request->input('remember', 0);

        if (empty($phone) || empty($passwd)) {
            return redirect()->route('login')->withErrors(['error'=>'账号或密码不能为空']);
        }

        $user_model = new UserModel();
        $user_data = $user_model->getUser(['phone'=>$phone]);
        if (empty($user_data) || $user_data[0]['status'] != 1) {
            return redirect()->route('login')->withErrors(['error'=>'账户不存在，请联系管理员！']);
        }

        $user_data = $user_data[0];
        if (!$this->password_verify($passwd, $user_data['password'])) {
            return redirect()->route('login')->withErrors(['error'=>'密码有误']);
        }
        else if ($user_data['status'] != 1) {
            return redirect()->route('login')->withErrors(['error'=>'账号异常，请联系工作人员']);
        }

        // 用户关联角色
        $user_role_model = new UserRoleModel();
        $user_role = $user_role_model->getAll(['user_id'=>$user_data['id']]);
        if (empty($user_role)) {
            return redirect()->route('login')->withErrors(['error'=>'账号未分配权限，请联系工作人员']);
        }

        $role_list = array();
        foreach ($user_role as $val) {
            $role_list[] = $val['role_id'];
        }

        // 角色信息
        $role_model = new RoleModel();
        // $role_list = is_numeric($user_data['role_list']) ? intval($user_data['role_list']) : explode(',', $user_data['role_list']);
        $role_data = $role_model->getRole(['fields'=>['id','title','menu_list'],'id'=>$role_list, 'status'=>1]);
        if (empty($role_data)) {
            return redirect()->route('login')->withErrors(['error'=>'账号角色异常，请联系工作人员!']);
        }

        $menu_id = array();
        foreach($role_data as $val) {
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
        $menu_model = new MenuModel();
        $menu_param = array('status'=>1, 'sub_page'=>0, 'order'=>['parent_id', 'id']);
        if ($menu_id != array('all')) {
            $menu_param['id'] = $menu_id;
        }

        $menu_data = $menu_model->getMenu($menu_param);
        $menu_list = array();
        foreach ($menu_data as $val) {
            $menu = array(
                'id' => $val['id'],
                'title' => $val['title'],
                'subtitle' => $val['subtitle'],
                'icon' => $val['icon'],
                'uri' => $val['uri'],
                'parent_id' => $val['parent_id'],
                'sub_menu' => array()
            );

            if ($val['parent_id'] == 0) {
                $menu_list[$val['id']] = $menu;
            }
            else {
                $menu_list[$val['parent_id']]['sub_menu'][$val['id']] = $menu;
            }
        }

        // 登录成功后
        $user_info = [
            'uid' => $user_data['id'],
            'username' => $user_data['username'],
            'phone' => $user_data['phone'],
            'role_id' => implode(',', $role_list),
            'role_info' => $role_data,
            'menu_list' => $menu_list
        ];

        \Session::put('user_info', $user_info);
        return redirect()->route('home');
    }

    // 退出
    public function logout()
    {
        \Session::remove('user_info');
        return redirect()->route('home');
    }
}
