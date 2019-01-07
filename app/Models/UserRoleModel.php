<?php
namespace App\Models;

class UserRoleModel extends BaseModel
{
    protected $_table = 'sys_user_role';

    // 获取记录
    public function getAll($data)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = $_db->where('id', $data['id']);
        !empty($data['user_id']) && $_db = $_db->where('user_id', $data['user_id']);
        !empty($data['role_id']) && $_db = $_db->where('role_id', $data['role_id']);

        if (!empty($data['pids'])) {
            if (is_array($data['pids'])) {
                $sql = "(1 ";
                foreach ($data['pids'] as $val) {
                    $sql .= " OR find_in_set({$val}, pids) OR id = {$val}";
                }
                $sql .= ")";
            }
            else {
                $sql = "(find_in_set({$data['pids']}, pids) OR id = {$data['pids']})";
            }

            $_db = $_db->whereRaw($sql);
        }

        return $this->toArray($_db->get());
    }

    // 联表角色记录
    public function getJoinRole($data)
    {
        $_db = $this->table($this->_table.' as t0');
        $_db->leftJoin('sys_role as t1', 't0.role_id', '=', 't1.id');

        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = $_db->where('t0.id', $data['id']);
        !empty($data['user_id']) && $_db = $_db->where('t0.user_id', $data['user_id']);
        !empty($data['role_id']) && $_db = $_db->where('t0.role_id', $data['role_id']);

        return $this->toArray($_db->get());
    }
}
