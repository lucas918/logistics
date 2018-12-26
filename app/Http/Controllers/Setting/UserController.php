<?php
namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class UserController extends Controller
{
    public function index()
    {
    	$page_size = 10;
    	$page = $this->request->input('page', 0);
    	$page < 1 && $page = 1;

        // 当前角色id
        $user_info = \Session::get('user_info');
        $role_id = is_numeric($user_info['role_id']) ? intval($user_info['role_id']) : explode(',', $user_info['role_id']);

        // 查看当前角色下的用户
        $user_role_model = new UserRoleModel;
        $user_data = $user_role_model->getAll(['pids'=>$role_id, 'fields'=>[\DB::raw('distinct(user_id) as user_id'),'id','role_id']]);

        $user_ids = array();
        foreach ($user_data as $val) {
            $user_ids[] = $val['user_id'];
        }

        $user_model = new UserModel;
        $user_data = $user_model->getUser(['id'=>$user_ids], $page, $page_size);

        // 查询对应的角色id
        $user_role_model = new UserRoleModel;
        foreach ($user_data as $key => $val) {
            $rows = $user_role_model->getAll(['fields'=>['id','role_id'], 'user_id'=>$val['id']]);
            $arr = array();
            foreach ($rows as $v) {
                $arr[] = $v['role_id'];
            }

            $user_data[$key]['role_id'] = $arr;
        }

        $user_total = $user_model->count(['id'=>$user_ids]);

        $paginator = new LengthAwarePaginator($user_data, $user_total, $page_size, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        // 当前角色
        $role_model = new RoleModel();
        $role_data = $role_model->getRole(['pids'=>$role_id, 'status'=>1]);
        $role_data_tree = $this->getRoleTree($role_data, 0);

        return view('setting/user', array(
            'user_info' => $user_data,
            'role_data_tree' => $role_data_tree,
        	'page_info' => $paginator
        ));
    }

    // 新增
    public function add()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['user_name']) || empty($params['user_phone']) || empty($params['user_passwd']) || empty($params['role_id'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        // 角色信息
        $role_model = new RoleModel;
        $role_info = $role_model->getRole(['id'=>$params['role_id'], 'status'=>1, 'fields'=>['id','title','parent_id','pids']]);
        if (empty($role_info)) {
            echo json_encode(['status'=>0, 'info'=>'角色不存在，请检查']);
            return;
        }

        $user_info = \Session::get('user_info');
        $role_id = explode(',', $user_info['role_id']);

        // 用户是否有权限添加
        $not_allow_role = array();
        foreach ($role_info as $val) {
            if (in_array($val['id'], $role_id) || in_array($val['parent_id'], $role_id)) {
                continue;
            }

            $pids = explode(',', $val['pids']);
            $inter_id = array_intersect($role_id, $pids);
            if (empty($inter_id)) {
                $not_allow_role = $val;
                break;
            }
        }

        if (!empty($not_allow_role)) {
            echo json_encode(['status'=>0, 'info'=>"角色[{$not_allow_role['title']}]不能添加"]);
            return;
        }

        // 手机号码是否存在
        $user_model = new UserModel;
        $count = $user_model->count(['phone'=>$params['user_phone']]);
        if ($count > 0) {
            echo json_encode(['status'=>0, 'info'=>'当前号码已注册，请检查']);
            return;
        }

        // 用户信息
        $user_data = array(
            'username' => $params['user_name'],
            'phone' => $params['user_phone'],
            'email' => empty($params['user_email']) ? '' : $params['user_email'],
            'password' => $this->passwd_encrypt($params['user_passwd']),
            'address' => isset($params['address']) ? trim($params['address']) : '',
        );

        $user_id = $user_model->create($user_data);

        // 角色信息
        $user_role_model = new UserRoleModel;
        foreach ($role_info as $val) {
            $role_data = array(
                'user_id' => $user_id,
                'role_id' => $val['id'],
                'pids' => empty($val['pids']) ? $val['id'] : $val['pids'].",".$val['id']
            );
            
            $user_role_model->create($role_data);
        }

        echo json_encode(['status'=>1, 'result'=>['user_id'=>$user_id], 'info'=>'success']);
    }

    // 编辑
    public function update()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['id']) || empty($params['user_name']) || empty($params['user_phone']) || empty($params['role_id'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        // 用户是否存在
        $user_model = new UserModel;
        $user_data = $user_model->getUser(['id'=>$params['id']]);
        $user_data = isset($user_data[0]) ? $user_data[0] : array();
        if (empty($user_data)) {
            echo json_encode(['status'=>0, 'info'=>'用户不存在']);
            return;
        }

        // 是否有操作权限
        $user_role_model = new UserRoleModel;
        $user_role = $user_role_model->getAll(['user_id'=>$params['id']]);

        $user_info = \Session::get('user_info');
        $role_id = explode(',', $user_info['role_id']);

        $is_allow = false;
        $old_role_id = array();
        foreach ($user_role as $val) {
            $old_role_id[$val['id']] = $val['role_id'];

            if (in_array($val['role_id'], $role_id)) {
                $is_allow = true;
            }

            $pids = explode(',', $val['pids']);
            $inter_id = array_intersect($role_id, $pids);
            if (!empty($inter_id)) {
                $is_allow = true;
            }
        }

        if (!$is_allow) {
            echo json_encode(['status'=>0, 'info'=>'当前用户不可操作，请查询后操作']);
            return;
        }

        $role_model = new RoleModel;
        $diff_id = array_diff($params['role_id'], $old_role_id);
        $add_role_info = array();
        if (!empty($diff_id)) {
            // 新角色信息
            $role_info = $role_model->getRole(['id'=>$diff_id, 'status'=>1, 'fields'=>['id','title','parent_id','pids']]);
            if (empty($role_info)) {
                echo json_encode(['status'=>0, 'info'=>'角色不存在，请检查']);
                return;
            }

            $add_role_info = $role_info;
            // TODO: 判断权限
        }

        // 更改用户信息
        $update_data = array();
        if ($params['user_phone'] != $user_data['phone']) {
            $update_data['phone'] = $params['user_phone'];
        }
        if (!empty($params['user_passwd'])) {
            $update_data['passwd'] = $params['user_passwd'];
        }
        if ($params['user_name'] != $user_data['username']) {
            $update_data['username'] = $params['user_name'];
        }
        if ($params['user_email'] != $user_data['email']) {
            $update_data['email'] = $params['user_email'];
        }
        if ($params['status'] != $user_data['status']) {
            $update_data['status'] = $params['status'];
        }

        if (!empty($update_data)) {
            $user_model->update($params['id'], $update_data);
        }

        // 角色信息
        if (!empty($add_role_info)) {
            // 添加角色
            foreach ($add_role_info as $val) {
                $role_data = array(
                    'user_id' => $params['id'],
                    'role_id' => $val['id'],
                    'pids' => empty($val['pids']) ? $val['id'] : $val['pids'].",".$val['id']
                );
                
                $user_role_model->create($role_data);
            }
        }

        // 删除角色
        $diff_id = array_diff($old_role_id, $params['role_id']);
        if (!empty($diff_id)) {
            foreach ($diff_id as $key => $val) {
                $user_role_model->delete(['id'=>$key, 'user_id'=>$params['id']]);
            }
        }

        echo json_encode(['status'=>1, 'info'=>'success']);
    }
}