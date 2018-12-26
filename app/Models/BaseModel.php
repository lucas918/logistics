<?php
namespace App\Models;
use DB;

/**
* 封装Model类 
* 使用查询构建器对数据库进行增删改查
**/
class BaseModel
{
	public $_db;
    protected $_table = '';
    protected $_key = 'id';
	public $_db_name = '';

    public function __construct() {
    	if (empty($this->_db_name)) {
			$this->db = DB::table($this->_table);
		}
		else {
			$this->db = DB::connection($this->_db_name)->table($this->_table);
		}
    }

    public function table($table = '')
	{
		if (!empty($table)) {
			$this->db = DB::table($table);
		}

		return $this->db->cloneWithout([]);
	}

    // 新增数据
    public function create($data = [])
	{
		if (empty($data['created_at'])) {
			$data['created_at'] = date('Y-m-d H:i:s');
		}
		
		if (empty($data['updated_at'])) {
			$data['updated_at'] = date('Y-m-d H:i:s');
		}
		
		$id = $this->table()->insertGetId($this->checkData($data));

		return empty($id) ? false : $id;
	}

	// 转化成数组
    public function toArray($object)
	{
	    $new = [];
	    if (empty($object)) {
	        $object = [];
	    }
	    
	    foreach ($object as $key => $value) {
	        if (is_array($value) || is_object($value)) {
	            $new[$key] =  $this->toArray($value);
	        }else{
	            $new[$key] = (string) $value;
	        }
	    }

	    return $new;
	}

	// 更新数据
	public function update($id, $data)
	{
		$db = $this->table();

		if (is_array($id)) {
			$db = $db->whereIn($this->_key, $id);
		}
		else {
			$db = $db->where($this->_key, $id);
		}

		$data['updated_at'] = date('Y-m-d H:i:s');

		return $db->update($this->checkData($data)) !== false;
	}

	// 总数
	public function count($data)
	{
		$db = $this->table();
		$data = $this->checkData($data);

		foreach ($data as $key => $val) {
			if (is_array($val)) {
				$db = $db->whereIn($key, $val);
			}
			else {
				$db = $db->where($key, $val);
			}
		}

		return $db->count();
	}

	// 删除
	public function delete($data)
	{
		$db = $this->table();
		$data = $this->checkData($data);

		foreach ($data as $key => $val) {
			if (is_array($val)) {
				$db = $db->whereIn($key, $val);
			}
			else {
				$db = $db->where($key, $val);
			}
		}

		return $db->delete();
	}

	// 检验数据表字段
	public function checkData($data)
	{
		if (empty($this->_db_name)) {
			$_db_name = env('DB_DATABASE');
		}
		else {
			$_db_name = $this->_db_name;
		}

		$param = DB::select('show columns from `'.$_db_name.'`.`'.$this->_table.'`');
		$filed = array();
		$vaild_data = array();
		foreach ($param as $key => $value) {
			if (isset($data[$value->Field])) {
				$vaild_data[$value->Field] = $data[$value->Field];
			}
		}
		
		return $vaild_data;
	}
}
