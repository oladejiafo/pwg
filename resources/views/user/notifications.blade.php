
<div id="tbod">
<?php

// Post::where('Expiration_date','<',Carbon::now())->delete();

$notifications = DB::table('notifications')
->where('client_id', '=', Auth::user()->id)
->orderBy('id', 'desc')
->orderBy('status', 'desc')
->limit(5)
->get();

?>

@if($notifications->first())

<div class="row">
        <div class="col px-3 mb-0"><b>NOTIFICATIONS</b></div>
            <div align="right" class="col mb-0" style="margin-right:25px;margin-top:2px">
            <a href="javascript:void(0)" id="noty" style="text-decoration:blue; font-size:11px;color:blue"><i>Mark all as read</i></a>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div style="overflow-y: scroll; height:500px">
        @foreach($notifications as $notify)
        @if($notify->status =="Unread")
        <style>
            #notificationDropdown img {
            content: url("{{asset('user/images/Notification.svg')}}");
            }
        </style>
        <a class="dropdown-item preview-item" style="background-color:#FAFDFE !important;color:#000 !important; font-weight:bold !important">
        @else  
        <a class="dropdown-item preview-item" style="background-color:transparent !important;">
        @endif

        <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
               <i class="mdi mdi-calendar text-success"></i>
            </div>
        </div>
        
        <div class="preview-item-content"  style="width:80%;word-wrap: break-word;">

            <p class="preview-subject mb-1"><b>{{ $notify->criteria }}</b></p>
            
        @if($notify->status =="Unread")
            <p class="text-muted ellipsis mb-0"  style="width:80%;word-wrap: break-word; color:#000 !important; font-weight:500 !important">{{ $notify->message }}</p>
        @else
            <p class="text-muted ellipsis mb-0"  style="width:80%;word-wrap: break-word;">{{ $notify->message }}</p>
        @endif
            <p class="text-muted ellipsis mb-0">{{ $notify->link }}</p>
        </div>
    </a>

        @if(!$loop->last)
            <div class="dropdown-divider"></div>
        @endif
    @endforeach
    @endif
        </div>
</div>
<!-- <p class="p-3 mb-0 text-center">See all notifications</p> -->
<script src="{{asset('user/extra/assets/js/jquery-min.js')}}"></script>

<script>
    $('#noty').on('click', function(e){
        e.preventDefault(); //1

        var $this = $(this); //alias form reference
        $.ajax({ //2
            url: '{{ route("mark_read") }}',
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            }
        }).done( function (response) {  
            if (response) {
                $('#tbod').load(document.URL +  ' #tbod');
                // $('#target-div').html(response.status); 
            }
        });
    });

</script>