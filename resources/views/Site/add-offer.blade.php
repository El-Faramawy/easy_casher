@extends('Site.Layouts.app')
@section('content')
					<!-- ================ routeNav ================= -->
					<div class="routeNav">
						<button onclick="goBack()" class="Back">
							<i class="fas fa-angle-right"></i>
						</button>
						<ul>
							<li>
								<a href="index.html"> الرئسية </a>
							</li>
							<li>
								<a href="add-page.html"> اضافة </a>
							</li>
							<li>
								<a href="#!" class="active"> الخصومات </a>
							</li>
						</ul>
					</div>
					<!-- ================ /routeNav ================= -->
					<div class="addOffers">
						<div class="sections">
							<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addOffer">
								<i class="fas fa-plus-octagon"></i> اضافة خصم </button>
							@foreach($coupones as $coupone)
                            <div class="section">
								<div class="row align-items-center">
									<div class="col-8 col-lg-8 p-1">
										<h6 class="Name"> {{$coupone->title}} </h6>
									</div>
									<div class="col-2 p-1">
                                        @if($coupone->type == 'pre')
										<p  class="badge badge-warning"> <span>  {{$coupone->value}}</span> % </p>
                                        @else
                                            <p class="badge badge-warning"> <span>  {{$coupone->value}}</span> جنيها </p>
                                        @endif
									</div>
									<div class="col-2 p-1 text-start">
										<button class="btn btn-light color1 " data-bs-toggle="modal"
											data-bs-target="#editOffer{{$coupone->id}}"> <i class="fas fa-edit"></i> </button>
									</div>
								</div>
							</div>
                                <div class="modal fade" id="editOffer{{$coupone->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                     aria-labelledby="editOfferLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editOffer"> تعديل خصم </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('update-offer')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label">اسم الخصم </label>
                                                                <input type="hidden" value="{{$coupone->id}}" name="id">
                                                                <input type="text" class="form-control" name="title" value="{{$coupone->title}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 p-1">
                                                            <div class="mb-3">
                                                                <label class="form-label"> قيمة الخصم </label>
                                                                <input type="number" class="form-control element" name="offer_type" value="{{$coupone->value}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 p-1 one">
                                                            <label class="form-label d-block mb-3"> نوع الخصم </label>
                                                            <div class="form-check d-inline-block ">
                                                                <input class="form-check-input " {{$coupone->type =='pre'?'checked':''}} type="radio" name="offerType" id="offerType1" value="pre">
                                                                <label class="form-check-label" for="offerType1" > نسبة </label>
                                                            </div>
                                                            <div class="form-check d-inline-block ">
                                                                <input class="form-check-input" {{$coupone->type =='value'?'checked':''}} type="radio" name="offerType" id="offerType2" value="value">
                                                                <label class="form-check-label" for="offerType2"> قيمة </label>
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

                            @endforeach
						</div>
					</div>

		<div class="modal fade" id="addOffer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addOfferLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addOfferLabel"> اضافة خصم </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="{{route('create-offer')}}" method="post" enctype="multipart/form-data">
                        @csrf
						<div class="modal-body">
							<div class="row align-items-center">
								<div class="col-md-12 p-1">
									<div class="mb-3">
										<label class="form-label">اسم الخصم </label>
										<input type="text" class="form-control" name="title">
									</div>
								</div>
								<div class="col-6 p-1">
									<div class="mb-3">
										<label class="form-label"> قيمة الخصم </label>
										<input type="number" class="form-control element" name="offer_type">
									</div>
								</div>
								<div class="col-6 p-1 one">
									<label class="form-label d-block mb-3"> نوع الخصم </label>
									<div class="form-check d-inline-block ">
										<input class="form-check-input" type="radio" name="offerType" id="offerType12" value="pre">
										<label class="form-check-label" for="offerType12" > نسبة </label>
									</div>
									<div class="form-check d-inline-block ">
										<input class="form-check-input" type="radio" name="offerType" id="offerType22" value="value">
										<label class="form-check-label" for="offerType22"> قيمة </label>
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
@endsection
