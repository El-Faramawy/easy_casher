<form action="{{route('sliders.update',$slider->id)}}" method="post" id="Form">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">تعديل ({{$slider->title}})</h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_title">الإسم </label>
                <input  type="text" class="form-control" value="{{$slider->title}}" id="ar_title" name="ar_title" placeholder="الاسم">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_desc">الوصف </label>
                <textarea  class="summernote" name="desc" id="summernote1" placeholder="الوصف بالعربية">{{$slider->ar_desc}}</textarea>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="type">النوع </label>
                <select  data-validation="required" name="type" id="type" class="form-control selectpicker my-select" data-live-search="true">
                    <option  {{$slider->type == 'categories' ?'selected':''}} value="categories">الأقسام</option>
                    <option  {{$slider->type == 'clients' ?'selected':''}} value="clients">العملاء</option>
                    <option  {{$slider->type == 'suppliers' ?'selected':''}} value="suppliers">الموردين</option>
                    <option  {{$slider->type == 'expenses' ?'selected':''}} value="expenses">المصروفات</option>

                </select>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="address1">الصورة </label>
                <input  type="file" data-default-file="{{get_file($slider->image)}}" class="form-control dropify" id="image" name="image" >
            </div>
        </div>


    </div>
    {{--form--}}
</form>


