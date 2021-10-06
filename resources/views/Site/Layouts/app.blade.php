<!DOCTYPE html>
<html lang="en">

<head>
    @include('Site.Layouts.css')
</head>

    <body class="hold-transition light-skin sidebar-mini theme-success fixed rtl">
        <div class="wrapper">
            <!-- ================ loader ================= -->
            <div id="loader"></div>
            <!-- ================ Header ================= -->
            @include('Site.Layouts.header')
            <!-- ================ sidebar ================= -->
            @include('Site.Layouts.sidebar')
            <div class="content-wrapper">
                <div class="container-full">
                    <!-- ================ content ================= -->
                    <section class="content">
                        @yield('content')
                    </section>
                </div>
            </div>
            <!-- ================ Footer ================= -->
            @include('Site.Layouts.footer')
            <!-- ================ /Footer ================= -->
        </div>
    @include('Site.Layouts.js')
    </body>
</html>


