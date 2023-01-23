<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>PWG Group</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' media='screen' href='{{asset('css/login.css')}}'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="login">
            @include('user/header')
            @if(session()->has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" style="float:right">
                    
                </button>
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('failed'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" style="float:right">
                    
                </button>
                {{ session()->get('failed') }}
            </div>
        @endif
            @yield('content')
        </div>
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
          </script>
          @stack('custom-scripts')

          @include('user/footer')
    </body>
</html>