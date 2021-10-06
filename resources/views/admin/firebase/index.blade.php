@extends('admin.layouts.layout')
@section('styles')
    <style>
        .bs-example{
            margin: 20px;
        }
        #users_special{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/bs-select/bs-select.css" />
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/summernote/summernote-bs4.css" />
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
     ارسال اشعارات عامة
@endsection

@section('page-links')

    <li class="breadcrumb-item active">  ارسال اشعارات عامة</li>
@endsection

@section('content')
    <div class="row gutters card" id="form-add">
        <form method="post" id="notificationForm" action="{{route('firebaseNotification.store')}}">
            @csrf
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                <div class="custom-control custom-switch " style="margin-right: 20px;">
                    <input name="select_user" type="checkbox" class="custom-control-input"  id="customSwitch3">
                    <label class="custom-control-label" for="customSwitch3">هل تريد تحديد البعض ؟</label>
                </div>
            </div>
            <input type="hidden" id="flag" value="all" name="flag">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="users_special">
                <div class="form-group">
                    <p><code>اختر من تريد الإرسال اليه</code></p>
                    <select data-validation="required"  name="users[]" class="form-control selectpicker my-select" multiple data-live-search="true">
                        @foreach($users as $user)
                            <option value="{{$user->id}}">({{$user->phone}})-{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label for="en_title">عنوان الإشعار</label>
                    <input required data-validation="required" type="text" class="form-control" value="" id="title" name="title" placeholder="عنوان الشعار">
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label for="ar_desc">محتوى الإشعار</label>
                    <textarea required  class="summernote" name="body" id="summernote1" placeholder="نص الشعار"></textarea>
                </div>
            </div>
            <div class="custom-btn-group">
                <button class="btn btn-success" type="submit">
                    حفظ
                    <span class="icon-circle-with-plus" ></span>

                </button>
            </div>

        </form>

    </div>
     <div id="messages"></div>
@endsection

@section('js')

    <script src="{{asset('admin')}}/vendor/bs-select/bs-select.min.js"></script>
    <script src="{{asset('admin')}}/vendor/summernote/summernote-bs4.js"></script>
    <script>
        var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;
        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });
    </script>
    <script>
        $('.my-select').selectpicker();
        $('.summernote').summernote({
            height: 170,
            tabsize: 2

        });
        //=================submit form==============================
        //=========================================================
        //=========================================================
        //========================Save Data=========================
        //=========================================================
        $(document).on('submit','form#notificationForm',function(e) {
            e.preventDefault();
            var myForm = $("#notificationForm")[0]
            var formData = new FormData(myForm)
            var url = $('#notificationForm').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    // $('#form-add').append(loader)
                    // $('#notificationForm').hide()

                },
                complete: function(){


                },
                success: function (data) {
                    $('#notificationForm')[0].reset();
                    $('#summernote1').summernote("reset");
                    messages.show("تمت العملية بنجاح..", {
                        type: 'success',
                        title: '',
                        icon: '<i class="jq-icon-success"></i>',
                        delay:2000,
                    });


                },
                error: function (data) {
                    $('#form-add > .linear-background').hide(loader)
                    ('#notificationForm').show()
                    if (data.status === 500) {
                        messages.show("هناك خطأ", {
                            type: 'danger',
                            title: 'خطأ',
                            icon: '<i class="icon-alert-octagon"></i>',
                            delay:2000,
                        });
                    }
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    myToast(key, value, 'top-left', '#ff6849', 'error',4000, 2);

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

        //==============================

        $('#customSwitch3').click(function () {
            if ($(this).is(':checked')) {
                $('#users_special').show()
                $('#flag').val('special')
            } else {
                $('#users_special').hide()
                $('#flag').val('all')
            }
        });
    </script>
@endsection
