<style>
    #headerTitle {
        font-family: 'TT Norms Pro Black';
        font-weight: 900;
        font-size: 60px;
        font-style: normal;
    }

        .jiji {
        font-family: 'TT Norms Pro';
        font-style: normal;
padding-block: 50px;
margin-left: 15%;
margin-right: 15%;
align-items: center;
justify-content: center;
}
 
    .jiji {
        font-family: 'TT Norms Pro';
        font-style: normal;
padding-block: 50px;
margin-left: 15%;
margin-right: 15%;
align-items: center;
justify-content: center;
}

.jiji h3 {
  font-weight: 600;
  font-size: 16px;
}

.jiji .title{
  position: absolute;
  display: inline-block;
  top: 330px;
  left:350px;
  text-align: center;
  color: #fff;
}
.jiji .product-title{
  text-transform: uppercase;
}

.jiji .price{
  position: absolute;
  display: inline-block;
  top: 460px;
  left:320px;
  text-align: center;
  color: #000;
  font-size: 20px;
  font-weight: bold;
}
.jiji strong {
  font-weight: bold !important;
  font-size: 22px !important;
}

.jiji strong .wrap {
    font-size: 15px;
    width: 100px;
    word-wrap: break-word;
    white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
    white-space: -pre-wrap;      /* Opera 4-6 */
    white-space: -o-pre-wrap;    /* Opera 7 */
    white-space: pre-wrap;       /* css-3 */
    word-wrap: break-word;       /* Internet Explorer 5.5+ */
    white-space: -webkit-pre-wrap; /* Newer versions of Chrome/Safari*/
    word-break: break-all;
    white-space: normal;
}

.jiji .btn {
    position: absolute;
  display: inline-block;
  top: 580px;
  left:320px;
  width: 150px;
  border-radius: 10px;
  text-align: center;
  color: #ccc;
  font-size: 20px;
  font-weight: bold;
}

/* SECOND PAYMENT ITEMS */

.jiji .title2{
  position: absolute;
  display: inline-block;
  top: 330px;
  left:700px;
  text-align: center;
  color: #fff;
}

.jiji .price2{
  position: absolute;
  display: inline-block;
  top: 460px;
  left:690px;
  text-align: center;
  color: #000;
  font-size: 20px;
  font-weight: bold;
}

.jiji .btn2 {
    position: absolute;
  display: inline-block;
  top: 580px;
  left:685px;
  width: 150px;
  border-radius: 10px;
  text-align: center;
  color: #ccc;
  font-size: 20px;
  font-weight: bold;
}

/* SECOND PAYMENT ITEMS */

.jiji .title3 {
  position: absolute;
  display: inline-block;
  top: 330px;
  left:1090px;
  text-align: center;
  color: #fff;
}

.jiji .price3 {
  position: absolute;
  display: inline-block;
  top: 460px;
  left:1070px;
  text-align: center;
  color: #000;
  font-size: 20px;
  font-weight: bold;
}

.jiji .btn3 {
    position: absolute;
  display: inline-block;
  top: 580px;
  left:1065px;
  width: 150px;
  border-radius: 10px;
  text-align: center;
  color: #ccc;
  font-size: 20px;
  font-weight: bold;
}

</style>


<div class="card d-flex aligns-items-center justify-content-center text-center">
    <div class="card-header" style="background-color:white">My Applications</div><br>
    <div class="card-body" style="background-color:#FAE008;">
        <div class="row jiji d-flex aligns-items-center justify-content-center text-center">
            
            <div class="col-4" style="min-height:500px;background-image: url(../user/images/payment1.svg);background-repeat: no-repeat;">
                <span class="title">
                    <h3 class="product-title" style="font-size: 25px; color:aliceblue">FIRST PAYMENT</h3>
                </span>

                <p><strong class="price">{{number_format(1500,2)}} AED |<span class="wrap">POLAND &nbsp;&nbsp;&nbsp;&nbsp;<br><span class="wrap" style="float:right; margin-left:10px">PACKAGE</span></span></strong></p>

                <p><a class="btn btn-secondary" href="#">Get Receipt</a></p>

            </div>
            
            <div class="col-4 sect" style="min-height:500px;background-image: url(../user/images/payment2.svg);background-repeat: no-repeat;">
            <span class="title2">
                    <h3 class="product-title" style="font-size: 25px; color:aliceblue">SECOND PAYMENT</h3>
                </span>

                <p><strong class="price2">{{number_format(2000,2)}} AED |<span class="wrap">POLAND &nbsp;&nbsp;&nbsp;&nbsp;<br><span class="wrap" style="float:right; margin-left:10px">PACKAGE</span></span></strong></p>

                <p><a class=" btn2 btn btn-secondary" href="#">Pay Now</a></p>
            </div>
            <div class="col-4" style="min-height:500px;background-image: url(../user/images/payment3.svg);background-repeat: no-repeat;">
            <span class="title3">
                    <h3 class="product-title" style="font-size: 25px; color:aliceblue">THIRD PAYMENT</h3>
                </span>

                <p><strong class="price3">{{number_format(1289,2)}} AED |<span class="wrap">POLAND &nbsp;&nbsp;&nbsp;&nbsp;<br><span class="wrap" style="float:right; margin-left:10px">PACKAGE</span></span></strong></p>

                <p><a class=" btn3 btn btn-secondary" href="#">Pay Now</a></p>
            </div>
        </div>


    </div>
</div>