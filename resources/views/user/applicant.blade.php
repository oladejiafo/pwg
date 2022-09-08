@extends('layouts.master')
 <link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <link href="{{asset('css/alert.css')}}" rel="stylesheet">

 <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
 <link href="{{asset('user/css/select2.min.css') }}" rel="stylesheet" />
<style>
    body {
    background: #f0f3f4 !important;
    font-family: TT Norms Pro;
}

.embassy select{
    height: 60px !important;
    border-radius: 20px !important;

}
</style>
@section('content')
@php 
    $completed = DB::table('applicants')
                ->where('product_id', '=', $productId)
                ->where('user_id', '=', Auth::user()->id)
                ->first();

    $levels = $completed->applicant_status;
@endphp
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard bg-white">
                    <div class="row">
                        <div class="tabs d-flex justify-content-center">
                            

                        <div class="wrapper">
                              @php 
                                if ($levels == '2' || $levels == '5' || $levels == '4' || $levels == '3') 
                                {
                              @endphp    
                                <a href="#" onclick="return alert('Payment Concluded Already!');"><div class="round-completed round2 m-2">1</div></a>
                              @php
                                } else {
                              @endphp    
                                <a href="{{ url('payment_form', $productId) }}" >
                                    <div class="round-completed round2  m-2">1</div>
                                </a>
                              @php   
                                }
                              @endphp
                              <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            
                            <div class="wrapper">
                                <a href="{{route('applicant', $productId)}}" ><div class="round-active  round3  m-2">2</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div>

                            @php 
                              if ($levels == '5' || $levels == '4' || $levels == '3' ) {
                            @endphp    
                            <div class="wrapper">
                                <a href="{{route('applicant.details',  $productId)}}" ><div class="round4 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="{{url('applicant/review',  $productId)}}" ><div class="round5 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            
                            @php  
                              } else {
                            @endphp

                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round4 m-2">3</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="#" onclick="return alert('You have to complete Application Details first');"><div class="round5 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Reviews</div>
                            </div>
                            @php  
                              }
                            @endphp

                        </div>
                    </div>
                </div>
            <div>
            <div class="row">
                <div class="applicant-sec">
                    <div class="heading">
                      <div class="first-heading">
                          <h3>
                              Application Details
                          </h3>
                      </div>
                    </div>
                    
                    @php
                        $applied = DB::table('products')
                            ->where('id', '=', $productId)
                            ->get();

                        $products =  DB::table('products')->get();
                    @endphp    

                    <div class="form-sec">
                        <form method="POST" action="{{route('store.applicant',$productId)}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$productId}}">
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mt-3">
                                    <select class="form-select form-control" id="inputFirstname" name="applied_country" placeholder="Applied Country *" value="{{old('applied_country')}}" required>
                                        <!-- <option selected disabled>Applied Country *</option> -->
                                        <option selected>@foreach($applied as $appliedc) {{$appliedc->product_name}} @endforeach</option>
                                        @foreach($products as $product)
                                         <!-- <option value="{{$product->product_name}}">{{$product->product_name}}</option> -->
                                        @endforeach 
                                        <!-- <option value="Canada">Canada</option>

                                        <option value="Czech">Czech</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Malta">Malta</option> -->
                                    </select>
                                    @error('applied_country') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-6 mt-3">

                                <input type="text" name="agent_code" class="form-control" placeholder="Please enter your agent code here if available" value="{{old('agent_code')}}" />
                                @error('agent_code') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <!-- <div class="col-sm-6 mt-3"> -->
                                    <!-- <select class="form-select form-control" id="inputLastname" name="job_type" placeholder="Are you apply for white collar job? *" value="{{old('job_type')}}" required>
                                        <option selected disabled>Are you apply for white collar job? *</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select> -->
                                     {{-- @error('job_type') <span class="error">{{ $message }}</span> @enderror --}}
                                <!-- </div> -->
                            </div>        
                            <div class="form-group row mt-3">
                                <div class="col-sm-12 mt-3">
                                    <input type="text" class="form-control cvupload" placeholder="Upload your cv (PDF only)*" name="cv" value="{{old('cv')}}" readonly required>
                                    <div class="input-group-btn">
                                        <span class="fileUpload btn">
                                            <span class="upl" id="upload">Choose File</span>
                                            <input type="file" class="upload up cvupload" id="up"  name="cv" accept="application/pdf" onchange="readURL(this);" />
                                          </span><!-- btn-orange -->
                                    </div><!-- btn -->
                                    @error('cv') <span class="error">{{ $message }}</span> @enderror
                                </div>

                            </div>
                            {{-- <div class="form-group row">
                                <div class="col-sm-6 mt-3">

                                    <input id="phone" type="tel" name="agent_phone" class="form-control" placeholder="Your agent phone number" value="{{old('agent_phone')}}" />
                                    @error('agent_phone') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <input id="agent-name" type="tel" name="agent_name" class="form-control" placeholder="Your agent name" value="{{old('agent_name')}}" />
                                    @error('agent_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div> --}}
                            <div class="heading">
                                <div class="first-heading">
                                    <h3>
                                        Country of embassy appearance
                                    </h3>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2 col-sm-12">
                                    <select class="form-select form-control embassy" name="embassy_country" style="height: 50px !important;" placeholder="Applied Country *" value="{{old('embassy_country')}}"  required>
                                        <option selected disabled>--Select A Country--</option>
                                        @foreach (Constant::countries as $key => $item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                    @error('embassy_country') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="form-check col-lg-6 col-md-10 offset-lg-3 offset-md-1 col-sm-12 agree-terms">
                                    <input class=" checkcolor" type="checkbox" id="TnC" value="TnC" name="agree" value="{{old('agree')}}" required checked>
                                    <label class="form-check-label" for="TnC">
                                        I agree to <a class="text-primary" style="cursor: pointer" data-toggle="modal"
                                            data-target="#exampleModalLong">Terms and Conditions</a>
                                    </label>
                                    <label class="form-check-label text-danger" id="TnCAlert"></label>
                                    @error('agree') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4" style="margin-bottom: 70px">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                </div>
                            </div>

                        </form>
                    </div>            
                </div>
            </div>
        </div>
    </div>
@endSection
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.embassy').select2();
    });

    $(document).on('change','.up', function(){
        var names = [];
        var length = $(this).get(0).files.length;
          for (var i = 0; i < $(this).get(0).files.length; ++i) {
              names.push($(this).get(0).files[i].name);
          }
          // $("input[name=file]").val(names);
        if(length>2){
          var fileName = names.join(', ');
          $('.cvupload').attr("value",length+" files selected");
        }
        else{
          $('.cvupload').attr("value",names);
        }
     });
</script>

@endpush

<script src="{{asset('js/alert.js')}}"></script>