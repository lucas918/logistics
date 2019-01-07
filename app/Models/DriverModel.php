<?php
namespace App\Models;

class DriverModel extends BaseModel
{
    protected $_table = 'driver';
    
    public function getAll($data, $page=0, $page_size=10)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);
        empty($data['phone']) || $_db = $_db->where('phone', $data['phone']);

        if ($page > 0) {
            $_db = $_db->limit($page_size)->offset(($page-1) * $page_size);
        }

        return $this->toArray($_db->get());
    }
}