@extends('layouts.master')
<link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
@section('content')
    <div class="container">
        <div class="col-12">
            <div class="contract">
                <form method="get" action="{{route('signature', $productId)}}" id="sign">
                    <div class="col-4 offset-4 contractLogo">
                        <img src="{{asset('images/contract.svg')}}" width="100%" height="100%">
                    </div>
                    <div class="header">
                        <h3>Contract</h3>
                        <div class="bottom-title">
                            <p>Please review  the contract carefully</p>
                        </div>
                    </div>
                    <div class="contract-section">
                        <div class="col-8 offset-2 contractZoomIn">
                            <div class="zoomIcon">
                                <img src="{{asset('images/Magnifying_Glass.svg')}}" width="124px" height="124px" class="zoomOut">
                            </div>
                            <div class="contractPdf">
                                <embed src="{{ asset('pdf/PROMO_July_Poland_BC_Contract.pdf') }}" frameBorder="0" width="600" height="600" alt="pdf" borders="false" style="border: none" />
                            </div>
                        </div>
                        <div class="contractPreview">
                            <embed src="{{ asset('pdf/PROMO_July_Poland_BC_Contract.pdf') }}" frameBorder="0" width="100%" height="700" alt="pdf" borders="false" style="border: none" />
                        </div>
                        <div class="col-8 offset-2">
                            <div class="agree">
                                <p>&nbsp; <input type="checkbox" class="checkcolor" id="agree" style="font-size:25px;transform: scale(1.8); " checked required="" > &nbsp; By checking this box you accept our <a href="#" style="color:blue;margin:0">Terms & Conditions</a></p>
                            </div>
                            <button type="button" class="btn btn-secondary zoomOut" id="zoom" value="0" name="payall" style="width:100%; font-size:1.6em">ZOOM TO REVIEW</button>
                            <button type="button" class="btn btn-secondary zoomIn" id="zoom" value="0" name="payall" style="width:100%; font-size:1.6em">ZOOM TO REVIEW</button>

                            <button type="submit" class="btn btn-secondary" id="sign" value="0" name="payall" style="width:100%; font-size:1.6em;margin-top: 18px;">SIGN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endSection
@push('custom-scripts')
    <script>
        $(document).ready(function(){
            $('.contractPreview').hide();
            $('.zoomIn').hide();
            $('.zoomOut').click(function(){
                $('.contractPreview').show();
                $('.contractZoomIn').hide();
                $('.zoomIn').show();
                $('.zoomOut').hide();
            })
            $('.zoomIn').click(function(){
                $('.zoomOut').show();
                $('.zoomIn').hide();
                $('.contractPreview').hide();
                $('.contractZoomIn').show();
            });
        });
    </script>
@endpush