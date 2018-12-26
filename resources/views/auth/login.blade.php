<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">

    <link rel="stylesheet" href="{{ asset('css/amazeui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/amazeui.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.tpl.css') }}">

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body data-type="login" class="theme-white">
    <div class="am-g tpl-g">
        <div class="tpl-login">
            <div class="tpl-login-content">
                <div class="tpl-login-logo"></div>

                <form class="am-form tpl-form-line-form" method="post">
                    {{ csrf_field() }}
                    <div class="am-form-group">
                        <input type="text" name='phone' class="tpl-form-input am-form-field" placeholder="手机号">
                    </div>

                    <div class="am-form-group">
                        <input type="password" name='password' class="tpl-form-input am-form-field" placeholder="密码">
                    </div>
                    <div class="am-form-group tpl-login-remember-me">
                        <input type="checkbox" name="remember" value="1">
                        <label for="remember-me">记住密码</label>
                    </div>

                    @if (count($errors) > 0)
                    <div class="am-form-group">
                        @foreach ($errors->all() as $error)
                            <p class="am-form-help am-text-danger">{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <div class="am-form-group">
                        <button type="submit" class="am-btn am-btn-primary am-btn-block tpl-btn-bg-color-success tpl-login-btn">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/amazeui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>