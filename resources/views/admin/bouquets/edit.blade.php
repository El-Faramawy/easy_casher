@extends('admin.layouts.layout')
@section('styles')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/datatables/dataTables.bs4-custom.css" />
    <link href="{{asset('admin')}}/vendor/datatables/buttons.bs.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/bs-select/bs-select.css" />

    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    تعديل البيانات|{{$user->name}}
@endsection

@section('page-links')
    <li class="breadcrumb-item active"> تعديل وقت انتهاء باقة|{{$user->name}}</li>
@endsection

@section('content')

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <div>
                    <h3 class="text-center">تعديل وقت انتهاء باقة| {{$user->name}}</h3>
                </div>
{{--                <div class="t-header">--}}
{{--                    <button id="checkAll" class="btn btn-info pull-left"> تحديد الكل <span class="icon-check"></span>  </button>--}}
{{--                    <button id="bulk_delete" class="btn btn-danger pull-left"> حذف الكل <span class="icon-delete"></span>  </button>--}}

{{--                </div>--}}
{{--                <div class="table-responsive">--}}

{{--                    <table id="basicExample" class="table custom-table">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>الصورة</th>--}}
{{--                            <th>الاسم</th>--}}
{{--                            <th>البريد الالكترونى</th>--}}
{{--                            <th>الحالة الحالية</th>--}}
{{--                            <th>حالة القبول</th>--}}
{{--                            <th>وقت الانتهاء</th>--}}
{{--                            <th>التحكم</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--                <form action="{{route('usersPackages.update',$user->id)}}" method="PUT">--}}
                        <form  action="{{ aurl('update_finished_at') }}" method="POST">
                            @csrf
                                   <input class="form-control" type="hidden" name="id" value="{{$user->id}}">
                                    <label>ادخل وقت انتهاء الباقة:</label>
                                    <input class="form-control" type="date" name="package_finished_at"  value="{{$user->package_finished_at}}">
                                   <input type="submit" class="btn btn-success" value="تعديل">
                        </form>
            </div>
        </div>
    </div>
    {{--Models--}}
    <div  id="admin-model" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">مستخدمو التطبيق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
{{--                <div class="modal-body" id="form-for-addOrDelete">--}}

{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">أغلق</button>--}}
{{--                    <button style="margin-right: 5px" type="submit" id="save"  form="Form" class="btn btn-primary">حفظ</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <div id="messages"></div>
    <input type="hidden" id="user_type_value" value="all">
@endsection

@section('js')

    <!-- Data Tables -->
    <script src="{{asset('admin')}}/vendor/datatables/dataTables.min.js"></script>
    <script src="{{asset('admin')}}/vendor/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Custom Data tables -->
    {{--   <script src="{{asset('admin')}}/vendor/datatables/custom/custom-datatables.js"></script>--}}
    <script src="{{asset('admin')}}/vendor/datatables/custom/fixedHeader.js"></script>
    <script src="{{asset('admin')}}/vendor/bs-select/bs-select.min.js"></script>

    <!-- Download / CSV / Copy / Print -->
    {{--    <script src="{{asset('admin')}}/vendor/datatables/buttons.min.js"></script>
        <script src="{{asset('admin')}}/vendor/datatables/jszip.min.js"></script>
        <script src="{{asset('admin')}}/vendor/datatables/pdfmake.min.js"></script>
        <script src="{{asset('admin')}}/vendor/datatables/vfs_fonts.js"></script>
        <script src="{{asset('admin')}}/vendor/datatables/html5.min.js"></script>
        <script src="{{asset('admin')}}/vendor/datatables/buttons.print.min.js"></script>--}}

@endsection
