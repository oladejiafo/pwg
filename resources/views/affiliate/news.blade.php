@extends('affiliate.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="news">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            @if($news->count() > 0)
                                @foreach ($news as $new)
                                    <div class="news-left-section">
                                        <div class="news-banner">
                                            @if($new->video_link)
                                                <video width="100" height="240" controls>
                                                    <source src="{{asset('storage/news/'.$new->video_link)}}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{asset('storage/news/'.$new->image_url)}}">
                                            @endif
                                        </div>
                                        <div class="news-desc">
                                            <p>{{($new->published_date)->format('jS F Y')}}</p>
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
                                        </div>
                                        <div class="news-desc-hr"></div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-news-left-section">
                                    <p><b>No news found !</b></p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="news-right-section">
                                <div class="row">
                                    @if($oldNews->count() > 0)
                                        <div class="head-news-right-section">
                                            <ul>
                                                @foreach($oldNews as $onews)
                                                    <li class="news-head">
                                                        <h3>
                                                            <b>{{ ucfirst($onews->title)}}</b>
                                                        </h3>
                                                        <p>{{($onews->published_date)->format('jS F Y')}}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
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