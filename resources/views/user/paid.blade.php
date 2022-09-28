<!--====== Style CSS ======-->
<style>
.watermarked {
  position: relative;
}

.watermarked:after {
  content: "";
  display: block;
  width: 120px;
  height: 120px;
  position: absolute;
  top: 50%;
  left: 35%;
  background-image: url("../user/images/paid_stamp.png");
  background-size: 80px 80px;
  background-position: 30px 30px;
  background-repeat: no-repeat;
  opacity: 0.4;
}

</style>

<link rel="stylesheet" href="../user/assets/css/style.css">

<div class="card d-flex aligns-items-center justify-content-center text-center" style="margin-top:120px">
  <div class="card-header" style="background-color:white;">My Applications</div>
  <div class="card-body paid-section" style="background-color:#FAE008;">

    <div class="carousel" id="carouselThree" data-ride="carousel">
      <div class="outer scroll-pane" id="container">
        <div class="container-fluid text-center">
          <div class="row paid-thumbnail">
            <ul>
              <!-- 1st Payment Column  -->
              <li>
                <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                  <span class="paid-item " href="#">
                    <span class="positionAnchor  @if($paid->first_payment_status =='Paid')) watermarked @endif paid-thumbnail">
                      <img src="../user/images/First Payment.svg" height="500px" class="img-fluid">
                      <span class="title" style="align: center;">
                        <h3 class="paid-title" style="font-size: 22px; color:aliceblue">First Payment</h3>
                      
                      </span>
                      <strong style="line-height:25px;margin-top:20px" class="paid-price">
                        {{number_format($pays->first_payment_price)}} | 
                        <br><span style="font-size: 12px;float:left;display:inline">AED</span>
                        <span style="font-size: 12px;display:inline; float:right;margin-right:20px;"> + 5% VAT</span>
                      </strong>&nbsp;
                      <amp style="margin-left:18px">
                      
                         {{$prod->name}}
                         <br>Package
                      </amp>

                      @if($paid->first_payment_remaining >0 && $paid->first_payment_status !='Paid')
                         <br><amp style="display:fixed; align-content: center; text-align:center; font-size:10px !important; color:#ff0000;padding:1px;margin-left: 20px; line-height:100% !important; margin-top: 70px; margin-left:-100px">(Outstanding on 1st Payment: {{$paid->first_payment_remaining}}.)</amp>
                         <a class="btn" target="_blank" href="{{ route('getInvoice','First Payment')}}" style="display:fixed; align-content: center; text-align:center; font-size:10px !important; top:340px; height:25px; width:150px;margin-left: 25px;">Get Invoice Here</a>
                      @endif
  
                      <p>
                          @if($paid->first_payment_status =='Paid')
                          
                            <a class="btn btn-secondary" target="_blank" href="{{ route('getReceipt','First Payment')}}">Get Reciept</a>
                          @else
                          
                            <form action="{{ route('payment',$prod->id) }}" method="GET">
                              <button class="btn btn-secondary">Pay Now</button>
                            </form>
                          
                          @endif
                      </p>
                    </span>
                  </span>
                </div>

                @if($pays->pricing_plan_type)
                  @php
                  $a = explode(' ', $pays->pricing_plan_type);
                  $ptype = $a[0] . ' ' . $a[1];
                  @endphp
                  @if($pays->pricing_plan_type != 'Family Package') 
                    @php 
                      $ptype =$ptype . ' Package';  
                    @endphp
                  @endif
                @else
                 @php 
                  $ptype ='';  
                 @endphp 
                @endif
                
                <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block">
                  <div class="cardc-body">
                    
                    <div style="display:inline" id="ddx" class="block2 download-thumbnail img-fluid" data-bs-toggle="modal" data-bs-target="#statusModal">
                      <p style="font-size:11px; margin-top:20%;">Click for more info</p>
                    </div>
                    <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                      <p style="padding-top: 27px;padding-bottom:0px; font-size:14px;font-weight:800">Application Status</p>
                      <span style="font-size:11px !important; color:grey;padding-left:1px; padding-right:1px; line-height:100% !important">( {{$ptype}} )</span>
                      @if($paid->application_stage_status != 5)
                       @if($paid->application_stage_status==2)
                        @php 
                          $linkk = "applicant.details";
                        @endphp
                       @elseif($paid->application_stage_status==3)
                        @php 
                          $linkk = "applicant.details";
                        @endphp 
                       @elseif($paid->application_stage_status==4)
                        @php 
                          $linkk = "applicant.review";
                        @endphp   
                        @else
                          @php 
                            $linkk = "payment";
                          @endphp    
                       @endif
                      <a href="{{route($linkk, $paid->destination_id)}}">
                       <p style="display:fixed; align-content: center; text-align:center; font-size:9px !important; color:#ff0000;padding:1px;margin-left: 20px; line-height:100% !important">
                         Application process not completed. Click here
                       </p>
                      </a>
                      @endif
                    </div>
                  </div>
                </div>
              </li>

              <!-- 2nd Payment Column  -->
              <li>
                <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                  <span class="paid-item " href="#">
                    <span class="positionAnchor  @if($paid->second_payment_status =='Paid')) watermarked @endif paid-thumbnail">
                      <img src="../user/images/Second Payment.svg" height="500px" class="img-fluid">
                      <span class="title" style="align: center;">
                        <h3 class="paid-title" style="font-size: 22px; color:aliceblue">Second Payment</h3>
                      
                      </span>
                      <strong style="line-height:25px;margin-top:20px" class="paid-price">
                        {{number_format($pays->second_payment_price)}} | 
                        <br><span style="font-size: 12px;float:left;display:inline">AED</span>
                        <span style="font-size: 12px;display:inline; float:right;margin-right:20px;"> + 5% VAT</span>
                      </strong>&nbsp;
                      <amp style="margin-left:18px">
                      
                         {{$prod->name}}
                         <br>Package
                      </amp>

                      <p>
                          @if($paid->second_payment_status =='Paid')
                          <a class="btn btn-secondary" target="_blank" href="{{ route('getReceipt','Second Payment')}}">Get Reciept</a>
                          @else
                          @if($paid->application_stage_status != 5)
                            <button class="btn btn-secondary toastrDefaultError" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                          @else
                            <form action="{{ route('payment',$prod->id) }}" method="GET">

                              <button class="btn btn-secondary">Pay Now</button>
                            </form>
                          @endif
                          @endif
                      </p>
                    </span>
                  </span>
                </div>

                <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block">
                  <div class="cardc-body">
                    
                    <div style="display:inline" id="dd" class="block download-thumbnail img-fluid">
                      <svg style="margin:auto;margin-top:20px" width="39" height="30" class="dd" viewBox="0 0 39 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.78768 24.0116C10.8127 27.5821 14.6843 30 19.1291 30C23.5739 30 27.4456 27.5821 29.4706 24.0116C34.3102 23.9865 38.2328 20.1154 38.2328 15.3547C38.2328 10.5815 34.2847 6.68531 29.4196 6.68531H29.3687L26.2612 9.74216H29.4196C32.5654 9.74216 35.1253 12.2603 35.1253 15.3547C35.1253 18.0107 33.2276 20.2407 30.7059 20.8169C30.2984 20.9046 29.8654 20.9673 29.4196 20.9673C28.7574 20.9673 28.1333 20.8545 27.5475 20.6541C27.2673 21.6563 26.7961 22.5959 26.1847 23.4103C24.5928 25.5525 22.0201 26.9432 19.1164 26.9432C16.2126 26.9432 13.64 25.5525 12.048 23.4103C11.4367 22.5834 10.9655 21.6563 10.6853 20.6541C10.0995 20.8545 9.47541 20.9673 8.81315 20.9673C8.3674 20.9673 7.94712 20.9172 7.52684 20.8169C4.99242 20.2407 3.10753 18.0107 3.10753 15.3547C3.10753 12.2603 5.66742 9.74216 8.81315 9.74216H11.9716L8.8641 6.68531H8.81315C3.96082 6.68531 4.25317e-07 10.569 0 15.3547C0.0254711 20.1154 3.94809 23.9865 8.78768 24.0116Z" fill="#1C7E14" />
                        <path d="M19.1164 12.8037L27.1781 4.87341L22.4532 4.87341V5.73904e-07L15.7796 0V4.87341L11.0547 4.87341L19.1164 12.8037Z" fill="#1C7E14" />
                      </svg>
                    </div>
                    <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                      <p style="padding-top: 27px;padding-bottom:0px; font-size:14px;font-weight:800">Work Permit</p>
                      <span style="font-size:11px; color:grey;padding-left:1px; padding-right:1px">Work Permit not available yet.</span>
                    </div>

                  </div>
                </div>

              </li>

              <!-- 3rd Payment Column  -->

              <li>
                <div align="center" class="col-md-4 col-sm-12 img-fluid cellContainer">
                @if($pays->third_payment_price >0 )
                  <span class="paid-item " href="#">
                    <span class="positionAnchor  @if($paid->third_payment_status =='Paid')) watermarked @endif paid-thumbnail">
                      <img src="../user/images/Final Payment.svg" height="500px" class="img-fluid">
                      <span class="title" style="align: center;">
                        <h3 class="paid-title" style="font-size: 22px; color:aliceblue">Third Payment</h3>
                      
                      </span>
                      <strong style="line-height:25px;margin-top:20px" class="paid-price">
                        {{number_format($pays->third_payment_price)}} | 
                        <br><span style="font-size: 12px;float:left;display:inline">AED</span>
                        <span style="font-size: 12px;display:inline; float:right;margin-right:20px;"> + 5% VAT</span>
                      </strong>&nbsp;
                      <amp style="margin-left:18px">
                      
                         {{$prod->name}}
                         <br>Package
                      </amp>
 
                      <p>
                          @if($paid->third_payment_status =='Paid')
                          <a class="btn btn-secondary" target="_blank" href="{{ route('getReceipt','Third Payment')}}">Get Reciept</a>
                          @else
                            @if($paid->application_stage_status != 5)
                              <button class="btn btn-secondary toastrDefaultError" onclick="toastr.error('Your application process not completed!')">Pay Now</button>                           
                            @else
                            <form action="{{ route('payment',$prod->id) }}" method="GET">

                                <button class="btn btn-secondary">Pay Now</button>
                              </form>
                            @endif
                          @endif
                      </p>
                    </span>
                  </span>
                  @else
                  <span class="paid-item " href="#">
                    <span class="positionAnchor  @if($paid->third_payment_status =='Paid')) watermarked @endif paid-thumbnail">
                      <img src="../user/images/Final Payment.svg" height="500px" class="img-fluid">

                    </span>
                  </span>
                  @endif
                </div>
                @if($pays->third_payment_price >0 )

                  <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block">
                    <div class="cardc-body">
                      
                    <div style="display:inline" id="de" class="block2 download-thumbnail img-fluid">


                      <svg style="margin:auto;margin-top:7px" width="38" height="45" class="de" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
                        <path d="M1.59,27c1.47-1.76,3-3.5,4.4-5.27a1.51,1.51,0,0,1,1.28-.6q8.3,0,16.59,0a2.05,2.05,0,0,0,1-.3c1.29-.82,2.55-1.7,3.84-2.53a.84.84,0,0,0,.43-.81q0-5.52,0-11c0-.22,0-.49.07-.64s.46-.57.74-.61a.94.94,0,0,1,.77.45c.16.4.39.4.72.4h6.32c.8,0,1.09.29,1.1,1.1V12c0,.78-.3,1.07-1.08,1.07H30.85c0,1.21.09,2.36,0,3.49a2.08,2.08,0,0,0,1.22,2.29c1.08.6,2.06,1.37,3.11,2a1.85,1.85,0,0,0,.91.27c5.5,0,11,0,16.48,0a1.77,1.77,0,0,1,1.56.73C55.38,23.41,56.7,25,58,26.52c.29.34.53.68.31,1.14s-.64.51-1.08.5h-.58v25h.87a.83.83,0,1,1,0,1.66H2.82a1.24,1.24,0,0,1-1.23-.56v-.66c.45-.62,1.16-.39,1.74-.48v-25c-.65,0-1.31.1-1.74-.52Zm36.63-4.14.38.29c1.54,1,3.07,2.06,4.61,3.07a1.57,1.57,0,0,0,.82.24c1.72,0,3.44,0,5.16,0a2.56,2.56,0,0,1,.55.05.79.79,0,0,1,.66.83.77.77,0,0,1-.66.78,4,4,0,0,1-.77.05H5.08V48.68H9.59v-6c0-.78.28-1.06,1.07-1.07h3.05c.86,0,1.11.26,1.11,1.13V48.1c0,.2,0,.39,0,.57H16.7c0-2,0-4,0-6,0-.81.28-1.09,1.1-1.1h3c.91,0,1.15.25,1.15,1.16,0,1.77,0,3.55,0,5.32v.6h1.87a2.76,2.76,0,0,1,0-1,1.27,1.27,0,0,1,.64-.72,1.07,1.07,0,0,1,.84.32,1.15,1.15,0,0,1,.18.78c0,1.47,0,2.95,0,4.43,0,.2,0,.4,0,.6h3.57V43.31h-3.6c0,.29,0,.54,0,.8a.85.85,0,1,1-1.7,0c0-.46,0-.92,0-1.39,0-.84.28-1.12,1.14-1.12H35c.88,0,1.15.28,1.15,1.17v5.33c0,.19,0,.39,0,.6h1.83V48c0-1.8,0-3.59,0-5.38,0-.77.28-1,1-1H42.2c.82,0,1.1.29,1.1,1.1v6h1.88v-.63c0-1.81,0-3.63,0-5.44,0-.73.27-1,1-1h3.16c.79,0,1.07.29,1.07,1.07V48.1c0,.19,0,.39,0,.58h4.5V28.16c-.61,0-1.18,0-1.74,0A.84.84,0,0,1,52.36,27a.93.93,0,0,1,1-.52h2.41c-.14-.19-.21-.29-.29-.38-.78-.94-1.58-1.87-2.34-2.82a1.05,1.05,0,0,0-.93-.45c-4.43,0-8.87,0-13.31,0ZM5.05,53.12H23.76V50.43H5.05Zm31.17,0H54.93v-2.7H36.22Zm4.27-26.67-.39-.29c-3.25-2.17-6.51-4.33-9.76-6.52a.56.56,0,0,0-.73,0l-9.12,6.09c-.28.18-.56.38-.92.63a2.47,2.47,0,0,0,.3.05c1.81,0,3.63,0,5.44,0,.35,0,.41-.19.49-.45A4.42,4.42,0,0,1,30,22.9,4.37,4.37,0,0,1,34.17,26c.13.42.32.49.7.49,1.48,0,3,0,4.44,0ZM21.68,23l0-.14h-.59c-4.29,0-8.57,0-12.86,0a1.69,1.69,0,0,0-1.53.72c-.74,1-1.56,1.89-2.38,2.89a1.85,1.85,0,0,0,.28.05H16.16a.72.72,0,0,0,.41-.11C18.28,25.22,20,24.08,21.68,23ZM30.9,43.3v9.83h3.54V43.3Zm0-35.6v3.62h6.22V7.7ZM13.12,43.32H11.31v5.35h1.81Zm33.78,0v5.36h1.81V43.31Zm-28.47,0v5.37h1.79V43.3Zm21.35,0v5.38h1.79V43.3ZM32.51,26.42a2.57,2.57,0,0,0-2.58-1.81,2.54,2.54,0,0,0-2.44,1.81Z" />
                        <path d="M23.81,35.32c0-.83,0-1.66,0-2.49s.32-1,1-1H28c.72,0,1,.32,1,1q0,2.49,0,5c0,.73-.33,1-1.07,1-1,0-2.07,0-3.1,0-.77,0-1.08-.31-1.09-1.07S23.81,36.14,23.81,35.32Zm1.75-1.79v3.58h1.76V33.53Z" />
                        <path d="M36.19,35.36c0,.79,0,1.58,0,2.38s-.32,1.09-1.07,1.09c-1,0-2.11,0-3.16,0-.7,0-1-.32-1-1,0-1.67,0-3.33,0-5,0-.71.31-1,1-1,1.09,0,2.18,0,3.27,0a.9.9,0,0,1,1,1C36.2,33.66,36.19,34.51,36.19,35.36Zm-1.76,1.75V33.55H32.68v3.56Z" />
                        <path d="M14.82,35.31c0,.83,0,1.66,0,2.49s-.31,1-1,1c-1.08,0-2.15,0-3.22,0a.89.89,0,0,1-1-1c0-1.66,0-3.33,0-5,0-.7.3-1,1-1h3.21c.72,0,1,.31,1,1S14.82,34.48,14.82,35.31Zm-1.73,1.8V33.54H11.3v3.57Z" />
                        <path d="M50.41,35.33v2.5a.88.88,0,0,1-1,1c-1.09,0-2.18,0-3.27,0-.67,0-1-.31-1-1q0-2.52,0-5c0-.71.29-1,1-1h3.16c.74,0,1,.32,1,1.05Zm-3.53,1.76h1.83V33.54H46.88Z" />
                        <path d="M16.7,35.25c0-.82,0-1.63,0-2.44s.31-1,1-1c1.09,0,2.18,0,3.27,0,.69,0,1,.31,1,1,0,1.69,0,3.39,0,5.09a.86.86,0,0,1-1,1c-1.1,0-2.21,0-3.32,0a.88.88,0,0,1-.95-1C16.69,37,16.7,36.11,16.7,35.25Zm1.73-1.73v3.57h1.78V33.52Z" />
                        <path d="M38.05,35.3c0-.83,0-1.66,0-2.49s.31-1,1-1h3.21c.7,0,1,.34,1,1q0,2.49,0,5a.9.9,0,0,1-1,1q-1.6,0-3.21,0c-.68,0-1-.31-1-1C38,37,38.05,36.15,38.05,35.3Zm3.53,1.81V33.53h-1.8v3.58Z" />
                      </svg>

                      </div>
                      <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                      <p style="padding-top: 27px;padding-bottom:0px; font-size:14px;font-weight:800">Embassy Appearance</p>
                      <span style="font-size:11px; color:grey;padding-left:1px; padding-right:1px;line-height:1px;">Embassy appearance pending.</span>
                      </div>

                    </div>
                  </div>
                @else
                  <div class="cardc downlaod-item  d-flexx aligns-items-center justify-content-center text-center" style="font-weight: bold;font-family:'TT Norms Pro'; display:inline-block; margin-top:584px">
                    <div class="cardc-body">
                      
                    <div style="display:inline" id="de" class="block2 download-thumbnail img-fluid">


                      <svg style="margin:auto;margin-top:7px" width="38" height="45" class="de" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
                        <path d="M1.59,27c1.47-1.76,3-3.5,4.4-5.27a1.51,1.51,0,0,1,1.28-.6q8.3,0,16.59,0a2.05,2.05,0,0,0,1-.3c1.29-.82,2.55-1.7,3.84-2.53a.84.84,0,0,0,.43-.81q0-5.52,0-11c0-.22,0-.49.07-.64s.46-.57.74-.61a.94.94,0,0,1,.77.45c.16.4.39.4.72.4h6.32c.8,0,1.09.29,1.1,1.1V12c0,.78-.3,1.07-1.08,1.07H30.85c0,1.21.09,2.36,0,3.49a2.08,2.08,0,0,0,1.22,2.29c1.08.6,2.06,1.37,3.11,2a1.85,1.85,0,0,0,.91.27c5.5,0,11,0,16.48,0a1.77,1.77,0,0,1,1.56.73C55.38,23.41,56.7,25,58,26.52c.29.34.53.68.31,1.14s-.64.51-1.08.5h-.58v25h.87a.83.83,0,1,1,0,1.66H2.82a1.24,1.24,0,0,1-1.23-.56v-.66c.45-.62,1.16-.39,1.74-.48v-25c-.65,0-1.31.1-1.74-.52Zm36.63-4.14.38.29c1.54,1,3.07,2.06,4.61,3.07a1.57,1.57,0,0,0,.82.24c1.72,0,3.44,0,5.16,0a2.56,2.56,0,0,1,.55.05.79.79,0,0,1,.66.83.77.77,0,0,1-.66.78,4,4,0,0,1-.77.05H5.08V48.68H9.59v-6c0-.78.28-1.06,1.07-1.07h3.05c.86,0,1.11.26,1.11,1.13V48.1c0,.2,0,.39,0,.57H16.7c0-2,0-4,0-6,0-.81.28-1.09,1.1-1.1h3c.91,0,1.15.25,1.15,1.16,0,1.77,0,3.55,0,5.32v.6h1.87a2.76,2.76,0,0,1,0-1,1.27,1.27,0,0,1,.64-.72,1.07,1.07,0,0,1,.84.32,1.15,1.15,0,0,1,.18.78c0,1.47,0,2.95,0,4.43,0,.2,0,.4,0,.6h3.57V43.31h-3.6c0,.29,0,.54,0,.8a.85.85,0,1,1-1.7,0c0-.46,0-.92,0-1.39,0-.84.28-1.12,1.14-1.12H35c.88,0,1.15.28,1.15,1.17v5.33c0,.19,0,.39,0,.6h1.83V48c0-1.8,0-3.59,0-5.38,0-.77.28-1,1-1H42.2c.82,0,1.1.29,1.1,1.1v6h1.88v-.63c0-1.81,0-3.63,0-5.44,0-.73.27-1,1-1h3.16c.79,0,1.07.29,1.07,1.07V48.1c0,.19,0,.39,0,.58h4.5V28.16c-.61,0-1.18,0-1.74,0A.84.84,0,0,1,52.36,27a.93.93,0,0,1,1-.52h2.41c-.14-.19-.21-.29-.29-.38-.78-.94-1.58-1.87-2.34-2.82a1.05,1.05,0,0,0-.93-.45c-4.43,0-8.87,0-13.31,0ZM5.05,53.12H23.76V50.43H5.05Zm31.17,0H54.93v-2.7H36.22Zm4.27-26.67-.39-.29c-3.25-2.17-6.51-4.33-9.76-6.52a.56.56,0,0,0-.73,0l-9.12,6.09c-.28.18-.56.38-.92.63a2.47,2.47,0,0,0,.3.05c1.81,0,3.63,0,5.44,0,.35,0,.41-.19.49-.45A4.42,4.42,0,0,1,30,22.9,4.37,4.37,0,0,1,34.17,26c.13.42.32.49.7.49,1.48,0,3,0,4.44,0ZM21.68,23l0-.14h-.59c-4.29,0-8.57,0-12.86,0a1.69,1.69,0,0,0-1.53.72c-.74,1-1.56,1.89-2.38,2.89a1.85,1.85,0,0,0,.28.05H16.16a.72.72,0,0,0,.41-.11C18.28,25.22,20,24.08,21.68,23ZM30.9,43.3v9.83h3.54V43.3Zm0-35.6v3.62h6.22V7.7ZM13.12,43.32H11.31v5.35h1.81Zm33.78,0v5.36h1.81V43.31Zm-28.47,0v5.37h1.79V43.3Zm21.35,0v5.38h1.79V43.3ZM32.51,26.42a2.57,2.57,0,0,0-2.58-1.81,2.54,2.54,0,0,0-2.44,1.81Z" />
                        <path d="M23.81,35.32c0-.83,0-1.66,0-2.49s.32-1,1-1H28c.72,0,1,.32,1,1q0,2.49,0,5c0,.73-.33,1-1.07,1-1,0-2.07,0-3.1,0-.77,0-1.08-.31-1.09-1.07S23.81,36.14,23.81,35.32Zm1.75-1.79v3.58h1.76V33.53Z" />
                        <path d="M36.19,35.36c0,.79,0,1.58,0,2.38s-.32,1.09-1.07,1.09c-1,0-2.11,0-3.16,0-.7,0-1-.32-1-1,0-1.67,0-3.33,0-5,0-.71.31-1,1-1,1.09,0,2.18,0,3.27,0a.9.9,0,0,1,1,1C36.2,33.66,36.19,34.51,36.19,35.36Zm-1.76,1.75V33.55H32.68v3.56Z" />
                        <path d="M14.82,35.31c0,.83,0,1.66,0,2.49s-.31,1-1,1c-1.08,0-2.15,0-3.22,0a.89.89,0,0,1-1-1c0-1.66,0-3.33,0-5,0-.7.3-1,1-1h3.21c.72,0,1,.31,1,1S14.82,34.48,14.82,35.31Zm-1.73,1.8V33.54H11.3v3.57Z" />
                        <path d="M50.41,35.33v2.5a.88.88,0,0,1-1,1c-1.09,0-2.18,0-3.27,0-.67,0-1-.31-1-1q0-2.52,0-5c0-.71.29-1,1-1h3.16c.74,0,1,.32,1,1.05Zm-3.53,1.76h1.83V33.54H46.88Z" />
                        <path d="M16.7,35.25c0-.82,0-1.63,0-2.44s.31-1,1-1c1.09,0,2.18,0,3.27,0,.69,0,1,.31,1,1,0,1.69,0,3.39,0,5.09a.86.86,0,0,1-1,1c-1.1,0-2.21,0-3.32,0a.88.88,0,0,1-.95-1C16.69,37,16.7,36.11,16.7,35.25Zm1.73-1.73v3.57h1.78V33.52Z" />
                        <path d="M38.05,35.3c0-.83,0-1.66,0-2.49s.31-1,1-1h3.21c.7,0,1,.34,1,1q0,2.49,0,5a.9.9,0,0,1-1,1q-1.6,0-3.21,0c-.68,0-1-.31-1-1C38,37,38.05,36.15,38.05,35.3Zm3.53,1.81V33.53h-1.8v3.58Z" />
                      </svg>

                      </div>
                      <div class="dg aligns-items-center justify-content-center text-center" style="display:inline; justify-content: center;  align-items: center;">
                      <p style="padding-top: 27px;padding-bottom:0px; font-size:14px;font-weight:800">Embassy Appearance</p>
                      <span style="font-size:11px; color:grey;padding-left:1px; padding-right:1px;line-height:1px;">Embassy appearance pending.</span>
                      </div>

                    </div>
                  </div>
                @endif
              </li>

              <!-- Modal -->
              <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="statusModalLabel">Application Status</h5>
                      <button type="button" style="float:right; font-size:11px; width:20px;height:20px" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height:auto">

                      @if($paid->third_payment_status =='Paid')
                      <p>Congratutaion! You have completed your payments. </p>
                      <p style="font-size:15px">Your embassy appearnce date will be indicated soon.</p>

                      @elseif($paid->second_payment_status =='Paid')
                      <p>Your Application is in progress! </p> 
                      <p style="font-size:17px">Your third payment is pending. </p>
                      <p style="font-size:15px">Your work permit will be uploaded soon.</p>
                      @elseif($paid->first_payment_status =='Paid') 
                      <p>Your Application is in progress! </p>
                      <p style="font-size:15px">Your second payment pending.</p> 
                      @else 
                        @if($paid->first_payment_remaining >0 && $paid->first_payment_status !='Paid')
                        <p style="font-size:15px">You have outstanding payment of {{$paid->first_payment_remaining}} on first payment</p>
                        @endif
                      @endif                      

                      @if($paid->application_stage_status != 5)
                        @if($paid->application_stage_status==2)
                          @php 
                           $linkk = "applicant.details";
                          @endphp
                        @elseif($paid->application_stage_status==3)
                          @php 
                            $linkk = "applicant.details";
                          @endphp 
                        @elseif($paid->application_stage_status==4)
                          @php 
                            $linkk = "applicant.review";
                          @endphp   
                        @else
                          @php 
                            $linkk = "payment";
                          @endphp   
                        @endif
                      <a href="{{route($linkk, $paid->destination_id)}}">
                        <p style="display:fixed; align-content: center; text-align:center; font-size:11px !important; color:#ff0000;padding:1px;margin-left: 20px; line-height:100% !important">
                          Application process not completed. Click here
                        </p>
                      </a>
                      @endif
                    </div>

                  </div>
                </div>
              </div>
              <!-- Modal Ends -->

            <!-- End Column  -->
           
            </ul>

          </div>
        </div>

        <a class="carousel-control-prev" id="slideBack" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="prev">
          <i class="lni lni-arrow-left"></i>
        </a>
        <a class="carousel-control-next" id="slide" href="#carouselThree" style="text-decoration:none;" role="button" data-slide="next">
          <i class="lni lni-arrow-right"></i>
        </a><br>

      </div>

    </div>

  </div>

