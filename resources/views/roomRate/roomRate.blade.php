@extends('master')
@section('pageurl') Home > Room @stop
@section('pagetitle') Your Online stock @stop
@section('header') 
  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css"> -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
  <style type="text/css">
    .box {
  width: 200px; height: 300px;
  position: relative;
  border: 1px solid #BBB;
  background: #EEE;
}
.ribbon {
  position: absolute;
  left: -5px; top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 75px; height: 75px;
  text-align: right;
}
.ribbon span {
  font-size: 10px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  width: 100px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#EB236C 0%, #7A2727 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 19px; left: -21px;
}
.ribbon span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #7A2727;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #7A2727;
}
.ribbon span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #7A2727;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #7A2727;
}
  </style>
@stop
@section('content')
<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#createModal">Create</button>
  <button type="button" class="btn btn-sm btn-secondary">Availability</button>
  <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#rateModal">make rate</button>
  <button type="button" id="viewHotelRatebtn" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#currentHotelRate">View Hotel Rates</button>
  <div class="form-group col-md-3">
    <select title="Room Type" name="room_type_selector" id="room_type_selector" required>
      <option value="0">See All</option>
      <option value="Dulux">Dulux</option>
      <option value="Sweet">Sweet</option>
      <option value="Family">Family Room</option>
      <option value="Inter_connected">Inter Connected</option>
    </select>
  </div>
</div>
<!-- create modal start -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Create Room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- start form -->
      <form action="/create-room" method="post">
      {{ csrf_field() }}
        <!-- start input -->
        <div class="form-group col-md-3">
          <select title="Room Type" class="form-control" name="room_type" required>
            <option value="Dulux">Dulux</option>
            <option value="Sweet">Sweet</option>
            <option value="Family">Family Room</option>
            <option value="Inter_connected">Inter Connected</option>
          </select>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Room Count</span>
              </div>
              <input type="text" class="form-control" required name="room_count" placeholder="Room Count"> 
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Room Specification</span>
              </div>
              <input type="text" class="form-control" required name="room_specification" placeholder="Room Count"> 
          </div>
        </div>
        <!-- end input -->

      <!-- end form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Rooms</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- create modal end -->

<!-- create edit modal start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Room-<h4 id="room_no"></h4></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- start form -->
      <form action="/edit-room" method="post">
      {{ csrf_field() }}
        <!-- start input -->
        <div class="form-group col-md-3">
          <select title="Room Type" name="edit_room_type" id="edit_room_type">
            <option value="Dulux">Dulux</option>
            <option value="Sweet">Sweet</option>
            <option value="Family">Family Room</option>
            <option value="Inter_connected">Inter Connected</option>
          </select>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Room No</span>
              </div>
              <input type="text" class="form-control" name="edit_room_No" placeholder="Room NO" required> 
          </div>
        </div>
        <!-- end input -->
        <!-- start input -->
        <div class="form-group">
          <textarea class="form-control" id="description" name="room_specification" placeholder="Special Details about room........."></textarea>
        </div>
        <!-- end input -->
        <input type="hidden" name="room_id" id="room_id">
      <!-- end form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Rooms</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- create edit modal end -->

<!-- create rate modal start -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Create Room Rate for One Night</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- start form -->
      <form action="/create-new-hotel-rate" method="post">
      {{ csrf_field() }}
          <div class="form-row">
            <div class="form-group col-md-4">
              <select class="form-control" name="reservation_type" id="rate_reservation_type" title="Reservation Type">
                <option value="0">Reservation Type</option>
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
            <div class="form-group col-md-4" id="rateroomtypeDiv"></div>
            <div class="form-group col-md-4" id="rate_bed_typeDiv"></div>
          </div>
          <!-- start input -->
        <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Local Rate<span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="local_rate" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Foreign Rate<span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="foreign_rate" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div>
        <!-- end input -->
      <!-- end form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Rooms</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- create rate modal end -->

