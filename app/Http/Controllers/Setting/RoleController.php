<?php
namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\MenuModel;
use App\Models\RoleModel;

class RoleController extends Controller
{
    public function index()
    {
        $page_size = 10;
        $page = $this->request->input('page', 1);
        $page < 1 && $page = 1;

        // 当前角色id
        $user_info = \Session::get('user_info');

        // 角色菜单栏
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

        $is_privilege = ($menu_id == array('all')) ? 1 : 0;

        $menu_data = $menu_model->getMenu($menu_param);
        $menu_list = $this->getTree($menu_data, 0);

        $role_id = is_numeric($user_info['role_id']) ? intval($user_info['role_id']) : explode(',', $user_info['role_id']);

        // 获取角色信息
        $role_model = new RoleModel;
        $role_data = $role_model->getRole(['pids'=>$role_id, 'order'=>['parent_id','created']], $page, $page_size);

        $role_total = $role_model->countRole(['pids'=>$role_id]);

        // 所有角色树形数据
        $rows = $role_model->getRole(['pids'=>$role_id, 'order'=>['parent_id','created']]);
        $role_data_tree = $this->getRoleTree($rows, 0);

        $paginator = new LengthAwarePaginator($role_data, $role_total, $page_size, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
        // print_r($menu_list);
        // exit;

        return view('setting/role', array(
            'is_privilege' => $is_privilege,
            'role_data' => $role_data,
            'role_data_tree' => $role_data_tree,
            'menu_list' => $menu_list,
            'page_info' => $paginator
        ));
    }

    // 新增角色
    public function add()
    {
        $params = $this->request->all();
        if (empty($params) || empty($params['role_id']) || empty($params['role_name'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $role_model = new RoleModel;
        // 查看角色信息是否存在
        $role_data = $role_model->getRole(['id'=>$params['role_id'], 'status'=>1]);
        if (empty($role_data)) {
            echo json_encode(['status'=>0, 'info'=>'角色不存在']);
            return;
        }

        $role_pids = empty($role_data[0]['pids']) ? array(0) : explode(',', $role_data[0]['pids']);
        if (!in_array($params['role_id'], $role_pids)) {
            $role_pids[] = $params['role_id'];
        }

        $role_data = array(
            'title' => $params['role_name'],
            'remark' => empty($params['role_remark']) ? '' : $params['role_remark'],
            'parent_id' => $params['role_id'],
            'pids' => implode(',', $role_pids)
        );

        $role_id = $role_model->create($role_data);
        echo json_encode(['status'=>1, 'result'=>['role_id'=>$role_id], 'info'=>'success']);
    }

    // 编辑角色
    public function update()
    {
        $params = $this->request->all();
        if (empty($params) || empty($params['id']) || empty($params['role_id']) || empty($params['role_name'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $role_model = new RoleModel;

        // 查看当前角色是否可操作
        $role_data = $role_model->getRole(['id'=>$params['id']]);
        if (empty($role_data)) {
            echo json_encode(['status'=>0, 'info'=>'角色不存在']);
            return;
        }

        $role_pids = empty($role_data[0]['pids']) ? array(0) : explode(',', $role_data[0]['pids']);
        $user_info = \Session::get('user_info');
        $role_id = is_numeric($user_info['role_id']) ? array($user_info['role_id']) : explode(',', $user_info['role_id']);

        if (empty(array_intersect($role_pids, $role_id))) {
            echo json_encode(['status'=>0, 'info'=>'没有操作权限']);
            return;
        }

        // 更新角色信息
        $data = array(
            'title' => $params['role_name'],
            'remark' => $params['role_remark'],
        );

        // 父类角色是否有变更
        if ($params['role_id'] != $role_data[0]['parent_id']) {
            $row = $role_model->getRole(['id'=>$params['role_id']]);
            if (empty($row)) {
                echo json_encode(['status'=>0, 'info'=>'角色目录不存在']);
                return;
            }

            $role_pids = empty($row[0]['pids']) ? array(0) : explode(',', $row[0]['pids']);
            if (!in_array($params['role_id'], $role_pids)) {
                $role_pids[] = $params['role_id'];
            }

            $data['parent_id'] = $params['role_id'];
            $data['pids'] = implode(',', $role_pids);
        }

        // 菜单栏
        if (in_array('-1', $params['menu_id'])) {
            $data['menu_list'] = '*';
        }
        else {
            $data['menu_list'] = implode(',', $params['menu_id']);
        }

        $role_model->update($params['id'], $data);

        echo json_encode(['status'=>1, 'info'=>'success']);
    }
}