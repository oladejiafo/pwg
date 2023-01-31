@extends('affiliate.layout.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">

<style>
  body {
    font-family: 'TT Norms Pro';
    font-style: normal;
    width: 100%;
  }
  .card {
    padding-block: 50px;
    padding-left: 10%;
    padding-right: 10%;
    height: auto;
  }
  .mainsec{
    width: 80% !important;
    /* background-color: #fff; */
    margin-top: 3% !important;
  }
  .tab-pane {
    margin-bottom: 3%;
  }
  .ref-tab {
    margin-top: 20px;
  }
  tr {
    height: 50px !important;
  }
  .container-fluid{
    /* margin-top: 3% !important; */
    margin: auto;
  }
  @media (max-width: 789px) and (min-width: 260px)
  {
    body {
    width:fit-content;
    }
    thead {
      font-size: 15px;
    }
    tbody {
      font-size:12px;
    }
    .card {
    padding: 10px;
    }
    .mainsec{
      width: 100% !important;
    }
    .container-fluid{
      width: 100% !important;
    }
  }
</style>
@section('content')
<div class="container-fluid page-body-wrapper mainSec">
  <div class="row">
    <div class="col-12">

      <h2 style="text-align: center;color:#2c3144">My Total Earnings</h2>
      <p style="text-align: center;color:#2c3144"></p>
      <div class="tab-content clearfix" style="margin: 0; padding: 0;">

        <div class="card" id="earning">
          <div class="card-body table-responsive">
            <table class="table table-hover" width="100%">
              <thead>
              <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
                <th scope="col" style="padding:5px;">Referred Name</th>
                <th scope="col" style="padding:5px;">Referred Type</th>
                <th scope="col" style="padding:5px; text-align:right">Earned Commission</th>
                <th scope="col" style="padding:5px; text-align:center">Payment Date</th>
                <th scope="col" style="padding:5px; text-align:center">Status</th>
              </tr>
              </thead>
              @php 
                $sn=0;
                $tcomm=0;
              @endphp
              @foreach($clients as $client)
                @php
                  $reffered = DB::table('clients')
                    ->where('id', '=', $client->client_id)
                    ->get();

                  $pays = DB::table('payments')
                    ->where('application_id', '=', $client->id)
                    ->where('payment_type', '=', 'FIRST')
                    ->first();

                  $prod = DB::table('pricing_plans')
                    ->where('destination_id', '=', $client->destination_id)
                    ->first();

                  $comm = DB::table('commission')
                    ->where('product_id', '=', $client->destination_id)
                    ->first();

                  list($product, $ot) = explode(' ', $prod->plan_name);
                @endphp
                @foreach($reffered as $reffer)
                  @php
                  $name = $reffer->name . ' ' . $reffer->sur_name;
                  $tcomm = $tcomm + $comm->client_commission;
                  @endphp
                @endforeach
                <tbody>
                <tr style="color: #9d9e9f;background-color: #fff;">
                  <td style="padding:5px;">{{$name}}</td>
                  <td style="padding:5px;">Client</td>
                  <td style="padding:5px;text-align:right">{{number_format($comm->client_commission,2)}} <span style="font-size:10px;">AED</span> </td>
                  <td style="padding:5px;text-align:center">{{$pays->payment_date}}</td>
                  <td style="padding:5px;text-align:center">{{$client->first_payment_status}}</td>
                </tr>
              
              @endforeach

              <!-- Affiliates -->
              @foreach($affiliates as $affiliate)
                @php
                  $reffered = DB::table('applications')
                  ->where('refferer_code', '=', $affiliate->affiliate_code)
                  ->get();
                @endphp 
              
                @foreach($reffered as $reff)
                  @php
                    $comm = DB::table('commission')
                    ->where('product_id', '=', $reff->destination_id)
                    ->first();
                  @endphp  
                @endforeach

                @php
                  if(isset($comm))
                  {
                      $comm_aff = ($comm->affiliate_commission/100) * $comm->client_commission;
                  } else {
                      $comm_aff = 0;
                  }
                  $cnt = $reffered->count();
                  $name = $affiliate->first_name . ' ' . $affiliate->surname;
                  $commision = $cnt * $comm_aff;
                  $tcomm = $tcomm + $commision;
                @endphp

                <tr style="color: #9d9e9f;background-color: #fff;">
                  <td style="padding:5px;">{{$name}}</td>
                  <td style="padding:5px;">Affiliate</td>
                  <td style="padding:5px;text-align:right">{{number_format($commision,2)}} <span style="font-size:10px;">AED</span></td>
                  <td style="padding:5px;text-align:center">{{date('Y-m-d', strtotime($affiliate->created_at))}}</td>
                  <td style="padding:5px;text-align:center">{{$client->first_payment_status}}</td>
                </tr>
              @endforeach
              <tr style="color:#9d9e9f;background-color: #fff; padding-block:10px; border-block: 1px solid #cccccc;font-weight:bold">
                <td style="padding:5px; font-size:17px;" colspan=2>Total:</td>
                <td style="padding:5px; font-size:17px;text-align:right">{{number_format($tcomm,2)}} <span style="font-size:10px;">AED</span></td>
                <td style="padding:5px; font-size:17px;text-align:center"></td>
                <td style="padding:5px; font-size:17px;text-align:center"></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('affiliate-scripts')
  <script>

  </script>
@endpush