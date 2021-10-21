<!DOCTYPE html>
<html lang="en">

<head>
    @include('Site.Layouts.css')
</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed rtl">
<div class="wrapper">
    <!-- ================ loader ================= -->
    <div id="loader"></div>

    <section class="loginPage">
        <div class="container">
            <div class="row">

                <div class="col-lg-10 m-auto">
                    <div class="loginForm">
                        <img src="{{url('Site')}}/images/logo.png" class="logo order-md-last">
                        <form action="{{route('post_login')}}" id="login_form" method="post" class="order-md-first">
                            @csrf
                            <div class="secondTitle">
                                <h3> تسجيل الدخول </h3>
                            </div>


                            <label for="phone" class="form-label"> ادخل رقم الهاتف </label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="phone_code" id="phone_code" aria-label="Default select example">
                                    <option selected disabled>اختر الدوله</option>
                                    @foreach(phone_codes() as $key=>$phone_code)
                                        <option value="{{$key}}">{{$phone_code}}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="رقم الهاتف">
                            </div>

                            <button type="submit" {{--data-bs-toggle="modal" data-bs-target="#CodeModal"--}}
                            class="btn btn-primary"> ارسال
                            </button>

                        </form>
                        <span class="BGImg d-none d-md-block"><img src="{{url('Site')}}/images/before.png"></span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal Name -->
    <div class="modal fade" id="modal_register" tabindex="-1" aria-labelledby="CodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CodeModalLabel"> تسجيل حساب </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('register')}}" id="register" method="post">
                        @csrf
                        <div class="form-group">
                            <p> الاسم </p>
                            <input type="text" id="name" name="name" class="form-control "  placeholder="الاسم...">
                        </div>
                        <button type="submit" class="btn btn-primary"> حفظ </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="CodeModal" tabindex="-1" aria-labelledby="CodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CodeModalLabel"> كود التفعيل </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p> من فضلك ادخل الكود المرسل الي <span> 0123456799 </span></p>
                    <input type="number" class="form-control codeInput" maxlength="8" placeholder="----- ">


                    <a href="index.html" class="btn btn-primary"> تأكيد </a>


                </div>


            </div>
        </div>
    </div>


</div>

@include('Site.Layouts.js')
{{--        @push('site_js')--}}

<script>
    $(document).on('submit','form#login_form',function(e) {
        e.preventDefault();
        var myForm = $("#login_form")[0]
        var formData = new FormData(myForm)
        var url = $('#login_form').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('.loader').show()
            },
            success: function (data) {
                window.setTimeout(function () {
                    $('.loader').hide()
                    // $('#exampleModalCenter').modal('hide')
                    if (data.type == 'success') {
                        toastr.success("تم التسجيل بنجاح");
                        toastr.options.timeOut = 10000;
                        location.href = data.url;
                    }
                    if (data.type == 'error') {
                        $.each(data.message, function (key, value) {
                            toastr.options.timeOut = 10000;
                            toastr.error(value);
                        });
                    }
                    if (data.type == 'register') {
                        $('#modal_register').modal("show");
                    }
                }, 2000);
            },
            error: function (data) {
                $('.loader').hide()
                if (data.status === 500) {
                    // $('#exampleModalCenter').modal("hide");
                    toastr.options.timeOut = 10000;
                    toastr.error("هناك خطأ");
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>
<script>
    $(document).on('submit','form#register',function(e) {
        e.preventDefault();
        // var formData = {
        //      'name' : $('#name').val(),
        //      'phone_code' : $('#phone_code').val(),
        //      'phone' : $('#phone').val()
        // };
        var name = $('#name').val();
        var phone_code = $('#phone_code').val();
        var phone = $('#phone').val();
        // var url = $('#register').attr('action');
        $.ajax({
            url:'{{route("register")}}?name='+name+'&phone='+phone+'&phone_code='+phone_code,
            type: 'post',
            // data: formData,

            success: function (data) {
                window.setTimeout(function () {
                    $('.loader').hide()
                    if (data.type == 'success') {
                        $('#modal_register').modal("hide");
                        toastr.success("تم التسجيل بنجاح");
                        toastr.options.timeOut = 10000;
                        location.href = data.url;
                    }
                    if (data.type == 'error') {
                        $.each(data.message, function (key, value) {
                            toastr.options.timeOut = 10000;
                            toastr.error(value);
                        });
                    }
                }, 2000);
            },
            error: function (data) {
                $('.loader').hide()
                $('#modal_register').modal("hide");
                if (data.status === 500) {
                    // $('#exampleModalCenter').modal("hide");
                    toastr.options.timeOut = 10000;
                    toastr.error("هناك خطأ");
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>

{{--        @endpush--}}

</body>

</html>
