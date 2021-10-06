@extends('admin.layouts.layout')
@section('styles')
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .spanView{
            font-weight: bold;
            color: #0d7523;
            font-size: larger;
        }

    </style>
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    كل مشتركى التطبيق
@endsection

@section('page-links')
    <li class="breadcrumb-item "><a href="{{route('users.index')}}">  كل مشتركى التطبيق</a></li>
    <li class="breadcrumb-item active">عرض</li>
@endsection

@section('content')

    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img src="{{get_file($user->logo)}}" alt="Wafi Admin" />
                            </div>
                            @if ($user->rating != null)
                                <div>
                                    <span style="{{$user->rating >=1 ?"color: orange;":""}}" class="fa fa-star "></span>
                                    <span style="{{$user->rating >=2 ?"color: orange;":""}}" class="fa fa-star "></span>
                                    <span  style="{{$user->rating >=3 ?"color: orange;":""}}" class="fa fa-star "></span>
                                    <span  style="{{$user->rating >=4 ?"color: orange;":""}}" class="fa fa-star"></span>
                                    <span style="{{$user->rating >=5 ?"color: orange;":""}}" class="fa fa-star"></span>
                                </div>
                            @else
                                <div>
                                    <span style="" class="fa fa-star "></span>
                                    <span style="" class="fa fa-star "></span>
                                    <span style="" class="fa fa-star "></span>
                                    <span style="" class="fa fa-star "></span>
                                    <span style="" class="fa fa-star "></span>
                                </div>

                            @endif
                            <h5 class="user-name">{{$user->name}}</h5>
                            <h6 class="user-email">{{$user->email}}</h6>


                        </div>
                        <div class="setting-links">
                            @if (in_array($user->user_type,['family','driver','client']))
                                <a href="#" class="linkDetails" att_id="basic-info">
                                    <i class="icon-info"></i>
                                    المعلومات الأساسية
                                </a>
                            @endif
                            @if (in_array($user->user_type,['family','driver']))
                                <a href="#" class="linkDetails" att_id="location">
                                    <i class="icon-location"></i>
                                    الموقع الحالى
                                </a>
                            @endif
                            @if ($user->user_type == 'driver')
                                <a href="#" class="linkDetails" att_id="car-info">
                                    <i class="icon-drive"></i>
                                    بيانات السيارة
                                </a>
                            @endif

                            @if ($user->user_type == 'family')
                                    <a href="#" class="linkDetails" att_id="categories">
                                        <i class="icon-package"></i>
                                       اقسام منتجات الأسرة المنتجة
                                    </a>
                                <a href="#" class="linkDetails" att_id="slider">
                                    <i class="icon-drive"></i>
                                    صور الغلاف
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12" id="profile-div">

        </div>
    </div>
    <!-- Row end -->
    {{--Models--}}
    <div id="messages"></div>
@endsection

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeyMUJgKAhnNXbILHONb1um72CNzELFRY&libraries=places"></script>

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

        //========================================================================
        //========================================================================
        //============================change status===============================
        //========================================================================
        // =======================================================================
        getSection(true)
        function getSection(check = true , link = 'basic-info') {
            if (check == true) {
                $('#partNewDriver').hide()
                $('#profile-div').append(loader)
            }
            $.get('{{route('users.show',$user->id)}}'+'?viewSection='+link, function (data) {
                window.setTimeout(function() {
                    $(' .linear-background').hide(loader)
                    $('#profile-div').html(data.profileForm);
                    googleMap()

                }, 2000);


            });
        }//end

        $(document).on('click','.linkDetails',function (e) {
            e.preventDefault();
            var link = $(this).attr('att_id');
            getSection(true,link)

        })//end class

        function googleMap() {
            var lat = parseFloat('{{$user->tracker?$user->tracker->latitude:'24.507143283102817'}}')
            var long = parseFloat('{{$user->tracker?$user->tracker->latitude:'39.5947265625'}}')
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 10,
                center: new google.maps.LatLng(lat,long),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                draggable: true
            });


            map.setCenter(myMarker.position);
            myMarker.setMap(map);
        }

    </script>
@endsection
