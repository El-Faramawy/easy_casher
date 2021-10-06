<form action="{{route('settings.update',$settings->id)}}" method="post" id="settingsForm">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">معلومات التواصل</h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="email1">البريد الالكترونى (الرئيسى) </label>
                <input data-validation="required" value="{{$settings->email1}}" type="text" class="form-control" id="email1" name="email1" placeholder="البريد الالكترونى (الرئيسى)">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="email2">البريد الالكترونى  (الإضافى)</label>
                <input data-validation="required" type="text" value="{{$settings->email2}}" class="form-control" id="email2" name="email2" placeholder=" البريد الالكترونى  (الإضافى)">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="phone1">الهاتف (الرئيسى) </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->phone1}}" id="phone1" name="phone1" placeholder="الهاتف (الرئيسى)">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="phone2">الهاتف  (الإضافى)</label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->phone2}}" id="phone2" name="phone2" placeholder=" الهاتف  (الإضافى)">
            </div>
        </div>

        <div class="custom-btn-group">
            <button class="btn btn-success" type="submit">
                حفظ
                <span class="icon-circle-with-plus" ></span>

            </button>
        </div>

    </div>
    {{--form--}}
</form>

