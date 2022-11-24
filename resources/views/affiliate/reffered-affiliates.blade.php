
      <div class="card tab-pane" id="affiliateTab"  role="tabpanel">
        <div class="card-header" style="text-align:center; background-color:#fff">
          <img src="{{asset('images/affiliate/head2.png')}}" alt=""><br>
          <span style="color: #9d9e9f;padding:5px">Total Referred Affiliates</span> <br>
          {{$affiliates->count()}}
        </div>
      
        <div class="card-body table-responsive">
          <table class="table table-hover" width="100%">
            <thead>
            <tr style="color: #9d9e9f;background-color: #fff; border-block: 1px solid #cccccc;">
              <th scope="col" style="padding:5px; font-size:18px;">Affiliate Name</th>
              <th scope="col" style="padding:5px; font-size:18px;">Affiliate Code</th>
              <th scope="col" style="padding:5px; font-size:18px;text-align:right">How Many Clients</th>
              <th scope="col" style="padding:5px; font-size:18px;text-align:right">Commission</th>
              <th scope="col" style="padding:5px; font-size:18px;text-align:right">Date Joined</th>
            </tr>
            <thead>

            @foreach($affiliates as $affiliate)
          
             @php
                $reffered = DB::table('applications')
                ->where('refferer_code', '=', $affiliate->affiliate_code)
                ->get();
             @endphp 
            
             @foreach($reffered as $reff)
              @php
                $comm = DB::table('commission')
                ->where('product_id', '=', $reff->destination_id)
                ->first();
              @endphp  
             @endforeach

             @php
                if(isset($comm)){
                    $comm_aff = ($comm->affiliate_commission/100) * $comm->client_commission;
                } else {
                    $comm_aff = 0;
                }

                $cnt = $reffered->count();
                $name = $affiliate->first_name . ' ' . $affiliate->surname;
                $commision = $cnt * $comm_aff;
             @endphp
             <tbody>
            <tr style="color: #9d9e9f;background-color: #fff;">
              <td style="padding:5px; font-size:15px;">{{$name}}</td>
              <td style="padding:5px; font-size:15px;">{{$affiliate->affiliate_code}}</td>
              <td style="padding:5px; font-size:15px;text-align:right">{{$cnt}}</td>
              <td style="padding:5px; font-size:15px;text-align:right">{{number_format($commision,2)}} <span style="font-size:10px;">AED</span></td>
              <td style="padding:5px; font-size:15px;text-align:right">{{date('d-m-Y', strtotime($affiliate->created_at))}}</td>
            </tr>
            </tbody>
            @endforeach
          </table>
        </div>
      </div>
