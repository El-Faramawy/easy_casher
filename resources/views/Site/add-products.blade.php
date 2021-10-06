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
								<a href="#!" class="active"> المنتجات </a>
							</li>
						</ul>
					</div>
					<!-- ================ /routeNav ================= -->
					<div class="addProducts">
						<!-- ================ sections ================= -->
						<div class="sections">
							<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProduct">
								<i class="fas fa-plus-octagon"></i> اضافة منتج </button>
							@foreach( $products as $product)
                                  <div class="section">
								<div class="row align-items-center">
									@if($product->image!=null)
                                    <div class="col-2  col-lg-1 p-1">
										<img class="itemImg" src="{{asset($product->image)}}">
									</div>
                                    @else
                                        <div class="col-2  col-lg-1 p-1">
                                            <img class="itemImg">
                                        </div>
                                    @endif

									<div class="col-6 col-lg-7 p-1">
										<h6 class="Name"> {{$product->title}} </h6>
									</div>
{{--									<div class="col-2 p-1">--}}
{{--										<p> تكلفة الشراء <span>{{$product->product_cost}} </span> ج.م </p>--}}
{{--									</div>--}}
{{--                                    <div class="col-2 p-1">--}}
{{--										<p> سعر البيع<span>{{$product->product_price}} </span> ج.م </p>--}}
{{--									</div>--}}
									<div class="col-2 p-1 text-start">
										<button class="btn btn-light color1 " data-bs-toggle="modal"
											data-bs-target="#editProduct{{$product->id}}"> <i class="fas fa-edit"></i> </button>
									</div>
                                    <div class="col-2 p-1 text-start">
										<button class="btn btn-icon btn-warning btn-sm me-1" data-bs-toggle='modal' title="تفاصيل" data-bs-target="#product_detailes" style="border-radius: 15% !important ; padding: 10px"
                                                data-id= '{{$product->id}}'
                                                data-title= '{{$product->title}}'
                                                data-product_price= '{{$product->product_price}}'
                                                data-product_cost= '{{$product->product_cost}}'
                                                data-sku= '{{$product->sku}}'
                                                @if($product->stock_type == 'in_stock')
                                                data-stock_type= 'داخل المخزن'
                                                data-stock_amount= '{{$product->stock_amount}}'
                                                @elseif($product->stock_type == 'out_stock')
                                                data-stock_type= 'خارج المخزن'
                                                @endif
                                                data-image = '{{asset($product->image)}}'
                                        > <i class="fas fa-pencil"></i> </button>
									</div>
								</div>
							</div>
                                <div class="modal fade" id="editProduct{{$product->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                     aria-labelledby="editProductLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editProductLabel"> تعديل منتج </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="{{route('update-products')}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">اسم المنتج </label>
                                                                <input type="hidden" name="id" id="id" value="{{$product->id}}">
                                                                <input type="text" class="form-control" name="title" value="{{$product->title}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">اختر القسم </label>
                                                                <select class="form-select form-select-lg">
                                                                    @foreach($categories as $category)
                                                                        <option {{$category->id==$product->id?'selected':''}} value="{{$category->id}}">{{$category->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> بيع بـ : </label>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->product_type=='unit'?'checked':''}}  type="radio" name="sellType" id="sellType1" value="unit">
                                                                    <label class="form-check-label" for="sellType1"> الوحدة </label>
                                                                </div>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->product_type=='weight'?'checked':''}} type="radio" name="sellType" id="sellType2" value="weight">
                                                                    <label class="form-check-label" for="sellType2"> الوزن </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">مبلغ البيع </label>
                                                                <input type="number" class="form-control" placeholder="مبلغ البيع " name="product_price" value="{{$product->product_price}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> تكلفة الشراء </label>
                                                                <input type="number" class="form-control" placeholder="تكلفة الشراء" name="product_cost" value="{{$product->product_cost}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> SKU " اختياري "</label>
                                                                <input type="number" class="form-control" placeholder="SKU ' اختياري ' " name="sku" value="{{$product->sku}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> المخزن : </label>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->stock_type=='in_stock'?'checked':''}} type="radio" name="stockType"
                                                                           id="stockType1" value="in_stock">
                                                                    <label class="form-check-label"  for="stockType1"> في المخزن </label>
                                                                </div>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->stock_type=='out_stock'?'checked':''}} type="radio" name="stockType"
                                                                           id="stockType2" value="out_stock">
                                                                    <label class="form-check-label"   for="stockType2"> خارج المخزن </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if( $product->stock_type=='in_stock')
                                                            <div class="col-md-6 p-1 inStock">
                                                                <div class="mb-3">
                                                                    <!-- <label class="form-label"> SKU " اختياري "</label> -->
                                                                    <input type="number" class="form-control" placeholder="الكمية المتاحة" name="stock_amount" value="{{$product->stock_amount}}">
                                                                </div>
                                                            </div>
                                                            @endif
                                                        <div class="col-md-12 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> العرض في نقطة البيع : </label>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->display_logo_type=='color'?'checked':''}} type="radio" name="viewType" id="viewType1" value="color">
                                                                    <label class="form-check-label"   for="viewType1"> اللون والشكل </label>
                                                                </div>
                                                                <div class="form-check d-inline-block ">
                                                                    <input class="form-check-input" {{$product->display_logo_type=='image'?'checked':''}} type="radio" name="viewType" id="viewType2" value="image">
                                                                    <label class="form-check-label"  for="viewType2"> صورة </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 p-1 selectColor">
                                                            <div class="mb-3">
                                                                <label class="form-label">لون القسم </label>
                                                                <div class="colors">
                                                                    @foreach($colors as $color)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" {{$product->color_id== $color->id?'checked':''}} type="radio" name="cat_color" id="color{{$color->id}}" value="{{$color->id}}">
                                                                            <label class="form-check-label" style="background-color: {{$color->color_code}};" for="color{{$color->id}}"></label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @if($product->display_logo_type=='image')
                                                       <div class="row">
                                                            <div class="col-md-6 p-1 selectImg" style="display: block !important;">
                                                                <label class="d-block fw-bold fs-6 mb-1">الصورة الجديدة</label>
                                                                <input type="file" id="input-file" class="dropify" name="cat_image">
                                                            </div>
                                                           <div class="col-6 text-center update_image" >
                                                               <label class="d-block fw-bold fs-6 mb-1">الصورة الحالية</label>
                                                               <img height="200px" width="50%" id="img_show" onclick="window.open(this.src)"
                                                                    style="cursor: pointer;border-radius: 10%" src="{{asset($product->image)}}">
                                                           </div>
                                                       </div>
                                                        @endif
                                                        @if($product->display_logo_type=='color')
                                                        <div class="col-md-12 p-1 selectImg">
                                                            <input type="file" id="input-file" class="dropify" name="cat_image">
                                                        </div>
                                                        @endif
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
                                @endforeach
						</div>
					</div>
                    {{$products->links()}}

                    <div class="modal fade" id="addProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addProductLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addProductLabel"> اضافة منتج </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" action="{{route('create-products')}}" enctype="multipart/form-data">
                        @csrf
						<div class="modal-body">
							<div class="row align-items-center">
								<div class="col-md-6 p-1">
									<div class="mb-3">
										<label class="form-label">اسم المنتج </label>
										<input type="text" class="form-control" name="title">
									</div>
								</div>
								<div class="col-md-6 p-1">
									<div class="mb-3">
										<label class="form-label">اختر القسم </label>
										<select class="form-select form-select-lg selDiv" name="category_id" >
                                            @foreach($categories as $category)
											   <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
										</select>
									</div>
								</div>
								<div class="col-md-12 p-1">
                                    <div class="col-md-12 p-1">
                                        <div class="mb-3">
                                            <label class="form-label"> بيع بـ : </label>
                                            <div class="form-check d-inline-block ">
                                                                <input class="form-check-input"  type="radio" name="sellType" id="sellType12" value="unit">
                                                <label class="form-check-label" for="sellType12"> الوحدة </label>
                                            </div>
                                            <div class="form-check d-inline-block ">
                                                <input class="form-check-input" type="radio" name="sellType" id="sellType22" >
                                                <label class="form-check-label" for="sellType22"> الوزن </label>
                                            </div>
                                        </div>
                                    </div>
								</div>
								<div class="col-md-4 p-1">
									<div class="mb-3">
										<label class="form-label">مبلغ البيع </label>
										<input type="number" class="form-control" placeholder="مبلغ البيع " name="product_price">
									</div>
								</div>
								<div class="col-md-4 p-1">
									<div class="mb-3">
										<label class="form-label"> تكلفة الشراء </label>
										<input type="number" class="form-control" placeholder="تكلفة الشراء" name="product_cost">
									</div>
								</div>
								<div class="col-md-4 p-1">
									<div class="mb-3">
										<label class="form-label"> SKU " اختياري "</label>
										<input type="number" class="form-control" placeholder="SKU ' اختياري ' " name="sku">
									</div>
								</div>
								<div class="col-md-6 p-1">
									<div class="mb-3">
										<label class="form-label"> المخزن : </label>
										<div class="form-check d-inline-block ">
											<input class="form-check-input" type="radio" name="stockType"
												id="stockType12" value="in_stock">
											<label class="form-check-label" for="stockType12"> في المخزن </label>
										</div>
										<div class="form-check d-inline-block ">
											<input class="form-check-input" type="radio" name="stockType"
												id="stockType22" value="out_stock">
											<label class="form-check-label" for="stockType22"> خارج المخزن </label>
										</div>
									</div>
								</div>
								<div class="col-md-6 p-1 inStock">
									<div class="mb-3">
										<!-- <label class="form-label"> SKU " اختياري "</label> -->
										<input type="number" class="form-control" placeholder="الكمية المتاحة" name="stock_amount">
									</div>
								</div>
								<div class="col-md-12 p-1">
									<div class="mb-3">
										<label class="form-label"> العرض في نقطة البيع : </label>
										<div class="form-check d-inline-block  " >
											<input class="form-check-input " type="radio" name="viewType" id="viewType12" value="color">
											<label class="form-check-label" for="viewType12"> اللون والشكل </label>
										</div>
										<div class="form-check d-inline-block ">
											<input class="form-check-input" type="radio" name="viewType" id="viewType22" value="image">
											<label class="form-check-label" for="viewType22"> صورة </label>
										</div>
									</div>
								</div>
								<div class="col-md-12 p-1 selectColor">
									<div class="mb-3">
										<label class="form-label">لون القسم </label>
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
								<div class="col-md-12 p-1 selectImg">
									 <input type="file" id="input-file" class="dropify" name="cat_image">
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
                    <!-------------------------start EDIT modal -------------------------------------------------------------->
                    <div class="modal fade" id="product_detailes" tabindex="-1" aria-hidden="true" style="text-align: center !important;">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2>بيانات المنتج</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                        <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                            </g>
                        </svg>
					</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-3 mx-xl-15 my-3">
                                    <div class="card mb-5 mb-xl-8">
                                        <!--begin::Card body-->
                                        <div class="card-body pt-15">
                                            <!--begin::Summary-->
                                            <div class="d-flex flex-center flex-column mb-5">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-100px symbol-circle mb-7">
                                                    <img src="" alt="image" id="image">
                                                </div>
                                            </div>
                                            <!--start::Summary-->
                                            <div class="fw-bolder">
                                                <div class="">الاسم بالكامل :
                                                    <span class="text-gray-600" id="title"></span>
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <div class="mt-3">سعر المنتج :
                                                    <span class="text-gray-600" id="product_price"></span>
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <div class="mt-3">سعر التكلفة :
                                                    <span class="text-gray-600" id="product_cost"></span>
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <div class="mt-3"> المخزن  :
                                                    <span class="text-gray-600" id="stock_type"></span>
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <div class="mt-3">الكمية المتاحة  :
                                                    <span class="text-gray-600" id="stock_amount"></span>
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <div class="mt-3">رقم الاس كيو يو:
                                                    <span class="text-gray-600" id="sku"></span>
                                                </div>
                                            </div>
                                            <!--end::Summary-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-primary me-3" data-bs-dismiss="modal">اغلاق</button>
                                    </div>
                                    <!--end::Actions-->

                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!-------------------------end EDIT modal -------------------------------------------------------------->

@endsection
@push('site.js')
    <script>
        $(document).ready(function () {
                $(document).on('click', '#viewType1', function () {
                $('.update_image').css('display', 'none');
            });
            $(document).on('click', '#viewType2', function () {
                $('.update_image').css('display', 'block');
            });
        });
    </script>

    <script>
        //Show data in edit modal
        $('#product_detailes').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var title = button.data('title')
            var product_price = button.data('product_price')
            var product_cost = button.data('product_cost')
            var sku = button.data('sku')
            var stock_type = button.data('stock_type')
            var stock_amount = button.data('stock_amount')
            var image = button.data('image')
            var modal = $(this)
            modal.find('.modal-body #title').text(title);
            modal.find('.modal-body #product_price').text(product_price);
            modal.find('.modal-body #product_cost').text(product_cost);
            modal.find('.modal-body #sku').text(sku);
            modal.find('.modal-body #stock_type').text(stock_type);
            modal.find('.modal-body #stock_amount').text(stock_amount);
            modal.find('.modal-body #image').attr('src', image);
            // modal.find('.modal-body .selDiv option[value="'+display_logo_type+'"]').prop('selected', true);
        });

    </script>

    @endpush
