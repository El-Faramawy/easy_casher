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
    طلبات التجار الجديدة
@endsection

@section('page-links')
    <li class="breadcrumb-item active">طلبات التجار الجديدة</li>
@endsection

@section('content')

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-container">
                <div class="t-header">
                    <button id="checkAll" class="btn btn-info pull-left"> تحديد الكل <span class="icon-check"></span>  </button>
                    <button id="bulk_delete" class="btn btn-danger pull-left"> حذف الكل <span class="icon-delete"></span>  </button>
                  {{--  <button id="All" class="btn btn-primary pull-left"> كل المستخدم <span class="icon-users"></span>  </button>
                    <button id="all_users" class="btn btn-warning pull-left"> كل العملاء <span class="icon-data_usage"></span>  </button>
                    <button id="all_expert" class="btn btn-dark pull-left"> كل الخبراء <span class="icon-verified_user"></span>  </button>
             --}}   </div>
                <div class="table-responsive">

                    <table id="basicExample" class="table custom-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>رقم الجوال</th>
                            <th>الحالة</th>
                            <th>وقت الإضافة</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--Models--}}
    <div id="messages"></div>
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
        //========================================================================
        //========================================================================
        //========================================================================
        //========================================================================
        //datatable
        var table =$("#basicExample").DataTable({
            dom: 'Bfrtip',
            responsive: 1,
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 10,
            "ajax": "{{route('newUsers.index')}}",

            "columns": [
                {"data": "delete_all", orderable: false, searchable: false},
                {"data": "logo",   orderable: false,searchable: true},
                {"data": "name",   orderable: false,searchable: true},
                {"data": "phone",   orderable: false,searchable: false},
                {"data": "status",   orderable: false,searchable: false},
                {"data": "created_at", searchable: false},
                {"data": "actions", orderable: false, searchable: false}
            ],
            "language": {
                "sProcessing":   "{{trans('admin.sProcessing')}}",
                "sLengthMenu":   "{{trans('admin.sLengthMenu')}}",
                "sZeroRecords":  "{{trans('admin.sZeroRecords')}}",
                "sInfo":         "{{trans('admin.sInfo')}}",
                "sInfoEmpty":    "{{trans('admin.sInfoEmpty')}}",
                "sInfoFiltered": "{{trans('admin.sInfoFiltered')}}",
                "sInfoPostFix":  "",
                "sSearch":       "{{trans('admin.sSearch')}}:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "{{trans('admin.sFirst')}}",
                    "sPrevious": "{{trans('admin.sPrevious')}}",
                    "sNext":     "{{trans('admin.sNext')}}",
                    "sLast":     "{{trans('admin.sLast')}}"
                }
            },
            order: [
                [2, "desc"]
            ],
        })

        //========================================================================
        //========================================================================
        //============================change status======================================
        //========================================================================
        // ========================================================================

        $(document).on('click', '.status', function () {
            var id = $(this).attr('id');
            var status = $(this).attr('attr_type');
            swal({
                title: "هل أنت متأكد من ذلك ؟",
                text: "اضغط موافق ....",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("newUsers.changeStatus", ":id") }}?status='+status;
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {id: id},
                    success: function (data) {
                        swal.close()
                        myToast('بنجاح', 'تم الأمر بنجاح', 'top-left', '#ff6849', 'success',4000, 2);
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();
                    },error: function(data) {
                        swal.close()
                        messages.show("لا تملك الصلاحية للحذف", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }

                });
            });
        });

        //delete one row
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            swal({
                title: "هل أنت متأكد من الحذف؟",
                text: "لا يمكنك التراجع بعد ذلك؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("newUsers.destroy", ":id") }}';
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {id: id},
                    success: function (data) {
                        swal.close()
                        myToast('بنجاح', 'تم الأمر بنجاح', 'top-left', '#ff6849', 'success',4000, 2);
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();
                    },error: function(data) {
                        swal.close()
                        messages.show("لا تملك الصلاحية للحذف", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }

                });
            });
        });
        //delete multi rows
        $(document).on('click', '#checkAll', function () {
            var check=true;
            $('.delete-all:checked').each(function () {
                check=false;
            });

            $('.delete-all').prop('checked', check);
        });

        $(document).on('click', '#bulk_delete', function () {
            var id = [];
            $('.delete-all:checked').each(function () {
                id.push($(this).attr('id'));
            });
            if (id.length > 0) {
                swal({
                    title: "هل انت متاكد انك تريد حذف هذه البيانات؟",
                    text: "لن يمكنك استعادة هذه البيانات بعد الحذف.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "حذف البيانات",
                    cancelButtonText: "الغاء",
                    okButtonText: "موافق",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: '{{route('newUsers.delete.bulk')}}',
                        type: 'DELETE',
                        data: {id: id},
                        success: function (data) {
                            swal.close()
                            messages.show("تمت العملية بنجاح..", {
                                type: 'success',
                                title: '',
                                icon: '<i class="jq-icon-success"></i>',
                                delay:2000,
                            });
                            $('#basicExample').DataTable().ajax.reload();
                            if (data.error.length > 0) {
                                myToast('لم تتم العملية', data.error, 'buttom-left', '#ff6849', 'error', 3500, 6);
                            } else {
                                myToast('عملية ناجحة', data.success, 'buttom-left', '#ff6849', 'success', 3500, 6);
                            }
                        },error: function(data) {
                            swal.close()
                            messages.show("لا تملك الصلاحية للحذف", {
                                type: 'warning',
                                title: '',
                                icon: '<i class="icon-error"></i>',
                                delay:2000,
                            });
                        }
                    });
                });
            } else {
                swal({
                    title: "لم تتم العملية",
                    text: "برجاء تحديد  المراد حذفه اولا.",
                    type: "error",
                    confirmButtonText: "موافق"
                });
            }
        });

    </script>
@endsection
