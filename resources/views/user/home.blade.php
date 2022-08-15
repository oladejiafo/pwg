<!DOCTYPE html>

<html>

@include('user/header')


<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <!--====== Slick CSS ======-->
    <!-- <link rel="stylesheet" href="../user/assets/css/slick.css"> -->
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/LineIcons.css">
        
    <!--====== Bootstrap CSS ======-->
    <!-- <link rel="stylesheet" href="../user/assets/css/bootstrap.min.css"> -->
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/style.css">


<style>
  body {
    background-color: #F6F7FB;
  }
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
  margin: 0;
}

.banner_bg {
  height: 100%;
  float: left;
  /* background-image: url(../user/images/v1_17125.png); */
  height: auto;
  background-size: 100%;
  background-repeat: no-repeat;
}
@media (max-width: 768px) and (min-width: 370px)
{
.hero {
  padding: 0px;
  margin: 0px;
}
  .banner_bg {
    background-repeat:no-repeat;
-webkit-background-size:cover;
-moz-background-size:cover;
-o-background-size:cover;
background-size:cover;
background-position:center;
  }
  .banner_bg img {

  }

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
  font-family: 'TT Norms Pro';
  font-weight: bold;
  font-size: 32px;
  font-style: normal;
  color: #fff;
  border-radius: 10px;
}

@media (max-width: 768px) and (min-width: 370px)
{
  #headerTitle {
  font-family: 'TT Norms Pro Black';
  font-weight: 900;
  font-size: 35px;
  font-style: normal;
}

#headerText {
  font-family: 'TT Norms Pro Regular';
  font-weight: bold;
  font-size: 20px;
  font-style: normal;
  color: #fff;
  text-transform: lowercase;
}


#headerBtn {
  font-family: 'TT Norms Pro';
  font-weight: bold;
  font-size: 20px;
  font-style: normal;
  color: #fff;
  border-radius: 10px;
}

}

.cellContainer {
  width: 546px;
  margin: auto;
  padding: 0px;
  box-shadow: 5px 14px 22px #eceff0; 
    margin-bottom: 30px;
  padding-top: 10px;
}
.container-fluid {
  padding-left:50px; 
  padding-right:50px;
}

@media (max-width: 768px) and (min-width: 370px)
{
  .cellContainer {
  width: 100%;
  padding-left: 3px;
  }
  .container-fluid {
  padding-left:10px; 
  padding-right:10px;
  }
  .positionAnchor .btn {
    width: 95%;
    padding-top: 10px;
    margin-left: 5px;
    margin-right: 5px;
  }

}

::-webkit-scrollbar {
  overflow: hidden;
  width: 15px;
}

::-webkit-scrollbar-button:single-button {
  background: transparent;

  display: block;

  overflow: hidden;
}

::-webkit-scrollbar-button:single-button:horizontal:decrement {
  border-width: 0 8px 8px 8px;
  border-color: transparent transparent #555555 transparent;
}

::-webkit-scrollbar-track-piece {
  background: transparent;
}


.right-arrow,
.left-arrow {
  height: 100%;
  width: 50px;
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2rem;
  cursor: pointer;
  transition: all 0.2s linear;
}

.scroll-area {
  width: 100%;
  overflow: auto;
  white-space: nowrap;
}

.right-arrow {
  right: 10%;
}
.left-arrow {
  left:0px;
}

.scroll-btn {
  pointer-events: none;
}
.hide {
  opacity: 0;
}
</style>

<body>

@if(Route::has('login'))
        @auth
        @else
    <!-- Start Hero Section -->
    <div class="hero banner_bg layerd">

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
    <div class="product-section slider_area" id="home">

        @if(Route::has('login'))
        @auth
       <div class="carousel slide scroll-area" id="carouselThree"  data-ride="carousel">
       <ol class="carousel-indicators">
                <li data-target="#carouselThree" data-slide-to="0" class="active"></li>
                <li data-target="#carouselThree" data-slide-to="1"></li>
                <li data-target="#carouselThree" data-slide-to="2"></li>
            </ol>


          <div class="outer">
            <div class="container-fluid text-center">

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
            <a class="carousel-control-prev" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="prev">
                <i class="lni lni-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="next">
                <i class="lni lni-arrow-right"></i>
            </a>
       </div>
        @include('user.earning')

        @else

        <div class="container-fluid text-center">

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
                            <p><i class="fa fa-minus-circle" style='color: white'></i> {{$offer->discount}}% lower than last month</p>

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


    <script>
      let interval;

      $('.arrow').on('mousedown', ({ target })=> {
        const type = target.classList[1];

        const scrollArea = $(target).parent().find('.scroll-area');
        interval = setInterval(() => {
          const prev = scrollArea.scrollLeft();
          scrollArea.scrollLeft(type === 'left-arrow' ? prev - 10 : prev + 10);
        }, 50);
      });

      $('.arrow').on('mouseup mouseout', () => clearInterval(interval));

      $('.scroll-area').on('scroll', ({ target }) => {
        const left = $(target).parent().find('.left-arrow');
        const right = $(target).parent().find('.right-arrow');

        const scroll = $(target).scrollLeft();
        const fullwidth = $(target)[0].scrollWidth - $(target)[0].offsetWidth;

        if(scroll ===0) left.addClass('hide');
        else left.removeClass('hide');

        if(scroll > fullwidth) right.addClass('hide');
        else right.removeClass('hide');
      });
    </script>
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