<div class="account-settings">
    <div class="user-profile">
        <div class="user-avatar">
            <img src="{{$admin->image?get_file($admin->image):asset('admin/img/user.png')}}" alt="Wafi Admin" />
        </div>
        <h5 class="user-name">{{$admin->name}}</h5>
        <h6 class="user-email">{{$admin->email}}</h6>
    </div>
    {{--   <div class="setting-links">
                           <a href="chat.html">
                               <i class="icon-chat"></i>
                               Messages
                           </a>
                           <a href="tasks.html">
                               <i class="icon-date_range"></i>
                               Tasks
                           </a>
                           <a href="documents.html">
                               <i class="icon-file-text"></i>
                               Documents
                           </a>
                           <a href="faq.html">
                               <i class="icon-info"></i>
                               FAQ's
                           </a>
                       </div>--}}
</div>
