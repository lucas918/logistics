<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Models\CarModel;
use App\Models\CarDetailModel;

class CarController extends Controller
{
    public function index()
    {
        $page_size = 10;
        $page = $this->request->input('page', 0);
        $page < 1 && $page = 1;

        $car_model = new CarModel;
        $car_data = $car_model->getDetailAll(['fields'=>['t0.*','t1.vin','t1.engine_no']], $page, $page_size);

        $car_total = $car_model->count([]);

        $paginator = new LengthAwarePaginator($car_data, $car_total, $page_size, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('general/car', array(
            'car_data' => $car_data,
            'page_info' => $paginator
        ));
    }

    // 新增
    public function add()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['plate_number']) || !isset($params['status'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $car_model = new CarModel;

        // 判断车牌是否录入
        $count = $car_model->count(['plate_number'=>$params['plate_number']]);
        if ($count > 0) {
            echo json_encode(['status'=>0, 'info'=>'车牌号已存在，请勿重复添加']);
            return;
        }

        $data = array(
            'plate_number' => $params['plate_number'],
            'remark' => isset($params['remark']) ? $params['remark'] : '',
            'status' => $params['status']
        );
        $car_id = $car_model->create($data);

        if (empty($car_id)) {
            echo json_encode(['status'=>0, 'info'=>'保存失败']);
            return;
        }

        if (isset($params['vin'])) {
            $car_detail_model = new CarDetailModel;
            $data = array(
                'car_id' => $car_id,
                'vin' => isset($params['vin']) ? $params['vin'] : '',
                'engine_no' => isset($params['engine_no']) ? $params['engine_no'] : ''
            );

            $car_detail_model->create($data);
        }
        
        echo json_encode(['status'=>1, 'info'=>'success']);
    }

    // 编辑
    public function update()
    {
        $params = $this->request->all();

        if (empty($params) || empty($params['id']) || empty($params['plate_number']) || !isset($params['status'])) {
            echo json_encode(['status'=>0, 'info'=>'参数有误']);
            return;
        }

        $car_model = new CarModel;
        $car_info = $car_model->getRow(['id'=>$params['id']]);
        if (empty($car_info)) {
            echo json_encode(['status'=>0, 'info'=>'车辆不存在']);
        }

        $up_data = array();
        if ($params['plate_number'] != $car_info['plate_number']) {
            $up_data['plate_number'] = $params['plate_number'];
        }

        if (isset($params['remark']) && $params['remark'] != $car_info['remark']) {
            $up_data['remark'] = $params['remark'];
        }

        if ($params['status'] != $car_info['status']) {
            $up_data['status'] = intval($params['status']);
        }

        if (!empty($up_data)) {
            $car_model->update($params['id'], $up_data);
        }

        if (!isset($params['vin']) && !isset($params['engine_no'])) {
            echo json_encode(['status'=>1, 'info'=>'success']);
            return;
        }

        $up_data = array();

        $car_detail_model = new CarDetailModel;
        $car_detail = $car_detail_model->getRow(['car_id'=>$params['id']]);

        if (isset($params['vin']) && (empty($car_detail) || $car_detail['vin'] != $params['vin'])) {
            $up_data['vin'] = $params['vin'];
        }

        if (isset($params['engine_no']) && (empty($car_detail) || $car_detail['engine_no'] != $params['engine_no'])) {
            $up_data['engine_no'] = $params['engine_no'];
        }

        if (!empty($up_data)) {
            if (empty($car_detail)) {
                $up_data['car_id'] = $params['id'];
                $car_detail_model->create($up_data);
            }
            else {
                $car_detail_model->update($params['id'], $up_data);
            }
        }

        echo json_encode(['status'=>1, 'info'=>'success']);
    }
}