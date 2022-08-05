<!DOCTYPE html>

<html>

    <head>
        <link rel='stylesheet' type='text/css' media='screen' href="{{ asset('css/login.css') }}">
     <style>
.succ {
    width: 409px;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    margin: 0 auto;
    padding: 70px 203px 70px 203px;
    background-color: #ffffff;
    margin-bottom: 420px;
    margin-top: 250px;
    color: #636466;
    align-content: center;
    height: 760px;
}
    .sig button {
    margin: auto;
    margin-top: 20px;
    width: 400px;
    height: 50px;
    background-color: none;
    border-color: #000;
    color:#000;
    font-family: "TTNormsPro-Regular";
    font-size: 25px;
    font-weight: bold;
    padding: 2px;
} 

.sig button:hover{
    background-color: #f9bf29;
    border-color: #f9bf29;
} 
     </style>   
    </head>
    <body>

        <div class="loginx">
            <div class="container">
                <div class="succ" style="margin-top:70px;">
                    <div class="reset">
                        <div class="resetImage">
                            <img src="{{asset('images/Approved.svg')}}" alt="approved">
                        </div>
                        <div class="reset-heading">
                            Awesome !
                        </div>
                        <div class="subConfirm">Your signature has been uploaded successfully</div>
                        <div class="sig">
                            <input type="hidden" name="pid" value="{{$pid}}">
                            <button class="sig">Purchase Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>