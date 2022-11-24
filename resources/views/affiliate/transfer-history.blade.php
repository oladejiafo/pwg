
    <style>
.card-bodyx {
        padding-left:5%;
        padding-right: 5%;
    }
    </style>
      <div class="card tab-pane" id="historyTab"  role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <span style="color: #9d9e9f;padding:5px">Trasfer History</span> 
        </div>
      
        <div class="card-bodyx table-responsive">
          <table class="table table-hover" width="100%">
            <thead>
            <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
              <th scope="col" style="padding:5px; ">Account Balance</th>
              <th scope="col" style="padding:5px;;">Bank Details</th>
              <th scope="col" style="padding:5px; text-align:right">IBAN</th>
              <th scope="col" style="padding:5px; text-align:right">Swift</th>
              <th scope="col" style="padding:5px; text-align:right">Transfered Amount</th>
              <th scope="col" style="padding:5px; text-align:center">Date</th>
              <th scope="col" style="padding:5px; text-align:left">Status</th>
            </tr>
            </thead>

            @php
                $trans = DB::table('affiliate_transactions')
                ->where('affiliate_id', '=', $mine->id)
                ->orderBy('transaction_date', 'desc')
                ->get();
            @endphp  

            <tbody>
            @foreach($trans as $tran)
            <tr style="color: #9d9e9f;background-color: #fff;">
              <td style="padding:5px;">{{$tran->balance}} <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px;">{{$tran->bank_name}}</td>
              <td style="padding:5px;text-align:right">{{$tran->account_number}}</td>
              <td style="padding:5px;text-align:right">{{$tran->swift_code}}</td>
              <td style="padding:5px;text-align:right">{{number_format($tran->amount,2)}} <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px;text-align:center">{{date('d-m-Y', strtotime($tran->transaction_date))}}</td>
              <td style="padding:5px;text-align:left">Paid</td>
            </tr>
            @endforeach
            </tbody>
          
          </table>
        </div>
      </div>
