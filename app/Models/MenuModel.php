<?php
namespace App\Models;

class MenuModel extends BaseModel
{
    protected $_table = 'sys_menu';

    public function getMenu($data)
    {
        $_db = $this->table();
        !empty($data['fields']) && $_db = $_db->select($data['fields']);

        if (!empty($data['id'])) {
            $_db = (is_array($data['id'])) ? $_db->whereIn('id', $data['id']) : $_db->where('id', $data['id']);
        }
        isset($data['status']) && $_db = $_db->where('status', $data['status']);
        isset($data['sub_page']) && $_db = $_db->where('sub_page', $data['sub_page']);

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

        return $this->toArray($_db->get());
    }
}