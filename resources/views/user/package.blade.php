<!DOCTYPE html>

<html>

@include('user/header')


<!-- bootstrap core css -->
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<style type="text/css" media="screen">
  /* Linked Styles */
  .product-section {
    /* margin: 30px; */
    width: 100%;
    margin: 1em auto 0 auto;
    line-height: normal;
  }

  input[type=checkbox] {
    transform: scale(1.5);
  }

  hr {
    color: #faf9f6;
  }

  img {
    margin-top: 15px;
    margin-right: auto;
    vertical-align: middle;
    border-style: none;
  }

  .img-fluid {

    height: auto;
    /* margin-right: 10px; */
  }

  h1 {
    top: 0;
    font-size: 60px;
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-family: "TT Norms Pro";
    font-weight: bold;
    font-style: normal;

  }

  h2 {
    font-size: 50px;
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-family: "TT Norms Pro";
    font-weight: bold;
    font-style: normal;
  }

  h3,
  h4,
  h5,
  h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    color: #000;
    font-family: "TT Norms Pro";
    font-weight: bold;
    font-style: normal;
  }

  p {
    margin-top: 0;
    margin-bottom: 1rem;
    font-family: "TT Norms Pro";
    font-weight: normal;
    font-style: normal;
    font-size: 20px;
  }

  li {
    margin-top: 0;
    margin-bottom: 0.4rem;
    font-family: "TT Norms Pro";
    font-weight: normal;
    font-style: normal;
    font-size: 20px;
    list-style-type: disc;
  }

  .text {
    /* width:90%; */
    margin-top: 0;

    justify-content: left;
    /* width: calc(100% - 250px); */
  }

  .text .subheading {
    font-size: 25px;
    color: #000;
  }

  a {
    text-decoration: none;
    color: #000;
    margin-top: 0.1rem;
    margin-bottom: 0.4rem;
    font-family: "TT Norms Pro";
    font-weight: normal;
    font-style: normal;
    font-size: 20px;
  }

  a .hoveer {
    color: yellow;
  }

  @media (max-width: 991.98px) {
    .text {
      width: 100%;
    }
  }

  .text .subheading {
    color: #000000;
  }

  .text .subheading span {
    color: #000;
  }

  .text h3 {
    font-weight: 500;
    font-size: 24px;
  }

  .img {
    width: 250px;
  }

  @media (max-width: 991.98px) {
    .img {
      width: 100%;
      height: 300px;
    }
  }

  /* Mobile styles */
  @media only screen and (max-device-width: 480px),
  only screen and (max-width: 480px) {}
</style>

<body>

  <section class="product-section">
    <div class="container-fluid">
      <div class="row">

        <p style="font-style: italics; text-decoration:none"><a href="/"><b><i>Packages </a> > {{$data->product_name}} </i></b></p>

        <div class="col-md-6 col-sm-12 img-fluid">
          <img src="../user/images/{{$data->image}}" width="96%" height="99%" border="0" alt="" />
        </div>
        <div class="col-md-6 col-sm-12 text" style="padding-right:2px">
          <h1>{{$data->product_name}}</h1>
          <p class="subheading"><span>{{$data->slogan}}</span></p>
          <p>{{$data->description}}</p>
          <h2>{{number_format($data->unit_price,2)}} {{$data->currency}}</h2>
          <p class="subheading"><i class="fa fa-minus-circle btn btn-tertiary"></i>{{$data->discount}}% lower than last month</p>

          <p>
          <h3>Payment Installments</h3>
          <table width="540px" border=0 style="border-radius:10px">
            <tr>

              @foreach($ppay as $ppays)

              <td align="left" style="border-color:#fff;width:100px">

                <img src="../user/images/progress_payment_{{ $ppays->id}}.svg" width="100px" height="100px" alt="">

                @if(!$loop->last)
              </td>
              <td align="center" style="border-color:#fff;width:120px">
                <img src="../user/images/progress_bar.svg" alt="" width="120px" height="20px">
                @endif
              </td>

              @endforeach
            </tr>

            <tr>

              @foreach($ppay as $ppays)

              <td align="center" style="border-color:#fff;width:80px">

                <span style="font-size: 30px;font-weight:bold;">{{number_format($ppays->amount)}} </span><br>
                <span style="font-size: 12px;font-weight:bold;">{{$ppays->payment}}</span>

                @if(!$loop->last)
              </td>
              <td align="left" style="border-color:#fff;width:60px">

                @endif
              </td>

              @endforeach
            </tr>

          </table>

          </p>


          <h3>Working in {{$data->product_name}} provides several benefits, including but not limited to:</h3>

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
          <form action="{{ url('referal_details', $data->id) }}">
            @else
            <form action="{{ url('login') }}">
              @endauth
              @endif
              <p><input type="checkbox" id="agree" style="font-size:25px" required> By checking this box you accept our Terms & Conditions</p>

              <p><button class="btn btn-secondary" id="buy">Purchase Now</button></p>

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
</body>

</html>