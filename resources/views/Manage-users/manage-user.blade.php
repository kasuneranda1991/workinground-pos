@extends('master')
@section('pageurl') Manage User @stop
@section('pagetitle') System Users @stop
@section('content')

<div class="row">
  <div class="col">
    <div class="card card-small mb-5">
      <div class="card-header border-bottom">
        <h6 class="m-0">Active Users</h6>
      </div>
      <div class="card-body p-0 pb-3 text-center">
        <table class="table mb-0">
            <thead class="bg-light">
              <tr>
                <th scope="col" class="border-0">Shop Name</th>
                <th scope="col" class="border-0">Address</th>
                <th scope="col" class="border-0">Conatct</th>
                <th scope="col" class="border-0">State</th>
                <th scope="col" class="border-0"></th>
                <th scope="col" class="border-0">Created at</th>
              </tr>
          </thead>
          <tbody>
          @foreach($shops as $shop)<!-- get shop details -->
          @if(Auth::user()->role == 'super_admin')
            <tr>
              <td>{{ $shop->shop_name }}</td>
              <td>@if($shop->address){{ $shop->address }} @else <span class="badge badge-warning">Incomplete</span> @endif</td>
              <td>@if($shop->contact_no){{ $shop->contact_no }} @else <span class="badge badge-warning">Incomplete</span> @endif</td>
              <td>
                @if($shop->state == 'pending' )
                <form id="Verify{{$shop->id}}" method="post">
                {{ csrf_field() }}
                <div id="verifiedcheckbox{{ $shop->id }}" class="btn-group btn-group-sm">
                  <button class="btn btn-white" disabled>
                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                      <input type="checkbox" id="checkbox_state{{ $shop->id }}" name="checkbox_state" class="custom-control-input">
                      <input type="hidden" name="verifyshop" value="{{$shop->id}}">
                      <label id="checkbox_text{{ $shop->id }}" class="custom-control-label" for="checkbox_state{{ $shop->id }}">Pending</label>
                    </div>
                  </button>
                </div>
                </form>
                <button id="verifiedbtn{{ $shop->id }}" type="button" class="btn btn-white">
                    <span class="text-success">
                      <i class="material-icons">check</i>
                    </span> Verified 
                  </button>
                @else
                  <button type="button" class="btn btn-white">
                    <span class="text-success">
                      <i class="material-icons">check</i>
                    </span> Verified 
                  </button>
                    <!-- <label class="custom-control-label" for="checkbox">Approved</label> -->
                @endif
              </td>
              <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#shop{{ $shop->id }}">
                  <span class="text-success">
                      <i class="material-icons">add</i>
                    </span> More
                </button>
              </td>
              <td>{{ $shop->created_at->diffForHumans() }}</td>
            </tr>
            @else

              @if(Auth::user()->shop_id == $shop->id )
                <tr>
              <td>{{ $shop->shop_name }}</td>
              <td>@if($shop->address){{ $shop->address }} @else <span class="badge badge-warning">Incomplete</span> @endif</td>
              <td>@if($shop->contact_no){{ $shop->contact_no }} @else <span class="badge badge-warning">Incomplete</span> @endif</td>
              <td>
                @if($shop->state == 'pending' && Auth::user()->role == 'super_admin' )
                <form id="Verify{{$shop->id}}" method="post">
                {{ csrf_field() }}
                <div id="verifiedcheckbox{{ $shop->id }}" class="btn-group btn-group-sm">
                  <button class="btn btn-white" disabled>
                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                      <input type="checkbox" id="checkbox_state{{ $shop->id }}" name="checkbox_state" class="custom-control-input">
                      <input type="hidden" name="verifyshop" value="{{$shop->id}}">
                      <label id="checkbox_text{{ $shop->id }}" class="custom-control-label" for="checkbox_state{{ $shop->id }}">Pending</label>
                    </div>
                  </button>
                </div>
                </form>
                <button id="verifiedbtn{{ $shop->id }}" type="button" class="btn btn-white">
                    <span class="text-success">
                      <i class="material-icons">check</i>
                    </span> Verified 
                  </button>
                @else
                  @if($shop->state == 'pending')
                  <button type="button" class="btn btn-white">
                    <span class="text-warning">
                      <i class="fa fa-exclamation"></i>
                    </span> Not Verified 
                  </button>
                  @elseif($shop->state == 'Verified')
                  <button type="button" class="btn btn-white">
                    <span class="text-success">
                      <i class="material-icons">check</i>
                    </span> Verified 
                  </button>
                  @else
                    <button type="button" class="btn btn-white">
                    <span class="text-danger">
                      <i class="fa fa-meh-o"></i>
                    </span> state cannot identify 
                  </button>
                  @endif <!-- shop state for admin -->
                @endif <!-- if shop state -->
              </td>
              <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#shop{{ $shop->id }}">
                  <span class="text-success">
                      <i class="material-icons">add</i>
                    </span> More
                </button>
              </td>
              <td>{{ $shop->created_at->diffForHumans() }}</td>
            </tr>
              @endif

            @endif <!-- Auth filter -->
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- start manage-users model -->
@foreach($shops as $shop)
@include('Manage-users.manage-user-model')
@endforeach
<!-- end manage-users model -->

@stop
@section('script')
<script>
  $(document).ready(function(){
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    });
  });
</script>
<script type="text/javascript">
// start verifyshop
  $(function(){
  @foreach($shops as $shop)
  $('#verifiedbtn{{ $shop->id }}').hide();
    $('#checkbox_state{{ $shop->id }}').on('change',function(){
      var form{{$shop->id}} = document.getElementById('Verify{{$shop->id}}');
      var request{{$shop->id}} = new XMLHttpRequest();
      var formData{{$shop->id}} = new FormData(form{{$shop->id}});

      request{{$shop->id}}.open('post','/verify_shop');
      request{{$shop->id}}.send(formData{{$shop->id}});
      console.log('Shop Verified');
      $('#verifiedcheckbox{{ $shop->id }}').hide();
      $('#verifiedbtn{{ $shop->id }}').show();
    });
  @endforeach
// end verifyshop
  });
</script>
<script>
  $(document).ready(function(){
    @foreach($users as $user)
    // start verifi user
  $("#aprove_form{{ $user->id }}").on('click',function(e) {
    $(this).hide();

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
        }),
  // end verify user

 // start block user
  $("#block_form{{ $user->id }}").on('change',function(e) {
    
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
        }),
  // end block user

  // start promote user
  $("#promote_form{{ $user->id }}").on('change',function() {
    
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

     // avoid to execute the actual submit of the form.
        }),
  // end promote user

  // start delete user
  $("#delete_form{{ $user->id }}").on('click',function(e) {
    $(this).hide();

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
  // end delete user
  $(document).ready(function(){
    $('#checkbox_block{{ $user->id }}').on('change',function(){
              if (this.checked) {
                console.log('Block');
                $('#lable_block{{ $user->id }}').text('Blocked');
            }else{
              console.log('Unblock');
              $('#lable_block{{ $user->id }}').text('Unblocked');
            }
        });
    $('#checkbox_promote{{ $user->id }}').on('change',function(){
              if (this.checked) {
                console.log('Admin');
                $('#lable_promote{{ $user->id }}').text('Promote to Admin');
            }else{
              console.log('User');
              $('#lable_promote{{ $user->id }}').text('Demote to User');
            }
        });
  });


  @endforeach
  });
</script>
@stop