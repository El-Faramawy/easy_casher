<form action="{{route('sliders.store')}}" method="post" id="Form">
    @csrf
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">إضافة بانر جديد</h6>
    </div>


    {{--form--}}
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_title">الإسم </label>
                <input  type="text" class="form-control" value="" id="title" name="title" placeholder="الاسم ">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_desc">الوصف </label>
                <textarea  class="summernote" name="desc" id="summernote1" placeholder="الوصف "></textarea>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="type">النوع </label>
                <select  data-validation="required" name="type" id="type" class="form-control selectpicker my-select" data-live-search="true">
                    <option  value="categories">الأقسام</option>
                    <option  value="clients">العملاء</option>
                    <option  value="suppliers">الموردين</option>
                    <option  value="expenses">المصروفات</option>

                </select>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="address1">الصورة </label>
                <input data-validation="required" type="file" data-default-file="" class="form-control dropify" id="image" name="image" >
            </div>
        </div>


    </div>
    {{--form--}}
</form>


