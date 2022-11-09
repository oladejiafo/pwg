@extends('affiliate.layout.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
@section('content')
<style>
  body {
    font-family: 'TT Norms Pro';
    font-style: normal;

  }
  .card {
    padding-block: 50px;
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
  .container-fluid{
    /* margin-top: 3% !important; */
    margin: auto;
  }
  @media (max-width: 789px) and (min-width: 260px){
  .mainsec{
    width: 100% !important;
  }
   .container-fluid{
    width: 100% !important;
  }
  }
</style>
<div class="container-fluid page-body-wrapper mainSec">

  <div class="row">
    <div class="col-12">

      <h2 style="text-align: center;color:#2c3144">My Referrals</h2>
      <div class="ref-tab">
        <div class="row">
          <div class="col-6">
            <div class="clientTab active" data-toggle="tab" role="tab" aria-selected="true">
              <a href="#clientTab">
                <h4><i id="cl" class="fa fa-minus-circle"></i> Referred Clients</h4>
              </a>
            </div>
          </div>
          <div class="col-6">
            <div class="affiliateTab" data-toggle="tab" role="tab" aria-selected="false">
              <a href="#affiliateTab">
                <h4><i id="af" class="fa fa-plus-circle"></i> Referred Affiliates</h4>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-content clearfix" style="margin: 0; padding: 0;">
        @include('affiliate.reffered-client')
        @include('affiliate.reffered-affiliates')
      </div>
      </div>
  </div>
</div>
@endsection

@push('affiliate-scripts')
<script>
$(document).ready(function(){
    $('#clientTab').show();
    $('#affiliateTab').hide();
    $('.clientTab').addClass('active');
    $('.affiliateTab').removeClass('active');
})
$('.clientTab').click(function(){
    $('#clientTab').show();
    $('#affiliateTab').hide();
    $('.clientTab').addClass('active');
    $('.affiliateTab').removeClass('active');

    $('#cl').toggleClass('fa-minus-circle fa-plus-circle');
    $('#af').toggleClass('fa-plus-circle fa-minus-circle');
});
$('.affiliateTab').click(function(){
    $('#affiliateTab').show();
    $('#clientTab').hide();
    $('.affiliateTab').addClass('active');
    $('.clientTab').removeClass('active');

    $('#cl').toggleClass('fa-minus-circle fa-plus-circle');
    $('#af').toggleClass('fa-plus-circle fa-minus-circle');
});
</script>
@endpush