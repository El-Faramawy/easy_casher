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
                <label for="facebook">
                    <span class="icon-facebook"></span>
                    الفيس بوك
                </label>
                <input data-validation="required" type="text" value="{{$settings->facebook}}" class="form-control" id="facebook" name="facebook" placeholder="رابط الفيس بوك">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="twitter">
                    <span class="icon-twitter"></span>
                   التويتر
                </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->twitter}}" id="twitter" name="twitter" placeholder=" رابط التويتر">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="instagram">
                    <span class="icon-instagram"></span>
                    الانستجرام
                </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->instagram}}" id="instagram" name="instagram" placeholder=" رابط الانستجرام">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="linkedin">
                    <span class="icon-linkedin"></span>
                    اللينكدان
                </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->linkedin}}" id="linkedin" name="linkedin" placeholder=" رابط اللينكدان">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="telegram">
                    <span class="icon-link"></span>
                    التليجرام
                </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->telegram}}"  id="telegram" name="telegram" placeholder=" رابط التليجرام">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="youtube">
                    <span class="icon-youtube"></span>
                    اليوتيوب
                </label>
                <input data-validation="required" type="text" class="form-control" id="youtube" value="{{$settings->youtube}}"  name="youtube" placeholder=" رابط اليوتيوب">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="google_plus">
                    <span class="icon-google"></span>
                    جوجل بلس
                </label>
                <input data-validation="required" type="text" class="form-control" id="google_plus" value="{{$settings->google_plus}}" name="google_plus" placeholder=" رابط جوجل بلس">
            </div>
        </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="snapchat_ghost">
                    <span class="icon-link"></span>
                    اسناب شات
                </label>
                <input data-validation="required" type="text" class="form-control" id="snapchat_ghost" value="{{$settings->snapchat_ghost}}"  name="snapchat_ghost" placeholder=" رابط اسناب شات">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="whatsapp">
                    <span class="icon-link"></span>
                    الوتس اب
                </label>
                <input data-validation="required" type="text" class="form-control" id="whatsapp"  value="{{$settings->whatsapp}}"  name="whatsapp" placeholder=" رابط الوتس اب">
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

