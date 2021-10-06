@extends('admin.layouts.layout')
@section('styles')

@endsection

@section('page-title')
    تفاصيل اشعار
@endsection

@section('page-links')
    <li class="breadcrumb-item ">
        <a href="{{route('notifications.index')}}">كل الإشعارت</a>
    </li>
    <li class="breadcrumb-item active"> تفاصيل اشعار</li>
@endsection

@section('content')

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
           <div class="alert alert-info">
               <h5 class="text-center"> تفاصيل الإشعار</h5>
               <a  class="btn-warning btn" style="margin-right: 10px; font-weight: bold; color: white" href="{{route('notifications.index')}}"> عودة </a>
           </div>
            <div class="blog">
                <img class="blog-img" height="140px" src="{{asset('admin/img/notification-success.svg')}}" alt="Card image cap">
                <div class="blog-body">
                    <h2 class="blog-title">{{$notification->user->name}} -({{$notification->user->phone_code}}) {{$notification->user->phone}}</h2>
                    <h6 class="blog-date">
                        <span class="category">{{$notification->ar_title}}</span>
                        <span class="divider">/</span>
                        <span class="date">{{$notification->created_at->diffForHumans()}}</span>
                    </h6>
                    <div class="blog-description">
                        <p>{{$notification->ar_desc}}</p>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div id="messages"></div>
@endsection

@section('js')



@endsection
