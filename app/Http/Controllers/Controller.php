<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
	// 构造请求数
    public function __construct(Request $req)
    {
        $this->request = $req;
    }

    /**
     * 密码加密
     *
     * @param   string  $passwd
     *
     * @return  string  $hash
     */
    protected function passwd_encrypt($passwd)
    {
        return password_hash($passwd, PASSWORD_DEFAULT);
    }

    /**
     * 密码验证
     *
     * @param   string  $passwd
     * @param   string  $hash
     *
     * @return  void
     */
    protected function password_verify($passwd, $hash)
    {
        return password_verify($passwd, $hash);
    }

    // 无限级树形菜单
    protected function getTree($data, $pid)
    {
        $tree = [];

        foreach ($data as $key => $val) {
            if ($val['parent_id'] != $pid) {
                continue;
            }

            unset($data[$key]);

            $val['sub_menu'] = $this->getTree($data, $val['id']);

            $tree[] = array(
                'id' => $val['id'],
                'title' => $val['title'],
                'subtitle' => $val['subtitle'],
                'icon' => $val['icon'],
                'uri' => $val['uri'],
                'parent_id' => $val['parent_id'],
                'sub_page' => $val['sub_page'],
                'sub_menu' => $val['sub_menu']
            );
        }

        return $tree;
    }

    // 角色无限级树形
    protected function getRoleTree($data, $pid)
    {
        $tree = [];
        foreach ($data as $key => $val) {
            if ($val['parent_id'] != $pid) {
                continue;
            }

            unset($data[$key]);

            $val['sub_menu'] = $this->getRoleTree($data, $val['id']);
            $tree[] = array(
                'id' => $val['id'],
                'title' => $val['title'],
                'remark' => $val['remark'],
                'parent_id' => $val['parent_id'],
                'menu_list' => $val['menu_list'],
                'status' => $val['status'],
                'sub_menu' => $val['sub_menu']
            );
        }

        return $tree;
    }
}
