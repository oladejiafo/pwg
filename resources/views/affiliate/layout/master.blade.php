<!DOCTYPE html>
<html lang="en">
    @include('affiliate.layout.header')
    <body>
        @yield('content')
        @stack('affiliate-scripts')
    </body>
</html>