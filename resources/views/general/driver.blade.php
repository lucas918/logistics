@extends('layouts.app')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">司机列表</div>
                    <div class="widget-function am-fr"></div>
                </div>
                <div class="widget-body">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success modal-btn" data-method='add'><span class="am-icon-plus"></span> 新增</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-4 am-u-md-offset-2 am-u-lg-3 am-u-lg-offset-3">
                        <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                            <input type="text" class="am-form-field">
                            <span class="am-input-group-btn">
                                <button class="am-btn am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="button"></button>
                            </span>
                        </div>
                    </div>

                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black table-middle">
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>ID</th>
                                    <th>司机姓名</th>
                                    <th>手机号码</th>
                                    <th>备注信息</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (empty($driver_data)) {
                                    echo "<tr><td colspan='7' style='text-align:center;color:red;'>当前没有司机数据</td></tr>";
                                }
                                else {
                                    foreach ($driver_data as $val) {
                            ?>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th><?php echo $val['id']; ?></th>
                                    <td><?php echo $val['name']; ?></td>
                                    <td><?php echo $val['phone']; ?></td>
                                    <td><?php echo empty($val['remark']) ? '-' : $val['remark']; ?></td>
                                    <td><?php echo $val['status'] == 1 ? '有效' : '禁用'; ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                            <a href="javascript:;" class="modal-btn" data-method='edit' data-info='<?php echo json_encode(['id'=>$val['id'],'name'=>$val['name'],'phone'=>$val['phone'],'remark'=>$val['remark'],'status'=>$val['status']]); ?>'>
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                            <!-- <a href="javascript:;" class="tpl-table-black-operation-del">
                                                <i class="am-icon-trash"></i> 删除
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
                        <form class="am-form tpl-form-border-form tpl-form-border-br driver-add" data-target='add' method="POST" action="/general/driver/add" data-am-validator>
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="form-driver-1" class="am-u-sm-3 am-form-label">司机姓名 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-1" name="name" placeholder="姓名（至少2个字符）" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-driver-2" class="am-u-sm-3 am-form-label">联系方式 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-2" name="phone" placeholder="手机号码" pattern="^\d{11}$" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">状态 </label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="1" checked> 有效</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="0" required> 禁用</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-driver-3" class="am-u-sm-3 am-form-label">备注 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-3" name="remark" placeholder="备注信息">
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

                        <form class="am-form tpl-form-border-form tpl-form-border-br driver-edit" data-target='edit' method="POST" action="/general/driver/update">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="0">
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="form-driver-11" class="am-u-sm-3 am-form-label">司机姓名 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-11" name="name" placeholder="姓名（至少2个字符）" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-driver-12" class="am-u-sm-3 am-form-label">联系方式 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-12" name="phone" placeholder="手机号码" pattern="^\d{11}$" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">状态 </label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="1" checked> 有效</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="0" required> 禁用</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-driver-13" class="am-u-sm-3 am-form-label">备注 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-driver-13" name="remark" placeholder="备注信息">
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
                modal_title = '新增司机';

                $form = $("#dialog-modal form.driver-add");
                $form.find('.am-form-group').removeClass('am-form-error').removeClass('am-form-success');
                $form.find(".am-form-group input[type='text']").val('').removeClass('am-field-error').removeClass('am-field-valid').siblings('small').html('');
                $form.find(".am-form-group input[type='radio'][value='1']").prop('checked', true);
            }
            else {
                modal_title = '编辑车辆';

                $form = $("#dialog-modal form.driver-edit");
                $form.find(".am-form-group input[type='text']").val('').siblings('small').html('');
                $form.find(".am-form-group input[type='radio']").prop('checked', false).removeClass('am-field-valid');

                var data_info = JSON.parse($(e.target).attr('data-info'));
                if (typeof data_info.id != undefined) {
                    $form.find("input[name='id']").val(data_info.id);
                }

                if (typeof data_info.name != undefined) {
                    $form.find("input[name='name']").val(data_info.name);
                }

                if (typeof data_info.phone != undefined) {
                    $form.find("input[name='phone']").val(data_info.phone);
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
            var name = $target.find("input[name='name']").val();
            if (name.trim() == '') {
                $target.find("input[name='name']").siblings('small').addClass('am-text-danger').text('用户姓名不能为空');
                return false;
            }
            else if (name.length < 2 || name.length > 20) {
                $target.find("input[name='name']").siblings('small').addClass('am-text-danger').text('用户姓名控制在2-20字以内。');
                return false;
            }
            else {
                $target.find("input[name='name']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['name'] = name;

            var phone = $target.find("input[name='phone']").val();
            if (phone.trim() == '') {
                $target.find("input[name='phone']").siblings('small').addClass('am-text-danger').text('手机号码不能为空');
                return false;
            }
            else {
                $target.find("input[name='phone']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['phone'] = phone;

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