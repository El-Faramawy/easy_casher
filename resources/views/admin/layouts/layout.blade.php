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
    <link rel="shortcut icon" href="{{get_file(setting()->header_logo)}}" />

    <!-- Title -->
    <title>الرئيسية - @yield('page-title')</title>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('77752cfe6647f550bfc8', {
            cluster: 'eu'
        });

    </script>
    @include('admin.layouts.assets._css')
    <link href="{{asset('admin/css/font-awesome.min.css')}}" >

    @stack('css-push')
    @yield('styles')
</head>
<body>

<!-- Loading starts -->
<div id="loading-wrapper">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Loading ends -->


<!-- *************
    ************ Header section start *************
************* -->

<!-- Header start -->
@include('admin.layouts.inc._header')
<!-- Header end -->

<!-- Screen overlay start -->
<div class="screen-overlay"></div>
<!-- Screen overlay end -->

<!-- Quicklinks box start -->
@include('admin.layouts.inc._quick-links-box')
<!-- Quicklinks box end -->

<!-- Quick settings start -->
@include('admin.layouts.inc._quick-settings-box')
<!-- Quick settings end -->

<!-- *************
    ************ Header section end *************
************* -->


<div class="container-fluid">


    <!-- Navigation start -->
    @include('admin.layouts.inc._navbar')
    <!-- Navigation end -->


    <!-- *************
        ************ Main container start *************
    ************* -->
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.dashboard')}}">الرئيسية</a>
                </li>
                @yield('page-links')
                {{--<li class="breadcrumb-item active">Default Layout</li>--}}
            </ol>

            <ul class="app-actions">
              {{--  <li>
                    <a href="#" id="reportrange">
                        <span class="range-text"></span>
                        <i class="icon-chevron-down"></i>
                    </a>

                </li>--}}
               {{-- <li>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print">
                        <i class="icon-print"></i>
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download CSV">
                        <i class="icon-cloud_download"></i>
                    </a>
                </li>--}}
            </ul>
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            @yield('content')

        </div>
        <!-- Content wrapper end -->


    </div>
    <!-- *************
        ************ Main container end *************
    ************* -->


    <!-- Footer start -->
    @include('admin.layouts.inc._footer')
    <!-- Footer end -->

<div id="notes_alert"></div>
</div>

@include('admin.layouts.assets._js')
@stack('js-push')
@yield('js')
<script src="{{asset('admin/easyNotify.js')}}"></script>

<script>

    var myFunction = function($route) {
       // location.href =$route;
    };
    var myImg = "{{get_file(setting()->header_logo)}}";

    var notes_alert = $('#notes_alert').notify({
        removeIcon: '<i class="icon-close"></i>'
    });

    var channel = pusher.subscribe('new-order-channel');
    channel.bind('App\\Events\\OrderEvent', function(data) {
        //normal notifications
        getNotificationSection()

        // notifications alert
        notes_alert.show(data.message, {
            type: 'warning',
            title: data.title,
            icon: '<i class="icon-sentiment_satisfied"></i>',
            delay:2000,
        });

        //notification desktop
        var options = {
            title: data.title,
            options: {
                body: data.message,
                icon: myImg,
                lang: 'en-US',
                onClick: myFunction(data.router)
            }
        };
        $("#easyNotify").easyNotify(options);
        //----------------------------------
    });

     getNotificationSection()
    function getNotificationSection()
    {
        var url = '{{route('notificationsForLayout')}}';

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function(){

            },
            success: function(data){
                $('#notification-div').html(data.html);
            },
            error: function(data) {

            }
        });
    }

</script>
</body>
@toastr_render
</html>
