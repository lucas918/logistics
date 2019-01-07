@extends('layouts.app')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">个人信息</div>
                    <div class="widget-function am-fr">
                        <button type="button" class="am-btn am-btn-xs am-btn-default am-btn-success modal-btn" data-method='info-edit'><span class="am-icon-edit"></span> 编辑</button>
                        <button type="button" class="am-btn am-btn-xs am-btn-default am-btn-secondary modal-btn" data-method='passwd-edit'><span class="am-icon-edit"></span> 修改密码</button>
                    </div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-u-sm-12">
                        <div class="tpl-form-list">
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label">姓名</label>
                                <div class="am-u-sm-10 tpl-form-field"><?php echo $data['username']; ?></div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label">手机号码</label>
                                <div class="am-u-sm-10 tpl-form-field"><?php echo $data['phone']; ?></div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label">邮箱</label>
                                <div class="am-u-sm-10 tpl-form-field"><?php echo empty($data['email']) ? '未填写' : $data['email']; ?></div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label">性别</label>
                                <div class="am-u-sm-10 tpl-form-field">
                                    <label class="am-radio-inline"><input type="radio" <?php echo $data['sex'] == 1 ? 'checked' : 'disabled'; ?>>男</label>
                                    <label class="am-radio-inline"><input type="radio" <?php echo $data['sex'] == 2 ? 'checked' : 'disabled'; ?>>女</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-2 am-form-label">地址</label>
                                <div class="am-u-sm-10 tpl-form-field"><?php echo empty($data['address']) ? '未填写' : $data['address']; ?></div>
                            </div>
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
                        <form class="am-form tpl-form-border-form tpl-form-border-br info-edit" data-target='info-edit' method="POST" action="/general/info/update" data-am-validator>
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="form-info-1" class="am-u-sm-3 am-form-label">姓名 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-info-1" name="user_name" value="<?php echo $data['username']; ?>" placeholder="用户姓名（至少2个字符）" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-info-2" class="am-u-sm-3 am-form-label">手机号码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-info-2" name="user_phone" value="<?php echo $data['phone']; ?>" placeholder="手机号码" pattern="^\d{11}$" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-info-3" class="am-u-sm-3 am-form-label">邮箱 </label>
                                    <div class="am-u-sm-9">
                                        <input type="email" class="tpl-form-input" id="form-info-3" name="user_email" value="<?php echo $data['email']; ?>" placeholder="用户邮箱">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">性别 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <label class="am-radio-inline"><input type="radio" name="sex" value="1" <?php echo $data['sex'] == 1 ? 'checked' : ''; ?>>男</label>
                                        <label class="am-radio-inline"><input type="radio" name="sex" value="2" <?php echo $data['sex'] == 2 ? 'checked' : ''; ?>>女</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="form-info-5" class="am-u-sm-3 am-form-label">地址 </label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="form-info-5" name="address" value="<?php echo $data['address']; ?>" placeholder="详细地址">
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

                        <form class="am-form tpl-form-border-form tpl-form-border-br passwd-edit" data-target='passwd-edit' method="POST" action="/general/info/passwd" data-am-validator>
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="am-form-group">
                                    <label for="doc-ipt-passwd-1" class="am-u-sm-3 am-form-label">旧密码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="doc-ipt-passwd-1" name="passwd_old" placeholder="请输入当前登录密码" autocomplete="new-password" minlength="6" maxlength="24" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="doc-ipt-passwd-2" class="am-u-sm-3 am-form-label">新密码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="doc-ipt-passwd-2" name="passwd_new" placeholder="请输入6-24位新密码" autocomplete="new-password" minlength="6" maxlength="24" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="doc-ipt-passwd-3" class="am-u-sm-3 am-form-label">确认密码 <sup class="am-text-danger">*</sup></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="doc-ipt-passwd-3" name="passwd_cfr" placeholder="请输入6-24位新密码" autocomplete="new-password" minlength="6" maxlength="24" data-equal-to="#doc-ipt-passwd-2" required>
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
    $(function() {
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
            if (method == 'passwd-edit') {
                modal_title = '修改密码';

                $form = $("#dialog-modal form.passwd-edit");
                $form.find('.am-form-group').removeClass('am-form-error').removeClass('am-form-success');
                $form.find('.am-form-group input').removeClass('am-field-error').removeClass('am-field-valid').val('').siblings('small').html('');
            }
            else if (method == 'info-edit') {
                modal_title = '修改个人信息';
                $form = $("#dialog-modal form.info-edit");
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
            if ($target.data('target') == 'passwd-edit') {
                var passwd_old = $target.find("input[name='passwd_old']").val();
                var passwd_new = $target.find("input[name='passwd_new']").val();
                var passwd_cfr = $target.find("input[name='passwd_cfr']").val();

                form_data['passwd_old'] = passwd_old;
                form_data['passwd_new'] = passwd_new;
                form_data['passwd_cfr'] = passwd_cfr;
            }
            else if ($target.data('target') == 'info-edit') {
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

                if ($target.find("input[name='user_email']").val() != '') {
                    form_data['user_email'] = $target.find("input[name='user_email']").val();
                }

                if ($target.find("input[name='sex']:checked").length > 0) {
                    form_data['sex'] = $target.find("input[name='sex']:checked").val();
                }

                if ($target.find("input[name='user_address']").val() != '') {
                    form_data['user_address'] = $target.find("input[name='user_address']").val();
                }
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