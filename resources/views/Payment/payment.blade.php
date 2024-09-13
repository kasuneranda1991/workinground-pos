@extends('master')
@section('web-page-title'){{ Auth::user()->shop->shop_name }} Payment Details @stop
@section('pageurl') Home > Payment @stop
@section('pagetitle') Your Payment Summary @stop
@if(Auth::user()->role === 'super_admin')
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
@stop
@endif
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist">
@if(Auth::user()->role !='super_admin')
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Payment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">History</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Pending Payment</a>
  </li>
@elseif(Auth::user()->role === 'super_admin')
  <li class="nav-item">
    <a class="nav-link" id="table-tab" data-toggle="tab" href="#table" role="tab" aria-controls="table" aria-selected="false">Table</a>
  </li>
@endif
</ul>
<div class="tab-content" id="myTabContent">

@if(Auth::user()->role != 'super_admin')
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  	<div class="card">
	  <div class="card-body">
	    <h5 class="card-title">Bank Payment</h5>
	    <form action="/upload-payment" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
            @if(Auth::user()->shop->payment_plan == 'demo')
            <!-- input start -->
              <div class="form-group">
                <select required name="payment_duration" id="monthly_plan_selector" class="form-control">
                    <option value="0" selected="">Select Your Payment</option>
                    <option value="starter">start</option>
                    <option value="advance">advance</option>
                    <option value="economy">economy</option>
                </select>
              </div>
              <!-- end input -->
            @endif
              <!-- input start -->
              <div class="form-group">
                <select required name="payment_duration" id="payment_duration_selector" class="form-control">
                    <option value="0" selected="">Select Your Payment</option>
                    <option value="1M">1 Month</option>
                    <option value="3M">3 Month (10% OFF)</option>
                    <option value="6M">6 Month (15% OFF)</option>
                    <option value="1Y">1 Year (20% OFF)</option>
                    <option value="5Y">5 Year (25% OFF)</option>
                    <option value="sender_id">Request Sender ID</option>
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

              <!-- input -->
              <div id="user_sender_id" class="form-group">
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text">Your Sender ID</span>
                  </div>
                  <input type="text" class="form-control" maxlength="11" placeholder="Ex:-Shop Name"  name="request_sender_id"> 
              </div>
              </div>
              <!-- end input -->
              
              <input type="text" value="{{ Auth::user()->shop->monthly_rate }}" id="monthly_rate" name="monthly_rate">
              <input type="text" name="name" value="{{Auth::user()->username}}">
              <input type="text" id="my_total_amount" name="paid_amount">
              <input type="text" id="my_duration" name="payment_duration">
              <input type="text" value="{{Auth::user()->shop->payment_plan}}" name="payment_plan" id="payment_plan">
                            
            <hr>
            <p id="my_save_price">Your Total Price Rs.<span id="my_total_price"></span>,<br>save Rs.<span id="my_save"></span></p>
            <p id="my_discount"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Make My Payment</button>
            </div>
            </form> 
	    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
	  </div>
	</div>
  </div>
  @endif
@if(Auth::user()->role != 'super_admin')
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  	@include('Payment/payment-history-model')
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    @include('Payment/payment-pending-model')
  </div>
@else
@if(Auth::user()->role === 'super_admin')
<div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="payment-record-tab">
  <table class="ui celled selectable center aligned table" style="width:100%" id="paymentData">
    <thead>
        <tr>
            <th scope="col">Payment ID</th>
            <th scope="col">Shop Name</th>
            <th scope="col">Package</th>
            <th scope="col">Accept/Reject</th>
            <th scope="col">Duration</th>
            <th scope="col">Amount</th>
            <th scope="col">Rate</th>
            <th scope="col" data-orderable="false">Change</th>
            <th scope="col">Approved By</th>
            <th scope="col" data-orderable="false">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
