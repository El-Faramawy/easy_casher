@extends('Site.Layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger" style="padding: 15px">
            <ul style="margin-right: 15px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container-full">
				<!-- ================ content ================= -->
				<section class="content">
					<!-- ================ routeNav ================= -->
					<div class="routeNav">
						<button onclick="goBack()" class="Back">
							<i class="fas fa-angle-right"></i>
						</button>
						<ul>
							<li>
								<a href="/"> الرئسية </a>
							</li>
							<li>
								<a href="{{route('customers')}}" class="active"> العملاء </a>
							</li>
						</ul>
					</div>
					<!-- ================ /routeNav ================= -->
					<section class="innerPage">
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
						<!-- ================ section ================= -->
						<div class="Customer">
							<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCustomer">
								<i class="fas fa-plus-octagon"></i> اضافة عميل </button>
							<ul>
                                @foreach($customers as $customer)
								 <li class="supplier">
									<img src="{{asset('Site\images\preloaders\avatar.png')}}">
									<div class="info">
										<div class="data">
											<h6>{{$customer->name}} </h6>
											<p>{{$customer->phone}}</p>
										</div>
										<button class="btn btn-light color1 " data-bs-toggle="modal"
											data-bs-target="#edieCustomer{{$customer->id}}"> <i class="fas fa-edit"></i> </button>
                                        <button class="btn btn-danger color1 " data-bs-toggle="modal"
											data-bs-target="#delete_btn" data-id="{{$customer->id}}"> <i class="fas fa-trash-alt"></i> </button>

									</div>
								</li>

                                    <!-- editModal -->
                                    <div class="modal fade" id="edieCustomer{{$customer->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                         aria-labelledby="addCustomerLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addCustomerLabel"> تعديل عميل </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('update-customer')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
<input type="hidden" name="id" value="{{$customer->id}}">
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" الاسم " name="name" value="{{$customer->name}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" البريد الالكتروني " name="email" value="{{$customer->email}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" رقم الهاتف " name="phone" value="{{$customer->phone}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" العنوان " name="address" value="{{$customer->address}}">
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
							</ul>
						</div>
                        {{$customers->links()}}
					</section>
				</section>
				<!-- ================ /content ================= -->
			</div>
    <!-- deleteModal -->
    <div class="modal" id="delete_btn">
{{--    <div id="delete_btn" class="modal fade" role="dialog">--}}
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('delete-customer')}}" method="post" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" style="margin-right:-2%">حذف</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <h4>هل انت متأكد من حذف العميل المحدد<strong style="color: red"></strong>؟!</h4>
                    </div>
                    <div class="modal-footer d-flex justify-content-between ">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> اغلاق </button>
                        <button type="submit" class="btn btn-danger"> حذف </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
		<!-- Modal -->
		<div class="modal fade" id="addCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addCustomerLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addCustomerLabel"> اضافة عميل </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="{{route('create-customer')}}" method="post">
                        @csrf
						<div class="modal-body">

							<div class=" mb-3">
								<input type="text" class="form-control" placeholder=" الاسم " name="name">
							</div>
							<div class=" mb-3">
								<input type="text" class="form-control" placeholder=" البريد الالكتروني " name="email">
							</div>
							<div class=" mb-3">
								<input type="text" class="form-control" placeholder=" رقم الهاتف " name="phone">
							</div>
							<div class=" mb-3">
								<input type="text" class="form-control" placeholder=" العنوان " name="address">
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
@endsection

@push('site.js')

    <script>
        //Show data in the delete form
        $('#delete_btn').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endpush
