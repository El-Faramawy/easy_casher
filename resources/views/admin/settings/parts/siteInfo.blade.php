<form action="{{route('settings.update',$settings->id)}}" method="post" id="settingsForm">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">المعلومات الرئيسية</h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="ar_title">الإسم (عربى) </label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->ar_title}}" id="ar_title" name="ar_title" placeholder="الاسم باللغة العربية">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="en_title">الإسم (انجليزى)</label>
                <input data-validation="required" type="text" class="form-control" value="{{$settings->en_title}}" id="en_title" name="en_title" placeholder="الاسم باللغة الانجليزية">
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_desc">الوصف (عربى)</label>
                <textarea data-validation="required" class="summernote" name="ar_desc" id="summernote1" placeholder="الوصف بالعربية">{{$settings->ar_desc}}</textarea>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_desc">الوصف (انجليزى)</label>
                <textarea data-validation="required" class="summernote" name="en_desc" id="summernote2" placeholder="الوصف بالانجليزية">{{$settings->en_desc}}</textarea>
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

