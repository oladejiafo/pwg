<style> 
.paid-section {
  padding: 25px 25px 25px 25px;
  font-family: 'TT Norms Pro';
  font-style: normal;
align-items: center;
justify-content: center;
}

.paid-section .product-item {
  margin: 40px 10px 0 0;
  /* padding: 50px 25px; */
  padding: 2px;
  text-align: center;
  height:100%;
  width: 100%;
  text-decoration: none;
  box-shadow: 0px 0px 0px 1px #e0d8d881;
  display: inline-block;
  position: relative;
  border-style: solid 1px;
}

.paid-section .outer{
  width:100%;
  overflow:hidden;
  /* white-space:nowrap; */
}
.paid-section .outer li{
  display: inline-block;
  *display: inline;/*For IE7*/
  *zoom:1;/*For IE7*/
  /* vertical-align:top; */
  white-space:normal;
}

.paid-section .product-item .title{
  position: absolute;
  display: inline-block;
  top: 150px;
  left:27px;
  margin: 10px 10px 0 0;
  padding: 5px 5px;
  text-align: center;
  color: #fff;
}

.paid-section .product-item .positionAnchor {
 position: relative;
 display: inline-block;

}

.paid-section .product-item .product-thumbnail {
  margin-bottom: 30px;
  position: relative;
  top: 0;
  -webkit-transition: .3s all ease;
  -o-transition: .3s all ease;
  transition: .3s all ease;
}

.paid-section .product-item .product-title{
  text-transform: uppercase;
  font-size: 22px;
}

.paid-section .product-item h3 {
  font-weight: 600;
  font-size: 16px;
}

.paid-section .product-item strong {
  position: absolute;
  display: inline-block;
  top: 250px;
  left:25px;
  margin: 10px 10px 0 0;
  padding: 5px 5px;
  text-align: center;
  color: #000;

  font-weight: 800 !important;
  font-size: 35px !important;
}

.paid-section .product-item amp {
  position: absolute;
  display: inline-block;
  top: 260px;
  left:150px;
  margin: 10px 10px 0 0;
  line-height: normal;
  padding: 5px 5px;
  text-align: left;
  color: #000;

  font-weight: 600 !important;
  font-size: 17px !important;
}

.paid-section .product-item a {
  position: absolute;
  display: inline-block;
  top: 380px;
  left:35px;
  margin: 10px 10px 0 0;
  padding: 2px 5px;
  text-align: center;
  color: #000;
  width: 200px;
}

.paid-section .product-item h3,
.paid-section .product-item strong {
  color: #2f2f2f;
  text-decoration: none;
}

.paid-section .product-item:before {
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
        width: 460px;
        margin: auto;
    }
</style>


<div class="card d-flex aligns-items-center justify-content-center text-center">
    <div class="card-header" style="background-color:white">My Applications</div><br>
    <div class="card-body paid-section" style="background-color:#FAE008;">

    <div class="outer">

         <div class="row">
                    <ul>
                        @foreach($pays as $pay)
                        <!-- Start Column  -->
                        <li>
                            <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                                <span class="product-item " href="#">
                                    <span class="positionAnchor">
                                        <img src="../user/images/{{$pay->payment}}.svg" style="height:500px;" class="img-fluid product-thumbnail">
                                        <span class="title" style="align: center;">
                                            <h3 class="product-title" style="font-size: 22px; color:aliceblue">{{$pay->payment}}</h3>                                           
                                        </span>
                                        <strong class="product-price">{{number_format($pay->amount)}} | </strong>&nbsp;<amp>@foreach($prod as $pp) {{$pp->product_name}} @endforeach<br>Package</amp>

                                        <p>
                                          @foreach($paid as $pd) 
                                           
                                            @if( $pd->product_payment_id == $pay->id)
                                            <a class="btn btn-secondary" href="#">Get Reciept</a>
                                            @else
                                            <a class="btn btn-secondary" href="{{ url('product', $pay->id) }}">Pay Now</a>
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

    </div>
</div>
