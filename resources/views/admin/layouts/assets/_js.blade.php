<!-- *************
    ************ Required JavaScript Files *************
************* -->
<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="{{asset('admin')}}/js/jquery.min.js"></script>
<script src="{{asset('admin')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('admin')}}/js/moment.js"></script>


<!-- *************
    ************ Vendor Js Files *************
************* -->
<!-- Slimscroll JS -->
<script src="{{asset('admin')}}/vendor/slimscroll/slimscroll.min.js"></script>
<script src="{{asset('admin')}}/vendor/slimscroll/custom-scrollbar.js"></script>

<!-- Daterange -->
<script src="{{asset('admin')}}/vendor/daterange/daterange.js"></script>
<script src="{{asset('admin')}}/vendor/daterange/custom-daterange.js"></script>
<script src="{{asset('admin/js/dropify.js')}}"></script>

<script>
    $('.dropify').dropify();
</script>

<script src="{{asset('admin')}}/js/jquery.easing.1.3.js"></script>
<script src="{{asset('admin')}}/vendor/notify/notify.js"></script>
<!-- Main Js Required -->
<script src="{{asset('admin')}}/js/main.js"></script>
<!-- End custom js for this page -->
<script src="{{asset('admin/validation/jquery.form-validator.js')}}"></script>
<script src="{{asset('admin/validation/toastr.min.js')}}"></script>
<script src="{{asset('admin/axios.min.js')}}"></script>
<script src="{{asset('admin/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admin/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script>
    function myToast(heading, text, position, loaderBg, icon, hideAfter, stack) {
        "use strict";
        $.toast({
            heading: heading,
            text: text,
            position: position,
            loaderBg: loaderBg,
            icon: icon,
            hideAfter: hideAfter,
            stack: stack
        });
    }
    //for input number validation
    $(document).on('keyup','.numbersOnly',function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $.validate({

    });
</script>
