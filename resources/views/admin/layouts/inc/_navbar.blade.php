<nav class="navbar navbar-expand-lg custom-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#WafiAdminNavbar" aria-controls="WafiAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i></i>
						<i></i>
						<i></i>
					</span>
    </button>
    <div class="collapse navbar-collapse" id="WafiAdminNavbar">
        <ul class="navbar-nav">
            {{----------------------------------------------------------------------}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active-page" href="{{route('admin.dashboard')}}" id="dashboardsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-devices_other nav-icon"></i>
                    الرئيسية
                </a>
                <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('admin.dashboard')}}">الرئيسية</a>
                    </li>

                </ul>
            </li>
            {{----------------------------------------------------------------------}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings nav-icon"></i>
                    الإعدادات
                </a>
                <ul class="dropdown-menu" aria-labelledby="appsDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('admins.index')}}">المشرفين</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('contacts.index')}}">طلبات التواصل</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{route('firebaseNotification.index')}}">ارسال اشعارات</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('sliders.index')}}">البانر</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('packages.index')}}">الباقات</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('settings.index')}}">اعددات التطبيق</a>
                    </li>
                </ul>
            </li>
            {{----------------------------------------------------------------------}}

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="tablesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-new_releases nav-icon"></i>
                    طلبات التجار الجديدة
                </a>
                <ul class="dropdown-menu" aria-labelledby="tablesDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('newUsers.index')}}"> طلبات التجار الجديدة</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="tablesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-users nav-icon"></i>
                    مشتركو التطبيقات
                </a>
                <ul class="dropdown-menu" aria-labelledby="tablesDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('users.index')}}"> مشتركو التطبيقات</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('usersPackages.index')}}"> باقات المشتركين</a>
                    </li>
                </ul>
            </li>



            {{----------------------------------------------------------------------}}







            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="tablesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-notifications nav-icon"></i>
                    الإشعارات
                </a>
                <ul class="dropdown-menu" aria-labelledby="tablesDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route('notifications.index')}}">الإشعارات</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