<!-- edit rate modal start -->
<div class="modal fade" id="editRateModel" tabindex="-1" role="dialog" aria-labelledby="editRateModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Room Rate for One Night <span class="badge badge-pill badge-dark" id="rateCode">Code</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- start form -->
      <form action="/edit-hotel-rates" id="EditHotelRateForm" method="post">
      {{ csrf_field() }}
          <div class="form-row">
            <div class="form-group col-md-4" required>
              <select class="form-control" name="edit_reservation_type" id="edit_rate_reservation_type" title="Reservation Type">
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
            <div class="form-group col-md-4" id="edit_rateroomtypeDiv"></div>
            <div class="form-group col-md-4" id="edit_rate_bed_typeDiv"></div>
          </div>
           <!-- start input -->
        <div class="form-group col-md-12">
            <!-- <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">New Ratsssse Code Will Be</span>
              </div> -->
              <input type="hidden" class="form-control" name="editedNewRate" id="new_rate_code">
            <!-- </div> -->
          </div>
        <!-- end input -->

          <!-- start input -->
        <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Local Rate<span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="edit_local_rate" id="edit_local_rate" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Foreign Rate<span style="color: red;">*</span></span>
              </div>
              <input type="text" class="form-control" name="edit_foreign_rate" id="edit_foreign_rate" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-prepend">
                <span class="input-group-text">LKR</span>
              </div>
            </div>
          </div>
        <!-- end input -->
        <input type="hidden" name="edit_rate_id" id="edit_rate_id">
      <!-- end form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#currentHotelRate">Close</button>
        <button type="submit" id="edit_rate_sbt_btn" data-dismiss="modal" class="btn btn-primary">Create Rooms</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- edit rate modal end -->

<!-- get hotel rate modal start -->
<div class="modal fade"  id="currentHotelRate" tabindex="-1" role="dialog" aria-labelledby="currentHotelRate" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Current Hotel Rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="ui celled selectable center aligned table compact" style="width: 100%;" id="HotelRateData">
          <thead>
              <tr>
                  <th scope="col">Rate Code</th>
                  <th scope="col">Local Rate</th>
                  <th scope="col">Foreign Rate</th>
                  <th scope="col">Last Update</th>
                  <th scope="col">Updated By</th>
                  <th scope="col" data-orderable="false">action</th>
              </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- get hotel rate modal end -->

<!-- get hotel rate delete modal start -->
<div class="modal fade" style="background:-webkit-linear-gradient(-45deg, #c92a2a 0%,#ef4832 25%,#ff1919 63%,#ff1919 84%,#ff1919 84%,#e73827 100%);" id="deleteRateModel" tabindex="2" role="dialog" aria-labelledby="deleteItem1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteItem1">Delete <span id="delete_rate_code">Rate Code</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Warning! This Action Could not Be Undone,Really do you want to perform this action ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">No</button>
      <form id="deleteitemform" action="/delete-hotel-rates" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-outline-danger">Yes</button>
        <input type="hidden" id="delete_rate_id" name="delete_rate_id"></input>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- get hotel rate delete modal end -->

<!-- delete Hotem Room modal start -->
<div class="modal fade" style="background:-webkit-linear-gradient(-45deg, #c92a2a 0%,#ef4832 25%,#ff1919 63%,#ff1919 84%,#ff1919 84%,#e73827 100%);" id="deleteRoomModal" tabindex="2" role="dialog" aria-labelledby="deleteItem1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteItem1">Delete <span id="delete_room_no">Rate Code</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Warning! This Action Could not Be Undone,Really do you want to perform this action ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">No</button>
      <form id="deleteitemform" action="/delete-hotel-room" method="POST">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-outline-danger">Yes</button>
        <input type="hidden" id="delete_room_id" name="delete_room_id"></input>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- delete Hotem Room modal end -->

<!-- start room -->
<div id="MyRooms" class="row">
<!-- start no -->
<!-- end no -->
</div>
<!-- end room -->


