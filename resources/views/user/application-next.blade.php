@extends('layouts.master')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>

@section('content')
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="wizard-details bg-white">
                    <div class="row">
                        <div class="tabs-detail d-flex justify-content-center">
                            <div class="wrapper">
                                <a href="" ><div class="round-completed round1 p-3 m-2">1</div></a>
                                <div class="round-title">Refferal <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="" ><div class="round-completed round2 p-3 m-2">2</div></a>
                                <div class="col-2 round-title">Payment <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href="" ><div class="round-completed  round3 p-3 m-2">3</div></a>
                                <div class="col-2 round-title">Application <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href=" " ><div class="round-active round4 p-3 m-2">4</div></a>
                                <div class="col-2 round-title">Applicant <br> Details</div>
                            </div>
                            <div class="linear"></div>
                            <div class="wrapper">
                                <a href=" " ><div class="round5 p-3 m-2">5</div></a>
                                <div class="col-2 round-title">Application <br> Review</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="applicant-detail-sec">
                    <div class="heading">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{assets('images/Icons_Applicant Details')}}">
                            </div>
                            <div class="col-8">
                                <div class="first-heading d-flex justify-content-center">
                                    <h3>
                                        Applicants Details
                                    </h3>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    {{-- <div class="form-sec">
                        <form method="POST" action="{{route('store.applicant')}}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group row mt-4" style="margin-bottom: 70px">
                                <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                                    <button type="submit" class="btn btn-primary submitBtn">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>             --}}
                </div>
            </div>
        </div>
    </div>
@endSection
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
<script>

</script>

@endpush