<!DOCTYPE html>

<html>

@include('user/header')

<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('user/css/myapplication.css')}}" rel="stylesheet">

<body>

    <!-- Start Product Section -->
    <div class="paid-section">
     @if(Route::has('login'))

      @if(isset($pays) && isset($paid))

            @if( $paid->destination_id > 0 && $paid->destination_id != null)
              @include('user.paid')
              @include('user.paid_details') 
            @else
              @include('user.noapplication')
            @endif
      @else 
       @include('user.noapplication')
      @endif

     @endif

    </div>
    <!-- End Product Section -->


    <script>
        @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.warning("{{ session('warning') }}");
        @endif
    </script>
</body>
</html>


