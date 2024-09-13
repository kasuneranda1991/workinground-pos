@extends('master')
@section('pageurl') Home > Recervation @stop
@section('pagetitle') Your Online stock @stop
@section('header') 
  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
  <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/multiple-select/1.2.2/multiple-select.min.css"> -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"> -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet"> -->
@stop
@section('content')
<!-- start form -->
<form action="/create-new-reservation" id="getReservationForm" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="col-lg-12 mb-4">
    <div class="card card-small mb-4">
      <div class="card-header border-bottom">
        <h6 class="m-0">Guest Info</h6>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">First Name <span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="first_name" placeholder="First Name" aria-label="First Name" aria-describedby="basic-addon1" required="required"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Last Name</span>
              </div>
              <input type="text" class="form-control" name="last_name" placeholder="Last Name" aria-label="Last Name" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">address</span>
              </div>
              <input type="text" class="form-control" name="address" placeholder="Guest address" aria-label="Guest address" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Email</span>
              </div>
              <input type="text" class="form-control" name="email" placeholder="Guest Email" aria-label="Guest Email" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Contact No</span>
              </div>
              <input type="text" class="form-control" name="contact_no" placeholder="Contact" aria-label="Contact" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Passport No <span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="passport" required="required" placeholder="Passport NO" aria-label="Passport NO" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <!-- <select class="selectpicker show-tick" data-live-search="true" title="Country*" id="countryData" name="country" data-size="5">
          <option  data-icon="flag-icon flag-icon-af" value="af">Afghanistan</option>
        </select> -->
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Select Country <span style="color: red;">*</span></span>
              </div>
              <select id="countryData" class="form-control" name="country" required title="Select One"></select>
          </div>
        </div>
        <!-- ___________________________________ -->
        <h6 class="m-0">Recervation Info</h6>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Travel Agent<span style="color: red;">*</span></span>
              </div>
              <!-- <input type="text" class="form-control" name="travel_agent" placeholder="Travel Agent" aria-label="Travel Agent" aria-describedby="basic-addon1">  -->
              <select id="travel_agents" class="travel_agents form-control" name="travel_agent" required="required"></select>
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Tour NO</span>
              </div>
              <input type="text" class="form-control" name="tour_no" placeholder="Tour NO" aria-label="Tour NO" aria-describedby="basic-addon1"> 
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" >Check IN <span style="color: red;">*</span></span>
            </div>
            <input type="date" class="form-control" name="check_in"  data-toggle="tooltip" data-placement="top" title="Check IN" required="required">
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" >Check Out <span style="color: red;">*</span></span>
            </div>
            <input type="date" class="form-control" name="check_out" data-toggle="tooltip" data-placement="top" title="Check Out" required="required">
          </div>
        </div>
        <!-- ___________________________________ -->
        <!-- <div class="form-row">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group col-md-3">
                <select class="selectpicker"  name="check_in_to" title="Check IN To ">
                  <option value="bf">Breakfast</option>
                  <option value="lu">Lunch</option>
                  <option value="din">Dinner</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <select class="selectpicker"  name="check_out_after" title="Check Out After ">
                <option value="bf">Breakfast</option>
                <option value="lu">Lunch</option>
                <option value="din">Dinner</option>
              </select>
            </div>
          </div>
        </div> -->
        <!-- ___________________________________ -->
        <div class="row">
          <div class="form-group col-md-12">
            <div class="form-row">
              <div class="form-group col-md-3" required>
                <select class="form-control selectpicker" name="reservation_type" id="reservation_type" title="Reservation Type" required="required">
                  <option value="0" selected='selected'>Reservation Type</option>
                  <option value="fb">Full Board</option>
                  <option value="hb">Half Board</option>
                  <option value="bb">Bed & Breakfast</option>
                  <option value="com">Complementary</option>
                  <option value="ro">Room Only</option>
                  <option value="lo">Lunch Only</option>
                  <option value="bo">Breakfast Only</option>
                  <option value="do">Dinner Only</option>
                </select>
              </div>
              <div class="form-group col-md-3" id="reservation_roomtypeDiv">
                <select class='form-control selectpicker' required="required" name='reservation_room_type' id='reservationroomtype'  title='Room Type'><option value='0'>Room Type</option><option value='Dulux'>Dulux</option><option value='Sweet'>Sweet</option><option value='Family'>Family Room</option><option value='Inter_connected'>Inter Connected</option></select>
              </div>
              <div class="form-group col-md-3" id="reservation_bed_typeDiv">
                <select class='form-control selectpicker' required="required" name='reservation_bed_type' id='reservation_bed_type' title='bed Type'><option value='0'>Bed Type</option><option value='Double'>Double</option><option value='Single'>Single</option><option value='Normal'>Normal</option><option value='Bunker'>Bunker</option><option value='King'>King</option><option value='Twin'>Twin</option><option value='Tripple'>Tripple</option><option value='Extra_Single'>Extra Single Bed</option><option value='Extra_Double'>Extra Double Bed</option></select>
              </div>
              <!-- <div class="form-group col-md-3" id="availableRoomNoDiv">
                <select id="available_room_no" class="js-example-basic-multiple form-control" name="states[]" multiple="multiple"></select>
              </div> -->
             <input type="hidden" id="reservationRateCode"  name="reservationRateCode" value="">
          </div>
        </div>
        <!-- ___________________________________ -->
          <div class="form-group col-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Room Count</span>
                </div>
                <input type="number"  pattern="[0-9]" class="form-control" id="room_count" name="room_count" placeholder="Room Count" required="required"> 
            </div>
          </div>
          <div class="form-group col-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Adult<span style="color: red;">*</span></span>
                </div>
                <input type="number"  pattern="[0-9]" class="form-control" name="adult_count" placeholder="Room Count" required="required"> 
            </div>
          </div>
          <div class="form-group col-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Children<span style="color: red;">*</span></span>
                </div>
                <input type="number"  pattern="[0-9]" class="form-control" name="child_count" placeholder="Room Count"> 
            </div>
          </div>
          <div class="form-group col-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">No Of Night<span style="color: red;">*</span></span>
                </div>
                <input type="number"  pattern="[0-9]" class="form-control" required="required" name="night_count" id="night_count" placeholder="Room Count"> 
            </div>
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group row">
          <div class="input-group col-md-4">
            <div class="input-group-prepend">
              <span class="input-group-text" id="rateType">Local Rate<span style="color: red;">*</span></span>
            </div>
            <input type="text" class="form-control" id="totalPaymentAmount" name="rate" readonly>
            <div class="input-group-prepend">
              <span class="input-group-text">LKR</span>
            </div>
          </div><div class="input-group col-md-4">
            <div class="input-group-prepend">
              <span class="input-group-text" >Discount(%)</span>
            </div>
            <input type="text" class="form-control" id="reservation_discount" name="reservation_discount">
            <div class="input-group-prepend">
              <span class="input-group-text">LKR</span>
            </div>
          </div>
        </div>
        <!-- ___________________________________ -->
        <div class="form-group">
          <textarea class="form-control" name="special_note" placeholder="Special Requirement........."></textarea>
        </div>
        <!-- ___________________________________ -->
        <ul class="list-inline">
          <li class="list-inline-item"><h6 class="m-0">Payment Info</h6></li>
          <li class="list-inline-item"><label>Total Amount:</label> <span class="badge badge-pill badge-success" id="reservationGrossamount">0LKR</span></li>
        </ul>
        
        <!-- ___________________________________ -->
        <div class="form-group col-md-3">
          <select class="selectpicker" name="payment_collect" title="Payment Collect" required="required">
            <option value="DirectCollect">Direct Collect from Guest</option>
            <option value="Travel_agent_payment">Travel Agent Payment</option>
            <option value="Bank_deposite">Bank Deposite</option>
            <option value="Payment_Done">Full Payment Done</option>
          </select>
        </div>
        <!-- ___________________________________ -->
        <div class="row">
          <div class="col-md-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Advance Payment</span>
              </div>
              <input type="text" class="form-control" name="advance_payment" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Upload</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="advance_payment_voucher" id="inputGroupFile01">
                <label class="custom-file-label" for="inputGroupFile01">payment Voucher</label>
              </div>
            </div>
          </div>
        </div>
        <!-- ___________________________________ -->
        <!-- ___________________________________ -->
        <div class="row">
          <!-- <div class="col-md-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Total Reservation Payment<span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="total_reservation_payment" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div> -->
          <div class="col-md-12">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Upload Reservation Voucher</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="reservation_voucher" id="reservationVoucher">
                <label class="custom-file-label" for="inputGroupFile01">Reservation Voucher</label>
              </div>
            </div>
          </div>
        </div>
        <!-- ___________________________________ -->
      <input type="submit" class="float-right btn btn-sm blue-gradient btn-rounded waves-effect waves-light" value="Make Reservation">
    </div>
  </div>
</div>
</form>
<!-- end form -->
@stop
@section('script')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="js/form-rule.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/multiple-select/1.2.2/multiple-select.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js -->

"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js"></script> -->
<script type="text/javascript">
  // $('.ui.dropdown').dropdown();
  $(document).ready(function(){
    $('.js-example-basic-multiple').select2({
      placeholder: 'Select Rooms',
    });
    // $('#countryData').select2({
    //   placeholder: 'select Country',
    // });
    // $('#travel_agents').select2({
    //   placeholder: 'Select Travel Agent',
    // });
    $('.selectpicker').selectpicker();
   $.ajax({
          type: "post",
          url: '/get-available-room-data',
          success: function(data)
          {
            $.each(data,function(index,value){
              // console.log(value.room_no);
              $('#available_room_no').append($('<option>', {
                  value: value.id,
                  text: value.room_no,
              }));
            });
          }
    });
   $.ajax({
      type: "post",
      url: '/get-travel-agent-data',
      success: function(data)
      {
        $.each(data,function(index,value){
          // console.log(value.room_no);
          $('#travel_agents').append($('<option>', {
              value: value.id,
              text: value.name,
          }));
        });
      }
    });

   $.ajax({
      type: "post",
      url: '/get-country-data',
      success: function(data)
      {
        $.each(data,function(index,value){
          // console.log(value.room_no);
          $('#countryData').append($('<option>', {
              value: value.value,
              text: value.name,
          }));
        });
      }
    });
  var a ='';
  var b ='';
  var c ='';
   $('#reservation_type').change(function(){
      console.log($(this).val());
      a = $(this).val();
      return public();
   });
   $('#reservationroomtype').change(function(){
      console.log($(this).val());
      b = $(this).val();
      return public();
   });
   $('#reservation_bed_type').change(function(){
      console.log($(this).val());
      c = $(this).val();
      return public();
   });
   $('#room_count').on('keyup',function(){
      return public();
   });
   $('#night_count').on('keyup',function(){
      return public();
   });
   $('#countryData').change(function(){
      // console.log('change');
      return public();
   });
   // function getGross(){
   //  total = $('#room_count').val() * value.local_rate;
    
   //  $('#reservationGrossamount').text(total+'LKR');
   // }
   function public(){
      if(a != 0 && b != 0 && c != 0){
        console.log('a b c true');
        console.log(a+b+c);
        $('#reservationRateCode').val(a+b+c);
        $.ajax({
          type    : "POST",
          url   : "/get-room-rate-data", 
          success   : function(data)
                    {   
                    // console.log(data); 
                    var tota = '';      
                      $.each( data, function( key, value ) {
                        if(a+b+c == value.rateCode){
                          // console.log('exact match');
                          // console.log(value.local_rate);
                          if ($('#countryData').val() == 'lk') {
                            $('#totalPaymentAmount').val(value.local_rate);
                            total = $('#room_count').val() * value.local_rate * $('#night_count').val();
                            $('#reservationGrossamount').text(total+'LKR');
                            $('#rateType').text('Local Rate');
                          }else if($('#countryData').val() != 'lk'){
                            $('#totalPaymentAmount').val(value.foreign_rate);
                            total = $('#room_count').val() * value.foreign_rate * $('#night_count').val();
                            $('#reservationGrossamount').text(total+'LKR');
                            $('#rateType').text('Foreign Rate');
                          }
                        }else{
                          $('#reservationGrossamount').val(0);
                        }
                      });
                    }
          });
       }else{
        $('#reservationGrossamount').val(0);
       }
   }    
  });
</script>
@stop
