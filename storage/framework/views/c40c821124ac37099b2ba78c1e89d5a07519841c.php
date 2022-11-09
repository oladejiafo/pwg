
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->startSection('content'); ?>
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
    background-color: #fff;
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

      <h2 style="text-align: center;color:#2c3144">My Refferals</h2>
      <div class="ref-tab">
        <div class="row">
          <div class="col-6">
            <div class="clientTab active" data-toggle="tab" role="tab" aria-selected="true">
              <a href="#clientTab">
                <h4><i id="cl" class="fa fa-minus-circle"></i> Reffered Clients</h4>
              </a>
            </div>
          </div>
          <div class="col-6">
            <div class="affiliateTab">
              <a href="#affiliateTab" data-toggle="tab" role="tab" aria-selected="false">
                <h4><i id="af" class="fa fa-plus-circle"></i> Reffered Affiliates</h4>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-content clearfix" style="margin: 0; padding: 0;">

        <?php echo $__env->make('affiliate.reffered-client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('affiliate.reffered-affiliates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('affiliate-scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('affiliate.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shakun\Desktop\myGit\PWG\resources\views/affiliate/refferals.blade.php ENDPATH**/ ?>