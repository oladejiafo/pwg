<!DOCTYPE html>
<html>
    @include('user/header')

<body>
    <div class="login">
        @yield('content')
    </div>
    <!--  load jQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--load JS for Select2 -->    
    @stack('custom-scripts')
</body>
</html>