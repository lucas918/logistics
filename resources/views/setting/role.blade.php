@extends('layouts.app')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">角色列表</div>
                    <div class="widget-function am-fr"></div>
                </div>
                <div class="widget-body">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success modal-btn" data-method='add'><span class="am-icon-plus"></span> 新增</button>
                                    <!-- <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                            <!-- <input type="text" class="am-form-field ">
                            <span class="am-input-group-btn">
                                <button class="am-btn  am-btn-default am-btn-success tpl-table-list-field am-icon-search" type="button"></button>
                            </span> -->
                        </div>
                    </div>

                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black">
                            <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>ID</th>
                                    <th>角色名称</th>
                                    <th>备注信息</th>
                                    <th>时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($role_data as $key => $val) { ?>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><?php echo $val['id']; ?></td>
                                    <td><?php echo $val['title']; ?></td>
                                    <td><?php echo $val['remark']; ?></td>
                                    <td><?php echo substr($val['created'], 0, 10); ?></td>
                                    <td><?php echo $val['status'] == 1 ? '启动' : '禁用'; ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                            <a href="javascript:;" class="modal-btn" data-method='edit' data-info='<?php echo json_encode(['id'=>$val['id'],'title'=>$val['title'],'remark'=>$val['remark'],'parent_id'=>$val['parent_id'],'menu_list'=>$val['menu_list'],'status'=>$val['status']]); ?>'>
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
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
    <?php
    // 菜单目录
    function showTree($menu, $level=1, $is_privilege=0)
    {
        $ul_class = "menu-{$level} ";
        if ($level > 1) {
            $ul_class = "menu-ul ";
        }
        if ($menu[0]['type'] != 1) {
            $ul_class .= "am-u-sm-12";
        }

        $html = "<ul class='{$ul_class}'>";

        if ($is_privilege) {
            $html .= "<li style='border-bottom:1px solid;'><label><input type='checkbox' name='menu_id[]' value='-1' /><span class='title'>全部</span><span class='sub-title'>所有菜单操作权限</span></label></li>";
        }

        foreach ($menu as $key => $val) {
            $li_class = "";
            if ($val['type'] != 1) {
                $li_class .= "am-u-sm-4 ";
                
                if ($key == count($menu)-1) {
                    $li_class .= "am-u-end";
                }
            }

            $html .= "<li class='{$li_class}'><label><input type='checkbox' class='menu-tree-id' name='menu_id[]' value='{$val['id']}' />";

            if (!empty($val['icon'])) {
                $html .= "<i class='menu-icon {$val['icon']}'></i>";
            }
            if (!empty($val['title'])) {
                $html .= "<span class='title'>{$val['title']}</span>";
            }
            if (!empty($val['subtitle'])) {
                $html .= "<span class='sub-title'>{$val['subtitle']}</span>";
            }

            if (!empty($val['sub_menu'])) {
                $html .= showTree($val['sub_menu'], $level+1);
            }

            $html .= "</label></li>";
        }

        $html .= "</ul>";
        return $html;
    }

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
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <span class="modal-title">标题</span>
            <a href="javascript:void(0);" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd">
            <div class="row modal-form">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf role-add" style="text-align: left;display: none;">
                        <form class="am-form tpl-form-border-form tpl-form-border-br" data-target='add' method="POST" action="/setting/role/add">
                            {{ csrf_field() }}
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">角色目录</label>
                                <div class="am-u-sm-9">
                                    <select name="role_id" data-am-selected="{btnWidth:'40%', btnSize:'sm'}">
                                    <?php echo showRoleTree($role_data_tree, 0); ?>
                                    </select>
                                    <small></small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">角色名称</label>
                                <div class="am-u-sm-6 am-u-end">
                                    <input type="text" name='role_name' class="tpl-form-input" placeholder="角色名称">
                                    <small>角色名称控制在2-20字以内。</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">备注信息</label>
                                <div class="am-u-sm-6 am-u-end">
                                    <input type="text" name='role_remark' class="am-form-field tpl-form-no-bg" placeholder="角色备注信息">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">菜单列表</label>
                                <div class="am-u-sm-9 menu-list">
                                <?php echo showTree($menu_list, 1, $is_privilege); ?>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-text-default form-info" style="text-align:center;"></div>
                                <div class="am-u-sm-7 am-u-sm-push-5">
                                    <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="widget am-cf role-edit" style="text-align: left;display: none;">
                        <form class="am-form tpl-form-border-form tpl-form-border-br" data-target='edit' method="POST" action="/setting/role/update">
                        {{ csrf_field() }}
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">角色目录</label>
                                <div class="am-u-sm-9">
                                    <select name='role_id' data-am-selected="{btnWidth:'40%', btnSize:'sm'}">
                                    <?php echo showRoleTree($role_data_tree, 0); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">角色名称</label>
                                <div class="am-u-sm-6 am-u-end">
                                    <input type="text" name="role_name" class="tpl-form-input" placeholder="角色名称">
                                    <small>角色名称控制在2-20字以内。</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">备注信息</label>
                                <div class="am-u-sm-6 am-u-end">
                                    <input type="text" name="role_remark" class="am-form-field tpl-form-no-bg" placeholder="角色备注信息">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">状态</label>
                                <div class="am-u-sm-9">
                                    <label><input name="status" type="radio" value="1" />启动 </label>
                                    <label><input name="status" type="radio" value="0" />禁用 </label>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">菜单列表</label>
                                <div class="am-u-sm-9 menu-list">
                                <?php echo showTree($menu_list, 1, $is_privilege); ?>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-text-default form-info" style="text-align:center;"></div>
                                <div class="am-u-sm-7 am-u-sm-push-5">
                                    <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                </div>
                            </div>
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
    // modal click
    $(document).on('click', '.modal-btn', function(e) {
        var $target = $(e.target);

        if ($(e.target).attr('data-method') == undefined) {
            return;
        }

        var method = $(e.target).attr('data-method');
        if (method == 'add') {
            $('#dialog-modal .am-modal-hd .modal-title').html("新增角色");
            $('#dialog-modal .am-modal-bd .role-add').show();
            $('#dialog-modal .am-modal-bd .role-edit').hide();
            $('#dialog-modal').modal({width:700});
        }
        else if (method == 'edit') {
            $('#dialog-modal .am-modal-hd .modal-title').html("编辑角色");
            $('#dialog-modal .am-modal-bd .role-add').hide();
            $('#dialog-modal .am-modal-bd .role-edit').show();

            var data_info = JSON.parse($(e.target).attr('data-info'));

            var $form = $('#dialog-modal .role-edit form');

            if (typeof data_info.id != undefined) {
                if ($form.find("input[name='id']").length > 0) {
                    $form.find("input[name='id']").val(data_info.id);
                }
                else {
                    $form.prepend("<input type='hidden' name='id' value='"+data_info.id+"' />");
                }
            }
            if (typeof data_info.parent_id != undefined) {
                $select = $form.find('select[name="role_id"]');

                if (data_info.parent_id == 0 && $select.find("option[value='0']").length < 1) {
                    $select.find('option').prop('disabled', true);
                    $select.prepend("<option value='0'>超级管理员</option>");
                }
                else {
                    $select.find('option').prop('disabled', false).prop('selected', false);
                    if ($select.find("option[value='0']").length > 0) {
                        $select.find("option[value='0']").remove();
                    }

                    $select.find('option[value="'+data_info.parent_id+'"]').prop('selected', true);
                }

                // 手动触发事件
                $select.trigger('changed.selected.amui');
            }
            if (typeof data_info.title != undefined) {
                $form.find("input[name='role_name']").val(data_info.title);
            }
            if (typeof data_info.remark != undefined) {
                $form.find("input[name='role_remark']").val(data_info.remark);
            }
            if (typeof data_info.status != undefined) {
                $form.find("input[name='status'][value='"+data_info.status+"']").prop('checked', true);
            }
            if (typeof data_info.menu_list != undefined) {
                $form.find('input.menu-tree-id').prop('checked', false);
                $form.find('input.menu-tree-id').prop('disabled', (data_info.parent_id == 0) ? true : false);
                $form.find("input[name='menu_id[]'][value='-1']").prop('checked', false);

                if (data_info.menu_list == '*' || data_info.menu_list == 'all') {
                    $form.find("input[name='menu_id[]'][value='-1']").prop('checked', true);
                }
                else {
                    var menu_list = data_info.menu_list.split(',');
                    $form.find('input.menu-tree-id').each(function() {
                        if (menu_list.indexOf( $(this).val() ) != -1) {
                            $(this).prop('checked', true);
                        }
                    });
                }
            }

            $('#dialog-modal').modal({width:700, closeViaDimmer:false});
        }
    });

    $(function(){
        // 子菜单和父菜单关联
        $("input.menu-tree-id").change(function() {
            if ($(this).prop('checked') && $(this).parents('ul.menu-ul').length > 0) {
                $(this).parents('ul.menu-ul').siblings("input.menu-tree-id").prop('checked', true);
            }
            else if (!$(this).prop('checked') && $(this).siblings('ul.menu-ul').length > 0 && $(this).siblings('ul.menu-ul').find('input:checked').length > 0) {
                $(this).siblings('ul.menu-ul').find('input:checked').prop('checked', false);
            }
        });

        $("form").submit(function(e) {
            var $target = $(e.target);

            if ($target.data('target') == undefined) {
                console.log('empty target');
                return false;
            }

            var form_data = {};

            var role_id = $target.find("select[name='role_id']").val();
            if (parseInt(role_id) == 0) {
                $target.find("select[name='role_id']").siblings('small').addClass('am-text-danger').text('角色不能为空');
                return false;
            }
            else {
                $target.find("select[name='role_id']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['role_id'] = role_id;

            var role_name = $target.find("input[name='role_name']").val();
            if (role_name.trim() == '') {
                $target.find("input[name='role_name']").siblings('small').addClass('am-text-danger').text('角色名称不能为空');
                return false;
            }
            else if (role_name.length < 2 || role_name.length > 20) {
                $target.find("input[name='role_name']").siblings('small').addClass('am-text-danger').text('角色名称控制在2-20字以内。');
            }
            else {
                $target.find("input[name='role_name']").siblings('small').removeClass('am-text-danger').text('');
            }
            form_data['role_name'] = role_name;

            var role_remark = $target.find("input[name='role_remark']").val();
            form_data['role_remark'] = role_remark;

            var menu_id = [];
            $target.find("input[name='menu_id[]']:checked").each(function() {
                menu_id.push( $(this).val() );
            });
            form_data['menu_id'] = menu_id;

            var form_method = $target.attr('method');
            var form_action = $target.attr('action');

            // 隐藏参数
            $target.find("input[type='hidden']").each(function() {
                form_data[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                type: form_method,
                url: form_action,
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.status != 1) {
                        $target.find('.form-info').html(data.info).addClass('am-text-danger');
                        return false;
                    }

                    $target.find('.form-info').html('');
                    $("#dialog-modal").modal('close');
                    window.location.reload()
                },
                error: function(data) {
                    $target.find('.form-info').html('提交失败').addClass('am-text-danger');
                }
            });

            return false;
        });
    });
</script>
@endsection