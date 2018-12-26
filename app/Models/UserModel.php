<?php
namespace App\Models;

class UserModel extends BaseModel
{
    protected $_table = 'sys_user';

    // 获取用户
    public function getUser($data, $page=0, $page_size=10)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);
        !empty($data['phone']) && $_db = $_db->where('phone', $data['phone']);
        !empty($data['username']) && $_db = $_db->where('username', $data['username']);
        !empty($data['email']) && $_db = $_db->where('email', $data['email']);
        !empty($data['status']) && $_db = $_db->where('status', $data['status']);

        if ($page > 0) {
            $_db = $_db->limit($page_size)->offset(($page-1) * $page_size);
        }

        return $this->toArray($_db->get());
    }
}
