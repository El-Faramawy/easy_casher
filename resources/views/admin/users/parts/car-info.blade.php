<div class="card h-100" id="partNewDriver">
    <div class="card-header">
        <div class="card-title">بيانات سيارة السائق / المندوب ({{$user->name}})</div>
    </div>
    <div class="card-body">
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >اسم الموديل   :    </span>
                    <span class="spanView">{{$user->car?$user->car->car_model:''}}</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">سنة التصنيع   :    </span>
                    <span class="spanView">{{$user->car?$user->car->year_of_manufacture:''}}</span>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">نوع السيارة :  </span>
                    <span class="spanView">{{$user->car?$user->car->car_type?$user->car->car_type->title:'':''}}</span>
                </div>

            </div>

            <br>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >صورة الرخصة  :    </span>
                    <img src="{{get_file($user->car?$user->car->licence_image:null)}}" style="height: 70px; width: 70px" onclick="window.open(this.src)" >
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >الصورة الأمامية للسيارة  :    </span>
                    <img src="{{get_file($user->car?$user->car->front_car_image:null)}}" style="height: 70px; width: 70px" onclick="window.open(this.src)" >
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >الصورة الخلفية للسيارة  :    </span>
                    <img src="{{get_file($user->car?$user->car->back_car_image:null)}}" style="height: 70px; width: 70px" onclick="window.open(this.src)" >
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
