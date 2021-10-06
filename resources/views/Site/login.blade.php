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
                                        <select class="form-select" name="phone_code" aria-label="Default select example">
                                            <option selected disabled>اختر الدوله</option>
                                            @foreach(phone_codes() as $key=>$phone_code)
                                                <option value="{{$key}}">{{$phone_code}}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="phone" class="form-control" placeholder="رقم الهاتف">
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

    </body>

</html>
@push('site_js')

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
                    if (data.type == 'success') {
                        window.setTimeout(function () {
                            $('.loader').hide()
                            // $('#exampleModalCenter').modal('hide')
                            toastr.success("تم التسجيل بنجاح");
                            toastr.options.timeOut = 10000;
                            location.href = data.url;
                        }, 2000);
                    }

                    if (data.type == 'error') {
                        // $.each(data.message, function (key, value) {
                        toastr.options.timeOut = 10000;
                        toastr.error(data.message);
                        // });
                    }

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

@endpush
