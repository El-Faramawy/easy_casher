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
								<a href="{{route('suppliers')}}" class="active"> الموردين</a>
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
						<div class="suppliers">
							<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSuppliers">
								<i class="fas fa-plus-octagon"></i> اضافة مورد </button>
							<ul>
                                @foreach($suppliers as $supplier)
							     	<li class="supplier">
									<img src="{{asset('Site\images\avatar1.png')}}">
									<div class="info">
										<div class="data">
											<h6>{{$supplier->name}} </h6>
											<p>{{$supplier->phone}}</p>
										</div>
										<button class="btn btn-light color1 " data-bs-toggle="modal"
											data-bs-target="#editSupplier{{$supplier->id}}"> <i class="fas fa-edit"></i> </button>
									</div>
								</li>
                                    <!-- editModal -->
                                    <div class="modal fade" id="editSupplier{{$supplier->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                         aria-labelledby="addCustomerLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addCustomerLabel"> تعديل مورد </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('update-customer')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$supplier->id}}">
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" الاسم " name="name" value="{{$supplier->name}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" البريد الالكتروني " name="email" value="{{$supplier->email}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" رقم الهاتف " name="phone" value="{{$supplier->phone}}">
                                                        </div>
                                                        <div class=" mb-3">
                                                            <input type="text" class="form-control" placeholder=" العنوان " name="address" value="{{$supplier->address}}">
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
                        {{$suppliers->links()}}
					</section>
				</section>
				<!-- ================ /content ================= -->
			</div>


		<!-- Modal -->
		<div class="modal fade" id="addSuppliers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addSuppliersLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addSuppliersLabel"> اضافة مورد </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" action="{{route('create-supplier')}}">
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
