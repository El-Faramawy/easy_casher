<script src="{{url('Site')}}/js/vendors.min.js"></script>
<script src="{{url('Site')}}/js/template.js"></script>
<script src="{{url('Site')}}/js/fontawesome-pro.js"></script>
<script src="{{url('Site')}}/js/swiper.js"></script>
<script src="{{url('Site')}}/js/Custom.js"></script>
<script src="{{url('Site')}}/js/dropify.min.js"></script>

@stack('site_js')
{{--===================  toster ==============================--}}
<script src="{{url('Site/js')}}/tostar.js"></script>

<script>

    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}"
    switch(type){
        case 'info':

            toastr.options.timeOut = 10000;
            toastr.info("{{Session::get('message')}}");
            break;
        case 'success':

            toastr.options.timeOut = 10000;
            toastr.success("{{Session::get('message')}}");
            break;
        case 'warning':

            toastr.options.timeOut = 10000;
            toastr.warning("{{Session::get('message')}}");
            break;
        case 'error':

            toastr.options.timeOut = 10000;
            toastr.error("{{Session::get('message')}}");
            break;
    }
    @endif
</script>

{{--//===============  Ali =================================--}}
@stack('site.js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/dropzone.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.dropify').dropify();
    });//end jquery
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.file_upload').imageuploadify();
    })
</script>


<script>
    $(function () {
        $('.selectpicker').selectpicker();
    });
</script>
<script>
    $(document).ready(function () {

        $('#viewType1').change(function() {
            if ($(this).prop('checked') == true) {
                $(".selectColor").slideDown('slow');
                $(".selectImg").slideUp('fast');
            }
        });

        $('#viewType2').change(function() {
            if ($(this).prop('checked') == true) {
                $(".selectImg").slideDown('slow');
                $(".selectColor").slideUp('fast');
            }
        });
        $('#viewType12').change(function() {
            if ($(this).prop('checked') == true) {
                $(".selectColor").slideDown('slow');
                $(".selectImg").slideUp('fast');
            }
        });

        $('#viewType22').change(function() {
            if ($(this).prop('checked') == true) {
                $(".selectImg").slideDown('slow');
                $(".selectColor").slideUp('fast');
            }
        });


        $('#stockType1').change(function() {
            if ($(this).prop('checked') == true) {
                $(".inStock").slideDown('slow');
            }
        });

        $('#stockType2').change(function() {
            if ($(this).prop('checked') == true) {
                $(".inStock").slideUp('fast');
            }
        });
        $('#stockType12').change(function() {
            if ($(this).prop('checked') == true) {
                $(".inStock").slideDown('slow');
            }
        });

        $('#stockType22').change(function() {
            if ($(this).prop('checked') == true) {
                $(".inStock").slideUp('fast');
            }
        });


        $('.searchInput').click(function() {

            $(".searchResult").slideDown('slow');

        });

        $('.addClintBtn').click(function() {

            $(".addClintSection").addClass('addClintSectionOpen');

        });


    });

</script>
{{--======================= end dropyfi========================--}}
