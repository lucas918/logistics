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

    // 获取总数
    public function countUser($data)
    {
        $_db = $this->table();

        !empty($data['id']) && $_db = $_db->where('id', $data['id']);
        !empty($data['user_id']) && $_db = $_db->where('user_id', $data['user_id']);
        !empty($data['role_id']) && $_db = $_db->where('role_id', $data['role_id']);
        return $_db->count();
    }
}
