<form id="profile-form" method="post" action="{{route('profile.update',$admin->id)}}">
    @csrf
    @method('PUT')
    <div class="row gutters">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="fullName">الاسم</label>
                <input data-validation="required" type="text" class="form-control" id="name" name="name" value="{{$admin->name}}" placeholder="الاسم">
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="eMail">البريد الالكترونى</label>
                <input  data-validation="required" type="email" class="form-control"  value="{{$admin->email}}" id="email" name="email" placeholder="البريد الالكترونى">
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="password">كلمة المرور الجديدة</label>
                <input  type="password" class="form-control" id="password" name="password" value="" placeholder="كلمة المرور الجديدة">
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="address1">اللوجو  </label>
                <input  type="file" data-default-file="{{get_file($admin->image)}}" class="form-control dropify" id="image" name="image" placeholder="اللوجو">
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="text-right">
                <button type="submit" id="submit"  class="btn btn-success">حفظ</button>
            </div>
        </div>
    </div>
</form>
