<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\UserModel;

class InfoController extends Controller
{
    public function index()
    {
        $user_info = \Session::get('user_info');
        $uid = $user_info['uid'];

        $user_model = new UserModel;
        $user_data = $user_model->getUser(['id'=>$uid]);

        return view('general/info', array(
            'data' => $user_data[0]
        ));
    }

    // 修改密码
    public function passwd()
    {
        $passwd_old = $this->request->input('passwd_old', '');
        $passwd_new = $this->request->input('passwd_new', '');
        $passwd_cfr = $this->request->input('passwd_cfr', '');

        if (empty($passwd_old) || empty($passwd_new)) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }
        else if ($passwd_new != $passwd_cfr) {
            echo json_encode(['status'=>0, 'info'=>'两次输入的新密码不一致']);
            return;
        }

        // 用户信息
        $user_info = \Session::get('user_info');
        $uid = $user_info['uid'];

        $user_model = new UserModel;
        $user_data = $user_model->getUser(['id'=>$uid]);
        $user_data = $user_data[0];

        if (!$this->password_verify($passwd_old, $user_data['password'])) {
            echo json_encode(['status'=>0, 'info'=>'旧密码不对，请确认密码是否正确！']);
            return;
        }

        $passwd = $this->passwd_encrypt($passwd_new);
        $user_model->update($uid, ['password'=>$passwd]);
        echo json_encode(['status'=>1, 'info'=>'success']);
    }
}