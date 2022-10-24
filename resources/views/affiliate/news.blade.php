@extends('affiliate.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="news">
            <div class="col-12">
                <div clas="row justify-content-md-center">
                    <div class="col-6">
                        <div class="news-left-section">
                            <div class="news-banner">
                                <img src="{{asset('images/affiliate/news-banner.png')}}">
                            </div>
                            <div class="news-desc">
                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                <h3>
                                    <b>100 New Visas approved from Kenya</b>
                                </h3>
                                <p class="news-sub-desc">
                                    <b>
                                        October alone 100 visas has been issued !
                                    </b>
                                </p>
                                <p class="desc"> 
                                    we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued
                                </p>
                                <a class="btn checkout-news"><b>Check out the story</b></a>
                            </div>
                            <div class="news-desc-hr"></div>

                        </div>
                        <div class="news-left-section">
                            <div class="news-banner">
                                <img src="{{asset('images/affiliate/news-banner1.png')}}">
                            </div>
                            <div class="news-desc">
                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                <h3>
                                    <b>100 New Visas approved from Kenya</b>
                                </h3>
                                <p class="news-sub-desc">
                                    <b>
                                        October alone 100 visas has been issued !
                                    </b>
                                </p>
                                <p class="desc"> 
                                    we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued
                                </p>
                                <a class="btn checkout-news"><b>Check out the story</b></a>
                            </div>
                            <div class="news-desc-hr"></div>
                        </div>
                        <div class="news-left-section">
                            <div class="news-banner">
                                <video width="100" height="240" controls>
                                    <source src="{{asset('assets/video/news-video.mp4')}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="news-desc">
                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                <h3>
                                    <b>100 New Visas approved from Kenya</b>
                                </h3>
                                <p class="news-sub-desc">
                                    <b>
                                        October alone 100 visas has been issued !
                                    </b>
                                </p>
                                <p class="desc"> 
                                    we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued we are very delighted to announce that more than 1000 visas has been Issued
                                </p>
                                <a class="btn checkout-news"><b>Check out the story</b></a>
                            </div>
                            <div class="news-desc-hr"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="news-right-section">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection