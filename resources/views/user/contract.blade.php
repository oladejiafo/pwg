@extends('layouts.master')
<link href="{{ asset('user/css/bootstrap.min.css') }}" rel="stylesheet">
@section('content')
    @php
        $payall = $_REQUEST['payall'];
        
        $prodd = DB::table('destinations')
            ->where('id', '=', $productId)
            ->orderBy('id', 'desc')
            ->first();
    @endphp


    @if (Session::has('packageType'))
        @php
            $package = Session::get('packageType');
        @endphp
    @endif

    @if (isset($prodd) && isset($package))
        @if ($prodd->name == 'Czech')
            @php $contract_name = "czech.pdf"; @endphp
        @elseif($prodd->name == 'Malta')
            @php $contract_name = "malta.pdf"; @endphp
        @elseif($prodd->name == 'Canada')
            @if ($package == 'Express Entry')
                @php $contract_name = "canada_express_entry.pdf"; @endphp
            @elseif($package == 'Study Permit')
                @php $contract_name = "canada_study.pdf"; @endphp
            @else
                @php $contract_name = "canada.pdf"; @endphp
            @endif
        @else
            @php $contract_name = "poland.pdf"; @endphp
        @endif
    @else
        @php $contract_name = "poland.pdf"; @endphp
    @endif

    <div class="container">
        <div class="col-12">
            <div class="contract">
                <form method="get" action="{{ route('signature', $productId) }}" id="sign">
                    <div class="col-4 offset-4 contractLogo">
                        <img src="{{ asset('images/contract.svg') }}" width="100%" height="100%" alt="pwg">
                    </div>
                    <div class="header">
                        <h3>Contract</h3>
                        <div class="bottom-title">
                            <p>Please review the contract carefully</p>
                        </div>
                    </div>
                    <div class="contract-section">
                        <div class="col-12 col-md-8 col-lg-12 offset-md-2 offset-lg-2 contractZoomIn">
                            <div class="zoomIcon">
                                <img src="{{ asset('images/Magnifying_Glass.svg') }}" width="124px" height="124px"
                                    class="zoomOut" alt="pwg">
                            </div>
                            <div class="contractPdf">
                                <embed src="{{ asset('pdf/' . $contract_name) }}#toolbar=0" type="application/pdf"
                                    frameBorder="0" alt="pdf" borders="false" style="border: none" />
                            </div>
                        </div>
                        <div class="contractPreview">
                            <embed src="{{ asset('pdf/' . $contract_name) }}#toolbar=0" type="application/pdf" frameBorder="0"
                                alt="pdf" borders="false" style="border: none" />
                        </div>
                        <div class="col-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                            {{-- <div class="agree">
                                <p>&nbsp; <input type="checkbox" class="checkcolor" id="agree" style="font-size:25px;transform: scale(1.8); " checked required="" > &nbsp; By checking this box you accept our <a href="#" style="color:blue;margin:0">Terms & Conditions</a></p>
                            </div> --}}
                            <button type="button" class="btn btn-secondary zoomOut" id="zoom"
                                value="{{ $payall }}" name="payall" style="width:100%; font-size:1.6em">ZOOM TO
                                REVIEW</button>
                            <button type="button" class="btn btn-secondary zoomIn" id="zoom"
                                value="{{ $payall }}" name="payall" style="width:100%; font-size:1.6em">ZOOM TO
                                REVIEW</button>

                            <button type="submit" class="btn btn-secondary" id="signd" value="{{ $payall }}"
                                name="payall" style="width:100%; font-size:1.6em;margin-top: 18px;">SIGNATURE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endSection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('.contractPreview').hide();
            $('.zoomIn').hide();
            $('.zoomOut').click(function() {
                $('.contractPreview').show();
                $('.contractZoomIn').hide();
                $('.zoomIn').show();
                $('.zoomOut').hide();
            })
            $('.zoomIn').click(function() {
                $('.zoomOut').show();
                $('.zoomIn').hide();
                $('.contractPreview').hide();
                $('.contractZoomIn').show();
            });
        });
    </script>
@endpush
