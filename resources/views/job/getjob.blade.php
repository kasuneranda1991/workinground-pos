@extends('master')
@section('pageurl') Home > Get Job @stop
@section('pagetitle') Job Receive @stop
@section('content')
<div class="card card-small mb-4">
    <div class="card-header border-bottom">
      	<h6 class="m-0">Job Form</h6>
    </div>
    
    <ul class="list-group list-group-flush">
        <li class="list-group-item px-3">
            <form action="/postjob" id="receive_job_form" method="post">
                <!-- Button Groups -->
            {{ csrf_field() }}
                <strong class="text-muted d-block mb-2">Priority</strong>
                <div class="form-group">
                <div class="input-group mb-3">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="mb-2 btn btn-outline-success mr-2">
                            <input type="radio" name="priority" id="option1" autocomplete="off" checked="" value="normal"> Normal 
                        </label>
                        <label class="mb-2 btn btn-outline-danger mr-2">
                            <input type="radio" name="priority" id="option2" autocomplete="off" value="urgent"> Urgent 
                        </label>
                        <label class="mb-2 btn btn-outline-primary mr-2">
                            <input type="radio" name="priority" id="option3" autocomplete="off" value="one week"> With In One Week
                        </label>
                        <label class="mb-2 btn btn-outline-warning mr-2">
                        	<input type="radio" name="priority" id="option4" autocomplete="off" value="one day"> With In One Day
                        </label>
                    </div>
                </div>
                </div>
                <!-- / Button Groups -->

                <!-- Input Groups -->
                <strong class="text-muted d-block mb-2">Customer Details</strong>
                    
                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                        <input required type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Customer name" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->

                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">Address</span></div>
                        <input required type="text" class="form-control" placeholder="Address" name="address" aria-label="Customer Address" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->

                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">NIC Customer</span></div>
                        <input required type="text" class="form-control" placeholder="NIC" name="nic" aria-label="Customer NIC" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->

                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">Contact No</span></div>
                        <input required maxlength="11" placeholder="947xxxxxxxx" type="text" class="form-control valied_number" name="contact" aria-label="Customer Contact" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->
                <!-- end input group -->
                <!-- Input Groups -->
                <strong class="text-muted d-block mb-2">Job Details</strong>
                    
                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">Job Description</span></div>
                        <input required type="text" class="form-control" placeholder="Ex:Broken display" name="description" aria-label="Job Description" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->

                    <!-- input field -->
                    <div class="input-group mb-3">
                    	<div class="input-group-prepend"><span class="input-group-text">Remarks</span></div>
                        <input required type="text" class="form-control" placeholder="Ex: Dell 1345-lg ,Black Colour,small scratch on the back side" name="remark" aria-label="Remark" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->

                    <!-- input field -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">Advance Payment</span></div>
                        <input required type="text" class="form-control valied_number" placeholder="Ex: Rs.1000" name="advance" aria-label="Job Price" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->
                    <!-- input field -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">Price</span></div>
                        <input required type="text" class="form-control valied_number" placeholder="Ex: Rs.1000" name="job_price" aria-label="Job Price" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input field -->
                @if(Auth::user()->print_type == 'pos')
                <!-- end input group -->
                <input hidden="true" id="printerlist" value="{{Auth::user()->user_printer}}"></input>
                    <input id="cutter" hidden="true" type="checkbox" checked="checked"/><br/>
                    <input id="image" hidden="true" type="checkbox" checked="checked"/>

                <button type="submit" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2">
                      <i class="material-icons mr-1">print</i>Save & Print Receipt
                </button>
                @else
                <button type="submit" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2">
                      <i class="material-icons mr-1">print</i>Save & Print Invoice
                </button>
                @endif
                <!-- end input group -->
            </form>
        </li>
    </ul>
    
    
</div>
<!-- ==============Print Model -->
<!-- Modal -->
<div class="modal fade" id="print_model" tabindex="-1" role="dialog" aria-labelledby="print_model" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="print_model">Print Your Receipt
            @if(Session::has('job_id'))
                {{Session::get('job_id')}}
            @endif</h5>
      </div>
      <div class="modal-footer">
      <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <form id="printform" name="printform" action="/printJobReceiptModel" method="post">
      {{ csrf_field() }}
        @if(Session::has('job_id'))
            <input type="hidden" id="shop_name" value="{{Session::get('shop')}}">
            <input type="hidden" id="jobNo" value="{{Session::get('jobNo')}}">
            <input type="hidden" id="cashier" value="{{Auth::user()->username}}">
            <input type="hidden" id="time" value="{{Carbon\Carbon::now()->timezone('Asia/Colombo')->toDayDateTimeString()}}">
            <input type="hidden" id="address" value="{{Session::get('address')}}">
            <input type="hidden" id="city" value="{{Session::get('city')}}">
            <input type="hidden" id="contact_no" value="{{Session::get('contact_no')}}">
            <input type="hidden" name="print_job_id" id="print_job_id" value="{{Session::get('job_id')}}">
            <input type="hidden" id="description" value="{{Session::get('description')}}">
            <input type="hidden" id="priority" value="{{Session::get('priority')}}">
            <input type="hidden" id="job_price" value="{{Session::get('job_price')}}">
            <input type="hidden" id="remark" value="{{Session::get('remark')}}">
            <input type="hidden" id="advance_payment" value="{{Session::get('advance_payment')}}">
        @endif
        <button type="submit" onclick="webprint.printRaw(getEscSample($('#cutter').is(':checked'),$('#image').is(':checked')), $('#printerlist').val());" class="btn btn-outline-success">Print Receipt</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- ==============Print Model -->
@stop
@section('printer')
    @if(Auth::user()->print_type == 'pos')
        <script src="{{ asset('printer/webprint.js') }}"></script>
        <script src="{{ asset('js/printscript.js') }}"></script>
    @endif
@stop
@section('script')
<script>

$(document).ready(function() {

    $('.valied_number').on('input', function() {
    match = (/(\d{0,100})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
    this.value = match[1] + match[2];
  });
});
</script>
<script type="text/javascript">
@if(Session::has('job_id'))
    $(window).on('load',function(){
        $('#print_model').modal('show');
    });
@endif
</script>
@stop

