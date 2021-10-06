@extends('Site.Layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 m-auto p-2">
            <a href="{{url('add-page')}}" class=" category gradientBG ">
                <img src="{{url('Site')}}/images/add.png">
                <h4> اضافة منتج </h4>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="{{url('sale-invoice')}}" class=" category ">
                <img src="{{url('Site')}}/images/sell.jpg">
                <h4> فاتورة بيع </h4>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="{{url('receipt')}}" class=" category ">
                <img src="{{url('Site')}}/images/buy.jpg">
                <h4> فاتورة شراء </h4>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="#!" class=" category ">
                <img src="{{url('Site')}}/images/market.jpg">
                <h4> الموردين </h4>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="#!" class=" category ">
                <img src="{{url('Site')}}/images/customer.jpg">
                <h4> العملاء </h4>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="#!" class=" category ">
                <img src="{{url('Site')}}/images/expenses.jpg">
                <h4> المصروفات</h4>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-6  p-2">
            <a href="#!" class=" category ">
                <img src="{{url('Site')}}/images/reports.jpg">
                <h4> الاستعلامات والتقارير </h4>
            </a>
        </div>
    </div>
@endsection
