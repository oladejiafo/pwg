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
    @stack('custom-scripts')
</body>
</html>