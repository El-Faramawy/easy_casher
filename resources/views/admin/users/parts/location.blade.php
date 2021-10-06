<div class="card h-100" id="partNewDriver">
 <div class="card-header">
        <div class="card-title">الموقع الحالى السائق / المندوب ({{$user->name}})</div>
    </div>
    <div class="card-body">
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div  id='map_canvas' style="width: 100%; height: 300px;"></div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="text-right">

                    <a class='btn btn-info  pull-left '  href="{{route('users.index')}}"><span class='icon-arrow_back'></span> عودة </a>

                </div>
            </div>
        </div>
    </div>
</div>
