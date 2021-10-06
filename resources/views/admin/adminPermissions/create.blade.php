@extends('admin.layouts.layout')
@section('styles')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/summernote/summernote-bs4.css" />
    <link href="{{asset('admin/image_uploader/image-uploader.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/bs-select/bs-select.css" />


    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    اضافة صلاحيات للمشرفين
@endsection

@section('page-links')
    <li class="breadcrumb-item ">
        <a href="{{route('adminPermissions.index')}}">صلاحيات المشرفين</a>
    </li>
    <li class="breadcrumb-item active"> اضافة صلاحيات للمشرفين</li>
@endsection

@section('content')

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <a href="{{route('adminPermissions.index')}}" class="btn btn-success pull-left"> عودة <span class="icon-keyboard_return"></span>  </a>

        </div>
        <div id="form-for-addOrDelete" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
            <form action="{{route('adminPermissions.store')}}" method="post" id="Form"  enctype="multipart/form-data">
                @csrf
                <div class="alert alert-primary" role="alert">
                    <h6 class="text-center mb-1">إضافة صلاحيات لمشرف جديد</h6>
                </div>

                {{--form--}}
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="user_id"></label>
                            <select  data-validation="required" name="user_id" id="user_id" class="form-control selectpicker my-select" data-live-search="true">
                                @foreach($admins as $admin)
                                    <option {{$loop->first?'selected':''}} value="{{$admin->id}}">{{$admin->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div  class="form-group displayIfPermissionExist col-lg-12 col-md-12 col-sm-12 col-12">
                        <h4 class="text-center text-danger">اختر الصلاحيات التى تريد اعطائها لهذا المستخدم</h4>
                    </div>

                    <div class="col-12 mb-2 mt-2">
                        <span style="cursor: pointer" id="checkAll"  att_class="permission_class" class="btn btn-info check_permission_button">اختر كل الصلاحيات</span>
                    </div>

                    @php
                        $catArray=[];
                    @endphp
                    <div class="row" id="permission_div">
                        @foreach($permissions as $permission )
                            @if(!in_array($permission->type_name,$catArray))
                                @php
                                    array_push($catArray,$permission->type_name)
                                @endphp
                                <br>
                                <div class="col-12 mt-3 mb-3"  >
                                    <h3 class="">صلاحيات قسم {{$permission->type_name}}</h3>
                                    <span style="cursor: pointer" att_class="{{$permission->class_name}}"  class="btn btn-danger check_permission_button">اختر كل صلاحيات قسم {{$permission->type_name}}</span>
                                </div>

                            @endif

                            <div class="col-4">
                                <div class="form-group">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" name="permissions[]" value="{{$permission->id}}" class=" permission_class {{$permission->class_name}}"/>
                                        <span></span>
                                        {{$permission->ar_name?$permission->ar_name:$permission->name}}
                                    </label>

                                    {{--                                            <div class="form-check">--}}
                                    {{--                                                <input type="checkbox" name="permissions[]" value="{{$permission->id}}" class=" form-check-input permission_class {{$permission->class_name}}">--}}
                                    {{--                                                <label class="form-check-label">{{$permission->ar_name?$permission->ar_name:$permission->name}}</label>--}}
                                    {{--                                            </div>--}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <button style="margin-right: 5px" type="submit" id="save"  class="btn btn-primary">حفظ</button>
                {{--form--}}
            </form>

        </div>


    </div>
    {{--Models--}}


    <div id="messages"></div>
@endsection

@section('js')

    <script src="{{asset('admin')}}/vendor/summernote/summernote-bs4.js"></script>
    <script src="{{asset('admin/image_uploader/image-uploader.min.js')}}"></script>
    <script src="{{asset('admin')}}/vendor/bs-select/bs-select.min.js"></script>

    <script>
        //loader in js
        var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;
        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

    </script>
    <script>
        $(document).on('click', '.check_permission_button', function () {
            var op = $(this)
            var class_name = '.'+op.attr('att_class');
            var class_name_check = '.'+op.attr('att_class')+':checked';
            var check=true;
            $(class_name_check).each(function () {
                check=false;
            });
            $(class_name).prop('checked', check);
        });

        $(document).ready(function () {
            $('form').submit( function() {
                if ($('input.permission_class:checked').length < 1) {
                    myToast('اختر على الأقل صلاحية واحدة', 'تنبيه', 'buttom-left', '#ff6849', 'error', 3500, 6);
                    return false;
                }
            });

        });
    </script>

@endsection
