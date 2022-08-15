<!DOCTYPE html>

<html>

@include('user/header')

<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    body {
        /* background-color: #fcfcfc; */
        background-color: #F6F7FB;
    }
    .earn .p {
        padding-top: 100px;
        vertical-align: middle;
        width: 100%;
        justify-content: center;
    }

    .card {
        font-family: 'TT Norms Pro';
        font-weight: bold;
        font-style: normal;

        margin-left: 50px;
        margin-right: 50px;
    }
    .card .card-header {
        padding: 10px;
        height: 70px;
        font-size: 30px;
    }
    .card .card-body {
        padding: 30px 80px 30px 50px;
        height: auto;
        min-height: 200px;
        font-size: 20px;
    }
    .card .card-body img {
        padding-block: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .card .card-body h5 {
        font-weight: bold;
        font-size: 26px;
        line-height: 25px;
    }

    .card .card-body a {
        font-weight: bold;
        font-size: 30px;
        width:250px;
        height: 50px;
        padding-top: 1px;
        padding-bottom: 1px;
        color: #000;
        background-color: none;

    }

@media (min-width:375px) and (max-width:678px){
    .card {
        margin-left: 20px;
        margin-right: 20px;
    }
    .card .card-header {
        padding: 10px;
        height: 50px;
        font-size: 30px;
    }
    .card .card-body {
        padding: 1px 1px 1px 1px;
        height: auto;
        max-height: 560px;
        font-size: 20px;
    }
    .card .card-body img {
        padding-block: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
    }

}    
</style>

<body>

    <!-- Start Product Section -->
    <div class="paid-section">

     @if(Route::has('login'))

          @foreach($paid as $pd)
          
             @if( $pd->product_payment_id > 0)

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