@endif
@endif
</div>
@if(Auth::user()->role === 'super_admin')
<!-- approve model start -->
<div class="modal fade" id="paymentConfirmModel" tabindex="-1" role="dialog" aria-labelledby="Payment_Update" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Payment_Update">Payment Confirmation <span id="request" class="badge badge-secondary"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/payment_approve" id="acceptform" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <select class="form-control" name="state">
              <option selected="">Select Action</option>
              <option value="Rejected">Reject</option>
              <option value="Accepted">Accept</option>
              <!-- <option value="Accepted">Accept</option> -->
            </select>
          </div>
          
          <!-- change payment plan start-->
          <!-- start input -->
          <div id="changer_payment_plan" class="form-group">
            <select class="form-control" name="payment_plan_change">
              <option selected="">Select Plan</option>
              <option value="starter">Starter Plan</option>
              <option value="advance">Advance Plance</option>
              <option value="economy">Economy Plan</option>
              <!-- <option value="Accepted">Accept</option> -->
            </select>
          </div>
          <!-- end input -->
         <!-- change payment plan end -->
          
          <div class="form-group">
            <textarea style="min-height: 200px;" name="remark" class="form-control" placeholder="Remark about payment...">
              We're Sorry,our payment has been Rejected,OR Contragulation Your Payment has been Accepted,Your Current Service facility extended from YYY-MM-DD till YYY-MM-DD 
            </textarea>
          </div>
          
          <!-- if due payment -->
          <!-- input -->
          <p id="last_end_date" >Last payment connection end date:<span class="badge badge-dark" id="connection_end_date">Light</span></p>
          <p id="sender_id">Request Sender ID:<span style="font-size: 20px;" class="badge badge-dark" id="request_sender">Light</span></p>
            <div id="duepaymentInput" class="form-group">
            <div class="input-group mb-0">
                <div class="input-group-prepend">
                    <span class="input-group-text">Connection Expire at</span>
                </div>
                <input type="date" class="form-control" name="due_payment_duration" placeholder="Ex DD/MM/YYYY" aria-label="due_payment_duration" aria-describedby="basic-addon1"> 
            </div>
            </div>
          <!-- end input -->
          <!-- end if due payment -->
          <!-- if is not due paument start -->
            <!-- input start -->
            <div id="notduepaymentInput" class="form-group">
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
          <!-- if is not due paument end -->

          <input type="hidden" id="payment_id" name="payment_id" value="payment id">
          <input type="hidden" id="shop_id" name="shop_id" value="payment shop id">
          <div id="smsid"></div>
        </form>
        <img id="voucher_image" data-zoom-image="" src="" class="elevate-image img-fluid" alt="Responsive image">             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a  onclick="$('#acceptform').closest('form').submit()" class="btn btn-sm btn-outline-dark" >Proceed </a>
      </div>
    </div>
  </div>
</div>
<!-- approve model end -->
<form id="delete_form" action="/payment_delete" method="post">
{{ csrf_field() }}
  <input type="hidden" id="delete_payment_id" value="payment id" name="delete_id" >
</form>
@endif
@stop
@section('script')
@if(Auth::user()->role === 'super_admin')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#paymentData').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('payment.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'payment_plan', name: 'payment_plan' },
            { data: 'state', name: 'state' },
            { data: 'pay_for', name: 'pay_for' },
            { data: 'amount', name: 'amount' },
            { data: 'monthly_rate', name: 'monthly_rate' },
            { data: 'change', name: 'change' },
            { data: 'aproved_by', name: 'aproved_by' },
            { data: 'action', name: 'action' },
        ],
    });

    $('#paymentData tbody').on('click', 'button.paymentConfirmModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $('#smsid').empty();
        $('#shop_id').val(data.shop_id);
        if(data.pay_for === 'Request Sender ID'){
          $('#last_end_date').hide();
          $('#sender_id').show();
          $('#request_sender').text(data.other);
          $('#smsid').append('<input type="text" id="payment_duration_for_sms" name="senderId" value="sender_id">');
        }else{
          $('#last_end_date').show();
          $('#sender_id').hide();
          $('#connection_end_date').text(data.connection_end);
        }
        if(data.remark === 'Request to change Payment plan to advance'){
          $('#request').text(data.remark);
        }
        $('#payment_id').val(data.id);
        $('#voucher_image').attr("data-zoom-image",'payment/'+data.voucher);
        $('#voucher_image').attr("src",'payment/'+data.voucher);
        if(data.change != null){
          if(data.pay_for === 'Request Sender ID'){
            $('#changer_payment_plan').hide();
          }else{
            $('#changer_payment_plan').show();
          }
        }else{
          $('#changer_payment_plan').hide();
        }
        if(data.state == 'Due_Payment'){
          $('#connection_end_date').removeClass('badge badge-dark').addClass('badge badge-danger')
          $('#duepaymentInput').show();
          $('#notduepaymentInput').hide();
        }else{
          $('#duepaymentInput').hide();
          if(data.pay_for === 'Request Sender ID'){
            $('#notduepaymentInput').hide();
          }else{
            $('#notduepaymentInput').show();
          }
        }
    });

    $('#paymentData tbody').on('click', 'button.paymentDelete', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert('delete payment');
        $('#delete_payment_id').val(data.id);
        $('#delete_form').submit()
    });

  });
</script>
@endif
@stop