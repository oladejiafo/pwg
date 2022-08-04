<!DOCTYPE html>
<html lang="en">
<head>
    
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="images/fevicon.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />
    <!-- <link href="../user/css/main.css" rel="stylesheet" /> -->
    <title>PWG Client Portal</title>


  <!-- bootstrap core css -->
  <link href="../user/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

		<link href="../user/css/style.css" rel="stylesheet">

        <style>
            .banner_bg {
    width: 100%;
    float: left;
    background-image: url(../user/images/v1_17125.png);
    height: auto;
    background-size: 100%;
    background-repeat: no-repeat;
}

@font-face {
    font-family: 'MyFont_SerifReg';
    src: url('../user/fonts/TTNorms-Black.otf') format('truetype'),
         url('/assets/fonts/TTNorms-BlackItalics.otf') format('woff');
}
        </style>
</head>

<body>

@include('user/header');

<!-- Start Hero Section -->
<div class="hero banner_bg layer">

<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    img {
        height: auto;
        /* width: auto;  */
        width: 546px;
        max-height: 451px;
    }

    .banner_bg {
        width: 100%;
        float: left;
        background-image: url(../user/images/v1_17125.png);
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
    width: 15px;
}
::-webkit-scrollbar-button {
    background: #ccc;
    overflow-y: hidden;
   
}
::-webkit-scrollbar-track-piece {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: transparent;
}

.filled {
    background-color: hsl(51, 94%, 50%);
    width: 95%;
    height: 450px;
    margin: 50px;
    font-family: 'TT Norms Pro Black';
    font-weight: 900;
}
.filled .btn {
    font-size: 30px;
    margin-top: 15px;
    padding: 2px;
    border-color: #000;
    background-color: none;
    height: 60px;
    width: 300px;
    color: #000;
}
.filled .btn:hover {
    background-color: #fff;
    border-color: #fff;
    color: #000;
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
                        <p><a href="{{route('login')}}" id="headerBtn" class="btn btn-hero" style='width:350px'>START NOW</a></p>
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
                                        <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail">
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
       <div class="filled">
         <div align="center" class="earn" style="padding:150px">
            <p>
            <h1>REFER. EARN. REPEAT!</h1>
            <h3>Endless opportunity to earn money</h3>
            <a href="#" class="btn">LEARN MORE</a>
            </p>
         </div>
        </div>

        @else

        <div class="container-fluid text-center" style="padding-left:50px; padding-right:50px">

            <div class="row">
                @foreach($package as $offer)
                <!-- Start Column  -->
                <div class="col-4 cellContainer">
                    <span class="product-item" href="#">
                        <span class="positionAnchor">
                            <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail">
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{$offer->product_name}}</h3>
                                <p style="font-size:20px">{{$offer->slogan}}</p>
                            </span>
							<strong class="product-price">4,789AED</strong>
                            <p><i class="fa fa-minus-circle" style='color: white'></i>34% lower than last month</p>
                            <p><button class="btn btn-secondary">Buy Now</button></p>
							<span class="icon-cross">
								<img src="../user/images/v1_17064.png" class="img-fluid">
							</span>
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