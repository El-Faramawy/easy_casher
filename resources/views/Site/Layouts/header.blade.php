<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
            <div class="logo-mini w-50">
                <span class="light-logo"><img src="{{url('Site')}}/images/logo-letter.png"></span>
            </div>
            <div class="logo-lg">
                <span class="light-logo"><img src="{{url('Site')}}/images/logo-dark-text.png"></span>
            </div>
        </a>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item">
                    <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light"
                       data-toggle="push-menu" role="button">
                        <i class="fad fa-bars"></i>
                    </a>
                </li>
                <!-- <li class="btn-group d-lg-inline-flex d-none">
                    <div class="app-menu">
                        <div class="search-bx mx-5">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="بحث"
                                        aria-label="Search" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon3">
                                            <i class="fal fa-search ms-1"></i>

                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li> -->
            </ul>
        </div>
        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="#" data-provide="fullscreen"
                       class="waves-effect waves-light nav-link full-screen btn-warning-light"
                       title=" ملئ الشاشة ">
                        <i class="fal fa-expand-wide"></i>
                    </a>
                </li>
                <!-- setting  -->
                <li class="btn-group nav-item">
                    <a href="#" class="waves-effect full-screen waves-light btn-danger-light dropdown-toggle "
                       data-bs-toggle="dropdown" title="User">
                        <i class="fal fa-cog"></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <a class="dropdown-item" href="#"><i class="fas fa-globe text-muted me-2"></i>
                                اللغة
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- User Account-->
                @if(auth()->check())
                <li class="btn-group nav-item">
                    <a href="#"
                       class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent py-0 no-shadow"
                       data-bs-toggle="dropdown" title="User">
                        <div class="d-flex pt-5">
                            <img src="{{url('Site')}}/images/avatar1.png"
                                 class="avatar rounded-10 bg-primary-light h-40 w-40 ms-2" />
                            <div class="text-end me-10">
                                <p class="pt-5 fs-14 mb-0 fw-700 text-primary">محمود الكومي </p>
{{--                                <small class="fs-10 mb-0 text-uppercase text-mute"> ادمن </small>--}}
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <a class="dropdown-item" href="#"><i class="fas fa-user text-muted me-2"></i> حسابي
                            </a>
                            <hr>
                            <a class="dropdown-item" href="{{url('logout')}}"><i
                                    class="fas fa-sign-out-alt text-danger me-2"></i> تسجيل الخروج </a>
                        </li>
                    </ul>
                </li>
                @else
                    <li class="btn-group nav-item">
                        <a href="{{url('login')}}"
                           class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent py-0 no-shadow"
                           >
                            <div class="d-flex pt-5">
{{--                                <img src="{{url('Site')}}/images/avatar1.png"--}}
{{--                                     class="avatar rounded-10 bg-primary-light h-40 w-40 ms-2" />--}}
                                <div class="text-end me-10">
                                    <p class="pt-5 fs-14 mb-0 fw-700 text-primary">تسجيل الدخول</p>
                                    {{--                                <small class="fs-10 mb-0 text-uppercase text-mute"> ادمن </small>--}}
                                </div>
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
