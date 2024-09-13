@extends('master')
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
@stop

@section('content')
<table class="ui celled selectable center aligned table compact" style="width: 100%;" id="shopData">
    <thead>
        <tr>
            <th scope="col">Shop ID</th>
            <th scope="col">Shop Name</th>
            <th scope="col">Type</th>
            <th scope="col">City</th>
            <th scope="col">Payment Plan</th>
            <th scope="col">state</th>
            <th scope="col" data-orderable="false"></th>
            <th scope="col" data-orderable="false">action</th>
            <th scope="col" data-orderable="false">users</th>
        </tr>
    </thead>
</table>
<!-- _______________________Start Model Section_____________________________ -->
<!--start detail  Modal -->
<div class="modal fade actionModel" id="detail_model" tabindex="-1" role="dialog" aria-labelledby="detail_model" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="detail_model_title"></h6>&nbsp;<span id="detail_payment_plan" class="badge badge-pill badge-info"></span>
        <!-- <img src="shop/shop-logo.png" width="50px" height="50px"> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span id="owner_name"></span><i class="material-icons">person</i>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span id="address"></span><i class="material-icons">home</i>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span id="contact"></span><i class="material-icons">phone</i>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                NIC:<span id="detail_nic" class="badge badge-primary badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Monthly Pay:<span id="detail_monthly_rate" class="badge badge-primary badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                BR:<span id="br" class="badge badge-primary badge-pill"></span>
            </li> 
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Avarage Transaction(Monthly):<span id="avarage_transaction_count" class="badge badge-primary badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Avarage Customers(6 Month):<span id="avarage_customer_count" class="badge badge-primary badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                VAT:<span id="vat" class="badge badge-primary badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Bulk SMS
                <!-- changebulk -->
                <span>
                <form id="bulk_change_form" action="/test_bulk_change_shop" >
                {{ csrf_field() }}
                <input type="hidden" id="detail_shop_id_for_bulk" name="bulk_change_shop_id">
                <input type="hidden" id="bulk_check" name="change_state">
                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                        <input type="checkbox" id="bulkCheck" class="custom-control-input">
                        <label id="bulkLable" class="custom-control-label" for="bulkCheck">OFF</label>
                    </div>
                </form>
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                SMS Notification
                <!-- mynot -->
                <span>
                <form id="notification_change_form" action="/test_notification_change_shop" >
                {{ csrf_field() }}
                <input type="hidden" id="detail_shop_id_for_notification" name="notification_change_shop_id">
                <input type="hidden" id="notification_check" name="change_state_for_notification">
                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                        <input type="checkbox" id="NotifyCheck" class="custom-control-input">
                        <label class="custom-control-label" id="NOtifyLable" for="NotifyCheck">OFF</label>
                    </div>
                </form>
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                State
                <span>
                    <form id="verify_shop_form" action="/test_verify_shop">
                    {{ csrf_field() }}
                    <input type="hidden" id="detail_shop_id_for_update" name="verifyshop_id">
                    <input type="hidden" id="detail_change_state" name="state_change">

                        <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                            <input type="submit" data-dismiss="modal" id="detail_verification" name="customToggle5" class="btn btn-outline-success" value="Accept">
                            <!-- <label class="custom-control-label" for="customToggle3">OFF</label> -->
                        </div>
                    </form>
                </span>
            </li>
            <input type="hidden" id="detail_shop_id" value="">
        </ul>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-white" data-dismiss="modal">
              <span class="text-primary">
                <i class="material-icons">clear</i>
              </span> </button>
            <button type="button" id="delete_btn" class="btn btn-white" data-dismiss="modal" data-toggle="modal" data-target="#deleteModel">
              <span class="text-danger">
                <i class="material-icons">delete</i>
              </span></button>
            <button type="button" id="edit_btn" class="btn btn-white" data-dismiss="modal" data-toggle="modal" data-target="#EditModel">
              <span class="text-warnin">
                <i class="material-icons">edit</i>
              </span></button>
              <button type="button" id="message_btn" class="btn btn-white" data-dismiss="modal" data-toggle="modal" data-target="#messageModel">
              <span class="text-primary">
                <i class="material-icons">message</i>
              </span></button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end detail  Modal -->

