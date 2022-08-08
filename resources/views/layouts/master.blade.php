<!DOCTYPE html>
<html>
    @include('user/header')

<body>
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
    <div class="login">
        @yield('content')
    </div>
    <!--  load jQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--load JS for Select2 -->    
    @stack('custom-scripts')
</body>
</html>