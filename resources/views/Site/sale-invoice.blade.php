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
								<a href="#!" class="active"> فاتورة بيع </a>
							</li>
						</ul>
					</div>
					<!-- ================ /routeNav ================= -->
					<div class="innerPage">
						<div class="row ">
							<div class="col-lg-6 p-1">
								<div class="searchBox">
									<input type="text" class="form-control searchInput" placeholder=" ادخل اسم المنتج ">
									<div class="searchResult">
										<ul>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
											<li> <a href="#!"> بيبسي </a> </li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-6 p-1">
								<div class="sale">
									<div class="saleHead row">
										<h6 class=" col-6 ">الاسم</h6>
										<h6 class=" col-4 ">الكمية</h6>
										<h6 class=" col-2 ">السعر</h6>
									</div>
									<div class="Item row ">
										<p class=" col-6 "> بيبسي </p>
										<p class=" col-6  d-flex justify-content-between">
											<span class="input-counter">
												<span class="minus-btn">
													<i class="fas fa-minus-circle"></i>
												</span>
												<input readonly type="number" value="0" min="0">
												<span class="plus-btn">
													<i class="fas fa-plus-circle"></i>
												</span>
											</span>
											<span> 10 ر.س</span>
										</p>
									</div>
									<div class="Item row ">
										<p class=" col-6 "> بيبسي </p>
										<p class=" col-6  d-flex justify-content-between">
											<span class="input-counter">
												<span class="minus-btn">
													<i class="fas fa-minus-circle"></i>
												</span>
												<input readonly type="number" value="0" min="0">
												<span class="plus-btn">
													<i class="fas fa-plus-circle"></i>
												</span>
											</span>
											<span> 10 ر.س</span>
										</p>
									</div>
									<div class="Item row ">
										<p class=" col-6 "> بيبسي </p>
										<p class=" col-6  d-flex justify-content-between">
											<span class="input-counter">
												<span class="minus-btn">
													<i class="fas fa-minus-circle"></i>
												</span>
												<input readonly type="number" value="0" min="0">
												<span class="plus-btn">
													<i class="fas fa-plus-circle"></i>
												</span>
											</span>
											<span> 10 ر.س</span>
										</p>
									</div>
									<div class="Item row ">
										<p class=" col-6 "> بيبسي </p>
										<p class=" col-6  d-flex justify-content-between">
											<span class="input-counter">
												<span class="minus-btn">
													<i class="fas fa-minus-circle"></i>
												</span>
												<input readonly type="number" value="0" min="0">
												<span class="plus-btn">
													<i class="fas fa-plus-circle"></i>
												</span>
											</span>
											<span> 10 ر.س</span>
										</p>
									</div>
									<div class="Item row ">
										<p class=" col-6 "> بيبسي </p>
										<p class=" col-6  d-flex justify-content-between">
											<span class="input-counter">
												<span class="minus-btn">
													<i class="fas fa-minus-circle"></i>
												</span>
												<input readonly type="number" value="0" min="0">
												<span class="plus-btn">
													<i class="fas fa-plus-circle"></i>
												</span>
											</span>
											<span> 10 ر.س</span>
										</p>
									</div>
								</div>

								<div class="controlBtns">
									<h5 class="totalPrice"> <span>70</span> ر.س </h5>
									<button class="btn btn-success " data-bs-toggle="modal" data-bs-target="#SaleModal">
										حفظ </button>
									<button class="btn btn-outline-secondary "> حذف</button>
								</div>
							</div>
						</div>
					</div>

		<!-- Modal -->
		<div class="modal fade" id="SaleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="SaleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg  modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="SaleModalLabel"> فاتورة بيع </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form>
						<div class="modal-body">







							<div class="row align-items-end">
								<div class="col-8 p-1">

									<label class="form-label">اختر عميل </label>
									<select class="form-select form-select-lg">
										<option value="1">One</option>
										<option value="2">Two</option>
										<option value="3">Three</option>
									</select>

								</div>
								<div class="col-4 p-1">
									<button type="button" class="btn btn-primary addClintBtn"> اضف عميل </button>
								</div>
							</div>


							<div class="row addClintSection">

								<div class=" col-md-6 p-1">
									<input type="text" class="form-control" placeholder=" الاسم ">
								</div>
								<div class=" col-md-6 p-1">
									<input type="text" class="form-control" placeholder=" البريد الالكتروني ">
								</div>
								<div class=" col-md-6 p-1">
									<input type="text" class="form-control" placeholder=" رقم الهاتف ">
								</div>
								<div class=" col-md-6 p-1">
									<input type="text" class="form-control" placeholder=" العنوان ">
								</div>

							</div>


							<div class=" p-2">
								<label class="form-label">اضف قيمة الخصم </label>
								<select class="form-select form-select-lg">
									<option value="1">One</option>
									<option value="2">Two</option>
									<option value="3">Three</option>
								</select>
							</div>


							<hr>
							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> اجمالي الفاتورة </h6>
								<h6 class="col-4 p-2 text-start"> 70 ج.م </h6>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> قسمة الضريبة المضافة </h6>
								<h6 class="col-4 p-2 text-start"> 70 ج.م </h6>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> الخصم </h6>
								<h6 class="col-4 p-2 text-start"> 10 ج.م </h6>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> المدفوع </h6>
								<div class="col-4 p-2 text-start"> <input type="text" class="form-control"
										style="min-height: 35px;" placeholder=" مدفوع "> </div>
							</div>
							<hr>

							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> المتبقي </h6>
								<h6 class="col-4 p-2 text-start"> 10 ج.م </h6>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-8 p-2"> التاريخ </h6>
								<h6 class="col-4 p-2 text-start"> 10 / 10 / 2020 </h6>
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


		<!-- Modal -->
		<div class="modal fade" id="clintModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="clintModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clintModalLabel"> اضافة منتج </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form>
						<div class="modal-body">

							<div class="mb-3">
								<label class="form-label">اضف قيمة الخصم </label>
								<select class="form-select form-select-lg">
									<option value="1">One</option>
									<option value="2">Two</option>
									<option value="3">Three</option>
								</select>
							</div>

							<div class="mb-3">
								<label class="form-label">المدفوع </label>
								<input type="text" class="form-control">
							</div>

							<div class="row align-items-end">
								<div class="col-8 p-1">

									<label class="form-label">اختر عميل </label>
									<select class="form-select form-select-lg">
										<option value="1">One</option>
										<option value="2">Two</option>
										<option value="3">Three</option>
									</select>

								</div>
								<div class="col-4 p-1">
									<button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#SaleModal">
										اضف عميل </button>
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
