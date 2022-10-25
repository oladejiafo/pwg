@extends('affiliate.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="news">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="news-left-section">
                                <div class="news-banner">
                                    <img src="{{asset('images/affiliate/news-banner.png')}}">
                                </div>
                                <div class="news-desc">
                                    <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                    <h3>
                                        <b>{{ ucfirst('100 New Visas approved from Kenya')}}</b>
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
                                        <b>{{ ucfirst('100 New Visas approved from Kenya')}}</b>
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
                                        <source src="{{asset('video/news-video.mp4')}}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="news-desc">
                                    <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                    <h3>
                                        <b>{{ ucfirst('100 New Visas approved from Kenya')}}</b>
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
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="news-right-section">
                                <div class="row">
                                    <div class="head-news-right-section">
                                        <ul>
                                            <li class="news-head">
                                                <h3>
                                                    <b>{{ ucfirst('100 New Visas approved from Kenya')}}</b>
                                                </h3>
                                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                            </li>
                                            <li class="news-head">
                                                <h3>
                                                    <b>{{ ucfirst('huge summer promo')}}</b>
                                                </h3>
                                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                            </li>
                                            <li class="news-head">
                                                <h3>
                                                    <b>{{ ucfirst('5000  Visas issued to date')}}</b>
                                                </h3>
                                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                            </li>
                                            <li class="news-head">
                                                <h3>
                                                    <b>{{ ucfirst('JOIN US LIVE EVERY MONDAY')}}</b>
                                                </h3>
                                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                            </li>
                                            <li class="news-head">
                                                <h3>
                                                    <b>{{ ucfirst('new pwg group branch near you 
                                                        in india')}}</b>
                                                </h3>
                                                <p>{{Carbon\Carbon::now()->format('jS F Y');}}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="share-news-right-section">
                                        <p><b>Follow PWG Group on social media</b></p>
                                        <div class="share-news-image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection