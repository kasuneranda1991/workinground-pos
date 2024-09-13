  <!-- Modal Structure -->
  <div id="finishBillrem" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Print Bill of {{ Session::get('itemCount') }} items</h4>
      <div>
      <p>
      @php
          $count = Session::get('itemCount');
          $printid = 1;
        @endphp

        @if(Session::has('billItemArray'))
          @foreach(Session::get('billItemArray') as $row)
          
            @php
              $prod = str_split($row['name']);
              $qtyd = str_split($row['qty']);
              $priced = str_split($row['amount']);
              $item = array(56);
            @endphp

            @for ($i = 0 ; $i <= 56; $i++)
              <!-- =============Start item name=========== -->
              @if($i< 35)
                @foreach($prod as $key => $value)
                  @if($i <= $key)
                    @if($i == $key)
                      @php
                      $item[$i] = $value;
                      @endphp
                    @endif
                  @else
                    @php
                      $item[$i] = " ";
                    @endphp
                  @endif
                @endforeach
              <!-- ==========end item name=============== -->
              
              <!-- ==========start item qty============== -->
            @elseif($i < 42)
                 @foreach($qtyd as $key => $value)
                 @php
                 $key = $key + 35;
                 @endphp
                  @if($i <= $key)
                    @if($i == $key)
                      @php
                      $item[$i] = $value;
                      @endphp
                    @endif
                  @else
                    @php
                      $item[$i] = " ";
                    @endphp
                  @endif
                @endforeach
              <!-- ==========end item qty================ -->
              <!-- ==========start item qty============== -->
            @elseif($i < 56)
                 @<?php foreach ($variable as $key => $value): ?>
                   
                 <?php endforeach ?>($priced as $key => $value)
                 @php
                 $key = $key + 42;
                 @endphp
                  @if($i <= $key)
                    @if($i == $key)
                      @php
                      $item[$i] = $value;
                      @endphp
                    @endif
                  @else
                    @php
                      $item[$i] = " ";
                    @endphp
                  @endif
                @endforeach
              <!-- ==========end item qty================ -->
            @endif
            @endfor <!-- item array for loop end 56 -->
            <input type="hidden" id="billedItem{{$printid}}" value="@foreach($item as $key => $value){{$value}}@endforeach">
            @php $printid++;  @endphp
            <br>

          @endforeach
        @endif
      </p>
      <input type="hidden" id="itemCount" value="{{ Session::get('itemCount') }}">    
      <input type="hidden" id="total" value="{{ Session::get('total') }}">    
      <input type="hidden" id="dis" value="{{ Session::get('dis') }}">    
      <input type="hidden" id="cash" value="{{ Session::get('cash') }}">    
      <input type="hidden" id="balance" value="{{ Session::get('balance') }}">    
      <input type="hidden" id="shop_name" value="{{Session::get('shop')}}">    
      <input type="hidden" id="cashier" value="{{Auth::user()->username}}">
      <input type="hidden" id="time" value="{{Carbon\Carbon::now()->timezone('Asia/Colombo')->toDayDateTimeString()}}">
      <input type="hidden" id="address" value="{{Session::get('address')}}">
      <input type="hidden" id="bill_no" value="{{Session::get('bill_no')}}">
      <input type="hidden" id="city" value="{{Session::get('city')}}">
      <input type="hidden" id="contact_no" value="{{Session::get('contact_no')}}">
      <input id="printerlist" hidden="true" value="{{ Auth::user()->user_printer }}"></input>
      <input id="cutter" hidden="true" type="checkbox" checked="checked"/><br/>
      <input id="image" hidden="true" type="checkbox" checked="checked"/>

      <table class="highlight">
      <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Serial-NO</th>
        <th>Selling Price</th>
        <th>Discount</th>
        <th>Expire Date</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      @foreach( $bill_data as $bill)
      @if($bill->shop_id == Auth::user()->shop_id)
        @if($bill->transaction_id == Session::get('bill_no'))
          @foreach( $products as $product)
            @if($bill->product_id == $product->id)
              <tr>
                <td>{{ $product->company->company_name }}{{ $product->product_name }}</td>
                <td>{{ $bill->qty }}</td>
                <td>
                @if($bill->serial_no)
                  {{ $bill->serial_no }}
                @else
                  N/A
                @endif
                </td>
                <td>{{ $bill->selling_price }}</td>
                @if($bill->discount)
                  <td>{{ $bill->discount }}%</td>
                @else
                <td>N/A</td>
                @endif
                @if($bill->expire_date == '1111-01-01')
                  <!-- <td>{{ $bill->expire_date }}</td> -->
                  <td>N/A</td>
                @else
                 <td>{{ $bill->expire_date }}</td>
                 @endif
                 @if(0 == $bill->total_price)
                   <td>Free</td>
                  @else
                   <td>Rs.{{ $bill->total_price }}</td>
                 @endif
              </tr>
            @endif
          @endforeach
        @endif
      @endif
      @endforeach
    </tbody>
    </table>

      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" onclick="webprint.printRaw(getEscSample($('#cutter').is(':checked'),$('#image').is(':checked')), $('#printerlist').val());" class=" waves-effect waves-green btn-flat">Print Receipt</a>
    </div>
  </div>
        