@stop
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js"></script> -->
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
<script type="text/javascript">
  // $('.ui.dropdown').dropdown();
  $(document).ready(function(){
    $('#edit_rate_sbt_btn').click(function(){
      $('#EditHotelRateForm').submit();
    });
    $('#viewHotelRatebtn').click(function(){
      $('#edit_rateroomtypeDiv').empty();
      $('#edit_rate_bed_typeDiv').empty();
    });
    $('#rateroomtypeDiv').append("<select class='form-control' name='rate_room_type' id='rateroomtype'  title='Room Type'><option value='0'>Room Type</option><option value='Dulux'>Dulux</option><option value='Sweet'>Sweet</option><option value='Family'>Family Room</option><option value='Inter_connected'>Inter Connected</option></select>");
    $('#rate_bed_typeDiv').append("<select class='form-control' name='rate_bed_type' id='rate_bed_type' title='bed Type'><option value='0'>Bed Type</option><option value='Double'>Double</option><option value='Single'>Single</option><option value='Normal'>Normal</option><option value='Bunker'>Bunker</option><option value='King'>King</option><option value='Twin'>Twin</option><option value='Tripple'>Tripple</option><option value='Extra_Single'>Extra Single Bed</option><option value='Extra_Double'>Extra Double Bed</option></select>");
    // $('select').selectpicker();
    // start get room data
    $.ajax({
        type    : "POST",
        url   : "/get-room-data",
        data    : 'json',
        cache   : false,  
        success   : function(data) {          
                $.each( data, function( key, value ) {
                      // alert( key + ": " + value.id );
                      $('#MyRooms').append("<div class='card border-success mb-3 box' style='max-width: 18rem;''><div class='ribbon'><span>"+value.room_no+"</span></div><div class='card-header bg-transparent border-success text-right'>"+value.type+"</div><div class='card-body text-success'><h5 class='card-title'>Specification</h5><p class='card-text'>"+value.description+"</p></div><div class='card-footer bg-transparent border-success'><div class='btn-group btn-group-sm' role='group'><div class='btn-group' role='group'><div class='btn-group btn-group-sm' role='group'><button type='button' class='btn btn-unique btn-sm' id='room_edit_button"+value.id+"' data-toggle='modal' data-target='#editModal'>Edit</button><button type='button' id='room_delete_button"+value.id+"' data-toggle='modal' data-target='#deleteRoomModal' class='btn btn-unique btn-sm' id='room_delete_button'>Delete</button><button type='button' class='btn btn-unique btn-sm' id='room_disable_button'>Disable</button></div></div></div></div></div>");
                      $('#room_edit_button'+value.id).click(function(){
                        console.log(value.id);
                        $('#edit_room_type option[value='+value.type+']').attr('selected','selected');
                        $('#room_no').text(value.room_no);
                        $('#edit_room_type_selector').text(value.room_no);
                        $('#room_id').val(value.id);
                        $('#description').text(value.description);
                      });

                      // delete room start
                      $('#room_delete_button'+value.id).click(function(){
                        console.log(value.id);
                        $('#delete_room_no').text(value.room_no);
                        $('#delete_room_id').val(value.id);
                      });
                      // delete room end
                    });
                console.log(data);
              } //end function
      });
    // end get room data

    // start create rate
    $('#rate_reservation_type').on('change',function(){
      
      console.log($(this).val());
      var valS = $(this).val();
      if(valS == 'bo' || valS == 'lo' || valS == 'do' ){
        $('#rateroomtypeDiv').empty();
        $('#rate_bed_typeDiv').empty();
      }else{
        $('#rateroomtypeDiv').empty();
        $('#rate_bed_typeDiv').empty();
        $('#rateroomtypeDiv').append("<select class='form-control' name='rate_room_type' id='rateroomtype'  title='Room Type'><option value='0'>Room Type</option><option value='Dulux'>Dulux</option><option value='Sweet'>Sweet</option><option value='Family'>Family Room</option><option value='Inter_connected'>Inter Connected</option></select>");
        $('#rate_bed_typeDiv').append("<select class='form-control' name='rate_bed_type' id='rate_bed_type' title='bed Type'><option value='0'>Bed Type</option><option value='Double'>Double</option><option value='Single'>Single</option><option value='Normal'>Normal</option><option value='Bunker'>Bunker</option><option value='King'>King</option><option value='Twin'>Twin</option><option value='Tripple'>Tripple</option><option value='Extra_Single'>Extra Single Bed</option><option value='Extra_Double'>Extra Double Bed</option></select>");
      }
    });
    // end create rate

    // current rate table start
    var tableData = $('#HotelRateData').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('getHotelRate.data') !!}',
        columns: [
            { data: 'rateCode', name: 'id' },
            { data: 'local_rate', name: 'local_rate' },
            { data: 'foreign_rate', name: 'foreign_rate' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'user_id', name: 'user_id' },
            { data: 'action', name: 'action' },
        ],
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-copy buttons-html5')
            } },
                    { extend: 'excelHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-copy buttons-html5')
            } },
                    { extend: 'pdfHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-copy buttons-html5')
            } },
                    { extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-copy buttons-html5')
            } },
            {
              text: 'Refresh',
              className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
              action: function ( e, dt, node, config ) {
                  dt.ajax.reload();
              },init: function(api, node, config) {
                 $(node).removeClass('dt-button buttons-copy buttons-html5')
              },
            },
        ],
  });
    // current rate table end
  
  // edit rate start
  $('#HotelRateData tbody').on('click', 'button.editRateModel', function () {
    $('#edit_rateroomtypeDiv').append("<select class='form-control' required name='edit_rate_room_type' id='edit_rateroomtype'  title='Room Type'><option value='0' selected='selected'>Room Type</option><option value='Dulux'>Dulux</option><option value='Sweet'>Sweet</option><option value='Family'>Family Room</option><option value='Inter_connected'>Inter Connected</option></select>");
    $('#edit_rate_bed_typeDiv').append("<select required class='form-control' name='edit_rate_bed_type' id='edit_rate_bed_type' title='bed Type'><option value='0' selected='selected'>Bed Type</option><option value='Double'>Double</option><option value='Single'>Single</option><option value='Normal'>Normal</option><option value='Bunker'>Bunker</option><option value='King'>King</option><option value='Twin'>Twin</option><option value='Tripple'>Tripple</option><option value='Extra_Single'>Extra Single Bed</option><option value='Extra_Double'>Extra Double Bed</option></select>");
        var data = tableData.row( $(this).parents('tr') ).data();
        $('#new_rate_code').val(data.rateCode);
        // start create rate
        var a ='';
        var b ='';
        var c ='';
        $('#edit_rate_reservation_type').on('change',function(){
          
          console.log($(this).val());
          var valS = $(this).val();
          a = $(this).val();
          console.log(a+b+c);
          $('#new_rate_code').val(a+b+c)
          if(valS == 'bo' || valS == 'lo' || valS == 'do' ){
            $('#edit_rateroomtype').attr('disabled','disabled');
            $('#edit_rate_bed_type').attr('disabled','disabled');
          }else{
            $('#edit_rateroomtype').removeAttr('disabled','disabled');
            $('#edit_rate_bed_type').removeAttr('disabled','disabled');
          }
        });
         $('#edit_rateroomtype').on('change',function(){
          console.log($('#edit_rateroomtype').val());
          b = $(this).val();
          console.log(a+b+c);
          $('#new_rate_code').val(a+b+c)
         });
         $('#edit_rate_bed_type').on('change',function(){
          console.log($('#edit_rate_bed_type').val());
          c = $(this).val();
          console.log(a+b+c);
          $('#new_rate_code').val(a+b+c)
         });
        // end create rate
        $('#rateCode').text(data.rateCode);
        $('#edit_local_rate').val(data.local_rate);
        $('#edit_foreign_rate').val(data.foreign_rate);
        $('#edit_rate_id').val(data.id);
        console.log(data.id);
    });
  // edit rate end
  
  // delete rate start
   $('#HotelRateData tbody').on('click', 'button.deleteRateModel', function () {
      var data = tableData.row( $(this).parents('tr') ).data();

      $('#delete_rate_code').text(data.rateCode);
      $('#delete_rate_id').val(data.id);
   });
  // delete rate end
  });
</script>
@stop
