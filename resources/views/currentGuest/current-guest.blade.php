@extends('master')
@section('pageurl') Home > Room Occupancy @stop
@section('pagetitle') Your Room Occupancy Details @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css"> 
@stop
@section('content')
<table class="ui celled selectable left aligned table compact" style="width:100%" id="roomOccupancy">
    <thead>
        <tr>
            <th scope="col">Room No</th>
            <th scope="col">Guest</th>
            <th scope="col">Payble Reservation Amount</th>
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
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- more details model end  -->
@stop
@section('script')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var table = $('#roomOccupancy').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/currentGuestData',
        columns: [
            { data: 'room_no', name: 'room_no' },                
            { data: 'guest_name', name: 'guest_name' },                
            { data: 'outstanding_reservation', name: 'outstanding_reservation' },                
        ],
    });

// $('#roomOccupancy tbody').on('click', 'button.detailModel', function () {
//         var data = table.row( $(this).parents('tr') ).data();
//          $('#detailModel').modal('show');
//   });
});
</script>
@stop