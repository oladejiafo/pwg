
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="bannerImage">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 land-left-sec">
                        <div class="row">
                            <h1 class="land-font">
                                Referrals &<br>
                                Affiliate <br>
                                Program <br>
                            </h1>
                        </div>
                        <div class="row">
                            <p class="left-sub">
                                Recommend clients. Start earning immediately.
                                <br>
                                We are for people ! 
                            </p>
                        </div>
                        <div class="row">
                            <form action="<?php echo e(route('affiliate.login')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn start">Start Earning Now</button>
                            </form>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 land-right-sec">
                        <div class="landingpageicon">
                            <img src="<?php echo e(asset('/images/affiliate/Landingpageicon.svg')); ?>" width="100%" height="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="steps">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="step-1">
                            <img src="<?php echo e(asset('images/affiliate/Step1.svg')); ?>" width="100%" height="100%" >
                            <div class="step-1-desc">
                                <h5>Register on our platform</h5>
                                <p>Easy registration,few details and you are set to go </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="step-2">
                            <img src="<?php echo e(asset('images/affiliate/Step2.svg')); ?>" width="100%" height="100%">
                            <div class="step-2-desc">
                                <h5>Refer your friend & Earn</h5>
                                <p>Invite friends and other people to have their Europe dream come true by working in Poland </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="step-3">
                            <img src="<?php echo e(asset('images/affiliate/Step3.svg')); ?>" width="100%" height="100%">
                            <div class="step-3-desc">
                                <h5>Withdraw your Earnings</h5>
                                <p>Transfer your earnings to your prefered bank account.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="faqs">
                <div class="d-flex  align-items-center justify-content-center">
                    <h1>FAQs</h1>
                </div>
                <div class="d-flex  align-items-center justify-content-center">
                    <p style="text-align: center;">
                        Detailed answers to the most common questions about our Affiliate program. <br>
                        Learn how to start earning with PWG Group Refferal program.
                    </p>
                </div>
                <div class="faq-accordion">
                    <div class="accordion accordion-flush" id="accordionFlushFaqLeft">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="row accordion-left">                        
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                <b>What is PWG Group?</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushFaqLeft">
                                            <div class="accordion-body">PWG Group is an immigration company that helps students and professionals migrate abroad to either pursue their studies or careers.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faq-four">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-faq" aria-expanded="false" aria-controls="flush-faq">
                                                <b>Is PWG legitimate?</b>
                                            </button>
                                        </h2>
                                        <div id="flush-faq" class="accordion-collapse collapse" aria-labelledby="faq-four" data-bs-parent="#accordionFlushFaqLeft">
                                            <div class="accordion-body">Yes,  PWG Group is registered in the UAE and has been in operation for 8 years. It has helped more than 3000 professionals to migrate to Poland, Germany, Czech Republic, Malta and Canada. You can check out some testimonial videos from some of our successful applicants here.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="row accordion-right">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                <b>How do I pay for my application process?</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushFaqLeft">
                                            <div class="accordion-body">You must pay a down payment to start the application process, followed by a second installment once the visa is approved. The third and final payment is made after you arrive at your dream destination. </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                <b>I’m outside the UAE, can I apply for my visa through PWG?</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushFaqLeft">
                                            <div class="accordion-body">Yes, you can apply virtually from any country by contacting us via Whatsapp +971 50 423 0438</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('affiliate.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dejia\OneDrive\Desktop\mygit\pwg_eportal\resources\views/affiliate/home.blade.php ENDPATH**/ ?>