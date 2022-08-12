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
        @stack('custom-scripts')
    </body>
</html>