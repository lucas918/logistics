@extends('layouts.app')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title  am-cf">用户列表</div>
                </div>
                <div class="widget-body am-fr">
                <?php
                    // 角色列表
                    function showRoleTree($role, $level=0)
                    {
                        $html = "";
                        foreach ($role as $val) {
                            $html .= "<option value='".$val['id']."'>";

                            for($i=0; $i<$level; $i++) {
                                $html .= "&nbsp;&nbsp;";
                            }

                            $html .= $val['title']."</option>";

                            if (!empty($val['sub_menu'])) {
                                $html .= showRoleTree($val['sub_menu'], $level+1);
                            }
                        }

                        return $html;
                    }
                ?>
                    <div class="row search-form">
                        <div class="am-u-sm-12 am-u-md-3 am-u-lg-6">
                            <div class="am-form-group">
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button type="button" class="am-btn am-btn-default am-btn-success modal-btn" data-method='add'><span class="am-icon-plus"></span> 新增</button>
                                        <!-- <button type="button" class="am-btn am-btn-default am-btn-warning modal-btn" data-method='disable'><span class="am-icon-trash-o"></span> 禁用</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-u-md-5 am-u-lg-3">
                            <div class="am-form-group tpl-table-list-select">
                                <select name="role_id" data-am-selected="{btnSize:'sm'}">
                                    <?php echo showRoleTree($role_data_tree, 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-u-md-4 am-u-lg-3">
                            <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                <input type="text" name="keyword" class="am-form-field" value="<?php echo $search['keyword']; ?>" placeholder="搜索用户名">
                                <span class="am-input-group-btn">
                                    <button class="am-btn am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="button"></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black table-middle">
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>ID</th>
                                    <th>用户名称</th>
                                    <th>基本信息</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($user_info)) { ?>
                                <tr><td colspan="7" style="text-align:center;color:red;">当前没有用户数据</td></tr>
                                <?php } else {
                                    foreach ($user_info as $val) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" data-id="<?php echo $val['id']; ?>"></td>
                                    <td><?php echo $val['id']; ?></td>
                                    <td><?php echo $val['username']; ?></td>
                                    <td>
                                        <i>手机：<?php echo $val['phone']; ?></i>
                                        <br/>
                                        <i>邮箱：<?php echo empty($val['email']) ? '-' : $val['email']; ?></i>
                                    </td>
                                    <td><?php echo substr($val['created'], 0, 10); ?></td>
                                    <td><?php echo $val['status'] == 1 ? '启用' : '禁用'; ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                            <a href="javascript:;" class="modal-btn" data-method='edit' data-info='<?php echo json_encode(['id'=>$val['id'],'username'=>$val['username'],'phone'=>$val['phone'],'email'=>$val['email'],'address'=>$val['address'],'status'=>$val['status'],'role_id'=>$val['role_id']]); ?>'>
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
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
                        <form class="am-form tpl-form-border-form tpl-form-border-br user-add" data-target='add' method="POST" action="/setting/user/add" data-am-validator style="display:none;">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">用户姓名 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="user-name" name="user_name" placeholder="请输入用户姓名（至少 2 个字符）" minlength="2" required>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">手机号码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="am-form-field tpl-form-no-bg" id='user-phone' name="user_phone" placeholder="手机号码" pattern="^\d{11}$" required>
                                        <small>手机号码为必填</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">邮箱</label>
                                    <div class="am-u-sm-9">
                                        <input type="email" class="am-form-field tpl-form-no-bg" id='user-email' name="user_email" placeholder="用户邮箱">
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="passwd" class="am-u-sm-3 am-form-label">账号密码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="am-form-field tpl-form-no-bg" id='passwd' name="user_passwd" placeholder="账号密码" autocomplete="off" minlength="6" maxlength="24" required>
                                        <small>请输入6-24位密码</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="confirm-passwd" class="am-u-sm-3 am-form-label">确认密码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="am-form-field tpl-form-no-bg" id='confirm-passwd' name="user_passwd1" placeholder="账号密码" autocomplete="off" data-equal-to="#passwd" required>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">角色 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <select multiple data-am-selected name="role_id" required>
                                        <?php echo showRoleTree($role_data_tree, 0); ?>
                                        </select>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-address" class="am-u-sm-3 am-form-label">地址</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="am-form-field tpl-form-no-bg" id='user-address' name="user_address" placeholder="详细地址" autocomplete="off">
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

                        <form class="am-form tpl-form-border-form tpl-form-border-br user-edit" data-target='edit' method="POST" action="/setting/user/update" style="display:none;">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="0">
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="user-name1" class="am-u-sm-3 am-form-label">用户姓名 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="user-name1" name="user_name" placeholder="请输入用户姓名（至少 2 个字符）" minlength="2" required>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-phone1" class="am-u-sm-3 am-form-label">手机号码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="am-form-field tpl-form-no-bg" id='user-phone1' name="user_phone" placeholder="手机号码" pattern="^\d{11}$" required>
                                        <small>手机号码为必填</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-email1" class="am-u-sm-3 am-form-label">邮箱</label>
                                    <div class="am-u-sm-9">
                                        <input type="email" class="am-form-field tpl-form-no-bg" id='user-email1' name="user_email" placeholder="用户邮箱">
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="passwd1" class="am-u-sm-3 am-form-label">账号密码</label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="am-form-field tpl-form-no-bg" id='passwd1' name="user_passwd" placeholder="不更改密码则不填写" autocomplete="off">
                                        <small>请输入6-24位密码</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="confirm-passwd1" class="am-u-sm-3 am-form-label">确认密码</label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="am-form-field tpl-form-no-bg" id='confirm-passwd1' name="user_passwd1" placeholder="账号密码" autocomplete="off" data-equal-to="#passwd1">
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">角色 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <select multiple data-am-selected name="role_id" required>
                                        <?php echo showRoleTree($role_data_tree, 0); ?>
                                        </select>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-address1" class="am-u-sm-3 am-form-label">地址 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="am-form-field tpl-form-no-bg" id='user-address1' name="user_address" placeholder="详细地址" autocomplete="off">
                                        <small></small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">状态 </label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="1"> 启用</label>
                                        <label class="am-radio-inline am-form-label"><input type="radio" name="status" value="0"> 禁用</label>
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
        // 搜索角色
        <?php if (!empty($search['role_id'])) { ?>
        $(".search-form select[name='role_id']").find("option[value='<?php echo $search['role_id']; ?>']").prop('selected', true);
        // 手动触发事件
        $(".search-form select[name='role_id']").trigger('changed.selected.amui');
        <?php } ?>

        // 角色
        $(document).on('change', ".search-form select[name='role_id']", function() {
            var uri = '/setting/user?role_id='+$(this).val()+'&keyword='+$(".search-form input[name='keyword']").val();
            window.location.href = uri;
        });

        // 搜索按键
        $(document).on('click', ".search-form button.am-icon-search", function() {
            var uri = '/setting/user?role_id='+$(".search-form select[name='role_id']").val()+'&keyword='+$(".search-form input[name='keyword']").val();
            window.location.href = uri;
        });

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
                modal_title = '新增用户';

                $form = $("#dialog-modal form.user-add");
                $form.find('.am-form-group').removeClass('am-form-error').removeClass('am-form-success');
                $form.find('.am-form-group input').removeClass('am-field-error').removeClass('am-field-valid').val('').siblings('small').html('');

                if ($form.find('fieldset select option:selected').length > 0) {
                    $form.find('select option').prop('selected', false);
                    // 手动触发事件
                    $form.find('select').trigger('changed.selected.amui');
                }
            }
            else {
                modal_title = '编辑用户';

                $form = $("#dialog-modal form.user-edit");
                $form.find(".am-form-group input[type='text']").val('').siblings('small').html('');

                var data_info = JSON.parse($(e.target).attr('data-info'));
                if (typeof data_info.id != undefined) {
                    $form.find("input[name='id']").val(data_info.id);
                }

                if (typeof data_info.username != undefined) {
                    $form.find("input[name='user_name']").val(data_info.username);
                }

                if (typeof data_info.phone != undefined) {
                    $form.find("input[name='user_phone']").val(data_info.phone);
                }

                if (typeof data_info.email != undefined) {
                    $form.find("input[name='user_email']").val(data_info.email);
                }

                if (typeof data_info.role_id != undefined) {
                    $select = $form.find('select[name="role_id"]');
                    $.each(data_info.role_id, function(idx, val) {
                        $select.find('option[value="'+val+'"]').prop('selected', true);
                    });

                    // 手动触发事件
                    $select.trigger('changed.selected.amui');
                }

                if (typeof data_info.address != undefined) {
                    $form.find("input[name='user_address']").val(data_info.address);
                }

                if (typeof data_info.status != undefined) {
                    $form.find("input[name='status'][value='"+data_info.status+"']").prop('checked', true);
                }
            }

            $form.show();
            $('#dialog-modal .am-modal-hd .modal-title').html(modal_title);
            $('#dialog-modal').modal({width:700});
        });

        // 表单提交
        $("form").submit(function(e) {
            var $target = $(e.target);
            if ($target.data('target') == undefined) {
                console.log('empty target');
                return false;
            }

            var form_data = {};
            var user_name = $target.find("input[name='user_name']").val();
            if (user_name.trim() == '') {
                $target.find("input[name='user_name']").siblings('small').addClass('am-text-danger').text('用户姓名不能为空');
                return false;
            }
            else if (user_name.length < 2 || user_name.length > 20) {
                $target.find("input[name='user_name']").siblings('small').addClass('am-text-danger').text('用户姓名控制在2-20字以内。');
            }
            else {
                $target.find("input[name='user_name']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['user_name'] = user_name;

            var user_phone = $target.find("input[name='user_phone']").val();
            if (user_phone.trim() == '') {
                $target.find("input[name='user_phone']").siblings('small').addClass('am-text-danger').text('手机号码不能为空');
                return false;
            }
            else {
                $target.find("input[name='user_phone']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['user_phone'] = user_phone;

            var user_passwd = $target.find("input[name='user_passwd']").val();
            if ($target.data('target') == 'add') {
                if (user_passwd.trim() == '') {
                    $target.find("input[name='user_passwd']").siblings('small').addClass('am-text-danger').text('密码不能为空');
                    return false;
                }
            }

            if ($target.find("input[name='user_passwd1']").val() != user_passwd) {
                $target.find("input[name='user_passwd1']").siblings('small').addClass('am-text-danger').text('确认密码不一致');
                return false;
            }
            else {
                $target.find("input[name='user_passwd']").siblings('small').removeClass('am-text-danger').text('');
                $target.find("input[name='user_passwd1']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['user_passwd'] = user_passwd;

            var role_id = $target.find("select[name='role_id']").val();
            if (parseInt(role_id) == 0 || role_id == null) {
                $target.find("select[name='role_id']").siblings('small').addClass('am-text-danger').text('角色不能为空');
                return false;
            }
            else {
                $target.find("select[name='role_id']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['role_id'] = role_id;

            if ($target.find("input[name='user_email']").val() != '') {
                form_data['user_email'] = $target.find("input[name='user_email']").val();
            }

            if ($target.find("input[name='user_address']").val() != '') {
                form_data['user_address'] = $target.find("input[name='user_address']").val();
            }

            if ($target.find("input[name='status']:checked").length > 0) {
                form_data['status'] = $target.find("input[name='status']").val();
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