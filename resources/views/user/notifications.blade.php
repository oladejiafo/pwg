<?php
$notifications = DB::table('notifications')
->where('user_id', '=', Auth::user()->id)
->orderBy('id', 'desc')
->limit(5)
->get();

?>
@if($notifications->first())
@foreach($notifications as $notify)
    <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
            <i class="mdi mdi-calendar text-success"></i>
            </div>
        </div>
        <div class="preview-item-content"  style="width:80%;word-wrap: break-word;">
            <p class="preview-subject mb-1"><b>{{ $notify->criteria }}</b></p>
            <p class="text-muted ellipsis mb-0"  style="width:80%;word-wrap: break-word;">{{ $notify->message }}</p>
            <p class="text-muted ellipsis mb-0">{{ $notify->link }}</p>
        </div>
    </a>

    @if(!$loop->last)
        <div class="dropdown-divider"></div>
    @endif
@endforeach
@endif
<!-- <p class="p-3 mb-0 text-center">See all notifications</p> -->