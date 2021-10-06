@extends('Site.Layouts.app')
@section('content')

    <form action="{{route('post_login')}}" id="login_form" method="post" class="p-5 m-5">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">كود الهاتف</label>
            <select name="phone_code"  class="form-control">
                @foreach(phone_codes() as $key=>$phone_code)
                    <option value="{{$key}}">{{$phone_code}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">رقم الهاتف</label>
            <input type="number" name="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
{{--        <div class="mb-3">--}}
{{--            <label for="exampleInputEmail1" class="form-label">كلمة المرور</label>--}}
{{--            <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">--}}
{{--        </div>--}}
        <div class="text-center">
        <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
        </div>
    </form>

@endsection
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