<!--start edit  Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="edit_model" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit_model">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_shop_detail_form" action="/test_shop_detail" method="post">
        {{ csrf_field() }}
        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_shop_name" name="shop_name" placeholder="Shop Name" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">Shop Name Here</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_owner_name" name="owner_name" placeholder="Owner Name" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">Owner Name Here</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_owner_nic" name="owner_nic" placeholder="Owner NIC" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">Owner NIC Here</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_monthly_rate" name="monthly_rate" placeholder="Monthly Rate" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">Monthly Rate</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_vat" name="vat" placeholder="VAT" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">VAT</span>
          </div>
        </div>
        <!-- end input -->

         <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_br" name="br" placeholder="BR" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">BR</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="edit_contact_no" name="contact_no" placeholder="Contact NO" aria-label="" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <span class="input-group-text">Contact NO</span>
          </div>
        </div>
        <!-- end input -->

        <!-- start input -->
        <div class="form-group">
            <select class="form-control" name="payment_plan" id="edit_payment_plan">
                <option selected="">Choose Payment Plan</option>
                <option value="demo">Demo pack</option>
                <option value="stater">Stater Pack</option>
                <option value="advance">Advance Pack</option>
                <option value="economy">Enterprise Pack</option>
                <option value="life_time">Life Time</option>
            </select>
        </div>
        <!-- end input -->

        <!-- start input -->
        <input type="text" name="edit_shop_id" id="edit_shop_id" >
        <!-- end input -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="please" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--end edit  Modal -->

<!--start message  Modal -->
<div class="modal fade" id="messageModel" tabindex="-1" role="dialog" aria-labelledby="message_model" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="message_model">Send Message to</h5>
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
<!--end message  Modal -->

<!--start delete  Modal -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModel">Delete Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="text-danger">Do you really want to perform this step?</h5><p class="text-danger">Because all the details will be deleted related to this record,Onece you do this cannot be undone</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No,I don't</button>
        <form id="delete_shop_form" action="/test_delete_shop">
        {{csrf_field()}}
        <input type="text" name="delete_shop_id" id="delete_shop_id" >
            <button type="button" class="btn btn-primary">Yes,I want</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--end delete  Modal -->

<!-- start rate model -->
<!-- Modal -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="rateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/update-rate" method="post">
      {{ csrf_field() }}
        <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Update Rate</span>
            </div>
            <input type="text" class="form-control" name="update_rate" placeholder="Precentage of rate" aria-label="rate" aria-describedby="basic-addon1" data-bv-field="rate"> 
        </div>
        <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="rate" data-bv-result="NOT_VALIDATED" style="display: none;">Rate is required</small>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
      <input type="hidden" name="requestToUpdateRate" value="1">
      </form>
    </div>
  </div>
</div>
<!-- end rate model -->

<!-- start create rate model -->
<!-- Modal -->
<div class="modal fade" id="CreateRateModal" tabindex="-1" role="dialog" aria-labelledby="rateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/update-rate" id="create_rate_form" method="post">
      
        <!-- start input    -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Stater Rate</span>
              </div>
              <input type="text" class="form-control" id="create_stater_rate" name="stater_rate" placeholder="Stater rate" aria-label="rate" aria-describedby="basic-addon1" data-bv-field="rate"> 
          </div>
          <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="rate" data-bv-result="NOT_VALIDATED" style="display: none;">Rate is required</small>
        </div>
        <!-- end input    -->

        <!-- start input    -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Advance Rate</span>
              </div>
              <input type="text" class="form-control" id="create_advance_rate" name="advance_rate" placeholder="advance rate" aria-label="rate" aria-describedby="basic-addon1" data-bv-field="rate"> 
          </div>
          <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="rate" data-bv-result="NOT_VALIDATED" style="display: none;">Rate is required</small>
        </div>
        <!-- end input    -->

        <!-- start input    -->
        <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">Enterprice Rate</span>
              </div>
              <input type="text" class="form-control" id="create_enterprice_rate" name="enterprice_rate" placeholder="Enterprice rate" aria-label="rate" aria-describedby="basic-addon1" data-bv-field="rate"> 
          </div>
          <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="rate" data-bv-result="NOT_VALIDATED" style="display: none;">Rate is required</small>
        </div>
        <!-- end input    -->
        <input type="hidden" value="1" name="create_rate">
        {{ csrf_field() }}
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="create_rate_form_button" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end creat rate model -->

