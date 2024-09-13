@extends('master')
@section('web-page-title') {{ Auth::user()->username }} Profile Details @stop
@section('pageurl') Home > Profile @stop
@section('pagetitle') Profile @stop
@section('content')
<div class="row">
  <div class="col-lg-4">
    <div class="card card-small mb-4 pt-3">
    <p class="text-center" id="demo"></p>
      <div class="card-header border-bottom text-center">
        <div class="mb-3 mx-auto">
          <img class="rounded-circle" src="user/{{ Auth::user()->profile_pic }}" alt="User Avatar" width="110"> </div>
        <h4 class="mb-0">{{ Auth::user()->username }}</h4>
        <span class="text-muted d-block mb-2">Working as a {{ Auth::user()->role }}</span>
        
          <form action="/upload_pic" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
          @if(Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
            <label data-toggle="tooltip" data-placement="left" title="Maximum Upload file size is 1MB " for="shop_logo" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2">Shop Logo</label>
            <input type="file" onChange="$(this).closest('form').submit()" name="shop_logo" id="shop_logo" accept="image/*" style="display: none">
          @endif
            
            
            <label data-toggle="tooltip" data-placement="right" title="Maximum Upload file size is 1MB " for="profile_pic" class="mb-2 btn btn-sm btn-pill btn-outline-primary mr-2">Change Profile Picture</label>
            <input type="file" id="profile_pic" name="profile_pic" onChange="$(this).closest('form').submit()" accept="image/*" style="display: none">
            </form>


      </div>
      @if(Auth::user()->role != 'super_admin')
        <!-- Modal -->
      <div class="modal fade" id="choose_plan" tabindex="-1" role="dialog" aria-labelledby="choose_plan" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="choose_plan">Choose your Plan</h5>
            </div>
            <div class="modal-body">

              <!-- plan start -->
                <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card card-small card-post card-post--aside card-post--1">
                  <div class="card-post__image" style="background-image: url('payment_plan/starter.jpeg');">
                    <a href="#" class="card-post__category badge badge-pill badge-success">Starter Pack</a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('logo/logo.png');">Workinground.com</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">
                      <a class="text-fiord-blue" href="#">Recommended for Small Business</a>
                    </h5>
                    <p class="card-text d-inline-block mb-3">
                      <span class="badge badge-pill badge-secondary">Unlimited Product</span>
                      <span class="badge badge-pill badge-secondary">1 User</span>
                      <span class="badge badge-pill badge-secondary">Unlimit Customer Data Base</span>
                      <span class="badge badge-pill badge-secondary">Inventory Control</span>
                      <span class="badge badge-pill badge-secondary">Advance User Permission</span>
                    </p>
                    <span class="text-muted d-inline-block">
                      <input type="button" class="priviladge btn btn-outline-success" data-toggle="modal" data-target="#staterPack" value="Choose & Pay" >
                    </span>
                    <p class="float-right" ></p>
                    <span class="badge badge-pill badge-secondary float-right">$14/Month</span>
                  </div>
                </div>
              </div>
              <!-- plan end -->

              <!-- plan start -->
                <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card card-small card-post card-post--aside card-post--1">
                  <div class="card-post__image" style="background-image: url('payment_plan/advance.jpg');">
                    <a href="#" class="card-post__category badge badge-pill badge-info">Advance User Pack </a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('logo/logo.png');">Workinground.com</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">
                      <a class="text-fiord-blue" href="#">Recommended for Middle Type Business</a>
                    </h5>
                    <p class="card-text d-inline-block mb-3">Conviction up partiality as delightful is discovered. Yet jennings resolved disposed exertion you off. Left did fond drew fat head poor jet pan flying over...</p>
                    <span class="text-muted">
                      <input type="button" class="priviladge btn btn-outline-success" data-toggle="modal" data-target="#advancePack" value="Choose & Pay" >
                    </span>
                  </div>
                </div>
              </div>
              <!-- plan end -->

              <!-- plan start -->
                <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card card-small card-post card-post--aside card-post--1">
                  <div class="card-post__image" style="background-image: url('payment_plan/economy.jpg');">
                    <a href="#" class="card-post__category badge badge-pill badge-danger">Economy Users Pack </a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('logo/logo.png');">Workinground.com</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">
                      <a class="text-fiord-blue" href="#">Recommended for Multilevel User Control Business</a>
                    </h5>
                    <p class="card-text d-inline-block mb-3">Conviction up partiality as delightful is discovered. Yet jennings resolved disposed exertion you off. Left did fond drew fat head poor jet pan flying over...</p>
                    <span class="text-muted">
                      <input type="button" class="priviladge btn btn-outline-success" data-toggle="modal" data-target="#economyPack" value="Choose & Pay" >
                    </span>
                  </div>
                </div>
              </div>
              <!-- plan end -->

            </div>
            <div class="modal-footer">
              
            </div>
          </div>
        </div>
      </div>
    <!-- end model -->
    <!-- start sub model -->
    @if(Auth::user()->shop->expire_date > Carbon\Carbon::now())
      @include('Payment.starter_model')
      @include('Payment.advance_model')
      @include('Payment.economy_model')
    @endif
    <!-- end sub model -->
      @endif
      <ul class="list-group list-group-flush">
        @if(Auth::user()->role !='super_admin' )
        <!-- <li class="list-group-item px-4"> -->
          <!-- <strong class="text-muted d-block mb-2">Payment Plan: -->
          
          @switch(Auth::user()->shop->payment_plan)
            @case('demo')
              <!-- <span class="badge badge-primary">Demo</span> -->
            @break
            @case('starter')
              <!-- <span class="badge badge-success">Stater Pack</span> -->
            @break
            @case('advance')
              <!-- <span class="badge badge-info">Advance User Pack</span> -->
            @break
            @case('economy')
              <!-- <span class="badge badge-danger">Economy User Pack</span> -->
            @break
          @endswitch
          <!-- </strong> -->
        @if(Auth::user()->role !='user')
          <!-- Button trigger modal -->
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#choose_plan">
              Change My Plan
            </button> -->
        @endif
        <!-- </li> -->
        @endif
        <li class="list-group-item p-4">
        <div class="row">
          <div class="col col-md-6 col-lg-12"><strong class="text-muted d-block mb-2">Sender ID: <small>{{ Auth::user()->shop->sender_id }}</small> </strong></div>
          @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')
          <div class="col col-md-6 col-lg-12"><input type="button" class="btn btn-outline-info btn-sm" value="Request Sender ID" data-toggle="modal" data-target="#senderIdModel"></div>
          @endif
        </div>
        </li>
        @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')
        <!-- sender id model start -->
        <div class="modal fade" id="senderIdModel" tabindex="-1" role="dialog" aria-labelledby="senderIdModel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="senderIdModel">Request New Sender ID(Customer SMS)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="/upload-payment" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
                <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">New Sender ID</span>
                    </div>
                    <input type="text" class="form-control" name="request_sender_id" maxlength="11" required placeholder="EX:shop name" aria-label="EX:shop name" aria-describedby="basic-addon1" data-bv-field="request_sender_id"> 
                </div>
                </div>

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

                <input type="hidden" name="name" value="{{ Auth::user()->username }}" >
                <input type="hidden" name="contact" value="{{ Auth::user()->contact_no }}" >
                <input type="hidden" name="paid_amount" value="2500" >
                <input type="hidden" name="payment_duration" value="sender_id" >
                <input type="hidden" name="payment_plan" value="{{ Auth::user()->shop->payment_plan }}" >
                <input type="hidden" name="monthly_rate" value="{{ Auth::user()->shop->monthly_rate }}" >
                <input type="hidden" name="shop_id" value="{{ Auth::user()->shop->id }}" >
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Send My New Sender ID</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- sender id model end -->
        @endif
        <li class="list-group-item p-4">
          <strong class="text-muted d-block mb-2">Description</strong>
          <span>Joined at {{ Auth::user()->created_at }} ({{ Auth::user()->created_at->diffForHumans() }}) to {{Auth::user()->shop->shop_name}} </span>
        </li>
        @if(Auth::user()->shop->payment_plan != 'life_time')
        <li class="list-group-item p-4"><strong>Connection End with in</strong>
          <div id="getting-started" class="alert alert-success"></div>
        </li>
        @endif
        @if(Auth::user()->shop->payment_plan != 'life_time')
        <!-- <li class="list-group-item p-4">
          <div class="custom-control custom-toggle custom-toggle-sm mb-1">
            <input type="checkbox" id="customToggle1" name="customToggle1" class="custom-control-input">
            <label class="custom-control-label" for="customToggle1">SMS Notification is Currently OFF</label>
          </div>
        </li> -->
        @endif
        @if(Auth::user()->shop->payment_plan != 'life_time')
       <!--  <li class="list-group-item p-4">
          <div class="custom-control custom-toggle custom-toggle-sm mb-1">
            <input type="checkbox" id="customToggle2" name="customToggle2" class="custom-control-input">
            <label class="custom-control-label" for="customToggle2">2FA(Two factor verification code)</label>
          </div>
        </li> -->
        @endif
      </ul>
    </div>
  </div>

    <div class="col-lg-8">
      <div id="priviladge" class="card card-small mb-4">
        <div class="card-header border-bottom">
          <h6 class="m-0">Account Details</h6>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item p-3">
            <div class="row">
              <div class="col">
                <form id="shop_form" action="/userupdate" method="post">
                {{ csrf_field() }}
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="shop_name">Shop Name</label>
                      <input type="text" class="priviladge form-control" id="shop_name" name="shop_name" placeholder="Shop Name" value="{{ Auth::user()->shop->shop_name }}"> </div>
                      <div class="form-group col-md-4">
                      <label for="owner_name">Owner Name</label>
                      <input type="text" class="priviladge form-control" id="owner_name" name="owner_name" placeholder="Owner Name" value="{{ Auth::user()->shop->owner }}"> </div>
                      <div class="form-group col-md-4">
                      <label for="owner_nic">NIC</label>
                      <input type="text" class="priviladge form-control" id="owner_nic" name="owner_nic" placeholder="Owner NIC" value="{{ Auth::user()->shop->owner_nic }}"> </div>
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="priviladge form-control" name="address" placeholder="1234 Main St" value="{{ Auth::user()->shop->address }}"> </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="city">City</label>
                      <input type="text" class="priviladge form-control" id="city" value="{{ Auth::user()->shop->city }}"  name="city" placeholder="Ex: Anuradhapura,Colombo 2"> </div>
                    <div class="form-group col-md-4">
                      <label for="postal_code">Postal Code</label>
                      <input type="text" placeholder="50000" class="priviladge form-control" value="{{ Auth::user()->shop->postal_code }}" id="postal_code" name="postal_code"> </div>
                      <div class="form-group col-md-4">
                      <label for="country">Country</label>
                      <input type="text" placeholder="Sri Lanka" class="priviladge form-control" value="{{ Auth::user()->shop->country }}" id="country" name="country"> </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-4">
                      <label for="contact_no">Contact No</label>
                      <input type="text" placeholder="070-0000000" class="priviladge form-control" value="{{ Auth::user()->shop->contact_no }}" id="contact_no" name="contact_no"> </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="br">Business Registration</label>
                      <input type="text" class="priviladge form-control" id="br" value="{{ Auth::user()->shop->BR }}" name="br" placeholder="Your Business Reg No"> </div>
                    <div class="form-group col-md-6">
                      <label for="vat">Vat No</label>
                      <input type="text" placeholder="Ex:114439568" value="{{ Auth::user()->shop->VAT }}" class="priviladge form-control" id="vat" name="vat"> </div>
                  </div>
                  <button type="submit" class="priviladge btn btn-outline-success">Update</button>
                  </form>
                  <form action="/usersettings" method="post">
                  {{ csrf_field() }}
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username" value="{{ Auth::user()->username }}"> </div>
                    <hr></hr>
                    <div class="form-group col-md-12">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="old_password" placeholder="Password"> </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-12">
                      <label for="confirm password">New Password</label>
                      <input type="password" class="form-control" name="confirm_password" placeholder="New Password"> </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-lg-4 col-md-4 col-sm-12">
                      <label for="confirm password">Printer</label>
                      <input type="text" value="{{ Auth::user()->user_printer }}" class="form-control" name="ip" placeholder="Printer Name or IP"> </div>
                      <!-- <div class="form-group col-lg-4 col-md-4 col-sm-12">
                      <label for="confirm password">Printer Port No</label>
                      <input type="text" value="{{ Auth::user()->port }}" class="form-control" name="port" placeholder="Printer Port No if available"> </div> -->
                      <div class="form-group col-lg-4 col-md-4 col-sm-12">
                      <label for="confirm password">Billing Type</label>
                        <select name="printer_type" class="form-control">
                        @if(Auth::user()->print_type == 'pos')
                           <!-- <option value="invoice">Invoice</option> -->
                           <option selected value="pos">POS</option>
                        @else
                          <!-- <option selected value="invoice">Invoice</option> -->
                          <option value="pos">POS</option>
                        @endif
                        </select> 
                      </div>
                  </div>
                  <button type="submit" class="btn btn btn-outline-primary">Update</button>
                </form>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
<!-- ................. -->
@stop
@section('script')
<script src="{{ asset('timer/easytimer.min.js') }}"></script>
<script src="{{ asset('timer/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/form-rule.js') }}"></script>
<script type="text/javascript">

    var time = '{{Auth::user()->shop->expire_date}}';
    console.log(time);
    $("#getting-started").countdown(time, function(event) {
      $(this).text(event.strftime('%w weeks %d days %H:%M:%S'));
    });
  
</script>
<script>
  $(document).ready(function(){
    // start form validation
    $('#shop_form').bootstrapValidator({

        feedbackIcons: {
            // valid: 'fa fa-check-square-o',
            invalid: 'fa fa-times',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            // start field rule 
            shop_name: {
                validators: {
                    notEmpty: {
                        message: 'Shop Name is Required'
                    }
                }
            },
            // end field rule

            // start field rule 
            username: {
                validators: {
                    notEmpty: {
                        message: 'User Name is Required'
                    }
                }
            },
            // end field rule

        }
    });
    // end form validation
    @if( Auth::user()->role == 'admin' && Auth::user()->shop->state == 'Verified')
    $('.priviladge').attr('disabled','disabled');
    
    @elseif(Auth::user()->role == 'user' )
     $('.priviladge').attr('disabled','disabled');
    @endif
    // setInterval(function(){$("#countDown").html('')}, 2000);// the "3000" 
  });
</script>
@stop