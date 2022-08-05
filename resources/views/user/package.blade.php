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
    width:100%;
    margin: 1em auto 0 auto;
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
    top:0;
    font-size: 60px;
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-family: "TTNormsPro-Bold";
    font-weight: bold;
    font-style: normal;

  }

h2 {
    font-size: 50px;
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-family: "TTNormsPro-Bold";
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
    font-family: "TTNormsPro-Regular";
    font-weight: bold;
    font-style: normal;
  }

  p {
    margin-top: 0;
    margin-bottom: 1rem;
    font-family: "TTNormsPro-Regular";
    font-weight: normal;
    font-style: normal;
    font-size: 20px;
  }

  li {
    margin-top: 0;
    margin-bottom: 0.4rem;
    font-family: "TTNormsPro-Regular";
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

 .text .subheading{
    font-size: 25px;
    color: #000;
  }

  a {
    text-decoration: none;
    color: #000;
    margin-top: 0.1rem;
    margin-bottom: 0.4rem;
    font-family: "TTNormsPro-Regular";
    font-weight: normal;
    font-style: normal;
    font-size: 20px;
  }
  a .hoveer {
    color: yellow;
  }

  @media (max-width: 991.98px) {
    .course .text {
      width: 100%;
    }
  }

  .course .text .subheading {
    color: #000000;
  }

  .course .text .subheading span {
    color: #000;
  }

  .course .text h3 {
    font-weight: 500;
    font-size: 24px;
  }

  .course .img {
    width: 250px;
  }

  @media (max-width: 991.98px) {
    .course .img {
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
          <div>
            <p style="font-style: italics; text-decoration:none"><a href="/"><b><i>Packages </a>  > {{$data->product_name}} </i></b></p>
          </div>
          <div class="col-md-6 col-sm-12 img-fluid">
            <img src="../user/images/{{$data->image}}"  width="96%" border="0" alt="" />
          </div>
          <div class="col-md-6 col-sm-12 text" style="padding-right:2px">
            <h1>{{$data->product_name}}</h1>
            <p class="subheading"><span>{{$data->slogan}}</span></p>
            <p>{{$data->description}}</p><br>
            <h2>{{number_format($data->unit_price,2)}} {{$data->currency}}</h2>
            <p class="subheading"><i class="fa fa-minus-circle btn btn-tertiary"></i>{{$data->discount}}% lower than last month</p><br>

            <p>
<h3>Payment Installments</h3>
<table width="100%" border=0 style = "background-color:#e0e0e0">
<tr>
@foreach($ppay as $ppays)  

<td align="left" style="padding:10px; font-size:20px;border-color:#fff">{{ $ppays->payment }} -> {{ $ppays->amount}}  || </td>

@endforeach  
</tr></table>
<br>
</p>


            <h3>Working in {{$data->product_name}} provides several benefits, including but not limited to: -</h3>

            <p>
              <ul>
              @if ($data->benefits != "")
              
                @foreach(explode(' - ' ,$data->benefits) as $item)
                
                  <li> {{$item}} </li>
                  
                @endforeach
              @endif
              </ul>
            </p>
            <p><input type="checkbox"> By checking this box you accept our Terms & Conditions</p>
            @if(Route::has('login'))
            @auth 
            <p><a class="btn btn-secondary" href="{{ url('append_signature', $data->id) }}">Purchase Now</a></p>
            @else 
            <p><a class="btn btn-secondary" href="{{ url('login') }}">Purchase Now</a></p>
            @endauth
            @endif
          </div>
      
      </div>
    </div>
  </section>

</body>

</html>