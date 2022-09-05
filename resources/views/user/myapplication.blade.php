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

      @if($paid->first())

        @foreach($paid as $pd)
        @endforeach
            @if( $pd->product_id > 0 && $pd->product_id != null && $paid->first())

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
    </body>

</html>