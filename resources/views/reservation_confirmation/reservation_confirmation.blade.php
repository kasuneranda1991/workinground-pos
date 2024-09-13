@extends('master')
@section('pageurl') Home > Received Recervation Confirmation @stop
@section('pagetitle') Confirm clients reservation details @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> 
<link rel="stylesheet" href="css/notification.css">
@stop
@section('content')
<table class="ui celled selectable center aligned table compact" style="width: 100%;" id="confirmationTable">
  <thead>
      <tr>
          <th scope="col">Reservation ID</th>
          <th scope="col">payment state</th>
          <th scope="col">collect method</th>
          <th scope="col" data-orderable="false">remark</th>
          <th scope="col" data-orderable="false">aouthorized By</th>
          <th scope="col" data-orderable="false" >advance</th>
          <th scope="col" data-orderable="false">Discount</th>
          <th scope="col" data-orderable="false">Total Outstanding Payment</th>
          <th scope="col" data-orderable="false"></th>
      </tr>
  </thead>
</table>
<form id="reservationConfirmForm" action="/confirm-reservation" method="POST">
	{{ csrf_field() }}
	<input type="hidden" name="confirm_payment_id" id="confirm_payment_id">
	<input type="hidden" name="type" id="confirmtype">
</form>

<!-- modal start -->
<div class="modal fade" id="rejectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Reason for Reject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<form id="reservationRejectForm" action="/confirm-reservation" method="POST">
			{{ csrf_field() }}
			<textarea class="form-control" name="reason"  placeholder="please clearly state reson for reject"></textarea>
			<input type="hidden" name="reject_payment_id" id="reject_payment_id">
			<input type="hidden" name="type" id="rejectType">
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-danger" id="rejectButton">Reject</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end -->
@stop
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script src="js/notification.js"></script>
<script src="js/reservationVerification.js"></script>
@stop