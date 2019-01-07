@extends('layouts.app')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">车辆列表</div>
                    <div class="widget-function am-fr"></div>
                </div>
                <div class="widget-body">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success modal-btn" data-method='add'><span class="am-icon-plus"></span> 新增</button>
                                    <!-- <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 下线</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-4 am-u-md-offset-2 am-u-lg-3 am-u-lg-offset-3">
                        <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                            <input type="text" class="am-form-field ">
                            <span class="am-input-group-btn">
                                <button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="button"></button>
                            </span>
                        </div>
                    </div>

                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black table-middle">
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>ID</th>
                                    <th>车牌号</th>
                                    <th>车辆详情</th>
                                    <th>备注信息</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (empty($car_data)) {
                                    echo "<tr><td colspan='7' style='text-align:center;color:red;'>当前没有车辆数据</td></tr>";
                                }
                                else {
                                    foreach ($car_data as $val) {
                            ?>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><?php echo $val['id']; ?></td>
                                    <td><?php echo $val['plate_number']; ?></td>
                                    <td><?php echo '车辆识别码: '.$val['vin'].'<br/>发动机码: '.$val['engine_no']; ?></td>
                                    <td><?php echo empty($val['remark']) ? '-' : $val['remark']; ?></td>
                                    <td><?php echo empty($val['status']) ? '未上线' : ($val['status'] == 1 ? '上线' : '已下线'); ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                            <a href="javascript:;" class="modal-btn" data-method='edit' data-info='<?php echo json_encode(['id'=>$val['id'],'plate_number'=>$val['plate_number'],'remark'=>$val['remark'],'vin'=>$val['vin'],'engine_no'=>$val['engine_no'],'status'=>$val['status']]); ?>'>
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                            <!-- <a href="javascript:;" class="tpl-table-black-operation-del">
                                                <i class="am-icon-trash"></i> 下线
                                            </a> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr">
                            {{ $page_info->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="dialog-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <span class="modal-title">标题</span>
            <a href="javascript:void(0);" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd">
            <div class="row modal-form">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf" style="text-align:left;">
                        <form class="am-form tpl-form-border-form tpl-form-border-br car-add" data-target='add' method="POST" action="/general/car/add" data-am-validator>
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="form-car-1" class="am-u-sm-3 am-form-label">车牌号 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-1" name="plate_number" placeholder="车牌号，如：湘A12345" pattern="^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使]{1}[A-Z]{1}[A-Z0-9]{5,6}$" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-2" class="am-u-sm-3 am-form-label">车辆识别码 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-2" name="vin" placeholder="车辆识别码">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-3" class="am-u-sm-3 am-form-label">发动机码 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-3" name="engine_no" placeholder="发动机码" >
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">状态 </label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="0" checked required> 未上线</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="1"> 上线</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-5" class="am-u-sm-3 am-form-label">备注 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-5" name="remark" placeholder="备注信息">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-text-default form-info" style="text-align:center;"></div>
                                    <div class="am-u-sm-7 am-u-sm-push-5">
                                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success">提交</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <form class="am-form tpl-form-border-form tpl-form-border-br car-edit" data-target='edit' method="POST" action="/general/car/update">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="0">
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="form-car-11" class="am-u-sm-3 am-form-label">车牌号 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-11" name="plate_number" placeholder="车牌号，如：湘A12345" pattern="^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使]{1}[A-Z]{1}[A-Z0-9]{5,6}$" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-12" class="am-u-sm-3 am-form-label">车辆识别码 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-12" name="vin" placeholder="车辆识别码">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-13" class="am-u-sm-3 am-form-label">发动机码 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-13" name="engine_no" placeholder="发动机码" >
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">状态 </label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="0" disabled required> 未上线</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="1"> 上线</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="2"> 下线</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-car-15" class="am-u-sm-3 am-form-label">备注 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-car-15" name="remark" placeholder="备注信息">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-text-default form-info" style="text-align:center;"></div>
                                    <div class="am-u-sm-7 am-u-sm-push-5">
                                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success">提交</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript_run')
<script type="text/javascript">
    $(function(){
        // modal click
        $(document).on('click', '.modal-btn', function(e) {
            var $target = $(e.target);

            if ($(e.target).attr('data-method') == undefined) {
                return;
            }

            var $form = $('#dialog-modal form');
            $form.hide();

            var method = $(e.target).attr('data-method');
            var modal_title = 'Modal';
            if (method == 'add') {
                modal_title = '新增车辆';

                $form = $("#dialog-modal form.car-add");
                $form.find('.am-form-group').removeClass('am-form-error').removeClass('am-form-success');
                $form.find(".am-form-group input[type='text']").val('').removeClass('am-field-error').removeClass('am-field-valid').siblings('small').html('');
                $form.find(".am-form-group input[type='radio'][value='0']").prop('checked', true);
            }
            else {
                modal_title = '编辑车辆';

                $form = $("#dialog-modal form.car-edit");
                $form.find(".am-form-group input[type='text']").val('').siblings('small').html('');
                $form.find(".am-form-group input[type='radio']").prop('checked', false).removeClass('am-field-valid');

                var data_info = JSON.parse($(e.target).attr('data-info'));
                if (typeof data_info.id != undefined) {
                    $form.find("input[name='id']").val(data_info.id);
                }

                if (typeof data_info.plate_number != undefined) {
                    $form.find("input[name='plate_number']").val(data_info.plate_number);
                }

                if (typeof data_info.vin != undefined) {
                    $form.find("input[name='vin']").val(data_info.vin);
                }

                if (typeof data_info.engine_no != undefined) {
                    $form.find("input[name='engine_no']").val(data_info.engine_no);
                }

                if (typeof data_info.remark != undefined) {
                    $form.find("input[name='remark']").val(data_info.remark);
                }

                if (typeof data_info.status != undefined) {
                    $form.find("input[name='status'][value='"+data_info.status+"']").prop('checked', true);
                }
            }

            $form.show();
            $('#dialog-modal .am-modal-hd .modal-title').html(modal_title);
            $('#dialog-modal').modal({width:700, closeViaDimmer:false});
        });

        // 表单提交
        $("form").submit(function(e) {
            var $target = $(e.target);
            if ($target.data('target') == undefined) {
                console.log('empty target');
                return false;
            }

            var form_data = {};
            var plate_number = $target.find("input[name='plate_number']").val();
            if (plate_number.trim() == '') {
                $target.find("input[name='plate_number']").siblings('small').addClass('am-text-danger').text('车牌号不能为空');
                return false;
            }
            else if (plate_number.search(/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使]{1}[A-Z]{1}[A-Z0-9]{5,6}$/)) {
                $target.find("input[name='plate_number']").siblings('small').addClass('am-text-danger').text('车牌号不正确');
                return false;
            }
            else {
                $target.find("input[name='plate_number']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['plate_number'] = plate_number;

            if ($target.find("input[name='vin']").val() != '') {
                form_data['vin'] = $target.find("input[name='vin']").val();
            }

            if ($target.find("input[name='engine_no']").val() != '') {
                form_data['engine_no'] = $target.find("input[name='engine_no']").val();
            }

            if ($target.find("input[name='status']:checked").length < 1) {
                $target.find("input[name='status']").parent('label').siblings('small').addClass('am-text-danger').text('请选择状态');
                return false;
            }
            else {
                $target.find("input[name='status']").parent('label').siblings('small').removeClass('am-text-danger').text('');
                form_data['status'] = $target.find("input[name='status']:checked").val();
            }

            if ($target.find("input[name='remark']").val() != '') {
                form_data['remark'] = $target.find("input[name='remark']").val();
            }

            // 隐藏参数
            $target.find("input[type='hidden']").each(function() {
                form_data[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                type: $target.attr('method'),
                url: $target.attr('action'),
                data: form_data,
                dataType: 'json',
                beforeSend: function() {
                    $target.find("button[type='submit']").attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.status != 1) {
                        $target.find('.form-info').html(data.info).addClass('am-text-danger');
                        $target.find("button[type='submit']").removeAttr('disabled');
                        return false;
                    }

                    $target.find('.form-info').html('');
                    $("#dialog-modal").modal('close');
                    window.location.reload();
                },
                error: function(data) {
                    $target.find('.form-info').html('提交失败').addClass('am-text-danger');
                    $target.find("button[type='submit']").removeAttr('disabled');
                    return false;
                }
            });

            return false;
        });
    });
</script>
@endsection