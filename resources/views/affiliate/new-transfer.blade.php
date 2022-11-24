<style>
    .card-body {
        padding-left:25%;
        padding-right: 25%;
    }
    .request {
        font-weight: bold;
        font-size: larger;
        margin: auto;
        background: #FFF;
        border-color: #000;
        height: 55px;
        width: 40%;
        border-radius: 0px;
    }

    .request:hover {
        background: #FACB08;
        border-color: #FACB08;
    }

    .submit{
        text-align: center;
    }
</style>

      <div class="card tab-pane" id="transferTab" role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <img src="{{asset('images/affiliate/affiliate_withdraw.png')}}" alt=""><br>
          <h3><span style="color: #9d9e9f;padding:5px">Account Balance</span> </h3>
          <h4>{{number_format($mine->balance,2)}}<span style="font-size:10px;">AED</span></h4>
        </div>
        <div class="card-body">
          
        <form action="{{route('affiliate.process_transfer')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="formGroupamount" class="form-label">Amount to Transfer</label>
                <input type="hidden" name="myid" value="{{Session::get('loginId')}}">
                <input type="text" name="amount" class="form-control" id="formGroupamount" placeholder="Amount to Transfer">
                @if($errors->has('amount'))
                <span class="error" style="color:red;font-style:italic;font-size:small">{{$errors->first('amount')}}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="formGroupname" class="form-label">Your Full Name</label>
                <input type="text" name="name" class="form-control" id="formGroupname" placeholder="Your Full Name" required="" @isset($acct->account_name) value="{{ $acct->account_name}}" @else value="{{$mine->first_name .' '.$mine->surname}}" @endisset>
                @if($errors->has('name'))
                <span class="error" style="color:red;font-style:italic;font-size:small">{{$errors->first('name')}}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="formGroupbank" class="form-label">Your Bank Name</label>
                <input type="text" name="bank" class="form-control" id="formGroupbank" placeholder="Your Bank Name" required="" @isset($acct->bank_name) value="{{ $acct->bank_name }}" @endisset>
                @if($errors->has('bank'))
                <span class="error" style="color:red;font-style:italic;font-size:small">{{$errors->first('bank')}}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="formGroupbankAddress" class="form-label">Bank Address</label>
                <input type="text" name="bankAddress" class="form-control" id="formGroupbankAddress" placeholder="Address of Your Bank" required="" @isset($acct->bank_address) value="{{ $acct->bank_address }}" @endisset>
            </div>
            <div class="mb-3">
                <label for="formGroupbankCountry" class="form-label">Bank Country</label>
                <input type="text" name="bankCountry" class="form-control" id="formGroupbankCountry" placeholder="Bank Country" required=""  @isset($acct->bank_country) value="{{ $acct->bank_country }}" @else value="{{$mine->country_of_residence}}" @endisset>
            </div>
            <div class="mb-3">
                <label for="formGroupaccountNumber" class="form-label">Bank Account Number (IBAN)</label>
                <input type="text" name="accountNumber" class="form-control" id="formGroupaccountNumber" placeholder="Bank Account Number (IBAN)" required="" @isset($acct->account_number_iban) value="{{ $acct->account_number_iban }}" @endisset>
                @if($errors->has('accountNumber'))
                <span class="error" style="color:red;font-style:italic;font-size:small">{{$errors->first('accountNumber')}}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="formGroupswiftCode" class="form-label">SWIFT Code</label>
                <input type="text" name="swiftCode" class="form-control" id="formGroupswiftCode" placeholder="Bank SWIFT Code" @isset($acct->swift_code) value="{{ $acct->swift_code }}" @endisset>
            </div>
            <div class="submit">
                <button type="submit" class="btn request">Request Transfer</button>
            </div>
        </form>
        </div>
      </div>
