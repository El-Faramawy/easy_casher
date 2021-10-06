<a href="{{route('notifications.index')}}" id="notifications" data-toggle="dropdown" aria-haspopup="true">
    <i class="icon-bell"></i>
    @if ($unreadNotificationCount>0)
        <span class="count-label">{{$unreadNotificationCount}}</span>
    @endif

</a>
<div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
    <div class="dropdown-menu-header">
        عدد الإشعارات كلها ({{$notification_count}})
    </div>
    <ul class="header-notifications">
        @foreach($unreadNotifications->take(3) as $row)
        <li>
            <a href="{{route('notifications.show',$row->id)}}">
                <div class="user-img away">
                    <img src="{{$row->user?get_file($row->user->logo):asset('admin/img/user10.png')}}" alt="User" />
                </div>
                <div class="details">
                    <div class="user-title">{{$row->ar_title}}</div>
                    <div class="noti-details">{{$row->ar_desc}}</div>
                    <div class="noti-date">{{$row->created_at}}</div>
                </div>
            </a>
        </li>
        @endforeach
            <li>
                <a href="{{route('notifications.index')}}">
                    <div class="user-img away">
                        <img src="{{asset('admin/img/notification-success.svg')}}" alt="User" />
                    </div>
                    <div class="details">
                        <div class="user-title">كل الإشعارات</div>
                    </div>
                </a>
            </li>
    </ul>
</div>
