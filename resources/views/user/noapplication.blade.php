<div class="card d-flex aligns-items-center justify-content-center text-center" style="margin-top: 150px;">
    <div class="card-header">My Applications</div>
    <div class="card-body" style="margin-top: 50px;">
        <hr>
        <img src="{{asset('user/images/noapply.svg')}}" alt="..." style="width: 250px;height: 250px;">
        <h5 class="card-title">No Applications Yet</h5>
        <p class="card-text" style="margin-bottom: 30px;">You currently have no applications to view.</p><br>
        <a href="{{url('home')}}" class="btn btn-secondary">START NOW</a>
    </div>
</div>

@include('user.earning')