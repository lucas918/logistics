@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endsection('stylesheet')

@section('content')
<!-- 内容区域 -->
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">菜单栏</div>
                    <div class="widget-function am-fr"></div>
                </div>
                <div class="widget-body am-fr menu-list">
                <?php
                    function showTree($menu, $level=1)
                    {
                        $ul_class = "menu-{$level} ";
                        if ($level > 1) {
                            $ul_class = "menu-ul ";
                        }
                        if (!empty($menu[0]['sub_page'])) {
                            $ul_class .= "am-u-sm-12";
                        }

                        $html = "<ul class='{$ul_class}'>";

                        foreach ($menu as $key => $val) {
                            $li_class = "";
                            if ($val['sub_page'] == 1) {
                                $li_class .= "am-u-sm-3 ";
                                
                                if ($key == count($menu)-1) {
                                    $li_class .= "am-u-end";
                                }
                            }

                            $html .= "<li class='{$li_class}'>";

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

                            $html .= "</li>";
                        }

                        $html .= "</ul>";
                        return $html;
                    }

                    $tree = showTree($menu_list);
                    echo $tree;
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection