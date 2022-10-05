<!DOCTYPE html>

<html>

@include('user/header')

<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">

<style>
  .se2 {
    width: 100% !important;
    background-color: #FFCD04 !important;
    border-style: none !important;
    margin-bottom: 5px !important;
  }

  .se2:hover {
    background-color: white !important;
    border-color: grey !important;
    border-style: solid !important;
  }
</style>

<body>

  @if($promo->first())
  @foreach($promo as $prom)
  <?php
  // $offer_discount= $data->prev_discount - $data->discount;

  if ($prom->discount_percent > 0) {
    $icon = 'fa fa-minus-circle';
    $offer_discount_msg = 'Promo Offer: ' . number_format($data->discount) . '% Off !';
    //}
    // else if($offer_discount < 0)
    // { 
    //   $icon = 'fa fa-plus-circle';
    //  $offer_discount_msg = number_format(($offer_discount*-1)) .'% higher than last month';
  } else {
    $icon = '';
    $offer_discount_msg = '';
  }

  ?>
  @endforeach

  @else
  @php
  $icon = '';
  $offer_discount_msg = ''; @endphp
  @endif

  <section class="product-section">
    <div class="container-fluid">
      <div class="row" style="margin-block: 50px; background-color:#fff; border-radius:10px">

        <!-- <p style="font-style: italics; text-decoration:none"><a href="/"><b><i>Packages </a> > {{$data->name}} </i></b></p> -->

        <div class="col-12 col-md-12 col-lg-6 img-fluid packageImage" style="margin-bottom: 0px;">
          <img src="../user/images/{{$data->image}}" style="border-radius:10px" width="100%" height="100%" border="0" alt="PWG Group" />
        </div>
        <div class="col-12 col-md-12 col-lg-6 text">
          <h1>{{$data->name}}</h1>
          <p class="subheading"><span>{{$data->slogan}}</span></p>
          <p>{{$data->description}}</p>
          <h2>
            <?php
             $totalCost = Session::get('totalCost');
               
              if (is_numeric($totalCost))
              {
                $totalCost = number_format($totalCost,2);
              } else {
                $totalCost = $totalCost;
              }
            ?> 
            @if (Session::get('totalCost') >0)
             
               {{ $totalCost }} 
            @else
               {{number_format($ppay->total_price,2)}} 
            @endif 
            <span style="font-size:25px">{{$data->currency}} </span>
          </h2>

          <p class="subheading" style="margin-left: 0px;">
            <i class="<?php echo $icon; ?>"></i><i> {{$offer_discount_msg}} </i>
          </p><br>

          @if(Session::has('packageType'))
            @php
             $a = explode(' ', Session::get('packageType'));
             $ptype = $a[0] . ' ' . $a[1];
            @endphp
          @else 
             $ptype ='';  
          @endif
     
          

          <p>
          <h3>{{$ptype}} Payment Installments</h3>
          <table border=0 style="border-radius:10px">
            <tr>
              <td align="left" class="pie" style="border-color:#fff;">
                <img src="../user/images/progress_payment_1.svg" alt="PWG Group">
              </td>
              <td align="center" class="line" style="border-color:#fff;">
                <img src="../user/images/progress_bar.svg" alt="PWG Group">
              </td>
              <td align="left" class="pie" style="border-color:#fff;">
                <img src="../user/images/progress_payment_2.svg" alt="PWG Group">
              </td>
              @if($ppay->third_payment_price > 0)
              <td align="center" class="line" style="border-color:#fff;">
                <img src="../user/images/progress_bar.svg" alt="PWG Group">
              </td>
              <td align="left" class="pie" style="border-color:#fff;">
                <img src="../user/images/progress_payment_3.svg" alt="PWG Group">
              </td>
              @endif              
            </tr>

            <tr>
              <td align="center" style="border-color:#fff;">
                <span class="prices" style="font-size:30px;font-weight:bold;">{{number_format($ppay->first_payment_price)}} </span><br>
                <span class="pays" style="margin-left:0px;font-size:10px;font-weight:bold;">First Payment</span>
              </td>
              <td align="left" style="border-color:#fff;width:60px"> </td>
              <td align="center" style="border-color:#fff;">
                <span class="prices" style="font-size:30px;font-weight:bold;">{{number_format($ppay->second_payment_price)}} </span><br>
                <span class="pays" style="margin-left:0px;font-size:10px;font-weight:bold;">Second Payment</span>
              </td>
              @if($ppay->third_payment_price > 0)
              <td align="left" style="border-color:#fff;width:60px"> </td>
              <td align="center" style="border-color:#fff;">
                <span class="prices" style="font-size:30px;font-weight:bold;">{{number_format($ppay->third_payment_price)}} </span><br>
                <span class="pays" style="margin-left:0px;font-size:10px;font-weight:bold;">Third Payment</span>
              </td>
              @endif
            </tr>

          </table>

          </p>
   

          <br>
          <h4>Working in {{$data->name}} provides several benefits not limited to:</h4>

          <p>
          <ul>
            @if ($data->benefits != "")

            @foreach(explode(' - ' ,$data->benefits) as $item)

            <li> {{$item}} </li>

            @endforeach
            @endif
          </ul>
          </p>

          @if(Route::has('login'))
          @auth
          <form action="{{ url('contract', $data->id) }}" method="GET">
            @else
            <form action="{{ url('login') }}">
              @php Session::put('prod_id', $data->id); @endphp
              @endauth
              @endif
              <input type="hidden" value="{{$data->id}}">

              <p style="margin-left:2px;font-weight:bold; font-size:1.4em">Please, select one of the following options:</p>
              <?php
              if ($data->full_payment_discount > 0) {
              ?>
                <p style="margin-left:2px;font-weight:bold">Get {{number_format($data->full_payment_discount)}}% discount on Full Payment</p>
              <?php
              }

              ?>

              <p><button class="btn btn-secondary se2" id="buy" value="1" name="payall" style="font-size:1.6em">Full Payment</button>
                <button class="btn btn-secondary" id="buy" value="0" name="payall" style="width:100%; font-size:1.6em">Pay in Installments</button>
              </p>

              <p>&nbsp; <input type="checkbox" class="checkcolor" id="agree" style="font-size:25px;transform: scale(1.8); " required=""> &nbsp; By checking this box you accept our <a href="#" style="color:blue;margin:0">Terms & Conditions</a></p>
            </form>

        </div>

      </div>
    </div>
  </section>
  <script>
    $('#reset').click(function() {
      if (!$('#agree').is(':checked')) {
        alert('You Must Agree To Proceed');
        return false;
      }
    });
  </script>

  {{-- @include('user.package-jobs') --}}


  {{-- Session::get('myproduct_id') --}}

  {{-- Session::get('packageType') --}}
  {{-- Session::get('totalCost') --}}
  {{-- Session::get('mySpouse') --}}
  {{-- Session::get('myKids') --}}

</body>

</html>