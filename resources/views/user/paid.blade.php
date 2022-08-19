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

        .carousel .carousel-control-prev,
        .carousel .carousel-control-next {
          display: none;
        }
      }

      @media (min-width:3260px) and (max-width:768px) {
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
        border-radius: 10px;
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

      .paid-section .download-item {
        margin: 20px 0px 0 0;
        /* padding: 50px 25px; */
        padding: 0px;
        background-color: #fff;
        text-align: center;

        text-decoration: none;
        box-shadow: 0px 0px 0px 1px #e0d8d881;
        display: inline;
        position: relative;
        border-style: solid 0px;
        border-radius: 20px;
        z-index: 99;
      }

      .paid-section .cardc .cardc-body {
        padding: 0px;
        margin-top: 0px;
        background-color: #fff;
        text-align: center;
        height: 110px !important;
        width: 280px;
        border-style: solid 0px;
        border-radius: 20px;
      }

      .paid-section .paid-item:hover .paid-thumbnail {
        top: -25px;
      }

      .paid-section .download-item:hover .download-thumbnail {
        top: -25px;
      }

      .block {
        margin: auto;
        float: left;
        margin-top: 20px;
        margin-left: 20px;
        padding: 5px;
        padding-top: 2px;
        display: inline-block;
        width: 70px;
        height: 70px;
        background-color: #fff;
        border: 1px solid #1c7e14;
        border-radius: 10px;
      }


      .block:hover {
        background-color: #1c7e14;
      }

      .block2 {
        margin: auto;
        float: left;
        margin-top: 20px;
        margin-left: 20px;
        padding: 5px;
        padding-top: 2px;
        display: inline-block;
        width: 70px;
        height: 70px;
        background-color: #fff;
        border: 1px solid #b3b3b3;
        border-radius: 10px;
      }


      .block2:hover {
        background-color: #f9da28;
      }

      .paid-section .paid-item img {
        height: 500px;
      }

      .dd:hover path {
        fill: #fff;
        background-color: #1c7e14;
      }
      .de:hover path {
        fill: #000;
        background-color: #000;
      }

      .dg p {
        padding-top: 26px;
        padding-bottom: 0px !important;
      }

      .dg span {
        font-size: 11px;
        margin: 0;
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
        margin-bottom: 3px;
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


      .downloadContainer {
        width: 16%;
        border-radius: 20px;
        padding: 0px 0px;
        margin: auto;
        background-color: #fff;
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

      }

      p {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
      }

      span {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
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
                  @foreach($paid as $index => $pd)

                  <?php
                  $count = $pd->count;
                  $px = $pd->product_payment_id;
                  if ($count > 1) {
                    $countt = $pd->count - 1;
                  } else {
                    $countt = 1;
                  }

                  $ind = $index + 1;
                  ?>

                  @endforeach
                  @foreach($pays as $pay)

                  <?php
                  $pay_id = $pay->id;
                  $payment = $pay->payment;
                  $amount = $pay->amount;

                  ?>
                  <!-- Start Column  -->
                  <li>
                    <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                      <span class="paid-item " href="#">
                        <span class="positionAnchor  paid-thumbnail">
                          <img src="../user/images/{{$payment}}.svg" height="500px" class="img-fluid">
                          <span class="title" style="align: center;">
                            <h3 class="paid-title" style="font-size: 22px; color:aliceblue">{{$payment}}</h3>
                          </span>
                          <strong class="paid-price">{{number_format($amount)}} | </strong>&nbsp;<amp>@foreach($prod as $pp) @if ($pp == reset($prod )) last Item: @endif {{$pp->product_name}} @endforeach<br>Package</amp>

                          <p>

                            @if( $countt == $pay_id)

                            <a class="btn btn-secondary" href="#">Get Reciept</a>

                            @else

                          <form action="{{ route('payment',$pp->id) }}" method="GET">
                            
                            <button class="btn btn-secondary">Pay Now</button>
                          </form>
                          <!-- <a class="btn btn-secondary" href="{{ route('payment',$pp->id) }}">Pay Now</a> -->

                          @endif


                          </p>

                        </span>
                      </span>
                    </div>

                    @if($payment != "First Payment")
                    <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block">
                      <div class="cardc-body">
                        
                          @if($payment == "Second Payment")
                          <div style="display:inline" id="dd" class="block download-thumbnail img-fluid">
                          <svg style="margin:auto;margin-top:20px" width="39" height="30" class="dd" viewBox="0 0 39 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.78768 24.0116C10.8127 27.5821 14.6843 30 19.1291 30C23.5739 30 27.4456 27.5821 29.4706 24.0116C34.3102 23.9865 38.2328 20.1154 38.2328 15.3547C38.2328 10.5815 34.2847 6.68531 29.4196 6.68531H29.3687L26.2612 9.74216H29.4196C32.5654 9.74216 35.1253 12.2603 35.1253 15.3547C35.1253 18.0107 33.2276 20.2407 30.7059 20.8169C30.2984 20.9046 29.8654 20.9673 29.4196 20.9673C28.7574 20.9673 28.1333 20.8545 27.5475 20.6541C27.2673 21.6563 26.7961 22.5959 26.1847 23.4103C24.5928 25.5525 22.0201 26.9432 19.1164 26.9432C16.2126 26.9432 13.64 25.5525 12.048 23.4103C11.4367 22.5834 10.9655 21.6563 10.6853 20.6541C10.0995 20.8545 9.47541 20.9673 8.81315 20.9673C8.3674 20.9673 7.94712 20.9172 7.52684 20.8169C4.99242 20.2407 3.10753 18.0107 3.10753 15.3547C3.10753 12.2603 5.66742 9.74216 8.81315 9.74216H11.9716L8.8641 6.68531H8.81315C3.96082 6.68531 4.25317e-07 10.569 0 15.3547C0.0254711 20.1154 3.94809 23.9865 8.78768 24.0116Z" fill="#1C7E14" />
                            <path d="M19.1164 12.8037L27.1781 4.87341L22.4532 4.87341V5.73904e-07L15.7796 0V4.87341L11.0547 4.87341L19.1164 12.8037Z" fill="#1C7E14" />
                          </svg>
                          </div>
                          <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                          <p style="padding-top: 27px;padding-bottom:0px; font-size:16px">Work Permit</p>
                          <span style="font-size:11px; color:grey;padding-left:2px; padding-right:2px">Work Permit has been released.</span>
                        </div>
                          @else
                          <div style="display:inline" id="de" class="block2 download-thumbnail img-fluid">
                          <svg style="margin:auto;margin-top:20px" width="25" height="30" class="de" viewBox="0 0 43 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M42.1213 48.4562C42.1213 48.0084 42.2761 47.4037 42.045 47.1556C41.7786 46.8687 41.1557 47.0471 40.6935 47.0781C40.2312 47.1091 40.0843 46.9967 40.0843 46.4966C40.1026 35.7794 40.1111 25.0622 40.1098 14.345C40.1098 13.8701 39.9668 13.7906 39.5222 13.7945C36.8564 13.8139 34.1906 13.8178 31.5268 13.7945C31.0548 13.7945 30.9627 13.9244 30.9627 14.376C30.9758 24.7598 30.9758 35.143 30.9627 45.5255C30.9627 46.0237 31.137 46.6885 30.8824 46.9734C30.5906 47.2971 29.9031 47.0199 29.386 47.0858C28.8689 47.1517 28.7886 46.9715 28.7886 46.4947C28.8043 33.6906 28.8082 20.8872 28.8003 8.08443C28.8003 7.41379 28.8003 7.41379 28.1481 7.41379H21.9371C21.7412 7.41379 21.5454 7.46031 21.5454 7.13081C21.565 6.17913 21.5571 5.22745 21.5454 4.27771C21.5454 4.06256 21.5885 3.97341 21.8274 4.02768C22.3739 4.15366 22.9008 4.02768 23.412 3.84742C24.3913 3.5121 25.3707 3.14384 26.4225 3.72531V1.5506C26.4225 0.370205 26.4225 0.370205 25.4099 0.00969123H24.8027C24.164 0.126701 23.5339 0.285337 22.9165 0.484562C22.1643 0.717151 21.8803 0.593103 21.5689 0H20.566C20.566 2.35303 20.566 4.708 20.5895 7.06103C20.5895 7.42155 20.4211 7.41185 20.1645 7.40992C18.0726 7.40992 15.9808 7.42155 13.8967 7.39635C13.4403 7.39635 13.3091 7.50101 13.3091 7.96232C13.3156 20.486 13.3189 33.0058 13.3189 45.5217C13.3189 46.0217 13.4991 46.7001 13.2425 46.9734C12.9487 47.2893 12.2632 47.016 11.7402 47.08C11.2172 47.144 11.1526 46.9657 11.1526 46.4888C11.1604 35.7548 11.1644 25.0215 11.1644 14.2888C11.1644 13.9011 11.0645 13.7984 10.6708 13.8023C7.97171 13.8197 5.27264 13.8236 2.57358 13.8023C2.13483 13.8023 2.0271 13.8953 2.0271 14.3391C2.04277 24.303 2.04669 34.2688 2.03886 44.2366C2.03886 45.07 2.02906 45.9054 2.03886 46.7408C2.03886 46.9928 1.98597 47.0955 1.70784 47.08C1.27105 47.0567 0.830348 47.0955 0.393561 47.0684C0.0840895 47.049 0.00182486 47.1304 0.00182486 47.456C0.0233704 48.5395 0.0370811 49.6269 0.00182486 50.7103C-0.0158033 51.1813 0.0880069 51.3073 0.58943 51.3073C14.2362 51.2918 27.8817 51.2873 41.5259 51.2938C41.5761 51.2899 41.6265 51.2899 41.6767 51.2938C42.0156 51.3519 42.1409 51.2434 42.1272 50.8751C42.1115 50.0668 42.1272 49.2663 42.1213 48.4562ZM4.65174 18.08C4.65174 17.8454 4.71833 17.7621 4.96513 17.764C6.17951 17.7731 7.39259 17.7731 8.60436 17.764C8.83157 17.764 8.93734 17.8067 8.93342 18.0645C8.92167 19.2817 8.92167 20.4989 8.93342 21.7161C8.93342 21.9506 8.86878 22.034 8.62199 22.0282C7.99913 22.0127 7.37431 22.0282 6.75145 22.0282C6.17951 22.0282 5.60562 22.0165 5.03368 22.0282C4.7673 22.0282 4.64194 21.9875 4.64194 21.6812C4.66741 20.4815 4.66153 19.2797 4.65174 18.08ZM8.93342 44.663C8.93342 44.9092 8.85115 44.9693 8.61415 44.9673C7.40173 44.9576 6.18735 44.9538 4.97296 44.9673C4.68112 44.9673 4.64782 44.8491 4.6537 44.6126C4.66545 44.0118 4.6537 43.4109 4.6537 42.812C4.6537 42.2131 4.6537 41.649 4.6537 41.0676C4.6537 40.833 4.6772 40.7012 4.97296 40.7051C6.18539 40.7206 7.39977 40.7167 8.61415 40.7051C8.85115 40.7051 8.93538 40.7671 8.93342 41.0133C8.92428 42.2279 8.92428 43.4445 8.93342 44.663ZM8.61807 37.3093C7.4063 37.299 6.19257 37.299 4.97688 37.3093C4.74575 37.3093 4.65174 37.2647 4.6537 37.0089C4.66806 35.7917 4.66806 34.5738 4.6537 33.3553C4.6537 33.1052 4.74184 33.051 4.97492 33.0549C5.58015 33.0684 6.18735 33.0549 6.79454 33.0549C7.40173 33.0549 8.00892 33.0549 8.61611 33.0549C8.8492 33.0549 8.93929 33.1052 8.93538 33.3553C8.92363 34.5725 8.92363 35.7904 8.93538 37.0089C8.93734 37.2647 8.84724 37.3112 8.61807 37.3093ZM8.58281 29.6552C7.38802 29.6371 6.19257 29.6371 4.99647 29.6552C4.68699 29.6552 4.64782 29.5428 4.65174 29.2811C4.66349 28.1181 4.66349 26.952 4.65174 25.7826C4.65174 25.5131 4.70462 25.4085 5.0043 25.4143C6.1991 25.4324 7.39455 25.4324 8.59065 25.4143C8.90208 25.4143 8.94125 25.5325 8.93342 25.7903C8.91775 26.3718 8.93342 26.9533 8.93342 27.5347C8.93342 28.1162 8.91971 28.6977 8.93342 29.2792C8.94321 29.566 8.88249 29.6668 8.58281 29.6552ZM16.6663 10.9744C16.6663 10.6623 16.727 10.5421 17.0796 10.5441C19.7395 10.5596 22.4 10.5596 25.0612 10.5441C25.4177 10.5441 25.4745 10.672 25.4706 10.9782C25.4569 12.1121 25.4529 13.244 25.4706 14.3779C25.4706 14.719 25.3922 14.8295 25.0299 14.8237C23.6999 14.8024 22.37 14.8237 21.04 14.8237C19.7434 14.8237 18.4467 14.8043 17.1501 14.8237C16.7349 14.8334 16.6545 14.6977 16.6624 14.3217C16.6878 13.2091 16.682 12.0908 16.6663 10.9744ZM16.6663 20.4873C16.6663 20.2314 16.7349 20.1403 17.0071 20.1423C19.7179 20.1526 22.4287 20.1526 25.1396 20.1423C25.4255 20.1423 25.4706 20.2527 25.4686 20.495C25.4686 21.6793 25.4529 22.8616 25.4686 24.0459C25.4686 24.3754 25.3354 24.4219 25.0514 24.42C23.7038 24.4083 22.3563 24.42 21.0087 24.42C19.6964 24.42 18.3821 24.42 17.0698 24.42C16.7701 24.42 16.6565 24.3541 16.6604 24.0323C16.682 22.8519 16.678 21.6696 16.6663 20.4873V20.4873ZM25.4627 43.2326C25.4627 43.5078 25.4001 43.6028 25.1043 43.6009C22.4052 43.5892 19.7062 43.5892 17.0071 43.6009C16.7544 43.6009 16.6545 43.5466 16.6585 43.2733C16.6722 42.0716 16.6741 40.8699 16.6585 39.6682C16.6585 39.3697 16.7897 39.3561 17.0189 39.3561C18.3684 39.3561 19.7179 39.3561 21.0675 39.3561C22.3837 39.3561 23.6999 39.3677 25.0162 39.3561C25.3531 39.3561 25.4784 39.4142 25.4686 39.7825C25.449 40.928 25.4627 42.0793 25.4627 43.2326ZM25.0005 34.0123C23.6705 33.9968 22.3406 34.0123 21.0087 34.0123C19.7121 34.0123 18.4154 34.0007 17.1188 34.0123C16.7858 34.0123 16.6467 33.9561 16.6545 33.584C16.68 32.4346 16.6741 31.2833 16.6545 30.1339C16.6545 29.8316 16.7251 29.7463 17.0463 29.7463C19.7231 29.7592 22.4 29.7592 25.0769 29.7463C25.3961 29.7463 25.4686 29.8374 25.4686 30.1339C25.451 31.2852 25.4451 32.4346 25.4686 33.584C25.4823 33.9581 25.3393 34.0162 25.0083 34.0123H25.0005ZM33.1956 18.0664C33.1956 17.8105 33.2936 17.7621 33.5227 17.764C34.7345 17.7731 35.9476 17.7731 37.162 17.764C37.4068 17.764 37.4832 17.8396 37.4773 18.078C37.4636 18.6944 37.4773 19.3127 37.4773 19.9291C37.4773 20.5105 37.4675 21.092 37.4773 21.6735C37.4773 21.9196 37.4323 22.0262 37.1482 22.0224C35.9365 22.0081 34.7234 22.0081 33.509 22.0224C33.2661 22.0224 33.1937 21.9506 33.1956 21.7103C33.21 20.4995 33.2126 19.2849 33.2035 18.0664H33.1956ZM37.4773 44.6669C37.4773 44.9189 37.3833 44.9693 37.1541 44.9673C35.9397 44.957 34.726 44.957 33.5129 44.9673C33.272 44.9673 33.1897 44.9053 33.1956 44.6611C33.2113 44.0447 33.1956 43.4264 33.1956 42.81C33.1956 42.2286 33.2054 41.6471 33.1956 41.0656C33.1956 40.8272 33.225 40.7032 33.5168 40.7071C34.7312 40.7226 35.9456 40.7206 37.158 40.7071C37.4009 40.7071 37.4793 40.7768 37.4773 41.0191C37.4734 42.2299 37.476 43.4458 37.4851 44.6669H37.4773ZM37.1561 37.3016C36.5489 37.288 35.9417 37.3016 35.3345 37.3016C34.7273 37.3016 34.1201 37.2919 33.5129 37.3016C33.2798 37.3016 33.1917 37.2531 33.1937 37.0011C33.208 35.7813 33.208 34.5635 33.1937 33.3475C33.1937 33.0956 33.2838 33.0452 33.5149 33.0471C34.7267 33.0574 35.9404 33.0574 37.1561 33.0471C37.3892 33.0471 37.4793 33.0994 37.4753 33.3495C37.4636 34.5667 37.4636 35.7846 37.4753 37.0031C37.4891 37.2667 37.3931 37.3151 37.1639 37.3093L37.1561 37.3016ZM37.1091 29.6552C36.5215 29.6397 35.9339 29.6552 35.3463 29.6552C34.7587 29.6552 34.171 29.6435 33.5834 29.6552C33.3131 29.6649 33.2054 29.6067 33.2113 29.3082C33.2283 28.1259 33.2283 26.9436 33.2113 25.7612C33.2113 25.455 33.3229 25.4143 33.5874 25.4162C34.7626 25.4291 35.9378 25.4291 37.113 25.4162C37.3852 25.4162 37.493 25.4666 37.4871 25.7651C37.4701 26.9474 37.4701 28.1304 37.4871 29.314C37.493 29.6261 37.3735 29.6687 37.1091 29.6552Z" fill="black" />
                          </svg>
                          </div>
                          <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                          <p style="padding-top: 27px;padding-bottom:0px; font-size:16px">Embassy Appearance</p>
                          <span style="font-size:11px; color:grey;padding-left:2px; padding-right:2px;line-height:10px">Confirmation of embassy appearance registration.</span>
                        </div>
                          @endif

                      </div>
                    </div>
                    @endif

                  </li>
                  <?php
                  while ($countt < $count) {
                    $countt = $countt + 1;
                  } ?>
                  <!-- End Column  -->
                  @endforeach
                </ul>

              </div>

              <!-- <div class="row download-thumbnail">
                <div align="center" class="col-md-4 col-sm-12 img-fluid downloadContainer">
                  <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block">
                    <div class="cardc-body">
                      jjllj;j;

                    </div>
                  </div>
                </div>
                <div align="center" class="col-md-4 col-sm-12 img-fluid downloadContainer">
                  <div class="cardc downlaod-item" style="display:inline-block">
                    <div class="cardc-body">
                      jjllj;j;

                    </div>
                  </div>
                </div>
                <div align="center" class="col-md-4 col-sm-12 img-fluid downloadContainer">
                  <div class="cardc downlaod-item">
                    <div class="cardc-body">
                      jjllj;j;

                    </div>
                  </div>
                </div>
              </div> -->

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
      <p style="margin-top: 5px;">
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