<!-- start users model -->
<div class="modal fade bd-example-modal-lg" id="usersModel" tabindex="-1" role="dialog" aria-labelledby="usermodeltitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usermodelTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="model_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- end users model -->

<!-- _______________________End Model Section_____________________________ -->
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
     type: "POST",
     url: '/ratedata',
     success: function(data)
    {
      $.each(data,function(index,value){
        // create_stater_rate
        if(value.plan_name === 'stater'){
          $('#create_stater_rate').val(value.rate);
        }else if(value.plan_name === 'advance'){
          $('#create_advance_rate').val(value.rate);
        }else if(value.plan_name === 'economy'){
          $('#create_enterprice_rate').val(value.rate);
        }
      });        
    }
  });
});
$(function() {
  $('#create_rate_form_button').click(function(){
    $('#create_rate_form').submit();
  });
    var table = $('#shopData').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('shops.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'type', name: 'type' },
            { data: 'city', name: 'city' },
            { data: 'payment_plan', name: 'payment_plan' },
            { data: 'state', name: 'state' },
            { data: 'expire_state', name: 'expire_state' },
            { data: 'intro', name: 'intro' },
            { data: 'users', name: 'users' },
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
            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
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
    {
      text: 'Update Rate',
      className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
      action: function () {
          $('#rateModal').modal('show');
      },init: function(api, node, config) {
         $(node).removeClass('dt-button buttons-copy buttons-html5')
      },
    },
    {
      text: 'Create Rate',
      className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
      action: function () {
          $('#CreateRateModal').modal('show');
      },init: function(api, node, config) {
         $(node).removeClass('dt-button buttons-copy buttons-html5')
      },
    }
        ],select: {
            style: 'os',
            blurable: true
        },
    //     buttons: [
    //     {
    //         text: 'Reload',
    //         action: function ( e, dt, node, config ) {
    //             dt.ajax.reload();
    //         }
    //     }
    // ],
    });
    
    $('#shopData tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        if(data.bulk == 0){
            $('#bulkCheck').attr('checked',false);
        }else if(data.bulk == 1){
            $('#bulkCheck').attr('checked',true);
        }

        if(data.notification == 0){
            $('#NotifyCheck').attr('checked',false);
        }else if(data.notification == 1){
            $('#NotifyCheck').attr('checked',true);
        }
    } );

    $('#shopData tbody').on('click', 'button.usersModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $('#model_body').empty();
        // alert('user button');
        $('#usersModel').modal('show');
        $('#usermodelTitle').text('Current Users of '+data.shop_name);
        $.ajax({
               type: "get",
               url: '/manageusers/'+data.id,
               success: function(data)
              {
                    $.each(data,function(index,value){
                      $('#model_body').append('<div class="card-footer border-top d-flex"><div class="card-post__author d-flex"><a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('+'user/'+value.profile_pic+''+');"></a><div class="d-flex flex-column justify-content-center ml-3"><span class="card-post__author-name">'+value.username+'('+value.role+')'+'</span><small class="text-muted" id="verification'+value.id+'"></small></div></div><div class="my-auto ml-auto"><div class="btn-group btn-group-sm" role="group" aria-label="Small button group"><button type="button" id="roleAdmin'+value.id+'" class="btn btn-secondary">Make Admin</button><button type="button" id="roleUser'+value.id+'" class="btn btn-secondary" style="background-color:#550c5c;">Make User</button><button type="button" id="roleCashier'+value.id+'" class="btn btn-danger">Block</button></div></div></div><form action="/change-user-role" id="roleChangeForm'+value.id+'">{{ csrf_field() }} <input type="hidden" id="change'+value.id+'" name="change_role"><input type="hidden" id="change_user_id'+value.id+'" name="change_role_user_id"></form>');

                      $('#roleAdmin'+value.id).on('click',function(){
                        // alert('Role Changed as Admin on User Id'+value.id);
                        $('#change'+value.id).val('admin');
                        $('#change_user_id'+value.id).val(value.id);
                          var form = $('#roleChangeForm'+value.id);
                          var url = form.attr('action');

                          $.ajax({
                                 type: "POST",
                                 url: url,
                                 data: form.serialize(), // serializes the form's elements.
                                 success: function()
                                 {
                                     console.log('role changed'); // show response from the php script.
                                      
                                 }
                               });
                           $.ajax({
                              type: "get",
                              url: '/manageusers/'+value.id,
                              success:function(newdata)
                              {
                                $('#model_body').empty();
                                $.each(newdata,function(index,value){
                                  $('#model_body').append('<div class="card-footer border-top d-flex"><div class="card-post__author d-flex"><a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('+'user/'+value.profile_pic+''+');">Written by James Khan</a><div class="d-flex flex-column justify-content-center ml-3"><span class="card-post__author-name">'+value.username+'('+value.role+')'+'</span><small class="text-muted" id="verification'+value.id+'"></small></div></div><div class="my-auto ml-auto"><div class="btn-group btn-group-sm" role="group" aria-label="Small button group"><button type="button" id="roleAdmin'+value.id+'" class="btn btn-secondary">Make Admin</button><button type="button" id="roleUser'+value.id+'" class="btn btn-secondary">Make User</button><button type="button" id="roleCashier'+value.id+'" class="btn btn-secondary">Make Cashier</button></div></div></div><form action="/change-user-role" id="roleChangeForm'+value.id+'">{{ csrf_field() }} <input type="hidden" id="change'+value.id+'" name="change_role"><input type="hidden" id="change_user_id'+value.id+'" name="change_role_user_id"></form>');
                                  if(value.verification_code != 0){
                                    $('#verification'+value.id).append('<span class="badge badge-warning">Code:'+value.verification_code+'</span>');
                                  }else{
                                    $('#verification'+value.id).append('<span class="badge badge-success">Verified</span>');
                                  }
                                });
                              }
                           });
                      });

                      $('#roleUser'+value.id).on('click',function(){
                        // alert('Role Changed as User on User Id'+value.id);
                        // start form submit
                        $('#change'+value.id).val('user');
                        $('#change_user_id'+value.id).val(value.id);
                          var form = $('#roleChangeForm'+value.id);
                          var url = form.attr('action');

                          $.ajax({
                                 type: "POST",
                                 url: url,
                                 data: form.serialize(), // serializes the form's elements.
                                 success: function(data)
                                 {
                                     console.log('role changed'); // show response from the php script.
                                     location.reload();
                                      
                                 }
                          });
                        // end form submit
                      });

                      $('#roleCashier'+value.id).on('click',function(){
                        alert('Role Changed as Cashier on User Id'+value.id);
                      });

                      if(value.verification_code != 0){
                        $('#verification'+value.id).append('<span class="badge badge-warning">Code:'+value.verification_code+'</span>');
                      }else{
                        $('#verification'+value.id).append('<span class="badge badge-success">Verified</span>');
                      }
                      if(value.confirmed != 0){
                        $('#verification'+value.id).append('<span class="badge badge-light">Confirmed</span>');
                      }else{
                        $('#verification'+value.id).append('<form action="/change-user-role" id="activeMeForm'+value.id+'">{{ csrf_field() }}<a href="#" id="activeMe'+value.id+'" class="btn btn-outline-success">Active Me</a><input type="hidden" name="active_user_id" value="'+value.id+'" ><input type="hidden" name="active_user_shop_id" value="'+value.shop_id+'" ></form>');
                      }

                      $('#activeMe'+value.id).on('click',function(){
                          console.log('User Activated');
                          var form = $('#activeMeForm'+value.id);
                          var url = form.attr('action');

                          $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: form.serialize(), // serializes the form's elements.
                                   success: function()
                                   {
                                    location.reload();                                    
                                   }
                               });
                      });
                    });//end ajax each
              }
          });//end ajax get data
    });

     $('#shopData tbody').on('click', 'button.actionModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        // alert( 'You clicked on '+data.shop_name+'\'s row' );
        $('#detail_model').modal('show');
        $('#detail_model_title').text(data.shop_name);
        $('#owner_name').text(data.owner);
        console.log(data.id);
        $('#address').text(data.address);
        $('#br').text(data.BR);
        $('#avarage_transaction_count').text(data.avarage_transaction_count);
        $('#avarage_customer_count').text(data.avarage_customer_count);
        $('#vat').text(data.VAT);
        $('#contact').text(data.contact_no);
        $('#detail_nic').text(data.owner_nic);
        $('#detail_monthly_rate').text(data.monthly_rate);
        $('#detail_payment_plan').text(data.payment_plan);
        $('#detail_shop_id').val(data.id);
        $('#detail_shop_id_for_update').val(data.id);
        $('#detail_shop_id_for_delete').val(data.id);
        $('#detail_shop_id_for_bulk').val(data.id);
        $('#detail_shop_id_for_notification').val(data.id);

        $('#detail_shop_id_for_bulk').val(data.id);
        if(data.state == 'pending'){
            $('#detail_verification').removeClass('btn btn-outline-success').addClass('btn btn-outline-warning');
            $('#detail_verification').val('pending');
            $('#detail_change_state').val('Verified');
        }else if( data.state == 'Verified' ){
            $('#detail_verification').removeClass('btn btn-outline-success').addClass('btn btn-outline-success');
            $('#detail_verification').val('Accepted(Click To Block)');
            $('#detail_change_state').val('Blocked');
        }else if(data.state == 'Blocked'){
            $('#detail_verification').removeClass('btn btn-outline-success').addClass('btn btn-outline-danger');
            $('#detail_verification').val('Blocked(Click To Unblock)');
            $('#detail_change_state').val('Verified');
        }
    } );
     $('#edit_btn').on('click',function(){
        $('#edit_shop_name').val($('#detail_model_title').text());
        $('#edit_owner_name').val($('#owner_name').text());
        $('#edit_owner_nic').val($('#detail_nic').text());
        $('#edit_monthly_rate').val($('#detail_monthly_rate').text());
        $('#edit_vat').val($('#vat').text());
        $('#edit_br').val($('#br').text());
        $('#edit_contact_no').val($('#contact').text());
        $('#edit_payment_plan').val($('#detail_payment_plan').text());
        $('#edit_shop_id').val($('#detail_shop_id').val());
        $('#delete_shop_id').val($('#detail_shop_id').val());
     });
