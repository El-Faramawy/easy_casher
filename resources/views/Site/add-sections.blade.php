@extends('Site.Layouts.app')
@section('content')
					<!-- ================ routeNav ================= -->
					<div class="routeNav">
						<button onclick="goBack()" class="Back">
							<i class="fas fa-angle-right"></i>
						</button>
						<ul>
							<li>
								<a href="{{url('/')}}"> الرئسية </a>
							</li>
							<li>
								<a href="{{url('add-page')}}"> اضافة </a>
							</li>
							<li>
								<a href="#!" class="active"> الاقسام</a>
							</li>
						</ul>
					</div>
					<!-- ================ /routeNav ================= -->
					<div class="addSections">
						<!-- ================ slider ================= -->
						<div class="swiper mySwiper">
							<div class="swiper-wrapper">

								@foreach($categories2 as $category)
                                    @if($category->image!= null)
                                        <div class="swiper-slide">
                                            <img src="{{asset($category->image)}}">
                                        </div>
                                    @endif
                                @endforeach
							</div>
							<div class="swiper-pagination"></div>
						</div>
						<!-- ================ sections ================= -->
						<div class="sections">
							<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSection">
								<i class="fas fa-plus-octagon"></i> اضافة قسم </button>

                        @foreach( $categories as $category)
                            <div class="section">
								<div class="row align-items-center">
                                    @if($category->image!=null)
                                        <div class="col-2  col-lg-1 p-1">
                                            <img class="itemImg" src="{{asset($category->image)}}">
                                        </div>
                                    @else
                                        <div class="col-2  col-lg-1 p-1">
                                            <img class="itemImg">
                                        </div>
                                    @endif
									<div class="col-6 col-lg-7 p-1">
										<h6 class="Name">{{$category->title}}</h6>
									</div>
									<div class="col-2 p-1">
										<p> عدد : <span> 3 </span> </p>
									</div>
									<div class="col-2 p-1 text-start">
										<button class="btn btn-light color1 " data-bs-toggle="modal"
											data-bs-target="#editSection{{$category->id}}"
                                        > <i class="fas fa-edit"></i> </button>
									</div>
								</div>
							</div>
                                <div class="modal fade" id="editSection{{$category->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                     aria-labelledby="editSectionLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addSectionLabel"> تعديل قسم </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="{{route('update-sections')}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">اسم القسم </label>
                                                        <input type="hidden" id="id" name="id" class="id" value="{{$category->id}}">
                                                        <input type="text" class="form-control" id="title" name="cat_name" value="{{$category->title}}" >

                                                    </div>
                                                    <select class="form-select form-select-lg mb-3 cat_type_update selDiv  " aria-label=".form-select-lg example" name="cat_type">
                                                        <option selected disabled>--اختر نوع القسم--</option>
                                                        <option value="color" {{$category->display_logo_type=='color'?'selected':''}} class="type_of_cat_update"> لون</option>
                                                        <option value="image" {{$category->display_logo_type=='image'?'selected':''}} class="type_of_cat_update">صورة</option>
                                                    </select>
                                                <div class="update_div_image">
                                                    @if($category->display_logo_type=='image')
                                                        <div class="col-md-12 p-1 selectImg" style="display: block !important;">
{{--                                                                <label class="d-block fw-bold fs-6 mb-1">الصورة الجديدة</label>--}}
                                                                <input type="file" id="input-file" class="dropify" name="cat_image" data-default-file="{{$category->image}}">
                                                            </div>
                                                    @endif
                                                </div>
                                                    <div class="update_div_image d-none">
                                                        <div class="col-md-12 p-1 selectImg" style="display: block !important;">
{{--                                                                <label class="d-block fw-bold fs-6 mb-1">الصورة الجديدة</label>--}}
                                                                <input type="file" id="input-file" class="dropify" name="cat_image" data-default-file="{{$category->image}}">
                                                            </div>
                                                    </div>

                                                    @if($category->display_logo_type=='color')
                                                        <div class="update_div_color">
                                                    <div class="col-12" id="cat_color">
                                                            <label class="form-label" >لون القسم </label>
                                                            <div class=" colors ">
                                                                @foreach($colors as $color)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" {{$category->color_id==$color->id?'checked':''}} type="radio" name="cat_color" id="color{{$color->id}}" value="{{$color->id}}">
                                                                        <label class="form-check-label" style="background-color: {{$color->color_code}};" for="color{{$color->id}}"></label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                </div>
                                                @endif
                                                    <div class="update_div_color d-none">
                                                        <div class="col-12" id="cat_color">
                                                            <label class="form-label" >لون القسم </label>
                                                            <div class=" colors ">
                                                                @foreach($colors as $color)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cat_color" id="color{{$color->id}}" value="{{$color->id}}">
                                                                        <label class="form-check-label" style="background-color: {{$color->color_code}};" for="color{{$color->id}}"></label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                <div class="modal-footer d-flex justify-content-between ">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> اغلاق </button>
                                                    <button type="submit" class="btn btn-success "> حفظ </button>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
						</div>
                        {{$categories->links()}}
					</div>

                    <!-- Modal -->
                    <div class="modal fade" id="addSection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                         aria-labelledby="addSectionLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSectionLabel"> اضافة قسم </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{route('create-sections')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">اسم القسم </label>
                                            <input type="text" class="form-control" id="name" name="cat_name">
                                        </div>
                                        <select class="form-select form-select-lg mb-3 cat_type " aria-label=".form-select-lg example" name="cat_type">
                                            <option selected disabled>--اختر نوع القسم--</option>
                                            <option value="color" > لون</option>
                                            <option value="image" >صورة</option>
                                        </select>
                                        <div class="mb-3 row">
                                        <div class="col-12 d-none" id="cat_image">
                                            <label class="form-label" >صورة القسم </label>
                                            <input type="file" id="input-file-to-destroy" class="dropify"  name="cat_image">
                                        </div>
                                            <div class="col-12 d-none" id="cat_color2">
                                              <label class="form-label">لون القسم </label>
                                                <div class=" colors ">
                                                    @foreach($colors as $color)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="cat_color" id="color2{{$color->id}}" value="{{$color->id}}">
                                                        <label class="form-check-label" style="background-color: {{$color->color_code}};" for="color2{{$color->id}}"></label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between ">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> اغلاق </button>
                                        <button type="submit" class="btn btn-success "> حفظ </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
{{--   <!-- Modal -->--}}
{{--                    <div class="modal fade" id="editSection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"--}}
{{--                         aria-labelledby="editSectionLabel" aria-hidden="true">--}}
{{--                        <div class="modal-dialog modal-dialog-centered">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header">--}}
{{--                                    <h5 class="modal-title" id="addSectionLabel"> تعديل قسم </h5>--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                </div>--}}
{{--                                <form method="post" action="{{route('update-sections')}}" enctype="multipart/form-data">--}}
{{--                                    @csrf--}}
{{--                                    <div class="modal-body">--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="name" class="form-label">اسم القسم </label>--}}
{{--                                            <input type="hidden" id="id" name="id" class="id">--}}
{{--                                            <input type="text" class="form-control" id="title" name="cat_name" >--}}

{{--                                        </div>--}}
{{--                                        <select class="form-select form-select-lg mb-3 cat_type_update selDiv  " aria-label=".form-select-lg example" name="cat_type">--}}
{{--                                            <option selected disabled>--اختر نوع القسم--</option>--}}
{{--                                            <option value="color" class="type_of_cat_update"> لون</option>--}}
{{--                                            <option value="image" class="type_of_cat_update">صورة</option>--}}
{{--                                        </select>--}}
{{--                                        <div class="mb-3 d-none row cat_image_update" >--}}
{{--                                            <div class="col-6 text-center">--}}
{{--                                                <label class="d-block fw-bold fs-6 mb-1">الصورة الحالية</label>--}}
{{--                                                <img height="200px" width="50%" id="img_show" onclick="window.open(this.src)"--}}
{{--                                                     style="cursor: pointer;border-radius: 50%">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6 p-1 selectImg" style="display: block !important;">--}}
{{--                                                <label class="d-block fw-bold fs-6 mb-1">الصورة الجديدة</label>--}}
{{--                                                <input type="file" id="input-file" class="dropify" name="cat_image">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 d-none" id="cat_color">--}}
{{--                                              <label class="form-label" >لون القسم </label>--}}
{{--                                                <div class=" colors ">--}}
{{--                                                    @foreach($colors as $color)--}}
{{--                                                        <div class="form-check">--}}
{{--                                                            <input class="form-check-input" type="radio" name="cat_color" id="color{{$color->id}}" value="{{$color->id}}">--}}
{{--                                                            <label class="form-check-label" style="background-color: {{$color->color_code}};" for="color{{$color->id}}"></label>--}}
{{--                                                        </div>--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-footer d-flex justify-content-between ">--}}
{{--                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> اغلاق </button>--}}
{{--                                        <button type="submit" class="btn btn-success "> حفظ </button>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

@endsection
@push('site.js')
<script>
    $(document).ready(function () {

        $(document).on('change', '.cat_type', function () {
            var type_of_cat = $(this).val();
            if (type_of_cat == 'color') {
                $('#cat_color2').addClass('d-block').removeClass('d-none');
                $('#cat_image').addClass('d-none').removeClass('d-block');
            } if (type_of_cat == 'image'){
                $('#cat_image').addClass('d-block').removeClass('d-none');
                $('#cat_color2').addClass('d-none').removeClass('d-block');
            }

        });
    });
</script>

<script>
    $('#editSection').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var title = button.data('title')
        var color_id = button.data('color_id')
        var display_logo_type = button.data('display_logo_type')
        var image = button.data('image')


        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #title').val(title);
        modal.find('.modal-body .selDiv option[value="'+display_logo_type+'"]').prop('selected', true);
        modal.find('.modal-body #img_show').attr('src', image);


    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('change', '.cat_type_update', function () {
            var type_of_cat_update= $(this).val();
            if (type_of_cat_update == 'image') {
                $('.update_div_image').addClass('d-block').removeClass('d-none');
                $('.update_div_color').addClass('d-none').removeClass('d-block');
            }
             if (type_of_cat_update == 'color') {
                 $('.update_div_image').addClass('d-none').removeClass('d-block');
                 $('.update_div_color').addClass('d-block').removeClass('d-none');
            }
        });
    });
</script>

@endpush
