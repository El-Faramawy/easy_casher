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
    كل مشتركى التطبيق
@endsection

@section('page-links')
    <li class="breadcrumb-item active"> كل مشتركى التطبيق</li>
@endsection

@section('content')

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-container">
                <div class="t-header">
                    <button id="checkAll" class="btn btn-info pull-left"> تحديد الكل <span class="icon-check"></span>  </button>
                    <button id="bulk_delete" class="btn btn-danger pull-left"> حذف الكل <span class="icon-delete"></span>  </button>

                </div>
                <div class="table-responsive">

                    <table id="basicExample" class="table custom-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>البريد الالكترونى</th>
                            <th>الحالة الحالية</th>
                            <th>حالة القبول</th>
                            <th>وقت الانتهاء</th>
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
    <div  id="admin-model" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">مستخدمو التطبيق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form-for-addOrDelete">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">أغلق</button>
                    <button style="margin-right: 5px" type="submit" id="save"  form="Form" class="btn btn-primary">حفظ</button>
                </div>
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
        dataTable('all')
        function dataTable(userType){
            if ($.fn.DataTable.isDataTable('#basicExample')) {
                $('#basicExample').dataTable().fnClearTable();
                $('#basicExample').dataTable().fnDestroy();
            }
            $("#basicExample").DataTable({
                dom: 'Bfrtip',
                responsive: 1,
                "processing": true,
                "lengthChange": true,
                "serverSide": true,
                "ordering": true,
                "searching": true,
                'iDisplayLength': 20,
                "ajax": "{{route('usersPackages.index')}}",

                "columns": [
                    {"data": "delete_all", orderable: false, searchable: false},
                    {"data": "logo", orderable: false, searchable: false},
                    {"data": "name",   orderable: false,searchable: true},
                    {"data": "email",   orderable: false,searchable: false},
                    {"data": "is_block",   orderable: false,searchable: false},
                    {"data": "is_confirmed",   orderable: false,searchable: false},
                    {"data": "package_finished_at", searchable: false},
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
        }

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
            },
                function () {
                var url = '{{ route("users.changeBlock", ":id") }}'
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
        //========================================================================
        //========================================================================
        //============================Delete======================================
        //========================================================================
        //edit one row
        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            swal({
                title: "هل أنت متأكد من التعديل؟",
                // text: "لا يمكنك التراجع بعد ذلك؟",
                type: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("usersPackages.edit", ":id") }}';
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {id: id},
                    success: function () {
                        return location.href = url;
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
                        url: '{{route('users.delete.bulk')}}',
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
                            // $('#basicExample').DataTable().ajax.reload();
                            dataTable( $('#user_type_value').val())
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
        /*======================================*/
        // $('#select-user-type').change(function (e) {
        //     var user_type = $(this).val()
        //     $('#user_type_value').val(user_type)
        //     dataTable(user_type)
        // })


    </script>
@endsection
