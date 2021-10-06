<form action="{{route('settings.update',$settings->id)}}" method="post" id="settingsForm">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">الموقع</h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="address1">العنوان (الرئيسى) </label>
                <input data-validation="required" type="text"  value="{{$settings->address1}}" class="form-control" id="address1" name="address1" placeholder="العنوان">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="address2">العنوان (الإضافى)</label>
                <input data-validation="required" type="text" value="{{$settings->address2}}" class="form-control" id="address2" name="address2" placeholder="عنوان اضافى">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
            <div  id='map_canvas' style="width: 100%; height: 300px;"></div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <input  data-validation="required" readonly  value="{{$settings->latitude}}" class="form-control" type="text" name="latitude" id="lat" >
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <input data-validation="required" readonly class="form-control" value="{{$settings->longitude}}" type="text" name="longitude" id="long" >
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