</div>

@if($paid->third_payment_status !='Paid')
  @if(isset($prod->id))
    @php  
      $ppd = $prod->id; 
    @endphp

    <div class="card d-flex aligns-items-center justify-content-center text-center wiggy" style="background-color:#000; color: #fff; padding-block:35px; font-weight: bold;font-family:'TT Norms Pro'">
      <h3 style="font-size:36px">Earn 5% discount when you pay full amount! </h3>
      <p style="margin-top: 5px;">
      @if($paid->application_stage_status != 5)
        <button class="btn btn-secondary toastrDefaultError" style="border-width:thin; width:250px; height:60px; font-size:32px; font-weight:bold" onclick="toastr.error('Your application process not completed!')">Pay All Now</button>                           
      @else
        <form action="{{ route('payment',$ppd) }}" method="GET">
          <input type="hidden" name="pid" value="{{$ppd}}">
          <input type="hidden" name="payall" value="1">
          <button class="btn btn-secondary" style="border-width:thin; width:250px; height:60px; font-size:32px; font-weight:bold">Pay All Now</button>
        </form>
      @endif  
      </p>
    </div>
  @endif
@endif


<!-- 
<div style="display:block">
<a href="#" class="mi" style="display:inline">-</a>
<div class="RegSpLeft" id="phone"  style="display:inline">
<input type="text" value="Phone"><br>
</div>
<a href="#" class="pl" style="display:inline">+</a>
</div>
    
<script type="text/javascript" src="dist/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
  $(function() {
      $('a.pl').click(function(e) {
          e.preventDefault();
          $('#phone').append('<input type="text" value="Phone">');
      });
      $('a.mi').click(function (e) {
          e.preventDefault();
          if ($('#phone input').length > 1) {
              $('#phone').children().last().remove();
          }
      });
  });
</script> -->

<!-- <script src="../user/assets/js/vendor/jquery-1.12.4.min.js"></script> -->
<script>
  var button = document.getElementById('slide');
  button.onclick = function() {
    var container = document.getElementById('container');
    sideScroll(container, 'right', 25, 100, 10);
  };

  var back = document.getElementById('slideBack');
  back.onclick = function() {
    var container = document.getElementById('container');
    sideScroll(container, 'left', 25, 100, 10);
  };

  function sideScroll(element, direction, speed, distance, step) {
    scrollAmount = 0;
    var slideTimer = setInterval(function() {
      if (direction == 'left') {
        element.scrollLeft -= step;
      } else {
        element.scrollLeft += step;
      }
      scrollAmount += step;
      if (scrollAmount >= distance) {
        window.clearInterval(slideTimer);
      }
    }, speed);
  }
</script>