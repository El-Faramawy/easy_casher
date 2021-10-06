<form action="{{route('settings.update',$settings->id)}}" method="post" id="settingsForm">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">الشروط و الأحكام </h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_termis_condition">الشروط و الأحكام (عربى)</label>
                <textarea data-validation="required" class="summernote" name="ar_terms_condition" id="ar_termis_condition" placeholder="الشروط و الأحكام بالعربية">{{$settings->ar_terms_condition}}</textarea>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="en_termis_condition">الشروط و الأحكام  (انجليزى)</label>
                <textarea data-validation="required" class="summernote" name="en_terms_condition" id="en_termis_condition" placeholder="الشروط و الأحكام باللغة الانجليزية">{{$settings->en_terms_condition}}</textarea>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_about_app">عن التطبيق  (عربى)</label>
                <textarea data-validation="required" class="summernote" name="ar_about_app" id="ar_about_app" placeholder="عن التطبيق بالعربية">{{$settings->ar_about_app}}</textarea>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="en_about_app">عن التطبيق   (انجليزى)</label>
                <textarea data-validation="required" class="summernote" name="en_about_app" id="en_about_app" placeholder="عن التطبيق باللغة الانجليزية">{{$settings->en_about_app}}</textarea>
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

