@if ($contacts->count()>0)
    <div class="row" id="contacts">
        @foreach($contacts as $contact)
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <figure class="user-card">
                    <figcaption>
                        <a href="#" class="edit-card" id="{{$contact->id}}" >
                            <i class="icon-delete"></i>
                        </a>
                        <img src="{{asset('admin/img/notification-success.svg')}}" alt="Wafi Admin" class="profile">
                        <h5>{{$contact->name}}</h5>
                        <ul class="list-group">
                            <li class="list-group-item">{{$contact->email}}</li>
                            <li class="list-group-item">{{$contact->subject}}</li>
                            <li class="list-group-item">{{$contact->message}}</li>
                            <li class="list-group-item">{{date('Y/m/d ',strtotime($contact->created_at))}}</li>
                        </ul>
                    </figcaption>
                </figure>
            </div>

        @endforeach
            {!! $contacts->links() !!}

    </div>


    @else
   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
       <figure class="user-card">
           <figcaption>
               <img src="{{asset('admin/img/notification-success.svg')}}" alt="Wafi Admin" class="profile">
               <h2 class="blog-title text-center text-success">لا توجد طلبات تواصل</h2>

           </figcaption>
       </figure>


   </div>
@endif
