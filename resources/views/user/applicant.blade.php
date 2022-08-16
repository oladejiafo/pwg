@extends('layouts.master')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<style>
    .round1,
    .round2,
    .round3{
        width: 80px;
        height: 80px;
        /* border: 1px solid black; */
        border-radius: 100px;
        font-weight : bolder;
        font-size: 35px;
        text-align:center;
        cursor: pointer;
        background: white
    }

    .round1:hover,
    .round2:hover,
    .round3:hover{
        background: black;
        color: white;
    }

    .tabs {
        display: flex;
        align-items: center;
        margin-top: 9rem;

    }

    .linear {
        border: 0.25px solid #babcc1;
        width: 300px;

    }

    .content-box {
        width: 100%;
        padding: 2rem;
        height: auto;
        background: white;
    }
    
    .round-title {
        text-align: center;
        margin-bottom: 1rem;
        font-size:25px;
        font-weight: 300;
        font-family: "TT Norms Pro";
    }

    .applicant-sec {
        width: 100%;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
        margin: 0 auto;
        background-color: #ffffff;
        margin-bottom: 420px;
        margin-top: 71px;
        color: #636466;
        padding: 70px 100px 70px 100px;
    }

    .applicant-sec h3 {
        font-family: TT Norms Pro;
        font-size: 36px;
        font-weight: 700;
        line-height: 43px;
        letter-spacing: 0em;
        text-align: center;
        margin-bottom: 70px;
    }
</style>
@section('content')
    <div class="container">
        <div class="col-12">
            <div class="row">
                <div class="tabs d-flex justify-content-center">
                    <div class="round1 p-3 m-3">1</div>
                    <div class="linear"></div>
                    <div class="round2 p-3 m-3">2</div>
                    <div class="linear"></div>
                    <div class="round3 p-3 m-3">3</div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 round-title">Application Details</div>
                <div class="col-4 round-title">Applicant's Details</div>
                <div class="col-4 round-title">Confirmation</div>
            </div>
            <div class="row">
                <div class="applicant-sec">
                    <div class="heading">
                      <div class="first-heading">
                          <h3>
                              Application Details
                          </h3>
                      </div>
                    </div>
                    <div class="form-sec">
                        <form method="POST" action="">
                            <div class="form-group row mt-4">
                                <div class="col-sm-6">
                                    <select class="form-select form-control" id="inputFirstname" placeholder="Applied Country *" required>
                                        <option selected disabled>Applied Country *</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Czech">Czech</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Malta">Malta</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-select form-control" id="inputLastname" placeholder="Are you apply for white collar job? *" required>
                                        <option selected disabled>Are you apply for white collar job? *</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>        
                            <div class="form-group row mt-4">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="upload-file" aria-describedby="emailHelp" placeholder="Upload your cv*">
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
            </div>
            
            {{-- <div class="content-box">
                <div class="form-sec">

                </div>
            </div> --}}
        </div>
    </div>
@endSection
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>


@endpush