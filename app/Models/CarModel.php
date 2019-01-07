<?php
namespace App\Models;

class CarModel extends BaseModel
{
    protected $_table = 'car';
    
    public function getAll($data, $page=0, $page_size=10)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);

        if ($page > 0) {
            $_db = $_db->limit($page_size)->offset(($page-1) * $page_size);
        }

        return $this->toArray($_db->get());
    }

    public function getDetailAll($data, $page=0, $page_size=10)
    {
        $_db = $this->table($this->_table.' as t0');
        $_db->leftJoin('car_detail as t1', 't0.id', '=', 't1.car_id');

        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        !empty($data['id']) && $_db = (is_array($data['id'])) ? $_db->whereIn('t0.id', $data['id']) : $_db->where('t0.id', $data['id']);

        $_db = $_db->orderBy('t0.id', 'asc');

        if ($page > 0) {
            $_db = $_db->limit($page_size)->offset(($page-1) * $page_size);
        }

        return $this->toArray($_db->get());
    }
}