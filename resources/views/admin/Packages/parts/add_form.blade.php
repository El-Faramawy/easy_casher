<form action="{{route('packages.store')}}" method="post" id="Form">
    @csrf
    <div class="alert alert-primary" role="alert">
        <h6 class="text-center mb-1">إضافة باقة جديدة</h6>
    </div>


    {{--form--}}
    <div class="row gutters">


        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="name">العنوان  </label>
                <input data-validation="required" type="text" class="form-control" id="name" name="title" placeholder="العنوان ">
            </div>
        </div>


        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="email">السعر</label>
                <input type="text" value="0" class="form-control numbersOnly" id="email" name="price" placeholder="السعر">
            </div>
        </div>


        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
                <label for="num_of_days">عدد الايام</label>
                <input type="text" value="0" class="form-control numbersOnly" id="num_of_days" name="num_of_days" placeholder="السعر">
            </div>
        </div>


        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="show" name="is_showing" id="is_showing1" checked>
                    <label class="form-check-label" for="is_showing1">
                        عرض
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="hidden" name="is_showing" id="is_showing2" >
                    <label class="form-check-label" for="is_showing2">
                        إخفاء
                    </label>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-6">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="yes" name="is_free" id="is_free1" checked>
                    <label class="form-check-label" for="is_free1">
                        مجانية
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="no" name="is_free" id="is_free2" >
                    <label class="form-check-label" for="is_free2">
                        غير مجانية
                    </label>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="address1">الصورة </label>
                <input  type="file" data-default-file="" class="form-control dropify" id="image" name="image" >
            </div>
        </div>


    </div>
    {{--form--}}
</form>


