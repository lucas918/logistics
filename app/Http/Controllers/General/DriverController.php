<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Models\DriverModel;

class DriverController extends Controller
{
    public function index()
    {
        $page_size = 10;
        $page = $this->request->input('page', 0);
        $page < 1 && $page = 1;

        $driver_model = new DriverModel;
        $driver_data = $driver_model->getAll([], $page, $page_size);
        $driver_total = $driver_model->count([]);

        $paginator = new LengthAwarePaginator($driver_data, $driver_total, $page_size, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('general/driver', array(
            'driver_data' => $driver_data,
            'page_info' => $paginator
        ));
    }

    // 新增
    public function add()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['name']) || !isset($params['phone'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $driver_model = new DriverModel;
        $count = $driver_model->count(['phone'=>$params['phone']]);
        if ($count > 0) {
            echo json_encode(['status'=>0, 'info'=>'该手机号码已注册，请检查后再录入']);
            return;
        }

        $data = array(
            'name' => $params['name'],
            'phone' => $params['phone'],
            'status' => $params['status'],
            'remark' => isset($params['remark']) ? $params['remark'] : ''
        );

        $driver_model->create($data);

        echo json_encode(['status'=>1, 'info'=>'success']);
    }

    // 编辑
    public function update()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['id']) || empty($params['name']) || !isset($params['phone'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $driver_model = new DriverModel;
        $driver_row = $driver_model->getRow(['id'=>$params['id']]);
        if (empty($driver_row)) {
            echo json_encode(['status'=>0, 'info'=>'司机信息不存在']);
            return;
        }

        $up_data = array();
        if ($params['phone'] != $driver_row['phone']) {
            // 检查手机号码是否存在
            $count = $driver_model->count(['phone'=>$params['phone']]);
            if ($count > 0) {
                echo json_encode(['status'=>0, 'info'=>'手机号码已注册，请检查后再更改']);
                return;
            }

            $up_data['phone'] = $params['phone'];
        }

        if ($params['name'] != $driver_row['name']) {
            $up_data['name'] = $params['name'];
        }
        if (isset($params['status']) && $params['status'] != $driver_row['status']) {
            $up_data['status'] = $params['status'];
        }
        if (isset($params['remark']) && $params['remark'] != $driver_row['remark']) {
            $up_data['remark'] = $params['remark'];
        }

        if (!empty($up_data)) {
            $driver_model->update($params['id'], $up_data);
        }

        echo json_encode(['status'=>1, 'info'=>'success']);
    }
}