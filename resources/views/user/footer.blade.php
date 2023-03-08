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
        padding: 16px;
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
<div id="days">
</div>
<div class="footer" align="right" style="padding:20px; ">
    <hr>
    &copy {{ date('Y') }} <a style="" href="http://pwggroup.ae" target="_blank">PWG Group</a>. All rights
    reserved.
</div>

<script>
// Set the date we're counting down to

var countDownDate = new Date("March 14, 2023 15:17:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;
  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("days").innerHTML = "EXPIRED";
  }
  countDown(distance);
}, 1000);

countDown = (distance) => {
    // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

document.getElementById("days").innerHTML = "<p><span class='head'>PRICE INCREASES IN:</span> <span class='timed'><span>" + days + "</span>Days: <span>" + hours + "</span>Hrs: <span>"
  + minutes + "</span>Mins: <span>" + seconds + "</span>Secs.</span></p>";
}

</script>