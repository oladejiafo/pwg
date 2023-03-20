<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<style>
    .footer {
        font-size: 15px;
    }

    .footer a {
        font-size: 15px;
        margin: 0px;
    }

    .footer a:hover {
        color: blue;
    }

    hr {
        border: 2px solid #fff;
    }

    #days {
        background: #FACB08;
        padding: 6px;
        text-align: center;
        line-height: 1;
        display: block;
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        z-index: 1030;
    }

    #days .head {
        font-size: 20px;
        line-height: 24px;
        font-weight: 700;
        color: #000000;
    }

    #days p span {
        font-weight: 700;
        font-size: 38px;
        color: #000000;
    }

    #days p {
        word-spacing: 8px
    }

    @media (max-width:768px) {
        #days p span.timed {
            font-weight: 500;
            font-size: 14px;
            color: #000000;
            display: inline-block;
        }
    }
    @media (max-width:360px) {
        .footer {
            font-size: 12px;
        }

        .footer a {
            font-size: 12px;
            margin: 0px;
        }
    }
</style>
<?php $timer = App\Helpers\users::getDateTime();?>
<script>
    var timer = new Date("<?php echo e($timer); ?>");
    var countDownDate = new Date("<?php echo e($timer); ?>").getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
    
      // Get today's date and time
    var now = new Date().getTime();

      // Find the distance between now and the count down date
      console.log(parseInt(countDownDate) ,parseInt(now) );
      var distance = parseInt(countDownDate) - parseInt(now);
      // If the count down is finished, write some text
    //   if (distance < 0 || isNaN(distance) || (Math.floor(distance / (1000 * 60 * 60 * 24)) <= 1)) {
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1)
    if ((tomorrow.getMonth()+1) < 10) {
            tomorrow = tomorrow.getFullYear()+'-0'+(tomorrow.getMonth()+1)+'-'+tomorrow.getDate();
    } else {
        tomorrow = tomorrow.getFullYear()+'-'+(tomorrow.getMonth()+1)+'-'+tomorrow.getDate();
    }
    var lastDay = new Date(tomorrow);
    if (compareDate(timer, lastDay) || (Math.floor(parseInt(distance) / (1000 * 60 * 60 * 24)))  <= 0) {
        var date = new Date();
        // Add 7 days to current date
        const futureDate = new Date(date.getTime() + 7 * 24 * 60 * 60 * 1000);

        // Format future date in YMD format
        const year = futureDate.getFullYear();
        const month = String(futureDate.getMonth() + 1).padStart(2, '0');
        const day = String(futureDate.getDate()).padStart(2, '0');
        const hour = futureDate.getHours();
        const minutes = futureDate.getMinutes();
        const second = futureDate.getSeconds();
        const formattedDate = `${year}-${month}-${day}`+' '+`${hour}:${minutes}:${second}`;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "<?php echo e(url('/update/timer/')); ?>",
            data: {
                date: formattedDate,
            },
            success: function (response) {
            }
        });
        countDownDate = date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
        distance = countDownDate - now;
      }
      countDown(distance);
    },1000 );
    
    countDown = (distance) => {
        // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(parseInt(distance) / (1000 * 60 * 60 * 24));
      var hours = Math.floor(parseInt(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor(parseInt(distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor(parseInt(distance % (1000 * 60)) / 1000);
    
    document.getElementById("days").innerHTML = "<p><span class='head'>PRICE INCREASES IN:</span> <span>" + days + "</span>Days: <span>" + hours + "</span>Hrs: <span>"
      + minutes + "</span>Mins: <span>" + seconds + "</span>Secs:</p>";
    }
    compareDate = (timer, tomorrow) => {
        if(timer.getFullYear() >= tomorrow.getFullYear()){
            if(timer.getMonth() >= tomorrow.getMonth()){
                if(timer.getDate() >= tomorrow.getDate()){
                    return true;
                }
            }
        }
        return false;
    }
</script>   
<div id="days">
</div>
<div class="footer" align="right" style="padding:20px; ">
    <hr>
    &copy <?php echo e(date('Y')); ?> <a style="" href="http://pwggroup.ae" target="_blank">PWG Group</a>. All rights
    reserved.
</div>
<?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/footer.blade.php ENDPATH**/ ?>