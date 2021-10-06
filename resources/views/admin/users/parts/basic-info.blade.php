<div class="card h-100" id="partNewDriver">
    <div class="card-header">
        <div class="card-title text-center badge badge-primary" style="font-weight: bold" >بيانات السائق / المندوب ({{$user->name}})</div>
    </div>
    <div class="card-body">
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >الاسم   :    </span>
                    <span class="spanView">{{$user->name}}</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">البريد الالكترونى   :    </span>
                    <span class="spanView">{{$user->email}}</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">رقم الجوال   :    </span>
                    <span class="spanView">{{$user->phone}}({{$user->phone_code}})</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">   الجنسية :  </span>
                    <span class="spanView">{{$user->nationality_title}}</span>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">   رقم الهوية الوطنية :  </span>
                    <span class="spanView">{{$user->card_id}}</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">  رقم الحساب البنكى :  </span>
                    <span class="spanView">{{$user->account_bank_number}}</span>
                </div>
                <div class="form-group">
                    <span  style="font-weight: bold;font-size: larger">  عنوان الحساب البنكى :  </span>
                    <span class="spanView">{{$user->address_registered_for_bank_account}}</span>
                </div>
                <div class="form-group">

                    <span  style="font-weight: bold;font-size: larger">  حالة الإشترك :  </span>
                    <span class="spanView">{{$user->package_finished_at == null?'لم يتم الاشتراك حتى الآن':'مفعل حتى : '.date('Y M  d ',strtotime($user->package_finished_at))}}</span>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="text-right">

                    <a class='btn btn-info  pull-left '  href="{{route('users.index')}}"><span class='icon-arrow_back'></span> عودة </a>
                </div>
            </div>
        </div>
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <span style="font-weight: bold;font-size: larger" >صورة بطاقة الهوية   :    </span>
                   <img src="{{get_file($user->card_image)}}" style="height: 70px; width: 70px" onclick="window.open(this.src)" >
                </div>
            </div>
        </div>
    </div>
</div>
