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
        /* height: 480px;    */
        padding-top: 30px;
        background-size: 100%;
        background-repeat: no-repeat;
        }
        .col-4 {
            /* width: 100% !important; */
        }

        @media (min-width:601px) and (max-width:768px) {
            .banner_bg {
                width: 100%;
                float: left;
                background-size: 100%;
                background-repeat: no-repeat !important;
                background-position: center left !important;
                object-fit: contain;
            }
        }
        @media (min-width:280px) and (max-width:600px) {
            .banner_bg {
                width: 100%;
                float: left;
                background-size: 100%;
                background-repeat: no-repeat !important;
                background-position: center top !important;
                object-fit: contain;
            }
        }
    </style>

<body>

@if(Route::has('login'))


        @auth
        @else
    <!-- Start Hero Section -->
    {{-- <div class="hero banner_bg layerd" style="padding-top: 80px; ">

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
    </div> --}}
    <div class="col-12 banner">
        <div class="row">
            <div class="col-4">
                <div class="new-applicant">
                    <div class="applicantImg">
                        <img src="{{asset('images/Applications.png')}}" alt="pwg" width="40%" height="40%">
                    </div>
                    <p class="headerFont">NEW APPLICANTS</p>
                    <p class="subHead">Migration journey  start here.</p>
                    <p class="headDetails">Get your Europe & Canada Visa <br> from any part of  the world.</p>
                    <a class="applicantBtn" href="{{route('register')}}">START NOW</a>
                </div>
            </div>
            <div class="col-4">
                <div class="existing-applicant"> 
                    <div class="applicantImg">
                        <img src="{{asset('images/existingApplicant.png')}}" alt="pwg" width="40%" height="40%">
                    </div>
                    <p class="headerFont">EXISTING APPLICANTS</p>
                    <p class="subHead">Migration journey  continues here.</p>
                    <p class="headDetails">Get your Europe & Canada Visa <br> from any part of  the world.</p>
                    <a class="applicantBtn" href="{{route('login')}}">START NOW</a>
                </div>
            </div>
            <div class="col-4">
                <div>

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
       <div class="carousel" id="carouselThree"  data-ride="carousel" style="margin-block:20px ;">

          <div class="outer  scroll-pane" id="container">
            <div class="container-fluid text-center">
                <div class="row" >

                    <ul>
                        @foreach($package as $offer)

                            @if($promo->first())
                                @foreach($promo as $prom)
                                    <?php
                                        if($prom->discount_percent >0 && $prom->product_id == $offer->id)
                                        { 
                                            $icon = 'fa fa-minus-circle';
                                            $offer_discount_msg = 'Promo Offer: ' .$prom->discount_percent .'% off !';
                                        } else {
                                            $icon = '';
                                            $offer_discount_msg = '-';
                                        }
                                    ?>
                                @endforeach
                            @else 
                                @php
                                    $icon = '';
                                    $offer_discount_msg = '-'; 
                                @endphp
                            @endif

                        <!-- Start Column  -->
                        <li>
                            <div class="col-4 cellContainer" style="margin-top:10%">
                                <span class="product-item item-hints" href="#">
                                    <span class="positionAnchor hint"  data-position="1">

                                        <!-- <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img" alt="PWG Group"> -->

                                        {{-- <div class="home-img"> --}}
                                            <img src="../user/images/{{$offer->image}}" width="100%" class="img-fluid product-thumbnail home_img" alt="PWG Group">
                                        {{-- </div> --}}

                                        <div class="hint-content do--split-children">
                                            <p>{{$offer->description}}</p>
                                        </div>
                                        <span class="bottom">
                                            <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{ucfirst($offer->name)}}</h3>
                                            <p style="font-size:20px">{{$offer->slogan}}</p>
                                        </span>

                                        
                                        <p style="font-size:12px">@if($offer->name == "Canada" || $offer->name == "Germany") Full Payment Price @else First Installment Payment From @endif</p>

                                        <strong class="product-price">  {{number_format($offer->first_payment_sub_total,2)}} {{$offer->currency}}</strong>

                                        {{-- <p style="font-size:12px">Starting from </p>

                                        <strong class="product-price">  {{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong> --}}
                                        <p> 
                                            <i class="{{$icon}}"></i> {{$offer_discount_msg}}
                                        </p>
                                        <p>
                                            
                                            @if(isset($started) && $offer->id == $started->destination_id)
                                            <a class="btn btn-secondary" href="#"><span class="done">Already Applied</span><span class="doned">Applied</span> <i class="fa fa-check-circle" style="font-size:18px; color:green"></i></a>
                                            {{-- <a class="btn btn-secondary" href="#">Already Applied <i class="fa fa-check-circle" style="font-size:18px; color:green"></i></a> --}}
                                            @else
                                            
                                            {{-- <a class="btn btn-secondary" @if(isset($started->destination_id)) onclick="return alert('You have an active application already.');" @endif href="{{ url('package/type', $offer->id) }}">Apply Now</a> --}}
                                            <a class="btn btn-secondary" @if(isset($started->destination_id)) onclick="toastr.error('You have an active application already.','',{positionClass: 'toast-top-center', closeButton: 'true', width: '400px'})" href="#" @else href="{{ url('package/type', $offer->id) }}" @endif>Apply Now</a>
                                            @endif
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
            <div class="nextprev">
                <a class="carousel-control-prev" alt="PWG" id="slideBack" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="prev" aria-label="Navigate Back">
                    <i class="lni lni-arrow-left"></i>
                </a>
                <a class="carousel-control-next" alt="PWG" id="slide" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="next" aria-label="Navigate forward">
                    <i class="lni lni-arrow-right"></i>
                </a>
            </div>
 
        </div>

       </div>
        <!-- @include('user.earning') -->

        @else

        <div class="container-fluid text-center">

            <div class="row">
              @foreach($package as $offer)
                @if($promo->first())
                    @foreach($promo as $prom)
                        <?php

                            if($prom->discount_percent >0 && $prom->product_id == $offer->id)
                            { 
                            $icon = 'fa fa-minus-circle';
                            $offer_discount_msg = 'Promo Offer: ' .$prom->discount_percent .'% off !';
        
                            } else {
                            $icon = '';
                            $offer_discount_msg = '-';
                            }
                                                
                        ?>
                    @endforeach

                @else 
                    @php
                        $icon = '';
                        $offer_discount_msg = '-'; 
                    @endphp
                @endif
                <!-- Start Column  -->
                <div class="col-sm-12 col-xs-12 col-lg-4 cellContainer destinationView">
                    <span class="product-item item-hints" href="#">
                        <span class="positionAnchor hint"  data-position="1">

                            <!-- <img src="../user/images/{{$offer->image}}" style="height:458px" class="img-fluid product-thumbnail home_img" alt="PWG Group"> -->

                            {{-- <div class="home-img"> --}}
                                <img src="../user/images/{{$offer->image}}" width="100%"  class="img-fluid product-thumbnail home_img" alt="PWG Group">
                            {{-- </div> --}}

                            <div class="hint-content do--split-children">
                              <p>{{$offer->description}}</p>
                            </div>
                            <span class="bottom">
                                <h3 class="product-title intro-excerpt" style="font-size: 35px; color:aliceblue">{{ucfirst($offer->name)}}</h3>
                                <p style="font-size:20px">{{$offer->slogan}}</p>
                            </span>
                            {{-- <p style="font-size:12px">Starting from </p>
                            <strong class="product-price">{{number_format($offer->unit_price,2)}} {{$offer->currency}}</strong> --}}

                            <p style="font-size:12px">@if($offer->name == "Canada" || $offer->name == "Germany") Full Payment Price @else First Installment Payment From @endif</p>
                            <strong class="product-price">{{number_format($offer->first_payment_sub_total,2)}} {{$offer->currency}}</strong>
                            <p>
                                <i class="{{$icon}}"></i> {{$offer_discount_msg}} 
                            </p>
                            <p>
                                <a class="btn btn-secondary" href="{{ url('package/type', $offer->id) }}">Apply Now</a>
                            </p>
                        </span>
                    </span>
                </div>
                <!-- End Column  -->
                @endforeach
                <div class="col-4 cellContainer">
                    <span class="product-itemx" href="#">
                        <span class="positionAnchorx" data-position="1">
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
    <div class="modal fade" id="formatModal" tabindex="-1" aria-labelledby="formatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid #fff">
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img loading="lazy" src="{{asset('images/warningimage.png')}}" width ="100%" height ="100%;" alt="PWG">
            </div>
          </div>
        </div>
    </div>
    @include('user/footer')
    <!-- End Product Section -->


    <!--====== Jquery js ======-->
    <script src="../user/assets/js/vendor/jquery-1.12.4.min.js"></script>

  </body>

</html>

<script>
    $(document).ready(function() {
        $('#formatModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        if(!Cookies.get("visited")){
            $('#formatModal').modal('show');
        }

        $('.btn-close').click(function(){
            var date = new Date();
            date.setDate(date.getDate() + 1);
            Cookies.set('visited', true, {expires: date});
            $('#formatModal').modal('hide');
        });
    });
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
<script>
    $(document).ready(function() {
    @if(Session::has('message'))
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.success("{{ session('message') }}");
    @endif
    
    @if(Session::has('error'))
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.error("{{ session('error') }}");
    @php Session::forget('error'); @endphp
    @endif
    
    @if(Session::has('info'))
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.info("{{ session('info') }}");
    @endif
    
    @if(Session::has('warning'))
    toastr.options =
    {
    "closeButton" : true,
    "progressBar" : true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
    }); 
   </script>