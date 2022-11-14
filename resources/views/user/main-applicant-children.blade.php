<div class="tab-pane active" id="children">
    <form method="POST" id="child_details">
        @csrf
        @for($i = 1; $i <= $client['children_count']; $i++)
            <div class="applicant-detail-sec" @if($i ==  $client['children_count']) style="margin-bottom:70px" @endif data-bs-toggle="collapse" data-bs-target="#collapsechild{{$i}}" aria-expanded="false" aria-controls="collapsechild{{$i}}">
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
                        <div class="col-2 mx-auto my-auto">
                            <div class="down-arrow">
                                <img src="{{asset('images/down_arrow.png')}}" height="auto" width="25%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="collapse" id="collapsechild{{$i}}">
                        <div class="form-sec">
                            <div class="form-group row mt-4">
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="hidden" name="applicant_id" value="{{$applicant['id']}}">
                                    <input type="hidden" name="childrenCount" value="{{$client['children_count']}}">
                                    <input type="hidden" name="product_id" value="{{$productId}}">
                                    <input type="hidden" name="child" value="{{$i}}">
                                    <input type="text" name="child_{{$i}}_first_name" id="child_{{$i}}_first_name" class="form-control child_{{$i}}_first_name" placeholder="First Name*" value="" autocomplete="off" />
                                    <label for="child_{{$i}}_first_name">First Name*</label>
                                    <span class="child_{{$i}}_first_name_errorClass"></span>
                                    @error('child_{{$i}}_first_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="text" name="child_{{$i}}_middle_name"id="child_{{$i}}_middle_name" class="form-control " placeholder="Middle Name" value=""  autocomplete="off"/>
                                    <label for="child_{{$i}}_middle_name">Middle Name</label>
                                </div>
                                <div class="form-floating col-sm-4 mt-3">
                                    <input type="text" name="child_{{$i}}_surname" id="child_{{$i}}_surname" class="form-control child_{{$i}}_surname" placeholder="Surname*" value="" autocomplete="off"  />
                                    <label for="child_{{$i}}_surname">Surname*</label>
                                    <span class="child_{{$i}}_surname_errorClass"></span>
                                    @error('child_{{$i}}_surname') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="form-floating col-sm-6 mt-3">
                                    <input type="text"  name="child_{{$i}}_dob"  id="child_{{$i}}_dob" class="child-dob form-control" placeholder="Date Of Birth*" readonly>
                                    <label for="child_{{$i}}_dob">Date Of Birth*</label>
                                    <span class="child_{{$i}}_dob_errorClass"></span>
                                    @error('child_{{$i}}_dob') <span class="error">{{ $message }}</span> @enderror

                                </div>
                                <div class="form-floating col-sm-6 mt-3">
                                    <select name="child_{{$i}}_gender" id="child_{{$i}}_gender" aria-required="true" class="form-control form-select child_{{$i}}_gender" >
                                        <option selected disabled>Gender</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                    <label for="child_{{$i}}_gender">Gender *</label>
                                    <span class="child_{{$i}}_gender_errorClass"></span>
                                    @error('child_{{$i}}_gender') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                @if($i ==  $client['children_count'])
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
