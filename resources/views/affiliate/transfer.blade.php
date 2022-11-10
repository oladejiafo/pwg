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

      <h2 style="text-align: center;color:#2c3144">Make a Transfer</h2>
      <div class="ref-tab">
        <div class="row">
          <div class="col-6">
            <div class="transferTab active" data-toggle="tab" role="tab" aria-selected="true">
              <a href="#transferTab">
                <h4><i id="transfer" class="fa fa-minus-circle"></i> New Transfer</h4>
              </a>
            </div>
          </div>
          <div class="col-6">
            <div class="historyTab" data-toggle="tab" role="tab" aria-selected="false">
              <a href="#historyTab">
                <h4><i id="history" class="fa fa-plus-circle"></i> Transaction History</h4>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-content clearfix" style="margin: 0; padding: 0;">
         @include('affiliate.new-transfer')
         @include('affiliate.transfer-history')
      </div>
      </div>
  </div>
</div>
@endsection

@push('affiliate-scripts')
<script>
$(document).ready(function(){
    $('#transferTab').show();
    $('#historyTab').hide();
    $('.transferTab').addClass('active');
    $('.historyTab').removeClass('active');
})
$('.transferTab').click(function(){
    $('#transferTab').show();
    $('#historyTab').hide();
    $('.transferTab').addClass('active');
    $('.historyTab').removeClass('active');

    $('#transfer').toggleClass('fa-minus-circle fa-plus-circle');
    $('#history').toggleClass('fa-plus-circle fa-minus-circle');
});
$('.historyTab').click(function(){
    $('#historyTab').show();
    $('#transferTab').hide();
    $('.historyTab').addClass('active');
    $('.transferTab').removeClass('active');

    $('#transfer').toggleClass('fa-minus-circle fa-plus-circle');
    $('#history').toggleClass('fa-plus-circle fa-minus-circle');
});
</script>
@endpush