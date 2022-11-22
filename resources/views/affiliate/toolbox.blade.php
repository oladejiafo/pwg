@extends('affiliate.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="toolbox">
                <div class="col-12">
                    @php $lastId = null; @endphp
                    <div class="presentation">
                        @foreach($presents as $present)
                            <div class="toolbox-sec">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="toolbox-left-sec">
                                            <img src="{{asset('images/affiliate/'.$present->image_url)}}"  width="100%" height="100%">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="toolbox-right-sec">
                                            <h1>{{$present->title}}</h1>
                                            <p class="toolbox-right-sub-head">{{$present->sub_title}}</p>
                                            <p class="toolbox-right-desc">
                                                {!!
                                                    substr($present->details,0,500)
                                                !!}
                                            </p>
                                            <input type="button" class="btn startCopy" value="Copy Link" onclick="Copy('{{$present->link_url}}');" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $lastId = $present->id; @endphp
                        @endforeach
                    </div>
                    <div class="row justify-content-md-center">
                        <button type="button" class="btn btn-default load">Load More <span class="loadImg"><img src="{{asset('images/down_arrow.png')}}"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('affiliate-scripts')
    <script>
        var lastid = '{{$lastId}}';
        $('.load').click(function(){
            $.ajax({
                url:"{{ route('affiliate.loadmore.load_data') }}",
                method:"POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "lastid": lastid
                },
                success:function(response){  
                    console.log(response);
                    $.each(response, function( index, value ) {
                        $('.presentation').append('<div class="toolbox-sec"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><div class="toolbox-left-sec"><img src="{{asset('images/affiliate')}}/'+value.image_url+'" width="100%" height="100%"></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><div class="toolbox-right-sec"><h1>'+value.title+'</h1><p class="toolbox-right-sub-head">'+value.sub_title+'</p><p class="toolbox-right-desc">'+(value.details).substring(0,500)+'</p><input type="button" class="btn startCopy" value="Copy Link" onclick="Copy('+value.link_ur+');" /></div></div></div></div>');
                        lastid = value.id;
                    });
                }
            });
        });

        function Copy(copyText) {
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');  
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                'positionClass': 'toast-bottom-right',
            }
            toastr.info("Code copied!");
        }
    </script>
@endpush
