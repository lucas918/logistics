<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/amazeui.min.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/amazeui.datatables.min.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('css/app.tpl.css') }}">

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script> -->
</head>

<body class="theme-white">
    <div class="am-g tpl-g">
        <!-- 头部 -->
        <header>
            <!-- logo -->
            <div class="am-fl tpl-header-logo">
                <a href="javascript:;">Manager Site<!-- <img src="img/logo.png" alt=""> --></a>
            </div>
            <!-- 右侧内容 -->
            <div class="tpl-header-fluid">
                <!-- 侧边切换 -->
                <div class="am-fl tpl-header-switch-button am-icon-list">
                    <span></span>
                </div>
                <!-- 其它功能-->
                <div class="am-fr tpl-header-navbar">
                    <ul>
                        <!-- 欢迎语 -->
                        <li class="am-text-sm tpl-header-navbar-welcome">
                            <a href="javascript:;">欢迎你, <span>Manageer</span> </a>
                        </li>

                        <!-- 新邮件 -->
                        <li class="am-dropdown tpl-dropdown" data-am-dropdown>
                            <a href="javascript:;" class="am-dropdown-toggle tpl-dropdown-toggle" data-am-dropdown-toggle>
                                <i class="am-icon-envelope"></i>
                                <span class="am-badge am-badge-success am-round item-feed-badge">4</span>
                            </a>
                            <!-- 弹出列表 -->
                            <ul class="am-dropdown-content tpl-dropdown-content">
                                <li class="tpl-dropdown-menu-messages">
                                    <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                                        <div class="menu-messages-ico">
                                            <img src="img/user04.png" alt="">
                                        </div>
                                        <div class="menu-messages-time">
                                            3小时前
                                        </div>
                                        <div class="menu-messages-content">
                                            <div class="menu-messages-content-title">
                                                <i class="am-icon-circle-o am-text-success"></i>
                                                <span>夕风色</span>
                                            </div>
                                            <div class="am-text-truncate"> Amaze UI 的诞生，依托于 GitHub 及其他技术社区上一些优秀的资源；Amaze UI 的成长，则离不开用户的支持。 </div>
                                            <div class="menu-messages-content-time">2016-09-21 下午 16:40</div>
                                        </div>
                                    </a>
                                </li>

                                <li class="tpl-dropdown-menu-messages">
                                    <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                                        <div class="menu-messages-ico">
                                            <img src="img/user02.png" alt="">
                                        </div>
                                        <div class="menu-messages-time">
                                            5天前
                                        </div>
                                        <div class="menu-messages-content">
                                            <div class="menu-messages-content-title">
                                                <i class="am-icon-circle-o am-text-warning"></i>
                                                <span>禁言小张</span>
                                            </div>
                                            <div class="am-text-truncate"> 为了能最准确的传达所描述的问题， 建议你在反馈时附上演示，方便我们理解。 </div>
                                            <div class="menu-messages-content-time">2016-09-16 上午 09:23</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="tpl-dropdown-menu-messages">
                                    <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                                        <i class="am-icon-circle-o"></i> 进入列表…
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- 新提示 -->
                        <li class="am-dropdown" data-am-dropdown>
                            <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle>
                                <i class="am-icon-bell"></i>
                                <span class="am-badge am-badge-warning am-round item-feed-badge">5</span>
                            </a>

                            <!-- 弹出列表 -->
                            <ul class="am-dropdown-content tpl-dropdown-content">
                                <li class="tpl-dropdown-menu-notifications">
                                    <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                        <div class="tpl-dropdown-menu-notifications-title">
                                            <i class="am-icon-line-chart"></i>
                                            <span> 有6笔新的销售订单</span>
                                        </div>
                                        <div class="tpl-dropdown-menu-notifications-time">
                                            12分钟前
                                        </div>
                                    </a>
                                </li>
                                <li class="tpl-dropdown-menu-notifications">
                                    <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                        <div class="tpl-dropdown-menu-notifications-title">
                                            <i class="am-icon-star"></i>
                                            <span> 有3个来自人事部的消息</span>
                                        </div>
                                        <div class="tpl-dropdown-menu-notifications-time">
                                            30分钟前
                                        </div>
                                    </a>
                                </li>
                                <li class="tpl-dropdown-menu-notifications">
                                    <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                        <div class="tpl-dropdown-menu-notifications-title">
                                            <i class="am-icon-folder-o"></i>
                                            <span> 上午开会记录存档</span>
                                        </div>
                                        <div class="tpl-dropdown-menu-notifications-time">
                                            1天前
                                        </div>
                                    </a>
                                </li>


                                <li class="tpl-dropdown-menu-notifications">
                                    <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                        <i class="am-icon-bell"></i> 进入列表…
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- 退出 -->
                        <li class="am-text-sm">
                            <a href="/logout">
                                <span class="am-icon-sign-out"></span> 退出
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- 侧边导航栏 -->
        <div class="left-sidebar">
            <!-- 用户信息 -->
            <div class="tpl-sidebar-user-panel">
                <div class="tpl-user-panel-slide-toggleable">
                    <div class="tpl-user-panel-profile-picture">
                        <img src="/img/user04.png" alt="avatar image">
                    </div>
                    <span class="user-panel-logged-in-text">
                        <i class="am-icon-circle-o am-text-success tpl-user-panel-status-icon"></i>
                        小张
                    </span>
                    <a href="javascript:;" class="tpl-user-panel-action-link"> <span class="am-icon-pencil"></span> 账号设置</a>
                </div>
            </div>

            <!-- 菜单 -->
            <ul class="sidebar-nav">
            <?php
            foreach ($menu_list as $menu) {
                if ($menu['parent_id'] == 0) {
                    if (empty($menu['uri'])) {
                        echo '<li class="sidebar-nav-heading">'.$menu['title'].' <span class="sidebar-nav-heading-info"> '.$menu['subtitle'].'</span></li>';
                    }
                    else {
                        echo '<li class="sidebar-nav-link"><a href="javascript:;" data-uri="'.$menu['uri'].'" class="active"><i class="sidebar-nav-link-logo '.$menu['icon'].'"></i> '.$menu['title'].'</a></li>';
                    }
                }

                if (!empty($menu['sub_menu'])) {
                    foreach ($menu['sub_menu'] as $val) {
                        echo '<li class="sidebar-nav-link"><a href="javascript:;" data-uri="'.$val['uri'].'"><i class="sidebar-nav-link-logo '.$val['icon'].'"></i> '.$val['title'].'</a></li>';
                    }
                }
            }
            ?>

                <!-- <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/home' class="active">
                        <i class="am-icon-home sidebar-nav-link-logo"></i> 首页
                    </a>
                </li>
                <li class="sidebar-nav-heading">Logistics <span class="sidebar-nav-heading-info"> 物流</span></li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/home'>
                        <i class="am-icon-users sidebar-nav-link-logo"></i> 司机列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/home'>
                        <i class="am-icon-bus sidebar-nav-link-logo"></i> 车辆列表
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/home'>
                        <i class="am-icon-map-marker sidebar-nav-link-logo"></i> 车辆动态
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/home'>
                        <i class="am-icon-user-secret sidebar-nav-link-logo"></i> 账号信息
                    </a>
                </li>

                <li class="sidebar-nav-heading">Setting<span class="sidebar-nav-heading-info"> 系统设置</span></li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/setting/role'>
                        <i class="am-icon-medium sidebar-nav-link-logo"></i> 角色
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/setting/menu'>
                        <i class="am-icon-navicon sidebar-nav-link-logo"></i> 菜单
                    </a>
                </li>
                <li class="sidebar-nav-link">
                    <a href="javascript:;" data-uri='/setting/user'>
                        <i class="am-icon-user sidebar-nav-link-logo"></i> 管理员
                    </a>
                </li> -->
            </ul>
        </div>

        <!-- 内容区域 -->
        <div class="tpl-content-wrapper">
            <iframe id='content-iframe' src="/home" frameborder="0" width="100%" height="100%" scrolling="auto"></iframe>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/amazeui.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/amazeui.datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.responsive.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        "use strict";

        // iframe自适应
        function iframeFixed()
        {
            var win_height = $(window).height();
            var side_height = $(".left-sidebar").innerHeight();
            var top_height = $("#content-iframe").offset().top;

            var frame_height = (parseFloat(side_height + top_height) > parseFloat(win_height)) ? side_height : parseFloat(win_height - top_height);

            $("#content-iframe").innerHeight(frame_height);
        }

        // 侧边菜单开关
        function autoLeftNav()
        {
            $('.tpl-header-switch-button').on('click', function() {
                if ($('.left-sidebar').is('.active')) {
                    if ($(window).width() > 1024) {
                        $('.tpl-content-wrapper').removeClass('active');
                    }
                    $('.left-sidebar').removeClass('active');
                } else {

                    $('.left-sidebar').addClass('active');
                    if ($(window).width() > 1024) {
                        $('.tpl-content-wrapper').addClass('active');
                    }
                }
            })

            if ($(window).width() < 1024) {
                $('.left-sidebar').addClass('active');
            } else {
                $('.left-sidebar').removeClass('active');
            }
        }

        $(function() {
            iframeFixed();
            autoLeftNav();

            $(window).resize(function() {
                iframeFixed();
                autoLeftNav();
            });

            // 侧边菜单
            $('.sidebar-nav-sub-title').on('click', function() {
                $(this).siblings('.sidebar-nav-sub').slideToggle(80)
                    .end().find('.sidebar-nav-sub-ico').toggleClass('sidebar-nav-sub-ico-rotate');
            });

            // 侧边菜单栏
            $(".sidebar-nav-link a").click(function() {
                if ($(this).attr('data-uri') == undefined) {
                    return;
                }

                $('.sidebar-nav-link a.active').removeClass('active');
                $(this).addClass('active');
                $("#content-iframe").attr('src', $(this).attr('data-uri'));
            });
        });
    </script>
</body>
</html>