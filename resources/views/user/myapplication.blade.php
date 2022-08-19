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

          @foreach($paid as $pd)
          
             @if( $pd->product_id > 0)

              @include('user.paid')
              @include('user.paid_details')
             @else

                <div class="card d-flex aligns-items-center justify-content-center text-center">
                    <div class="card-header">My Applications</div>
                    <div class="card-body">
                        <hr>
                        <img src="{{asset('user/images/noapply.svg')}}" alt="..." style="width: 200px;height: 200px;">
                        <h5 class="card-title">No Applications Yet</h5>
                        <p class="card-text">You currently have no applications to view.</p>
                        <a href="{{url('home')}}" class="btn btn-primary">START NOW</a>
                    </div>
                </div>

                @include('user.earning')
             @endif
          @endforeach
      @endif          

    </div>
    <!-- End Product Section -->

</body>

</html>