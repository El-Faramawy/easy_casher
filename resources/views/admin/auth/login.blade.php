<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/logo-dark.png'):asset('admin/img/logo-dark.png')}}" />

    <!-- Title -->
    <title>تسجيل الدخول </title>

    <!-- *************
        ************ Common Css Files *************
    ************ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Master CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/fonts/style.css">
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/notify/notify-flat.css" />
    <link rel="stylesheet" href="{{asset('admin')}}/css/main.css" />


</head>

<body class="authentication">

<!-- Container start -->
<div class="container">
    <div id="messages"></div>
    <div id="notes"></div>
    <form action="{{route('admin.login.submit')}}" method="post" id="LoginForm">
        @csrf
        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box">
                        <a href="#" class="login-logo">
                            <img style="width: 60px !important;" src="{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/logo-dark.png'):asset('admin/img/logo-dark.png')}}" alt="Wafi Admin Dashboard" />
                        </a>
                        <div class="form-group">
                            <input type="text" data-validation="required,email"  name="email" class="form-control" placeholder="{{__('admin.email')}}" />
                        </div>
                        <div class="form-group">
                            <input type="password" data-validation="required" name="password" class="form-control" placeholder="{{__('admin.password')}}" />
                        </div>
                        <div class="actions mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember_me" class="custom-control-input" id="remember_pwd">
                                <label class="custom-control-label" for="remember_pwd">{{__('admin.Remember me')}}</label>

                                <button style="margin-left: 134px;" type="submit" class="btn btn-primary " id="loginButton">
                                    <i style="display: none;" class="fa fa-circle-o-notch fa-spin"></i>
                                     {{__('admin.login')}}
                                </button>

                            </div>

                        </div>
                       {{-- <div class="forgot-pwd">
                            <a class="link" href="forgot-pwd.html">Forgot password?</a>
                        </div>
                        <hr>
                        <div class="actions align-left">
                            <span class="additional-link">New here?</span>
                            <a href="signup.html" class="btn btn-dark">Create an Account</a>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Container end -->
<!-- Notify js -->

<script src="{{asset('admin')}}/js/jquery.min.js"></script>
<script src="{{asset('admin')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('admin')}}/js/moment.js"></script>

<script src="{{asset('admin')}}/vendor/slimscroll/slimscroll.min.js"></script>
<script src="{{asset('admin')}}/vendor/slimscroll/custom-scrollbar.js"></script>

<script src="{{asset('admin')}}/js/jquery.easing.1.3.js"></script>
<script src="{{asset('admin')}}/vendor/notify/notify.js"></script>
<script src="{{asset('admin/validation/jquery.form-validator.js')}}"></script>
<script src="{{asset('admin')}}/js/main.js"></script>

<script>
    $.validate({

    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var notes = $('#notes').notify({
        removeIcon: '<i class="icon-close"></i>'
    });
   /* notes.show("I'm a notification I will quickly alert you as well!", {
        type: 'success',
        title: 'Hello',
        icon: '<i class="icon-sentiment_satisfied"></i>'
    });*/
    var messages = $('#messages').notify({
        type: 'messages',
        removeIcon: '<i class="icon-close"></i>'
    });


    $("form#LoginForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var url = $('#LoginForm').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#loginButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    'role="status" aria-hidden="true"></span>جارى العمل').attr('disabled', true);

            },
            complete: function(){


            },
            success: function (data) {
                messages.show(" بك مرة أخرى ", {
                    type: 'success',
                    title: 'مرحبا',
                    icon: '<i class="icon-sentiment_satisfied"></i>',
                    delay:2000,
                });
                window.setTimeout(function() {
                    window.location.href='{{route('admin.dashboard')}}';
                }, 2000);
            },
            error: function (data) {
                if (data.status === 500) {
                    $('#loginButton').html('{{__('admin.login')}}').attr('disabled', false);
                    messages.show(" فى البريد الالكترونى و/أو كلمة المرور", {
                        type: 'danger',
                        title: 'خطأ',
                        icon: '<i class="icon-alert-octagon"></i>',
                        delay:2000,
                    });
                }
                if (data.status === 422) {
                    $('#loginButton').html('{{__('admin.login')}}').attr('disabled', false);
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                notes.show(value, {
                                    type: 'danger',
                                    title: key,
                                    icon: '<i class="icon-alert-triangle"></i>',
                                    delay:2000,
                                });

                            });

                        } else {

                        }
                    });
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>

</body>
</html>
