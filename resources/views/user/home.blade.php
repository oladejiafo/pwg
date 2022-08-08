<!DOCTYPE html>

<html>

@include('user/header')


<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    .banner_bg {
        background-image: url(../user/images/v1_17125.png);
    }

    #headerBtn {
  width: 350px;

}

.home_img {
  height: auto;
  /* width: auto;  */
  width: 546px;
  max-height: 451px;
}

.banner_bg {
  width: 100%;
  float: left;
  /* background-image: url(../user/images/v1_17125.png); */
  height: auto;
  background-size: 100%;
  background-repeat: no-repeat;
}

#headerTitle {
  font-family: 'TT Norms Pro Black';
  font-weight: 900;
  font-size: 60px;
  font-style: normal;
}

#headerText {
  font-family: 'TT Norms Pro Regular';
  font-weight: bold;
  font-size: 28px;
  font-style: normal;
  color: #fff;
  text-transform: lowercase;
}

#headerText:first-letter {
  text-transform: uppercase;
}

#headerBtn {
  font-family: 'TT Norms Pro Bold';
  font-weight: bold;
  font-size: 32px;
  font-style: normal;
  color: #fff;
  border-radius: 10px;
}

.cellContainer {
  width: 546px;
  margin: auto;
}

.earn .p {
  padding-top: 100px;
  vertical-align: middle;
  width: 100%;
  justify-content: center;
}

::-webkit-scrollbar {
  overflow-y: hidden;
  width: 15px;
}

::-webkit-scrollbar-button:single-button {
  background: #ccc;

  display: block;

  overflow-y: hidden;

  background: url('user/images/Forward.svg');
}

::-webkit-scrollbar-button:single-button:horizontal:decrement {
  border-width: 0 8px 8px 8px;
  border-color: transparent transparent #555555 transparent;
}

::-webkit-scrollbar-track-piece {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  -webkit-border-radius: 10px;
  border-radius: 10px;
  background: url('http://cdn.css-tricks.com/wp-content/themes/CSS-Tricks-10/images/header-demos.jpg');
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
  background: transparent;
  overflow-y: hidden;
}

</style>

<body>

@if(Route::has('login'))
        @auth
        @else
    <!-- Start Hero Section -->
    <div class="hero banner_bg layer">

        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-md-12">
                    <div class="intro-excerpt">
                        <h1 id="headerTitle">Your Migration Journey Starts Here</h1>
                        <p id="headerText" class="mb-4">Get your Europe & Canada Visa from any part of the world.</p>
                        <p><a href="{{route('login')}}" id="headerBtn" class="btn btn-hero">START NOW</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Hero Section -->
@endauth 
@endif

    <!-- Start Product Section -->
    <div class="product-section">

        @if(Route::has('login'))
        @auth

        <div class="outer">
            <div class="container-fluid text-center" style="padding-left:50px; padding-right:50px">

                <div class="row">
                    <ul>
                        @foreach($package as $offer)
                        <!-- Start Column  -->
                        <li>
                            <div class="col-4 cellContainer">
                                <span class="product-item" href="#">
                                    <span class="positionAnchor">
                                        <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img">
                                        <span class="bottom">
                                            <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{$offer->product_name}}</h3>
                                            <p style="font-size:20px">{{$offer->slogan}}</p>
                                        </span>
                                        <strong class="product-price">{{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong>
                                        <p><i class="fa fa-minus-circle" style='color: white'></i>{{$offer->discount}}% lower than last month</p>

                                        <p><a class="btn btn-secondary" href="{{ url('product', $offer->id) }}">Buy Now</a></p>

                                    </span>
                                </span>
                            </div>
                        </li>
                        <!-- End Column  -->
                        @endforeach
                    </ul>

                </div>

            </div>
        </div>
        @include('user.earning')

        @else

        <div class="container-fluid text-center" style="padding-left:50px; padding-right:50px">

            <div class="row">
                @foreach($package as $offer)
                <!-- Start Column  -->
                <div class="col-4 cellContainer">
                    <span class="product-item" href="#">
                        <span class="positionAnchor">
                            <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img">
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{$offer->product_name}}</h3>
                                <p style="font-size:20px">{{$offer->slogan}}</p>
                            </span>
                            <strong class="product-price">{{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong>
                            <p><i class="fa fa-minus-circle" style='color: white'></i>{{$offer->discount}}% lower than last month</p>

                            <p><a class="btn btn-secondary buy_now" href="{{ url('product', $offer->id) }}">Buy Now</a></p>

                        </span>
                    </span>
                </div>
                <!-- End Column  -->
                @endforeach
            </div>
        </div>
        @endauth
        @endif

    </div>
    <!-- End Product Section -->

</body>

</html>