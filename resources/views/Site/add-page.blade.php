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
								<a href="#!" class="active"> اضافة </a>
							</li>
						</ul>
					</div>

					<!-- ================ /routeNav ================= -->

					<div class="addPage">
						<div class="row">
							<div class="col-md-4 col-sm-6 p-2">
								<a href="{{url('add-sections')}}" class="addType">
									<i class="fas fa-layer-group"></i>
									<h4>الاقسام</h4>
								</a>
							</div>
							<div class="col-md-4 col-sm-6 p-2">
								<a href="{{url('add-products')}}" class="addType">
									<i class="fas fa-box-full"></i>
									<h4>منتجات </h4>
								</a>
							</div>
							<div class="col-md-4 col-sm-6 p-2">
								<a href="{{url('add-offer')}}" class="addType">
									<i class="fas fa-badge-percent"></i>
									<h4>خصومات</h4>
								</a>
							</div>
						</div>

					</div>

@endsection
