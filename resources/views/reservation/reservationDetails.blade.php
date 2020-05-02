@extends('master')
@section('pageurl') Home > Received Recervation @stop
@section('pagetitle') Your reservation history @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css">
<link rel="stylesheet" href="css/notification.css">
@stop
@section('content')
<table class="ui celled selectable left aligned table compact" style="width:100%" id="reservationDetails">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ref</th>
            <th scope="col">Travel Agent</th>
            <th scope="col">Guest Name</th>
            <th scope="col">Contact</th>
            <th scope="col">Check IN</th>
            <th scope="col">Check OUT</th>
            <th scope="col">Status</th>
            <th scope="col" data-orderable="false"></th>
        </tr>
    </thead>
<tbody>
</tbody>
</table>

<!-- more details model start  -->
<div class="modal fade" id="detailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reservation NO: <span id="reservationRef"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&tims;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- start form -->
      <!-- start form -->
      <form action="/edit-reservation" id="editReservationForm" method="post">
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
                    <input type="text" class="form-control" required="required" name="first_name" id="first_name" placeholder="First Name" aria-label="First Name" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Last Name</span>
                    </div>
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" aria-label="Last Name" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">address</span>
                    </div>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Guest address" aria-label="Guest address" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Email</span>
                    </div>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Guest Email" aria-label="Guest Email" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Contact No</span>
                    </div>
                    <input type="text" class="form-control" required="required" name="contact_no" id="contact_no" placeholder="Contact" aria-label="Contact" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Passport No <span style="color: red;">*</span></span>
                    </div>
                    <input type="text" class="form-control" required="required" name="passport" id="passport" placeholder="Passport NO" aria-label="Passport NO" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <!-- <select id="countryData" class="form-control" name="country" ></select> -->
              <!-- ___________________________________ -->
              <h6 class="m-0">Recervation Info</h6>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <!-- <div class="input-group-prepend">
                        <span class="input-group-text">Travel Agent<span style="color: red;">*</span></span>
                    </div> -->
                    <!-- <input type="text" class="form-control" name="travel_agent" placeholder="Travel Agent" aria-label="Travel Agent" aria-describedby="basic-addon1">  -->
                    <!-- <select id="travel_agents" class="travel_agents form-control" name="travel_agent"></select> -->
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tour NO</span>
                    </div>
                    <input type="text" class="form-control" name="tour_no" id="tour_no" placeholder="Tour NO" aria-label="Tour NO" aria-describedby="basic-addon1"> 
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="">Check IN - OUT <span style="color: red;">*</span></span>
                  </div>
                  <input type="date" class="form-control" required="required" name="check_in" id="check_in"  data-toggle="tooltip" data-placement="top" title="Check IN">
                  <input type="date" class="form-control" required="required" name="check_out" id="check_out" data-toggle="tooltip" data-placement="top" title="Check Out">
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-row">
                <div class="row">
                  <!-- <div class="col-md-6"> -->
                   <!--  <span>Check In To</span> -->
                    <div class="form-group col-md-6">
                      <select class="form-control"  name="check_in_to" id="check_in_to" title="Check IN To ">
                        <option value="bf">Breakfast</option>
                        <option value="lu">Lunch</option>
                        <option value="din">Dinner</option>
                      </select>
                    </div>
                  <!-- </div> -->
                  <!-- <span>Check Out After</span> -->
                  <div class="col-md-6">
                    <select class="form-control"  name="check_out_after" id="check_out_after" title="Check Out After ">
                      <option value="bf">Breakfast</option>
                      <option value="lu">Lunch</option>
                      <option value="din">Dinner</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="row">
                <div class="form-group col-md-12">
                  <div class="form-row">
                    <div class="form-group col-md-3" required>
                      <select class="form-control" required="required" name="reservation_type" id="reservation_type" title="Reservation Type">
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
                      <select class='form-control' required="required" name='reservation_room_type' id='reservationroomtype'  title='Room Type'><option value='0'>Room Type</option><option value='Dulux'>Dulux</option><option value='Sweet'>Sweet</option><option value='Family'>Family Room</option><option value='Inter_connected'>Inter Connected</option></select>
                    </div>
                    <div class="form-group col-md-3" id="reservation_bed_typeDiv">
                      <select class='form-control' required="required" name='reservation_bed_type' id='reservation_bed_type' title='bed Type'><option value='0'>Bed Type</option><option value='Double'>Double</option><option value='Single'>Single</option><option value='Normal'>Normal</option><option value='Bunker'>Bunker</option><option value='King'>King</option><option value='Twin'>Twin</option><option value='Tripple'>Tripple</option><option value='Extra_Single'>Extra Single Bed</option><option value='Extra_Double'>Extra Double Bed</option></select>
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
                      <input type="number" required="required"  pattern="[0-9]" class="form-control" id="room_count" name="room_count" placeholder="Room Count"> 
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Adult<span style="color: red;">*</span></span>
                      </div>
                      <input type="number" required="required" pattern="[0-9]" class="form-control" name="adult_count" id="adult_count" placeholder="Room Count"> 
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Children<span style="color: red;">*</span></span>
                      </div>
                      <input type="number"  pattern="[0-9]" class="form-control" name="child_count" id="child_count" placeholder="Room Count"> 
                  </div>
                </div>
                <div class="form-group col-md-3">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">No Of Night<span style="color: red;">*</span></span>
                      </div>
                      <input type="number" required="required"  pattern="[0-9]" class="form-control" name="night_count" id="night_count" placeholder="Room Count"> 
                  </div>
                </div>
              </div>
              <!-- ___________________________________ -->
              <div class="form-group row">
                <div class="input-group col-md-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="rateType">Local Rate<span style="color: red;">*</span></span>
                  </div>
                  <input type="text" class="form-control" id="totalPaymentAmount" name="rate" id="rate" readonly>
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
                <textarea class="form-control" name="special_note" id="special_note" placeholder="Special Requirement........."></textarea>
              </div>
              <!-- ___________________________________ -->
              <ul class="list-inline">
                <li class="list-inline-item"><h6 class="m-0">Payment Info</h6></li>
                <li class="list-inline-item"><label>Total Amount:</label> <span class="badge badge-pill badge-success" id="reservationGrossamount">0LKR</span></li>
              </ul>
              
              <!-- ___________________________________ -->
              <div class="form-group col-md-3">
                <select class="form-control" required="required" name="payment_collect" id="payment_collect" title="Payment Collect">
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
                    <input type="text" class="form-control" name="advance_payment" id="advance_payment" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-prepend">
                      <span class="input-group-text">LKR</span>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-md-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="advance_payment_voucher" id="inputGroupFile01">
                      <label class="custom-file-label" for="inputGroupFile01">payment Voucher</label>
                    </div>
                  </div>
                </div> -->
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
                <!-- <div class="col-md-12">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Upload Reservation Voucher</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="reservation_voucher" id="reservationVoucher">
                      <label class="custom-file-label" for="inputGroupFile01">Reservation Voucher</label>
                    </div>
                  </div>
                </div> -->
              </div>
              <!-- ___________________________________ -->
            <!-- <input type="submit" id="editReservationButton"  value="Make Reservation"> -->
          </div>
        </div>
      </div>
      <input type="hidden" id="edit_reservation_id" name="edit_reservation_id" >
      <!-- end form -->
      <!-- end form -->
      </div>
      <!-- <input type="text" id="user_role" value="'{{Auth::user()->role}}'"> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success" id="editReservationButton">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- more details model end  -->
@stop
@section('script')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script> -->
<script src="js/reservationDetails.js"></script>
<script src="js/notification.js"></script>
<script src="js/form-rule.js"></script>
@stop