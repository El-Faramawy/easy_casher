@extends('admin.layouts.layout')
@section('styles')
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    الحساب الشخصى
@endsection

@section('page-links')
    <li class="breadcrumb-item active">  الحساب الشخصى</li>
@endsection

@section('content')
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body" id="slider-form">
                    {{--Slider--}}
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title">تعديل البيانات</div>
                </div>

                <div class="card-body" id="profile-div">
                   {{--Form--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
    <div id="messages"></div>
@endsection

@section('js')
    <script>
        //loader in js
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

        getSection()
        $(document).on('submit','form#profile-form',function(e) {
            e.preventDefault();
            var myForm = $("#profile-form")[0]
            var formData = new FormData(myForm)
            var url = $('#profile-form').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#slider-form').append(loader)
                    $('#profile-div').append(loader)
                    $('#profile-form').hide()
                    $('.account-settings').hide()

                },
                complete: function(){


                },
                success: function (data) {

                    window.setTimeout(function() {
                        $('.linear-background').hide(loader)
                        getSection(false)
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });


                    }, 2000);


                },
                error: function (data) {
                    $('.linear-background').hide(loader)
                       getSection(false)
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

        //get sections
        function getSection(check = true) {
            if (check == true) {
                $('#slider-form').append(loader)
                $('#profile-div').append(loader)
            }
            $.get('{{route('profile.edit',$admin->id)}}', function (data) {
                window.setTimeout(function() {
                    $(' .linear-background').hide(loader)
                    $('#slider-form').html(data.slider);
                    $('#profile-div').html(data.profileForm);
                    $.validate({

                    });
                    $('.dropify').dropify();

                }, 2000);


            });
        }

    </script>
@endsection

