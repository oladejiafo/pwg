
    <style>
    input[type='text'] {
            border-radius: 10px;
    }
    select {
        border-radius: 10px !important;
        height: 50px !important;
        border-color: #ccc !important;
        text-align: left !important;
        align-content: flex-start;
    }
    .cols {
        width:50%; 
        margin-left: 0 auto;
    }

    button {
        width: 350px !important;
        height:60px !important; 
        text-align:center; 
        color:#000; 
        font-family:'TT Norms Pro'; 
        font-weight:700;
        
        display: block;
    margin: 0 auto;

    }

    @media (min-width:375px) and (max-width:768px){
        .cols {
        width:70%; 
        margin-left: 0 auto;
    }
    button {
        width:200px !important;
    }
    }
</style>

<?php
//  $apply = DB::table('applications')
//  ->where('client_id', '=', Auth::user()->id)
//  ->first();

// $applicant_id = $apply->id; 

$card = DB::table('card_details')
->where('client_id', '=', Auth::user()->id)
->orderBy('id', 'desc')
->first();

?>
<form name="form" id="form" method="POST" action="{{ route('card_details') }}" style="width:100%; border-color:#fff;border-style:hidden">
@csrf
  <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
   <div class="col">
    <label for="name" class="form-label">Cardholder' Name</label>
    <input type="text" class="form-control" name="name" id="name" value="{{ (isset($card->card_holder_name)) ? $card->card_holder_name : '' }}" aria-describedby="nameHelp">
    <span class="first_name_errorClass"></span>
   </div>
  </div>
  <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
   <div class="col">
    <label for="card_number" class="form-label">Card Number</label>
    <input type="text" class="form-control" name="card_number" id="card_number"  maxlength="16" value="{{(isset($card->card_number)) ? $card->card_number : '' }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
    @if($errors->has('card_number'))
    <div class="error">{{ $errors->first('card_number') }}</div>
    @endif
   </div>
  </div> 
  <div class="row mb-3" style="width:70%; margin: 0 auto; margin-bottom:20px">
  <!-- <div class="col-4">
    <label for="cvc" class="form-label">CVC</label>
    <input type="text" class="form-control" name="cvc" id="cvc" pattern="\d*" maxlength="3" value="{{(isset($card->cvv)) ? $card->cvv : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
   {{-- @if($errors->has('cvv')) --}}
    <div class="error">{{ $errors->first('cvv') }}</div>
    {{-- @endif --}}
   </div> -->
   <div class="col-lg-6 col-sm-12">
    <label for="month" class="form-label">Expiry Month</label>
    <select name="month" class="form-control" id="month" value="{{ old('month') }}" required>
        <option selected>{{ (isset($card->month)) ? $card->month : '' }}</option>
        <option>01</option>
        <option>02</option>
        <option>03</option>
        <option>04</option>
        <option>05</option>
        <option>06</option>
        <option>07</option>
        <option>08</option>
        <option>09</option>
        <option>10</option>
        <option>11</option>
        <option>12</option>
    </select>
   
   </div>
   <div class="col-lg-6 col-sm-12">
    <label for="year" class="form-label">Expiry Year</label>
    <input type="text" class="form-control" name="year" id="year" pattern="\d*" maxlength="4" value="{{(isset($card->year)) ? $card->year : '' }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
    @if($errors->has('year'))
    <div class="error">{{ $errors->first('year') }}</div>
    @endif
   </div>
  </div>
  <div class="row mb-3" style="width:70%; margin: 50px auto; margin-bottom:20px">
  <div align="center" class="col-12">
    <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <div id="target-div"></div>

  </div>
</form>


<script>
    $('#form').on('submit', function(e){
    e.preventDefault(); //1

    var $this = $(this); //alias form reference

    $.ajax({ //2
        url: $this.prop('action'),
        method: $this.prop('method'),
        dataType: 'json',  //3
        data: $this.serialize() //4
    }).done( function (response) {
        // if (response.hasOwnProperty('status')) {
            $('#target-div').html(response.status); 
        // }
    });
});
</script>