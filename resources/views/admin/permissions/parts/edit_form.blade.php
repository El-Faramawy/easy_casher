<form action="{{route('permissions.update',$permission->id)}}" method="post" id="Form">
    @csrf
    @method('PUT')
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">تعديل ({{$permission->ar_name}})</h6>
    </div>


    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="name">اسم الصلاحية بالانجليزية </label>
                <input data-validation="required" type="text" class="form-control" value="{{$permission->name}}" id="name" name="name" placeholder=" اسم الصلاحية بالانجليزية ">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="ar_name">اسم الصلاحية بالعربية </label>
                <input data-validation="required" type="text" class="form-control" value="{{$permission->ar_name}}" id="ar_name" name="ar_name" placeholder="اسم الصلاحية بالعربية ">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="type_name">نوع الصلاحية </label>
                <input data-validation="required" type="text" class="form-control" value="{{$permission->type_name}}" id="type_name" name="type_name" placeholder="نوع الصلاحية ">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="type_order">ترتيب نوع الصلاحية </label>
                <input data-validation="required" type="number" class="form-control" value="{{$permission->type_order}}" id="type_order" name="type_order" placeholder="ترتيب نوع الصلاحية ">
            </div>
        </div>



    </div>
</form>


