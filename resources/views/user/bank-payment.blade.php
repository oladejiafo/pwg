
    <div class="container">
        <div class="col-12">
            {{-- <div class="bankInfo">
                <h5 style="color:red">Our consultants do NOT accept cash payments- the only acceptable method of payment is bank transfer or deposit with below details :</h5>
            </div> --}}
            <div class="bank-tranfer">
                <form action="{{route('submit.bank.transfer')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name='paymentId' value="{{$paymentId}}"> --}}
                    <input type="hidden" name="productId" value="{{$pdet->destination_id}}">
                    <div class="row">
                        <div class="heading">
                            <div class="first-heading" style="text-align: center">
                                <p>Proceed to your bank APP to complete this payment and upload your proof of payment.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5>Bank Details:</h5>
                                <div class="row bankDetails">
                                    <div class="col-12 adcb">
                                        
                                        <ul>
                                            <li><h6>Bank Name:&emsp; <b>ADCB Bank</b></h6></li>
                                            <li><h6>Branch:&emsp; BusinessBay Branch</h6></li>
                                            <li><h6>Account Name:&ensp;	PWG Visa Services LLC</h6></li>
                                            <li><h6>Account Number:&ensp; 11977082920001</h6></li>
                                            <li><h6>IBAN:&emsp; AE500030011977082920001</h6></li>
                                            <li><h6>Swift Code:&emsp; ADCBAEAA</h6></li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        
                                        <div class="form-group row mt-4">
                                            <div class="form-floating mt-3" align="left">
                                                AMOUNT TO PAY:  <b style="font-size: 18px"> @if(isset($totalPay)){{ number_format($totalPay,2) }}@endif </b> <b>AED</b>
                                                <input type="hidden" name="invoice_amount" value="{{$totalPay}}"/>
                                            </div>
                                        </div>
                                        <input type="hidden" name="bank" class="form-select form-control bank" value="2">
                                            
                                        {{-- <div class="form-groupx row xmt-4">
                                            <div class="form-floating mt-2 dob">
                                                <input type="text" name="bank_reference" class="form-control bank_reference" id="floatingInput" placeholder="Bank Reference Number*" value="" autocomplete="off" required/>
                                                <label for="floatingInput">Bank/Payment Reference No:*</label>
                                                @if ($errors->has('bank_reference'))
                                                    <span class="error">{{ $errors->first('bank_reference') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                            
                                        <div class="form-groupx row xmt-4">
                                            <div class="form-floating mt-2">
                                                <input type="text" name="datepayment" class="form-control datepayment" placeholder="Date of Payment*" @if(isset($client['payment_date'])) value="{{ $client['payment_date'] }}" @else value="{{old('payment_date')}}" @endif id="payment_date" autocomplete="off" />
                                                <label for="datepayment">Date of payment*</label>
                                                @if ($errors->has('datepayment'))
                                                    <span class="error">{{ $errors->first('datepayment') }}</span>
                                                @endif
                                            </div>
                                        </div> --}}
                                        <input name="type_payment" value="TRANSFER" type="hidden" />
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5 align="center">Upload Receipt:</h5>
                                <div class="recieptUpload">
                                    <div class='file file--uploading'>
                                        <label for='input-file'>
                                            <div class="recieptUploadImage"><img src="{{asset('images/receiptupload.png')}}" alt="PWG Receipt" width="100%"></div>
                                        </label>
                                        <h6 style="text-align: center"><span style="color:aqua">Browse to upload</span></h6>
                                        <input id='input-file' name="imgInp" accept="image/*" type='file' id="imgInp" onchange="changeImage(event)"/>
                                        @if ($errors->has('imgInp'))
                                        <span class="error">Please upload receipt</span>
                                        @endif
                                    </div>
                                </div>
                                <div align="center" style="text-align: center;margin:20px auto;color:#ccc;">Supported formats: PDF, JPG, PNG</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h5 align="center">Preview:</h5>
                                <div class="previewImage">
                                    <img id="output" width="100%"/>
                                </div>
                            </div>
                            
                        </div>
                    </div>  
                    <div class="row" style="height:40px">
                        &nbsp;
                    </div> 
                    <div class="row">
                        <div class="col-4">
                            <a href="{{  url()->previous()  }}"><button type="cancel" class="cancelBtn btnx" style="float: left;">Cancel</button></a>
                        </div>
                        <div class="col-4">
                            <input type="hidden" name="pid" value="{{ $data->id }}">
                            <input type="hidden" name="ppid" value="{{ isset($pdet->id) ? $pdet->id : '' }}">
                            <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="packageType" value="{{$pdet->pricing_plan_type}}">
                            <input type="hidden" name="whichpayment" value="{{ $whichPayment ? $whichPayment : 'FIRST' }}">
                            <input type="hidden" name="first_p" value="{{ $pdet->first_payment_sub_total }}">
                            <input type="hidden" name="second_p" value="{{ $pdet->submission_payment_sub_total }}">
                            <input type="hidden" name="third_p" value="{{ $pdet->second_payment_sub_total }}">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary submitBtn" style="float: right;">Submit</button>
                        </div>
    
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('custom-scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.datepayment').datepicker({
                dateFormat : "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                constrainInput: false     
            });
        });

    </script>
    <script language="javascript" type="text/javascript">
        changeImage = (evt) => {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
@endpush
