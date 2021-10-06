
@extends('admin.layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/summernote/summernote-bs4.css" />

    <style>
        .active{
            font-weight: bold;
            color: #0d7523;
        }

    </style>
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    الإعدادت العامة
@endsection

@section('page-links')
    <li class="breadcrumb-item active">  الإعدادت العامة</li>
@endsection

@section('content')

    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link settings-link " href="{{route('settings.edit',$settings->id)}}?tab=siteInfo">المعلومات الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  settings-link" href="{{route('settings.edit',$settings->id)}}?tab=location"> الموقع </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link settings-link" href="{{route('settings.edit',$settings->id)}}?tab=contactInfo"> معلومات التواصل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link settings-link" href="{{route('settings.edit',$settings->id)}}?tab=socialInfo"> بيانات التواصل الإجتماعى</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link settings-link" href="{{route('settings.edit',$settings->id)}}?tab=termsAndConditions"> الشروط و الأحكام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link settings-link" href="{{route('settings.edit',$settings->id)}}?tab=logoAndImages"> اللوجو و الصور</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body" id="settings_sections">
                    <div class="row gutters">
                        <div class="alert-notify info">
                            <div class="alert-notify-body">
                                <span class="type">الإعدادات</span>
                                <div class="alert-notify-title">يمكنك تعديل البيانات الان....<img src="{{asset('admin')}}/img/notification-info.svg" alt=""></div>
                                <div class="alert-notify-text">اضغط على الاعدادات لإظهارها....</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div id="messages"></div>
@endsection





@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeyMUJgKAhnNXbILHONb1um72CNzELFRY&libraries=places"></script>
    <script src="{{asset('admin')}}/vendor/summernote/summernote-bs4.js"></script>
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
        var current_tab='';
        $(document).on('click','.settings-link' ,function(e){
            e.preventDefault();
            if ( $(this).attr('href') != '#' ) {
                $(".settings-link").removeClass("active");
                $(this).addClass('active')
                $("#settings_sections").animate({ scrollTop: 0 }, "fast");
                $.get($(this).attr('href'), function (data) {
                    current_tab = data.tab;
                    $('#settings_sections').html(data.html);
                    $.validate({

                    });
                    if (data.tab == 'siteInfo' || data.tab == 'termsAndConditions') {
                        //summernote
                        $('.summernote').summernote({
                            height: 170,
                            tabsize: 2
                        });
                    }//siteInfo

                    if (data.tab == 'location') {
                        initAutocomplete()
                        initAutocomplete1()
                        googleMap()
                    }//location

                    if (data.tab == 'logoAndImages') {
                        $('.dropify').dropify();
                    }

                });
            }
        });


        //google
        function initAutocomplete() {
            new google.maps.places.Autocomplete(
                (document.getElementById('address1')),
                {types: ['geocode']}
            );
        }

        function initAutocomplete1() {
            new google.maps.places.Autocomplete(
                (document.getElementById('address2')),
                {types: ['geocode']}
            );
        }

        function googleMap() {
            var lat = parseFloat(document.getElementById('lat').value)
            var long = parseFloat(document.getElementById('long').value)
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 10,
                center: new google.maps.LatLng(lat,long),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                draggable: true
            });

            google.maps.event.addListener(myMarker, 'dragend', function (evt) {
                document.getElementById('lat').value = evt.latLng.lat()
                document.getElementById('long').value = evt.latLng.lng()
            });

            map.setCenter(myMarker.position);
            myMarker.setMap(map);
        }

        //=================submit form==============================
        //=========================================================
        //=========================================================
        //========================Save Data=========================
        //=========================================================
        $(document).on('submit','form#settingsForm',function(e) {
            e.preventDefault();
            var myForm = $("#settingsForm")[0]
            var formData = new FormData(myForm)
            var url = $('#settingsForm').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#settings_sections').append(loader)
                    $('#settingsForm').hide()

                },
                complete: function(){


                },
                success: function (data) {

                    window.setTimeout(function() {
                        $('#settings_sections > .linear-background').hide(loader)
                        getSection()
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });


                    }, 2000);


                },
                error: function (data) {
                    $('#settings_sections > .linear-background').hide(loader)
                    ('#settingsForm').show()
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
        function getSection() {
            $.get('{{route('settings.edit',$settings->id)}}?tab='+current_tab, function (data) {
                $('#settings_sections').html(data.html);
                $.validate({

                });
                if (data.tab == 'siteInfo' || data.tab == 'termsAndConditions') {
                    //summernote
                    $('.summernote').summernote({
                        height: 170,
                        tabsize: 2
                    });
                }//siteInfo

                if (data.tab == 'location') {
                    initAutocomplete()
                    initAutocomplete1()
                    googleMap()
                }//location

                if (data.tab == 'logoAndImages') {
                    $('.dropify').dropify();
                }

            });
        }

    </script>
@endsection
