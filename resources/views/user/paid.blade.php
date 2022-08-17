    <!--====== Line Icons CSS ======-->

        
    <!--====== Bootstrap CSS ======-->
    <!-- <link rel="stylesheet" href="../user/assets/css/bootstrap.min.css"> -->
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="../user/assets/css/style.css">

<style>
  .card {
    /* style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" */
    border-color: none;
    border-radius: 10px;
    border-style: hidden;
  }

  .card-header {
    /* style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" */
    border-color: none;
    border-radius: 10px;
    border-style: hidden;
    padding-top: 60px;
    /* margin-bottom: 10px; */
  }

  .scoll-pane {
    width: 100%;
    height: auto;
    overflow: auto;
    outline: none;
    overflow-y: hidden;
    padding-bottom: 15px;
    -ms-overflow-style: scroll;
    scrollbar-width: none; 
  }

  .scoll-pane::-webkit-scrollbar {
    display: none;
  }

  @media (min-width: 789px) {
    .carousel .carousel-control-prev, .carousel .carousel-control-next {
    display: none;
} 
  }
  
  @media (min-width:375px) {
    .card-header {
      /* style="font-size:30px;font-family: 'TT Norms Pro';font-weight:700" */
      margin-bottom: 10px;
    }
  }

  .paid-section {
    padding: 25px 25px 25px 25px;
    font-family: 'TT Norms Pro';
    font-style: normal;
    align-items: center;
    justify-content: center;
    background-size: cover;

  }



  .paid-section .outer {
    width: 100%;
    margin-top: 5%;
    margin-bottom: 5%;
    overflow: hidden;
    white-space: nowrap;
    padding-bottom: 1em;
    display: flex;

  }

  .paid-section .outer li {
    display: inline-block;
    *display: inline;
    /*For IE7*/
    *zoom: 1;
    /*For IE7*/
    vertical-align: top;
    /* width:400px; */
    margin-right: 10px;
    margin-left: 20px;
    white-space: normal;
    flex: none;

  }

  .paid-section .paid-item {
    margin: 50px 0px 0 0;
    /* padding: 50px 25px; */
    padding: 0px;

    text-align: center;
    height: 100%;
    width: 100%;
    text-decoration: none;
    box-shadow: 0px 0px 0px 1px #e0d8d881;
    display: inline-block;
    position: relative;
    border-style: solid 1px;
  }

  .paid-section .paid-item:hover .paid-thumbnail {
    top: -25px;
  }

  .paid-section .paid-item img {
    height: 500px;
  }

  @media only screen and (max-width: 768px) and (min-width: 370px) {
    .paid-section {
      padding: 1px 1px 1px 1px;
    }

    .paid-section .paid-item {
      margin: 10px 0px 0px 0px;
      /* padding: 50px 25px; */
      padding: 0px;
      height: 500px;
    }


    .paid-section .outer {
      width: 100%;
      margin-top: 0%;
      overflow-x: visible;
      overflow-y: hidden;
      /* white-space:nowrap; */
    }

    .paid-section .outer li {
      display: inline-block;
      *display: inline;
      /*For IE7*/
      *zoom: 1;
      /*For IE7*/
      /* vertical-align:top; */
      white-space: normal;
      flex-basis: 0;
      flex-grow: 1;
    }

    .paid-section .paid-item img {
      height: 100%;
    }

  }

  @media (min-width:414px) and (max-width:736px) {
    .paid-section .paid-item img {
      height: 100%;
      width: 100%;
    }

    .paid-section .paid-item {
      margin: 10px 2px 0 2px;
      /* padding: 50px 25px; */
      padding: 0px;
    }
  }

  @media (min-width: 768px) and (max-width: 1024px) {
    .paid-section .paid-item img {
      height: 500px;
    }
  }

  .paid-section .paid-item .title {
    position: absolute;
    display: inline-block;
    top: 150px;
    left: 27px;
    margin: 10px 10px 0 0;
    padding: 5px 5px;
    text-align: center;
    color: #fff;
  }


  .paid-section .paid-item .positionAnchor {
    position: relative;
    display: inline-block;

  }

  .paid-section .paid-item .paid-thumbnail {
    margin-bottom: 30px;
    position: relative;
    top: 0;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
  }

  .paid-section .paid-item .paid-title {
    text-transform: uppercase;
    font-size: 22px;
  }

  .paid-section .paid-item h3 {
    font-weight: 600;
    font-size: 16px;
  }

  .paid-section .paid-item strong {
    position: absolute;
    display: inline-block;
    top: 250px;
    left: 25px;
    margin: 10px 10px 0 0;
    padding: 5px 5px;
    text-align: center;
    color: #000;

    font-weight: 800 !important;
    font-size: 35px !important;
  }

  .paid-section .paid-item amp {
    position: absolute;
    display: inline-block;
    top: 260px;
    left: 150px;
    margin: 10px 10px 0 0;
    line-height: normal;
    padding: 5px 5px;
    text-align: left;
    color: #000;

    font-weight: 600 !important;
    font-size: 17px !important;
  }

  .paid-section .paid-item a {
    position: absolute;
    display: inline-block;
    top: 380px;
    left: 35px;
    margin: 10px 10px 0 0;
    padding: 2px 5px;
    text-align: center;
    color: #000;
    width: 200px;
  }

  .paid-section .paid-item button {
    position: absolute;
    display: inline-block;
    top: 380px;
    left: 35px;
    margin: 10px 10px 0 0;
    padding: 2px 5px;
    text-align: center;
    color: #000;
    width: 200px;
    height: 50px;
    font-family: 'TT Norms Pro';
    font-weight: bold;
    font-size: 30px;
  }

  .paid-section .paid-item h3,
  .paid-section .paid-item strong {
    color: #2f2f2f;
    text-decoration: none;
  }

  .paid-section .paid-item:before {
    bottom: 0;
    left: 0;
    right: 0;
    position: absolute;
    content: "";
    background: #dce5e4;
    height: 0%;
    z-index: -1;
    border-radius: 10px;
    border-color: #6a6a6a;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease;
  }

  .cellContainer {
    width: 100%;
    padding: 0px 20px;
    margin: auto;
  }

  @media (min-width:375px) and (max-width:678px) {
    .cellContainer {
      padding: 0px;
      margin: 0px;
    }

  }


  @media (max-width: 768px) and (min-width: 370px) {
    .cellContainer {
      width: 100%;
    }

    .container-fluid {
      padding-left: 10px;
      padding-right: 10px;
    }

    /* 
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
} */
  }
