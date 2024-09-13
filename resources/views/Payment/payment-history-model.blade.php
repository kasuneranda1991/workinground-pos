<div class="row"><!-- Start Row -->
@foreach($payments as $payment)<!-- payment foreach start -->
@if(Auth::user()->role == 'super_admin')
    @if($payment->state != 'Accepted')<!-- payment accepted if start -->
    <div class="col-lg-4">
      <div class="card card-small card-post mb-4">
        <div class="card-body">
          <h5 class="card-title">
          {{ $payment->type }}
          </h5>
          <!-- ============================================= -->
            @if($payment->state == 'Pending' || $payment->state == 'Due_Payment')
              <p class="card-text text-muted">
              @foreach($shops as $shop)
                @if($shop->id == $payment->shop_id)
                  Shop Name:{{$shop->shop_name}}<br>
                  Contact:@if($shop->contact_no)
                            {{$shop->contact_no}}
                          @else 
                            {{$payment->contact}}
                          @endif <br>
                  Payment for {{ $payment->pay_for }}<br>
                    @if($payment->state == 'Due_Payment')
                      This is {{ $payment->state }} 
                    @endif<br>
                      {{ $payment->remark }}
                @endif
              @endforeach
              </p>
            @elseif($payment->state == 'Accepted')
              <p class="card-text text-success">
                {{$payment->remark}}
              </p>
            @else
              <p class="card-text text-danger">
                {{$payment->remark}}
              </p>
            @endif
            <!-- =========================================== -->
            <img data-zoom-image="payment/{{$payment->voucher}}" src="payment/{{$payment->voucher}}" class="elevate-image img-fluid" alt="Responsive image">
        </div>
        <div class="card-footer border-top d-flex">
          <div class="card-post__author d-flex">
            <div class="d-flex flex-column justify-content-center ml-3">
            <span class="card-post__author-name">Payment ID:{{$payment->id}}</span>
              <small class="text-muted">{{ \Carbon\Carbon::parse($payment->created_at)->toDateTimeString() }}</small>
            </div>
         </div>
          <div class="my-auto ml-auto">
          <!-- ===================================================== -->
            @if(Auth::user()->role == 'super_admin' && $payment->state == 'Pending' || $payment->state == 'Due_Payment'  )
            <a data-toggle="modal" data-target="#paymentConfirm" class="btn btn-sm btn-outline-dark" href="#"><i class="fa check-square-o mr-1"></i> Approve </a>
            <div class="modal fade" id="paymentConfirm" tabindex="-1" role="dialog" aria-labelledby="Payment_Update" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="Payment_Update">Payment Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="/payment_approve" id="form" method="post">
                      {{csrf_field()}}
                      <div class="form-group">
                        <select class="form-control" name="state">
                          <option selected="">Select Action</option>
                          <option value="Rejected">Reject</option>
                          <option value="Accepted">Accept</option>
                          <!-- <option value="Accepted">Accept</option> -->
                        </select>
                      </div>
                      
                      @if($payment->change != null)
                      <!-- start input -->
                      <div class="form-group">
                        <select class="form-control" name="payment_plan_change">
                          <option selected="">Select Plan</option>
                          <option value="starter">Starter Plan</option>
                          <option value="advance">Advance Plance</option>
                          <option value="economy">Economy Plan</option>
                          <!-- <option value="Accepted">Accept</option> -->
                        </select>
                      </div>
                      <!-- end input -->
                      @endif
                      
                      <div class="form-group">
                        <textarea style="min-height: 200px;" name="remark" class="form-control" placeholder="Remark about payment...">
                          We're Sorry,our payment has been Rejected,OR Contragulation Your Payment has been Accepted,Your Current Service facility extended from YYY-MM-DD till YYY-MM-DD 
                        </textarea>
                      </div>
                      
                      @if($payment->state == 'Due_Payment')
                      <!-- input -->
                        <div class="form-group">
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Connection Expire at</span>
                            </div>
                            <input type="date" class="form-control" name="due_payment_duration" placeholder="Ex DD/MM/YYYY" aria-label="due_payment_duration" aria-describedby="basic-addon1"> 
                        </div>
                        </div>
                      <!-- end input -->
                      @else
                        <!-- input start -->
                        <div class="form-group">
                          <select required name="payment_duration" class="form-control">
                              <option selected="">Select Extend Period</option>
                              <option value="1M">1 Month</option>
                              <option value="3M">3 Month</option>
                              <option value="6M">6 Month</option>
                              <option value="1Y">1 Year</option>
                              <option value="5Y">5 Year</option>
                          </select>
                        </div>
                        <!-- end input -->
                      @endif

                      <input type="hidden" name="payment_id" value="{{$payment->id}}">
                      <input type="hidden" name="shop_id" value="{{$payment->shop_id}}">
                    </form>                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a  onclick="$('#form').closest('form').submit()" class="btn btn-sm btn-outline-dark" >Proceed </a>
                  </div>
                </div>
              </div>
            </div>
            @elseif($payment->state == 'Rejected')
            <form id="delete_form" action="/payment_delete" method="post">
            {{ csrf_field() }}
              <input type="hidden" value="{{ $payment->id }}" name="delete_id" >
              <a onclick="$('#delete_form').closest('form').submit()" class="btn btn-sm btn-outline-danger" href="#"><i class="fa check-square-o mr-1"></i> Delete </a>
            </form>
            @endif
            <!-- ======================================== -->
          </div>
        </div>
      </div>
    </div>
    @endif<!-- payment accepted if end -->
@else
  <!-- ========= -->
  @if(Auth::user()->shop_id == $payment->shop_id)
  @if($payment->state != 'Pending')
  @if($payment->state != 'Due_Payment')
  <div class="col-lg-4">
    <div class="card card-small card-post mb-4">
      <div class="card-body">
        <h5 class="card-title">{{ $payment->type }}</h5>
          @if($payment->state == 'Accepted')
          <p class="card-text text-success">
            {{$payment->remark}}
          </p>
          @elseif($payment->state == 'Rejected')
          <p class="card-text text-danger">
            {{$payment->remark}}
          </p>
          @endif
      </div>
      <div class="card-footer border-top d-flex">
        <div class="card-post__author d-flex">
          <div class="d-flex flex-column justify-content-center ml-3">
          <span class="card-post__author-name">Payment ID:{{$payment->id}}</span> 
            <small class="text-muted">{{ \Carbon\Carbon::parse($payment->created_at)->toDateTimeString() }}</small>
          </div>
       </div>
        <div class="my-auto ml-auto">
          @if($payment->state == 'Accepted')
          <a class="btn btn-sm btn-success disabled" href="#"><i class="fa check-square-o mr-1"></i> Accepted </a>
          @elseif($payment->state == 'Rejected')
          <a class="btn btn-sm btn-danger disabled" href="#"><i class="fa check-square-o mr-1"></i> Rejected </a>
          @else
          <a href="#" data-toggle="tooltip" data-placement="right" title="Payment under Inspection,This will take few hours" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('loading/proccess.gif');">Proccesing</a>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif
  @endif
  @endif
  <!-- ========== -->
@endif
@endforeach <!-- end payment foreach -->
</div><!-- End Row -->