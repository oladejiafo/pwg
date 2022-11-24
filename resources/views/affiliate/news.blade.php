@extends('affiliate.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="news">
                <div class="col-12">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-12 col-md-12 col-lg-5">
                            @if(count($news->news) > 0)
                             <div class="news-left-container">
                                @foreach($news->news as $new)
                                    <div class="news-left-section">
                                        <div class="news-banner">
                                            @if($new->videoUrl)
                                                <video width="100" height="240" controls>
                                                    <source src="{{$new->videoUrl}}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{$new->imageUrl}}">
                                            @endif
                                        </div>
                                        <div class="news-desc">
                                            <p>{{$new->publishDate}}</p>
                                            <h3>
                                                <b>{{ ucfirst($new->title)}}</b>
                                            </h3>
                                            <p class="news-sub-desc">
                                                <b>
                                                    {!! $new->category!!}
                                                </b>
                                            </p>
                                            <p class="desc"> 
                                                {!! substr($new->details, 0, 500) !!}
                                            </p>
                                            <a class="btn checkout-news" href="{{route('affiliate.news.brief', $new->id)}}"><b>Check out the story</b></a>
                                            <hr>
                                        </div>
                                        <!-- <div class="news-desc-hr"></div> -->
                                    </div>
                                @endforeach
                             </div>  
                            @else
                                <div class="no-news-left-section">
                                    <p><b>No news found !</b></p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="news-right-section">
                                <div class="row">
                                    @if(count($news->oldNews) > 0)
                                        <div class="head-news-right-section">
                                            <ul>
                                                @foreach($news->oldNews as $onews)
                                                    <li class="news-head">
                                                        <h3>
                                                            <b>{{ ucfirst($onews->title)}}</b>
                                                        </h3>
                                                        <p>{{($onews->publishDate)}}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="share-news-right-section">
                                        <p><b>Follow PWG Group on social media</b>
                                        <div class="share-news-image wrapper">
                                            <ul class="list-unstyled ls">
                                                <li class="media">
                                                    <a target="_blank" href="https://www.instagram.com/pwggroup_ae/"><i style="background-color:#000;width:40px; height:40px; border-radius:50%; color:#fff;padding:11px" class="fa fa-instagram" aria-hidden="true"></i></a>
                                                </li>
                                                <li class="media">
                                                    <a target="_blank" href="https://www.facebook.com/pwggroupae"><i style="background-color:#000;width:40px; height:40px; border-radius:50%; color:#fff;padding:11px 11px 11px 12px" class="fa fa-facebook" aria-hidden="true"></i></a>
                                                </li>
                                                <li class="media">
                                                    <a target="_blank" href="https://www.linkedin.com/company/pwg-group-uae/"><i style="background-color:#000;width:40px; height:40px; border-radius:50%; color:#fff;padding:11px" class="fa fa-linkedin" aria-hidden="true"></i></a>
                                                </li>
                                                <li class="media">
                                                    <a target="_blank" href="https://www.youtube.com/channel/UC9_olBZKiCjTIfTWHTNyEGA"><i style="background-color:#000;width:40px; height:40px; border-radius:50%; color:#fff;padding:11px" class="fa fa-youtube" aria-hidden="true"></i></a>
                                                </li>
                                                <li class="media">
                                                    <a target="_blank" href="https://twitter.com/pwggroupae"><i style="background-color:#000;width:40px; height:40px; border-radius:50%; color:#fff;padding:11px" class="fa fa-twitter" aria-hidden="true"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        </p>
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