</style>


<div class="card d-flex aligns-items-center justify-content-center text-center">
  <div class="card-header" style="background-color:white;">My Applications</div>
  <div class="card-body paid-section" style="background-color:#FAE008;">

    <div class="carousel" id="carouselThree" data-ride="carousel">
      <div class="outer scroll-pane" id="container">
        <div class="container-fluid text-center">
          <div class="row paid-thumbnail">
            <ul>
              @foreach($pays as $pay)
              <!-- Start Column  -->
              <li>
                <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                  <span class="paid-item " href="#">
                    <span class="positionAnchor  paid-thumbnail">
                      <img src="../user/images/{{$pay->payment}}.svg" height="500px" class="img-fluid">
                      <span class="title" style="align: center;">
                        <h3 class="paid-title" style="font-size: 22px; color:aliceblue">{{$pay->payment}}</h3>
                      </span>
                      <strong class="paid-price">{{number_format($pay->amount)}} | </strong>&nbsp;<amp>@foreach($prod as $pp) @if ($pp == reset($prod )) last Item: @endif {{$pp->product_name}} @endforeach<br>Package</amp>

                      <p>
                        @foreach($paid as $pd)

                        @if( $pd->product_payment_id == $pay->id)
                        <a class="btn btn-secondary" href="#">Get Reciept</a>
                        @else
                        <form action="{{ route('payment',$pp->id) }}" method="GET">
                        <input type="hidden" name="pid" value="{{$pp->id}}">
                        <button class="btn btn-secondary">Pay Now</button>
                        </form>
                        <!-- <a class="btn btn-secondary" href="{{ route('payment',$pp->id) }}">Pay Now</a> -->
                        @endif

                        @endforeach

                      </p>

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
    </a><br>
    
      </div>

    </div>

  </div>


</div>


<div class="card d-flex aligns-items-center justify-content-center text-center" style="background-color:#000; color: #fff; padding-block:35px; font-weight: bold;font-family:'TT Norms Pro'">
  <h3 style="font-size:36px">Earn 5% discount when you pay full amount! </h3>
  <p>
  <form action="{{ route('payment',$pp->id) }}" method="GET">
                        <input type="hidden" name="pid" value="{{$pp->id}}">
                        <input type="hidden" name="payall" value="1">
                        <button class="btn btn-secondary" style="border-color:#fff;border-width:thin; width:250px; height:60px;color:#fff; font-size:32px; font-weight:bold">Pay All Now</button>
                        </form>
  </p>
</div>
<!-- <script src="../user/assets/js/vendor/jquery-1.12.4.min.js"></script> -->
<script>
  var button = document.getElementById('slide');
  button.onclick = function() {
    var container = document.getElementById('container');
    sideScroll(container, 'right', 25, 100, 10);
  };

  var back = document.getElementById('slideBack');
  back.onclick = function() {
    var container = document.getElementById('container');
    sideScroll(container, 'left', 25, 100, 10);
  };

  function sideScroll(element, direction, speed, distance, step) {
    scrollAmount = 0;
    var slideTimer = setInterval(function() {
      if (direction == 'left') {
        element.scrollLeft -= step;
      } else {
        element.scrollLeft += step;
      }
      scrollAmount += step;
      if (scrollAmount >= distance) {
        window.clearInterval(slideTimer);
      }
    }, speed);
  }
</script>