// changebulkjs
    $('#bulkCheck').on('change',function(e){
        if($(this).is(':checked')){
            $('#bulk_check').val(1);
            $('#bulkLable').text('ON');
            console.log('checked');
        }else{
            $('#bulk_check').val(0);
            $('#bulkLable').text('OFF');
        }
        console.log('Bulk Sms State changed');
        var form = $('#bulk_change_form');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   console.log(data); // show response from the php script.
               }
             });
        var table = $('#shopData').DataTable();
        table.ajax.reload( null, false );
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $('#NotifyCheck').on('change',function(e){
        if($(this).is(':checked')){
            $('#notification_check').val(1);
            $('#NOtifyLable').text('ON');
            console.log('checked');
        }else{
            $('#notification_check').val(0);
            $('#NOtifyLable').text('OFF');
        }
        console.log('Notification sms state changed');
        var form = $('#notification_change_form');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   console.log(data); // show response from the php script.
               }
             });
        var table = $('#shopData').DataTable();
        table.ajax.reload( null, false );
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


     $('#delete_btn').on('click',function(){
        $('#delete_shop_id').val($('#detail_shop_id').val());
     });

    $('#shopData').on( 'keyup', function () {
        table.column(i)
     .search("^" + $(this).val() + "$", true, false, true)
     .draw();
    } );
// start form submit
  //start verify shop detail
        $("#edit_shop_detail_form").on('click',function(e) {
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   console.log(data); // show response from the php script.
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
            });
  // end verify shop detail
// end form submit
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        //start verify shop
        $("#verify_shop_form").on('click',function(e) {

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   console.log(data); // show response from the php script.
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
            });
  // end verify shop

  //start delete shop
        $("#delete_shop_form").on('click',function(e) {

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   console.log('shop Deleted'); // show response from the php script.
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
            });
  // end delete shop
    });
</script>
@stop