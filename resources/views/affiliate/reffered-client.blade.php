
      <div class="card tab-pane" id="clientTab" role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <img src="{{asset('images/affiliate/head.png')}}" alt=""><br>
          <span style="color: #9d9e9f;padding:5px">Total Referred Clients</span> <br>
          {{$clients->count()}}
        </div>
        <div class="card-body">
          <table width="100%">
            <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
              <th style="padding:5px; font-size:18px;">Client Name</th>
              <th style="padding:5px; font-size:18px;">Product</th>
              <th style="padding:5px; font-size:18px;text-align:right">Product Amount</th>
              <!-- <th style="padding:5px; font-size:18px;">Product ID</th> -->
              <th style="padding:5px; font-size:18px;text-align:right">Commission</th>
              <th style="padding:5px; font-size:18px;text-align:center">Payment Date</th>

              <th style="padding:5px; font-size:18px;text-align:center">Status</th>
            </tr>

            @foreach($clients as $client)
          @php
          $reffered = DB::table('clients')
          ->where('id', '=', $client->client_id)
          ->get();
            $pays = DB::table('payments')
            ->where('application_id', '=', $client->id)
            ->where('payment_type', '=', 'First Payment')
            ->first();

            $prod = DB::table('pricing_plans')
            ->where('destination_id', '=', $client->destination_id)
            ->first();

            $comm = DB::table('commission')
            ->where('product_id', '=', $client->destination_id)
            ->first();

            list($product, $ot) = explode(' ', $prod->plan_name);
            @endphp
            @foreach($reffered as $reffer)
            @php
            $name = $reffer->name . ' ' . $reffer->sur_name;
            @endphp
            @endforeach
            <tr style="color: #9d9e9f;background-color: #fff;">
              <td style="padding:5px; font-size:15px;">{{$name}}</td>
              <td style="padding:5px; font-size:15px;">{{$product}}</td>
              <td style="padding:5px; font-size:15px;text-align:right">{{number_format($prod->total_price,2)}} <span style="font-size:10px;">AED</span></td>
              <!-- <td style="padding:5px; font-size:15px;">{{--$client->destination_id--}}</td> -->
              <td style="padding:5px; font-size:15px;text-align:right">{{number_format($comm->client_commission,2)}} <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px; font-size:15px;text-align:center">{{$pays->payment_date}}</td>

              <td style="padding:5px; font-size:15px;text-align:center">{{$client->first_payment_status}}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
