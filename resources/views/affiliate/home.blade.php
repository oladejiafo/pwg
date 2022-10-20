@extends('affiliate.layout.master')
@section('content')
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
                            <button class="btn start">Start Earning Now</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 land-right-sec">
                        <div class="landingpageicon">
                            <img src="{{asset('/images/affiliate/Landingpageicon.svg')}}" width="100%" height="100%">
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
                    <div class="col-4">
                        <div class="step-1">
                            <img src="{{asset('images/affiliate/Step1.svg')}}" width="100%" height="100%" >
                            <div class="step-1-desc">
                                <h4>Register on our platform</h4>
                                <p>Easy registration,few details and you </br> are set to go </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="step-2">
                            <img src="{{asset('images/affiliate/Step2.svg')}}" width="100%" height="100%">
                            <div class="step-2-desc">
                                <h5>Refer your friend & Earn</h5>
                                <p>Invite friends and other people to<br>
                                    have their Europe dream come true <br>
                                   by working in Poland </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="step-3">
                            <img src="{{asset('images/affiliate/Step3.svg')}}" width="100%" height="100%">
                            <div class="step-3-desc">
                                <h5>Withdraw your Earnings</h5>
                                <p>Transfer your earnings to your prefered <br>
                                    bank account.</p>
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
                <div class="col-6">
                    
                </div>
                <div class="col-6">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection