<div class="card h-100" id="partNewDriver">
    <div class="card-header">
        <div class="card-title"> صور الغلاف ({{$user->name}})</div>
    </div>
    <div class="card-body">
        <div class="row gutters">
            @foreach($user->user_images as $row)
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                <a target="_blank" href="{{$row->image?get_file($row->image):asset('admin/img/img5.jpg')}}" class="effects">
                    <img src="{{$row->image?get_file($row->image):asset('admin/img/img5.jpg')}}" class="img-fluid" alt="Wafi Admin">

                </a>
            </div>
            @endforeach
                 <br>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">

                        <a class='btn btn-info  pull-left '  href="{{route('users.index')}}"><span class='icon-arrow_back'></span> عودة </a>

                    </div>
                </div>
        </div>

    </div>
</div>
