<!DOCTYPE html>

<html>

@include('user/header')


<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/LineIcons.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/style.css">
    <link href="{{asset('user/css/products.css')}}" rel="stylesheet">
<style>
.banner_bg {
  width: 100%;
  float: left;
  background-image: url(../user/images/v1_17125.png) !important;
  background-color: rgba(6, 45, 83, 0.7);
  height: auto;
  padding-top: 30px;
  background-size: 100%;
  background-repeat: no-repeat;
}
</style>

<body>

@if(Route::has('login'))
        @auth
        @else
    <!-- Start Hero Section -->
    <div class="hero banner_bg layerd" style="padding-top: 80px; ">

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
       <div class="carousel" id="carouselThree"  data-ride="carousel">


          <div class="outer  scroll-pane" id="container">
            <div class="container-fluid text-center">

                <div class="row" >

                    <ul>
                        @foreach($package as $offer)

                        <?php
                                           $offer_discount= $offer->prev_discount - $offer->discount;
                                           if($offer_discount >0)
                                           { 
                                            $icon = 'fa fa-minus-circle';
                                            $offer_discount_msg = $offer_discount .'% lower than last month';
                                           }
                                           else if($offer_discount < 0)
                                           { 
                                            $icon = 'fa fa-plus-circle';
                                            $offer_discount_msg = ($offer_discount*-1) .'% higher than last month';
                                           } else {
                                            $icon = '';
                                            $offer_discount_msg = '-';
                                           }
                                           
                ?>
                        <!-- Start Column  -->
                        <li>
                            <div class="col-4 cellContainer">
                                <span class="product-item" href="#">
                                    <span class="positionAnchor">
                                        <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img" title="{{$offer->description}}">
                                        <span class="bottom">
                                            <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{$offer->product_name}}</h3>
                                            <p style="font-size:20px">{{$offer->slogan}}</p>
                                        </span>
                                        <strong class="product-price">{{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong>
                                        <p><i class="<?php echo $icon; ?>"></i> {{$offer_discount_msg}}</p>

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
            <a class="carousel-control-prev" id="slideBack" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="prev">
                <i class="lni lni-arrow-left"></i>
            </a>
            <a class="carousel-control-next" id="slide" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="next">
                <i class="lni lni-arrow-right"></i>
            </a>
 
        </div>

       </div>
        @include('user.earning')

        @else

        <div class="container-fluid text-center">

            <div class="row">
                @foreach($package as $offer)
                <?php
                                           $offer_discount= $offer->prev_discount - $offer->discount;
                                           if($offer_discount >0)
                                           { 
                                            $icon = 'fa fa-minus-circle';
                                            $offer_discount_msg = $offer_discount .'% lower than last month';
                                           }
                                           else if($offer_discount < 0)
                                           { 
                                            $icon = 'fa fa-plus-circle';
                                            $offer_discount_msg = ($offer_discount*-1) .'% higher than last month';
                                           } else {
                                            $icon = '';
                                            $offer_discount_msg = '-';
                                           }
                                           
                ?>
                <!-- Start Column  -->
                <div class="col-4 cellContainer">
                    <span class="product-item" href="#">
                        <span class="positionAnchor">
                            <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img" title="{{$offer->description}}">
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{$offer->product_name}}</h3>
                                <p style="font-size:20px">{{$offer->slogan}}</p>
                            </span>
                            <strong class="product-price">{{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong>
                            <p><i class="<?php echo $icon; ?>"></i> {{$offer_discount_msg}}</p>

                            <p><a class="btn btn-secondary buy_now" href="{{ url('product', $offer->id) }}">Buy Now</a></p>

                        </span>
                    </span>
                </div>
                <!-- End Column  -->
                @endforeach
                <div class="col-4 cellContainer">
                    <span class="product-item" href="#">
                        <span class="positionAnchor">
                            <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img">
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue"></h3>
                                <p style="font-size:20px"></p>
                            </span>
                            <strong class="product-price"></strong>
                            <p></p>


                        </span>
                    </span>
                </div>
            </div>
        </div>
        @endauth
        @endif

    </div>
    <!-- End Product Section -->


    <!--====== Jquery js ======-->
    <script src="../user/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- <script src="../user/assets/js/vendor/modernizr-3.7.1.min.js"></script> -->
    
    <!--====== Bootstrap js ======-->
    <!-- <script src="../user/assets/js/popper.min.js"></script> -->
    <!-- <script src="../user/assets/js/bootstrap.min.js"></script> -->
    
    <!--====== Slick js ======-->
    <!-- <script src="../user/assets/js/slick.min.js"></script> -->
    
    
    <!--====== Scrolling Nav js ======-->
    <!-- <script src="../user/assets/js/jquery.easing.min.js"></script>
    <script src="../user/assets/js/scrolling-nav.js"></script> -->
    
    <!--====== Main js ======-->
    <!-- <script src="../user/assets/js/main.js"></script> -->

  </body>

</html>

<script>
  var button = document.getElementById('slide');
button.onclick = function () {
    var container = document.getElementById('container');
    sideScroll(container,'right',25,100,10);
};

var back = document.getElementById('slideBack');
back.onclick = function () {
    var container = document.getElementById('container');
    sideScroll(container,'left',25,100,10);
};

function sideScroll(element,direction,speed,distance,step){
    scrollAmount = 0;
    var slideTimer = setInterval(function(){
        if(direction == 'left'){
            element.scrollLeft -= step;
        } else {
            element.scrollLeft += step;
        }
        scrollAmount += step;
        if(scrollAmount >= distance){
            window.clearInterval(slideTimer);
        }
    }, speed);
}
</script>