<!DOCTYPE html>

<html>

@include('user/header')

<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="{{asset('user/css/products.css')}}" rel="stylesheet">

<body>
<?php
  $offer_discount= $data->prev_discount - $data->discount;
  
  if($offer_discount >0)
  { 
    $icon = 'fa fa-minus-circle';
    $offer_discount_msg = number_format($offer_discount) .'% lower than last month';
  }
  else if($offer_discount < 0)
  { 
    $icon = 'fa fa-plus-circle';
   $offer_discount_msg = number_format(($offer_discount*-1)) .'% higher than last month';
  } else {
    $icon = '';
   $offer_discount_msg = '';
  }
  
?>

  <section class="product-section">
    <div class="container-fluid">
      <div class="row">

        <p style="font-style: italics; text-decoration:none"><a href="/"><b><i>Packages </a> > {{$data->product_name}} </i></b></p>

        <div class="col-md-6 col-sm-12 img-fluid" style="margin-bottom: 20px;">
          <img src="../user/images/{{$data->image}}" width="100%" height="99%" border="0" alt="" />
        </div>
        <div class="col-md-6 col-sm-12 text">
          <h1>{{$data->product_name}}</h1>
          <p class="subheading"><span>{{$data->slogan}}</span></p>
          <p>{{$data->description}}</p>
          <h2>{{number_format($data->unit_price,2)}} {{$data->currency}}</h2>
          <p class="subheading" style="margin-left: 0px;"><i class="<?php echo $icon; ?>"></i> {{$offer_discount_msg}}</p>

          <p>
          <h3>Payment Installments</h3>
          <table border=0 style="border-radius:10px">
            <tr>

              @foreach($ppay as $ppays)

              <td align="left" class="pie" style="border-color:#fff;">

                <img src="../user/images/progress_payment_{{ $ppays->id}}.svg" alt="">

                @if(!$loop->last)
              </td>
              <td align="center" class="line" style="border-color:#fff;">
                <img src="../user/images/progress_bar.svg" alt="">
                @endif
              </td>

              @endforeach
            </tr>

            <tr>

              @foreach($ppay as $ppays)

              <td align="center" style="border-color:#fff;">

                <span class="prices" style="font-size:30px;font-weight:bold;">{{number_format($ppays->amount)}} </span><br>
                <span class="pays" style="margin-left:0px;font-size:10px;font-weight:bold;">{{$ppays->payment}}</span>

                @if(!$loop->last)
              </td>
              <td align="left" style="border-color:#fff;width:60px">

                @endif
              </td>

              @endforeach
            </tr>

          </table>

          </p>

<br>
          <h4>Working in {{$data->product_name}} provides several benefits, including but not limited to:</h4>

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
            <form action="{{ url('append_signature', $data->id) }}" method="GET">
          @else
            <form action="{{ url('login') }}">
           @endauth
          @endif
          <input type="hidden" value="{{$data->id}}">
          <p><input type="checkbox" class="checkcolor" id="agree" style="font-size:25px;transform: scale(1.8); " required=""> &nbsp; By checking this box you accept our Terms & Conditions</p>
              <p><button class="btn btn-secondary" id="buy" value="1" name="payall">FULL PAYMENT</button>
                 <button class="btn btn-secondary" id="buy" value="0" name="payall">PARTIAL PAYMENT</button></p>
            </form>
            <?php
if ($data->full_payment_discount > 0) {
    ?>
            <p style="margin-left:2px;font-weight:bold">Get {{number_format($data->full_payment_discount)}}% discount on Full Payment</p>
            <?php
}
?>
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

  @include('user.package-jobs')
</body>

</html>