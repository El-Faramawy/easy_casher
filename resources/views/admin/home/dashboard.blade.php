@extends('admin.layouts.layout')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

@endsection

@section('page-title')
    معلومات عامة
@endsection

@section('page-links')
@endsection

@section('content')


    {{--        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header">--}}
    {{--                    <div class="card-title">اخر المنضمين</div>--}}
    {{--                </div>--}}
    {{--                <div class="card-body">--}}
    {{--                    <div class="customScroll5">--}}
    {{--                        <ul class="user-messages">--}}
    {{--                                @if ($last_users->count() > 0)--}}
    {{--                                @foreach($last_users as $last_user)--}}
    {{--                                    <li class="clearfix">--}}
    {{--                                        <a href="{{route('users.show',$last_user->id)}}">--}}
    {{--                                            <div class="customer" style="background-color: {{$colors[array_rand($colors)]}};">{{substr($last_user->name,0,1)}}</div>--}}
    {{--                                            <div class="delivery-details">--}}
    {{--                                    <span class="badge badge-success">--}}
    {{--                                         @if ($last_user->user_type == 'client')--}}
    {{--                                            عميل--}}
    {{--                                        @elseif($last_user->user_type == 'family')--}}
    {{--                                             أسرة منتجة--}}
    {{--                                        @elseif($last_user->user_type == 'driver')--}}
    {{--                                             مندوب--}}
    {{--                                        @endif--}}
    {{--                                    </span>--}}
    {{--                                                <h4>{{$last_user->phone}} -({{$last_user->phone_code}})</h4>--}}
    {{--                                                <h5>{{$last_user->created_at->diffForHumans()}}</h5>--}}
    {{--                                            </div>--}}
    {{--                                        </a>--}}
    {{--                                    </li>--}}
    {{--                                @endforeach--}}
    {{--                                @else--}}
    {{--                                    <li class="clearfix">--}}
    {{--                                        <a>--}}
    {{--                                            <div class="customer">C</div>--}}
    {{--                                            <div class="delivery-details">--}}
    {{--                                            <span class="badge badge-primary">--}}
    {{--                                               لا يوجد منضمين حتى الآن--}}
    {{--                                            </span>--}}
    {{--                                            </div>--}}
    {{--                                        </a>--}}
    {{--                                    </li>--}}
    {{--                                @endif--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}

{{--    <div class="row gutters">--}}
{{--        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <div class="card-title">اخر الطلبات</div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="customScroll5">--}}
{{--                        <ul class="user-messages">--}}
{{--                            @if ($last_orders->count() > 0)--}}
{{--                                @foreach($last_orders as $last_order)--}}
{{--                                    <li class="clearfix">--}}
{{--                                        <a href="{{route('orders.show',$last_order->id)}}">--}}
{{--                                            <div class="customer" style="background-color: {{$colors[array_rand($colors)]}};">{{$last_order->client?substr($last_order->client->name,0,1):''}}</div>--}}
{{--                                            <div class="delivery-details">--}}
{{--                                                <span class="badge badge-warning">--}}
{{--                                                     @if ($last_order->order_type == 'family')--}}
{{--                                                        أسرة منتجة--}}
{{--                                                    @elseif ($last_order->order_type == 'package')--}}
{{--                                                         طرد--}}
{{--                                                     @elseif ($last_order->order_type == 'google')--}}
{{--                                                        جوجل--}}
{{--                                                    @endif--}}
{{--                                                </span>--}}
{{--                                                <h4>{{$last_order->bill_cost}}</h4>--}}
{{--                                                <h5>{{$last_order->created_at->diffForHumans()}}</h5>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                                <li class="clearfix">--}}
{{--                                    <a>--}}
{{--                                        <div class="customer">C</div>--}}
{{--                                        <div class="delivery-details">--}}
{{--                                            <span class="badge badge-primary">--}}
{{--                                               لا يوجد طلبات حتى الآن--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}



{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}



{{--        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <div class="card-title">اخر المنتجات</div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="customScroll5">--}}
{{--                        <ul class="user-messages" >--}}
{{--                            @if ($last_products->count() > 0)--}}
{{--                                @foreach($last_products as $last_product)--}}
{{--                                    <li class="clearfix">--}}
{{--                                        <a href="{{route('products.show',$last_product->id)}}">--}}
{{--                                            <div class="customer" style="background-color: {{$colors[array_rand($colors)]}};">{{$last_product->family?substr($last_product->family->name,0,1):''}}</div>--}}
{{--                                            <div class="delivery-details">--}}
{{--                                                <span class="badge" style="background-color: {{$colors[array_rand($colors)]}};" >{{$last_product->sub_category?$last_product->sub_category->title:''}}</span>--}}
{{--                                                <h4>{{$last_product->title}}</h4>--}}
{{--                                                <h4>{{$last_product->family?$last_product->family->phone:''}} -({{$last_product->family?$last_product->family->phone_code:''}})</h4>--}}
{{--                                                <h5>{{$last_product->created_at->diffForHumans()}}</h5>--}}
{{--                                            </div>--}}

{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                                <li class="clearfix">--}}
{{--                                    <a>--}}
{{--                                        <div class="customer">C</div>--}}
{{--                                        <div class="delivery-details">--}}
{{--                                            <span class="badge badge-primary">--}}
{{--                                               لا يوجد منتجات مضافة حتى الآن--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


@endsection

@section('js')

@endsection
