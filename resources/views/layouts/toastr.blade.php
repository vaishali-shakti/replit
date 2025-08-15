<script>
    @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
    function toastr_success(message){
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success(message);
    }
    function toastr_error(message){
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.error(message);
    }
    function toastr_info(message){
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.info(message);
    }
    function toastr_warning(message){
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.warning(message);
    }
  </script>
