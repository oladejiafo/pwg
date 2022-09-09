<div class="tab-pane active" id="children">
    <form method="POST" id="child_details">
        @csrf
        @for($i = 1; $i <= $applicant['children_count']; $i++)
            <div class="applicant-detail-sec" @if($i ==  $applicant['children_count']) style="margin-bottom:70px" @endif>
                <div class="heading">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <div class="image">
                                <img src="{{asset('images/child.svg')}}" width="100%" height="100%">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="vl"></div>
                        </div>
                        <div class="col-6 my-auto">
                            <div class="first-heading d-flex justify-content-center">
                                <h3>
                                    Child {{$i}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="dataCompleted childData{{$i}}">
                                <img src="{{asset('images/Affiliate_Program_Section_completed.svg')}}" alt="approved">
                            </div>
                        </div>
                        <div class="col-2 mx-auto my-auto">
                            <div class="down-arrow" data-bs-toggle="collapse" data-bs-target="#collapsechild{{$i}}" aria-expanded="false" aria-controls="collapsechild{{$i}}">
                                <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="collapse" id="collapsechild{{$i}}">
                        <div class="form-sec">
                            <div class="form-group row mt-4">
                                <div class="col-sm-4 mt-3">
                                    <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                                    <input type="hidden" name="childrenCount" value="{{$applicant['children_count']}}">
                                    <input type="hidden" name="product_id" value="{{$productId}}">
                                    <input type="hidden" name="child" value="{{$i}}">
                                    <input type="text" name="child_{{$i}}_first_name" class="form-control child_{{$i}}_first_name" placeholder="First Name*" value="" autocomplete="off" />
                                    <span class="child_{{$i}}_first_name_errorClass"></span>
                                    @error('child_{{$i}}_first_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" name="child_{{$i}}_middle_name" class="form-control " placeholder="Middle Name" value=""  autocomplete="off"/>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <input type="text" name="child_{{$i}}_surname" class="form-control child_{{$i}}_surname" placeholder="Surname*" value="" autocomplete="off"  />
                                    <span class="child_{{$i}}_surname_errorClass"></span>
                                    @error('child_{{$i}}_surname') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mt-3">
                                    <input type="text"  name="child_{{$i}}_dob" class="child-dob form-control" placeholder="Date Of Birth*" >
                                    <span class="child_{{$i}}_dob_errorClass"></span>
                                    @error('child_{{$i}}_dob') <span class="error">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-sm-6 mt-3">
                                    <select name="child_{{$i}}_gender" aria-required="true" class="form-control form-select child_{{$i}}_gender" >
                                        <option selected disabled>Gender *</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                    <span class="child_{{$i}}_gender_errorClass"></span>
                                    @error('child_{{$i}}_gender') <span class="error">{{ $message }}</span> @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                @if($i ==  $applicant['children_count'])
                                    <button type="submit" class="btn btn-primary submitBtn">Submit <i class="fa fa-spinner fa-spin childReviewSpin"></i></button>  
                                @else 
                                    <button type="button" class="btn btn-primary submitBtn collapsechild{{$i+1}}" data-bs-toggle="collapse" data-bs-target="#collapsechild{{$i+1}}" aria-expanded="false" aria-controls="collapsechild{{$i+1}}">Continue</button>  
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </form>
</div>

{{-- <div class="accordion" id="children">
    <form method="POST" id="child_details">
        @csrf
        @for($i = 1; $i <= $applicant['children_count']; $i++)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                    Accordion Item #1
                    </button>
                </h2>
                <div id="collapse{{$i}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#children">
                    <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
        @endfor
    </form>
</div> --}}


{{-- <div class="accordion" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Accordion Item #1
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Accordion Item #2
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Accordion Item #3
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
  </div> --}}