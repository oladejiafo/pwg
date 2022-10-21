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
                                <p>Easy registration,few details and you are set to go </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="step-2">
                            <img src="{{asset('images/affiliate/Step2.svg')}}" width="100%" height="100%">
                            <div class="step-2-desc">
                                <h5>Refer your friend & Earn</h5>
                                <p>Invite friends and other people to have their Europe dream come true by working in Poland </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="step-3">
                            <img src="{{asset('images/affiliate/Step3.svg')}}" width="100%" height="100%">
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
                {{-- <div class="col-6">

                </div>
                <div class="col-6">

                </div> --}}
                <div class="col-xs-11 col-sm-7">
                    <div class="panel-group" id="accordion">
                
                        <!-- start panel left -->
                        <div class="panel-left col-sm-6">
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_1">
                                        TEST_1
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_2">
                                        TEST_2
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_3">
                                        TEST_3
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_4">
                                        TEST_4
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_5">
                                        TEST_5
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_5" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_6">
                                        TEST_6
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_6" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                
                
                
                        </div> 
                        <!-- end panel left -->
                
                
                        <!-- start panel right -->
                        <div class="panel-left col-sm-6">
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_7">
                                        TEST_7
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_7" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_8">
                                        TEST_8
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_8" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_9">
                                        TEST_9
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_9" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_10">
                                        TEST_10
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_10" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_11">
                                        TEST_11
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_11" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                            <!-- start panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#TEST_12">
                                        TEST_12
                                     </a>
                                    </h4>
                                </div>
                                <div id="TEST_12" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        TESTTESTTESTTESTTEST
                                    </div>
                                </div>
                            </div>
                            <!-- end panel -->
                
                
                
                
                        </div> 
                        <!-- end panel right -->
                
                
                
                
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('affiliate-scripts')
    <script>
        $('#accordion').on('show.bs.collapse', function () {
            $('#accordion .in').collapse('hide');
        });
    </script>    
@endpush