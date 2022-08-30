
<!-- Theme style  -->
<link rel="stylesheet" href="{{asset('user/extra/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">

<div class="row cardd">


    <h4>WHITE COLLAR JOBS</h4>
    @foreach($whiteJobs as $pdet)
    <div class="col-md-4">
        <div class="about-decc xxanimate-box">

            <div class="card fancy-collapse-panel">
                <div class="panel-group" id="accordionx" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default" style="background-color: #F5F5F5;border:none">
                        <div class="paneled-heading" role="tab" id="headings{{$pdet->id}}">
                            <h4 class="panel-title" style="padding-top:15px;padding-left:15px;">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionx" href="#collapsew{{$pdet->id}}" aria-expanded="true" aria-controls="collapsew{{$pdet->id}}"> &nbsp; {{$pdet->job_title}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapsew{{$pdet->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headings{{$pdet->id}}">
                        <hr style="height:0.1px;border:none;color:#333;">
                            <div class="paneled-body">
                                        <p>
                                            {{$pdet->description}}
                                        </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    @endforeach
</div>


<!-- jQuery -->
<script src="{{asset('user/extra/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('user/extra/js/bootstrap.min.js')}}"></script>

</body>

</html>