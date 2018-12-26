<?php
namespace App\Models;

class RoleModel extends BaseModel
{
    protected $_table = 'sys_role';

    public function getRole($data, $page=0, $page_size=10)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);
        
        if (!empty($data['id'])) {
            if (is_array($data['id']) && count($data['id']) == 1) {
                $data['id'] = array_shift($data['id']);
            }

            $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);
        }
        
        !empty($data['title']) && $_db = $_db->where('title', $data['title']);
        !empty($data['status']) && $_db = $_db->where('status', $data['status']);

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

        if (!empty($data['order'])) {
            isset($data['orderby']) || $data['orderby'] = 'asc';

            if (is_array($data['order'])) {
                foreach ($data['order'] as $key => $val) {
                    $orderby = is_array($data['orderby']) ? $data['orderby'][$key] : $data['orderby'];
                    $_db = $_db->orderBy($val, $orderby);
                }
            }
            else {
                $_db = $_db->orderBy($data['order'],$data['orderby']);
            }
        }

        if ($page > 0) {
            $_db = $_db->limit($page_size)->offset(($page-1) * $page_size);
        }

        return $this->toArray($_db->get());
    }

    // count
    public function countRole($data)
    {
        $_db = $this->table();

        if (!empty($data['id'])) {
            if (is_array($data['id']) && count($data['id']) == 1) {
                $data['id'] = $data['id'][0];
            }

            $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);
        }
        
        !empty($data['title']) && $_db = $_db->where('title', $data['title']);
        !empty($data['status']) && $_db = $_db->where('status', $data['status']);

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

        return $_db->count();
    }
}