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
                <a href="#!" class="active"> المصروفات </a>
            </li>
        </ul>
    </div>
    <!-- ================ /routeNav ================= -->
    <section class="innerPage">
        <!-- ================ slider ================= -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @forelse($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{asset('uploads/'.$slider->image)}}">
                </div>
                @empty
                    <div class="swiper-slide">
                        <img src="{{get_file('upload/image')}}">
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <!-- ================ section ================= -->
        <div class="Expenses">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addExpenses">
                <i class="fas fa-plus-octagon"></i> اضافة مصروف </button>
            <ul>
                @foreach($datas as $data)
                <li class="supplier">
                    <img src="{{url('Site')}}/images/avatar1.png">
                    <div class="info">
                        <div class="data">
                            <h6> {{$data->expense_account->display_title}} </h6>
                            <p> <i class="far fa-calendar-alt ms-2"></i> {{$data->date}} </p>
                            <span> <i class="fas fa-money-bill-wave ms-2"></i>  {{$data->total_price}} {{auth()->user()->currency}}</span>
                        </div>
                        <button class="btn btn-light color1 modal_edit" data-bs-toggle="modal"
                            data-bs-target="#editExpenses{{$data->id}}"> <i class="fas fa-edit"></i> </button>
                    </div>
                </li>


                    <!-- Modal -->
                    <div class="modal fade" id="editExpenses{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                         aria-labelledby="addExpensesLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addExpensesLabel"> تعديل مصروف </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form  method="post" action="{{route('editExpense')}}">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$data->id}}">
                                    <div class="modal-body">
                                        <div class="row align-items-end">
                                            <div class="col-8 p-1">
                                                <label class="form-label">اختر حساب </label>
                                                <select class="form-select form-select-lg" name="account_id">
                                                    @foreach($accounts as $account)
                                                        <option {{$account->id==$data->debtor_id?'selected':''}} value="{{$account->id}}">{{$account->display_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4 p-1">
                                                <button type="button" class="btn btn-primary addClintBtn"> اضف حساب </button>
                                            </div>
                                        </div>
                                        <div class=" addClintSection">
                                            <input type="text" name="name" class="form-control" placeholder=" الاسم ">
                                        </div>

                                        <div class="row  align-items-center">
                                            <h6 class="col-4 p-2"> المدفوع </h6>
                                            <div class="col-8 p-2 text-start"> <input name="total_price" value="{{$data->total_price}}" type="number" class="form-control" placeholder=" 00 ج.م "> </div>
                                        </div>

                                        <div class="row  align-items-center">
                                            <h6 class="col-4 p-2"> التاريخ </h6>
                                            <div class="col-8 p-2 text-start"> <input name="date" value="{{$data->date}}" type="date" class="form-control"> </div>
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
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addExpenses" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addExpensesLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addExpensesLabel"> اضافة مصروف </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="add_expenses" method="post" action="{{route('makeExpense')}}">
                        @csrf
						<div class="modal-body">
							<div class="row align-items-end">
								<div class="col-8 p-1">
									<label class="form-label">اختر حساب </label>
									<select class="form-select form-select-lg" name="account_id">
                                        @foreach($accounts as $account)
										<option value="{{$account->id}}">{{$account->display_title}}</option>
                                        @endforeach
									</select>
								</div>
								<div class="col-4 p-1">
									<button type="button" class="btn btn-primary addClintBtn"> اضف حساب </button>
								</div>
							</div>
							<div class=" addClintSection">
								<input type="text" name="name" class="form-control" placeholder=" الاسم ">
							</div>

							<div class="row  align-items-center">
								<h6 class="col-4 p-2"> المدفوع </h6>
								<div class="col-8 p-2 text-start"> <input name="total_price" type="number" class="form-control" placeholder=" 00 ج.م "> </div>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-4 p-2"> التاريخ </h6>
								<div class="col-8 p-2 text-start"> <input name="date" type="date" class="form-control"> </div>
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
    <div class="modal fade" id="addExpenses" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="addExpensesLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addExpensesLabel"> اضافة مصروف </h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="add_expenses" method="post" action="{{route('makeExpense')}}">
                        @csrf
						<div class="modal-body">
							<div class="row align-items-end">
								<div class="col-8 p-1">
									<label class="form-label">اختر حساب </label>
									<select class="form-select form-select-lg" name="account_id">
                                        @foreach($accounts as $account)
										<option value="{{$account->id}}">{{$account->display_title}}</option>
                                        @endforeach
									</select>
								</div>
								<div class="col-4 p-1">
									<button type="button" class="btn btn-primary addClintBtn"> اضف حساب </button>
								</div>
							</div>
							<div class=" addClintSection">
								<input type="text" name="name" class="form-control" placeholder=" الاسم ">
							</div>

							<div class="row  align-items-center">
								<h6 class="col-4 p-2"> المدفوع </h6>
								<div class="col-8 p-2 text-start"> <input name="total_price" type="number" class="form-control" placeholder=" 00 ج.م "> </div>
							</div>

							<div class="row  align-items-center">
								<h6 class="col-4 p-2"> التاريخ </h6>
								<div class="col-8 p-2 text-start"> <input name="date" type="date" class="form-control"> </div>
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

@push('site_js')

<script>
    $(document).on('submit','form#add_expenses',function(e) {
        e.preventDefault();
        var Form = $('#add_expenses')[0];
        var formData = new FormData(Form);
        var url = $('#add_expenses').attr('action');
        $.ajax({
            url:url,
            type: 'post',
            data: formData,

            success: function (data) {
                window.setTimeout(function () {
                    $('.loader').hide()
                    if (data.type == 'success') {
                        $('#addExpenses').modal("hide");
                        toastr.success("تم الاضافة بنجاح");
                        toastr.options.timeOut = 10000;
                        location.reload();
                    }
                    if (data.type == 'error') {
                        $.each(data.message, function (key, value) {
                            toastr.options.timeOut = 10000;
                            toastr.error(value);
                        });
                    }
                }, 2000);
            },
            error: function (data) {
                $('.loader').hide()
                $('#addExpenses').modal("hide");
                if (data.status === 500) {
                    toastr.options.timeOut = 10000;
                    toastr.error("هناك خطأ");
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });

</script>

@endpush
