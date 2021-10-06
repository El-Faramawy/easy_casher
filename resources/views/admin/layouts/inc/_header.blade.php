<header class="header">
    <div class="logo-wrapper">
        <a href="{{route('admin.dashboard')}}" class="logo">
            <img src="{{setting()?get_file(setting()->header_logo):asset('admin/img/logo.png')}}" alt="Wafi Admin Dashboard" />
        </a>
        <a href="#" class="quick-links-btn" data-toggle="tooltip" data-placement="right" title="" data-original-title="Quick Links">
            <i class="icon-menu1"></i>
        </a>
    </div>
    <div class="header-items">
        <!-- Custom search start -->

        <!-- Custom search end -->

        <!-- Header actions start -->
        <ul class="header-actions">
          {{--  <li class="dropdown">
                <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                    <i class="icon-box"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                    <div class="dropdown-menu-header">
                        Tasks (05)
                    </div>
                    <ul class="header-tasks">
                        <li>
                            <p>#48 - Dashboard UI<span>90%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                    <span class="sr-only">90% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>#95 - Alignment Fix<span>60%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>#7 - Broken Button<span>40%</span></p>
                            <div class="progress">
                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>--}}
            <li class="dropdown" id="notification-div">
{{--                @include('admin.layouts.notification')--}}
            </li>

            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name">{{admin()->user()->name}}</span>
                    <span class="avatar">{{substr (admin()->user()->name,0,1)}}<span class="status online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                            <div class="header-user">
                                <img src="{{admin()->user()->image?get_file(admin()->user()->image):asset('admin/img/user.png')}}" alt="Admin Template" />
                            </div>
                            <h5>{{admin()->user()->name}}</h5>
                            <p>مشرف</p>
                        </div>
                        <a href="{{route('profile.index')}}"><i class="icon-user1"></i>حسابى</a>
                        <a href="{{route('settings.index')}}"><i class="icon-settings1"></i>الأعدادت</a>
                        <a href="{{route('admin.logout')}}"><i class="icon-log-out1"></i> تسجيل الخروج</a>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="quick-settings-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Quick Settings">
                    <i class="icon-list"></i>
                </a>
            </li>
        </ul>
        <!-- Header actions end -->
    </div>
</header>
