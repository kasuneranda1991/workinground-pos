@extends('master')
@section('pageurl') Home > Received Recervation @stop
@section('pagetitle') Your reservation history @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css">
<link rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="{{ asset('styles/shards-dashboards.1.0.0.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css">
<link rel="stylesheet" href="css/notification.css">
@stop
@section('content')
<!-- toast -->

<!-- toast -->

<table id="checkinTable">
  <thead >
    <tr>
      <th data-orderable="false" style="width: 3px;">#</th>
      <th style="width: 60px;">ref</th>
      <th>Main Guest</th>
      <th data-orderable="false">Special Note</th>
      <th>Passport</th>
      <th></th>
      <th>Contact</th>
      <th>Room Type</th>
      <th></th>
    </tr>
  </thead>
  <tbody style="font-size: 12px;">
  </tbody>
</table>
<!-- start delete reservation model -->
<div class="modal fade" style="background:-webkit-linear-gradient(-45deg, #c92a2a 0%,#ef4832 25%,#ff1919 63%,#ff1919 84%,#ff1919 84%,#e73827 100%);" id="deleteReservationModal" tabindex="2" role="dialog" aria-labelledby="deleteItem" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteItem1">Mark as NO SHOW Reservation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Warning! This Action Could not Be Undone,Do you really want mark this reservation as NO SHOW ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">No</button>
      <form id="deleteReservationform" action="/mark-as-no-show" method="POST">
        {{ csrf_field() }}
        <button type="submit" id="noshowButton" class="btn btn-outline-danger">Yes</button>
        <input type="hidden" placeholder="product id" id="noshow-reservation_id" name="reservation_id" value="product id"></input>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- end delete reservation model -->

<!-- start checking model -->
<div class="modal fade" id="checkingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Check This Guest</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="checkinForm" action="make-guest-checked-in" method="POST">
          <!-- input -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="available_room_no">Assign Rooms</label>
            </div>
            <select class="custom-select" style="width: 75%;" id="available_room_no" name="rooms[]" multiple="multiple">
            </select>
          </div>
            <!-- end input -->
            
            <!-- input -->
           <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="checkinto">Check In for</label>
            </div>
            <select class="form-control" id="checkinto"  name="check_in_to" title="Check IN To ">
              <option value="bf">Breakfast</option>
              <option value="lu">Lunch</option>
              <option value="din">Dinner</option>
            </select>
            </div>
            <!-- end input -->

            <!-- input -->
           <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="checkoutAfter">Check Out After</label>
            </div>
            <select class="form-control" id="checkoutAfter"  name="check_out_after" title="Check out After ">
              <option value="bf">Breakfast</option>
              <option value="lu">Lunch</option>
              <option value="din">Dinner</option>
            </select>
            </div>
            <!-- end input -->
            {{ csrf_field() }}
            <input type="hidden" name="reservation_id" id="reservation_id" value="">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="checkinSubmit" class="btn btn-primary">Let Check In</button>
      </div>
    </div>
  </div>
</div>
<!-- end checking model -->
@stop
@section('script')
<script src="js/checkin.js"></script>
<script src="js/notification.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@stop