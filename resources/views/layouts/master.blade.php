<!DOCTYPE html>
<html>
@include('user/header')
<body>
    <div class="login">
        @yield('content')
    </div>
    @stack('custom-scripts')
</body>
</html>