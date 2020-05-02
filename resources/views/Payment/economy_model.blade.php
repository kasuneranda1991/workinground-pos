<!-- ======================start plan selection model======================= -->
      <div class="modal fade" id="economyPack" tabindex="-1" role="dialog" aria-labelledby="economyPack" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="economyPack">Economy Pack</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/upload-payment" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
            <!-- input start -->
              <div class="form-group">
                <select required name="payment_duration" id="economy_payment_duration" class="form-control">
                    <option selected="">Select Your Payment</option>
                    <option value="1M">1 Month</option>
                    <option value="3M">3 Month (10% OFF)</option>
                    <option value="6M">6 Month (15% OFF)</option>
                    <option value="1Y">1 Year (20% OFF)</option>
                    <option value="5Y">5 Year (25% OFF)</option>
                </select>
              </div>
              <!-- end input -->
              <!-- input -->
              <div class="form-group">
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Upload Payment Voucher</span>
                  </div>
                  <input type="file" class="form-control" name="voucher"  aria-label="voucher" aria-describedby="basic-addon1"> 
              </div>
              </div>
              <!-- end input -->
              <!-- input -->
              <div class="form-group">
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Your Contact No</span>
                  </div>
                  <input type="text" class="form-control valied_number" maxlength="11" placeholder="947xxxxxxxx"  name="contact" value="{{Auth::user()->contact_no}}"> 
              </div>
              </div>
              <!-- end input -->
              @if(Auth::user()->shop->payment_plan != 'demo')
                <input type="hidden" value="{{ Auth::user()->shop->monthly_rate }}" id="economy_monthly_starter" name="monthly_rate">
              @else
              @Inject('rates', 'App\Http\Controllers\RateController')
                <input type="hidden" value="{{ $rates->GetSystemRates('economy') }}" id="economy_monthly_starter" name="monthly_rate">
              @endif
              <input type="hidden" value="economy" name="payment_plan">
              <input type="hidden" id="economy_duration" name="payment_duration">
              <input type="hidden" id="economy_total_amount" name="paid_amount">
              <input type="hidden" name="name" value="{{Auth::user()->username}}">
              @if(Auth::user()->shop->expire_date < \Carbon\Carbon::parse(Carbon\Carbon::now()))
              <input type="hidden" name="due_payment" value="Due_Payment">
              @endif
              
            <hr>
            <p id="economy_save_price">Your Total Price Rs.<span id="economy_total_price"></span>,<br>save Rs.<span id="economy_save"></span></p>
            <p id="economy_discount"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Make My Payment</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    <!-- ======================end plan selection model========================= -->