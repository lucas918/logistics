<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">

    <link rel="stylesheet" href="{{ asset('css/amazeui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/amazeui.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.tpl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('stylesheet')

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script>
    @yield('javascript')
</head>

<body data-type="@yield('data-type')" class="theme-white">
    <div class="am-g tpl-g">
        @yield('content')
    </div>
    <script type="text/javascript" src="{{ asset('js/amazeui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/amazeui.datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @yield('javascript_run')
</body>
</html>