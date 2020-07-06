<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
   
  <meta name="google-site-verification" content="B6m8GdiTiX82dWVD6LxuiEFqUEmxJ_X3Q75CJex9SAU" />
  <meta name="description" content="This is a Web-Based Pos System software that facilitates the inventory and Billing for users who use this, We help you to solve your problems and guide user business to larger incomes">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('web-page-title') </title>
    <link rel="icon" href="https://res.cloudinary.com/workinground/image/upload/v1556021352/logo/logo_x6tjw6.png" type="image/x-icon" media="print">
    <meta name="description" content="online billing system for shops">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="https://res.cloudinary.com/workinground/raw/upload/v1556901846/css/master.min.css">
    <link rel="stylesheet" type="text/css" href="https://res.cloudinary.com/workinground/raw/upload/v1556901901/css/other.min.css" media="print">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" >
    <style type="text/css" >
      body {
        overflow: hidden;
      }


      /* Preloader */

      #preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #fff;
        opacity: 0.8;
        /* change if the mask should have another color then white */
        z-index: 1199;
        /* makes sure it stays on top */
      }

      #status {
        width: 300px;
        height: 200px;
        position: absolute;
        left: 50%;
        /* centers the loading animation horizontally one the screen */
        top: 50%;
        /* centers the loading animation vertically one the screen */
        background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021426/loading/ajax-loader_sctvdl.gif');
        /* path to your loading animation */
        background-repeat: no-repeat;
        background-position: center;
        margin: -100px 0 0 -100px;
        /* is width and height divided by two */
      }
    </style>
    @yield('header') 
    @yield('sub') 
    </head>
  <body class="h-100" id="style-7" >
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  @if(Auth::user()->verification_code != 0)
  <!-- ==============Print Model -->
    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="verification_modal" tabindex="-1" role="dialog" aria-labelledby="verification_modal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="">
          <div class="modal-header">
            <h5 class="modal-title" id="verification_modal">Please Enter Verification Code</h5>
          </div>
          <div class="modal-body">
            @if(Session::has('code_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <p class="text-justify">{{Session::get('code_error')}}</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            <br>
            <div class="text-center">
              <img src="https://res.cloudinary.com/workinground/image/upload/v1556021550/notification_code/notification_code_white_n9jdpk.gif" width="150" height="120" class="rounded" alt="notification gif">
            </div>
            <br>
            <p class="text-center">Enter Verification Code Below</p> 
            <form action="/verification_code_check" method="post">
            <div class="input-group mb-3">
                <div class="input-group input-group-seamless"> 
                  {{ csrf_field() }}
                    <input type="text" name="verification" class="form-control text-center" style="font-size: 25px;" name="verification" placeholder="XXXXX" > </div>            
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Get New Code</button>
            <button type="submit" class="btn btn-success">Let me in</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
  @endif
    @if(Auth::user()->shop->expire_date < \Carbon\Carbon::parse(Carbon\Carbon::now()) && Auth::user()->shop->payment_plan != 'life_time')
    <!-- ==================Connection Expire===================== -->
      <!-- Modal -->
      <div class="modal fade" id="connection_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="connection_model" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="connection_model">Sorry!,Your Connection has expired,Choose Your Plan</h5>
            </div>
            <div class="modal-body">
            @if(Session::has('code_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <p class="text-justify">{{Session::get('code_error')}}</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
              <!-- plan start -->
                <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card card-small card-post card-post--aside card-post--1">
                  <div class="card-post__image" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021629/payment_plan/starter_lljki5.jpg');">
                    <a href="#" class="card-post__category badge badge-pill badge-success">Starter Pack</a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021352/logo/logo_x6tjw6.png');">Workinground.com</a>
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
                  <div class="card-post__image" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021629/payment_plan/advance_cibuob.jpg');">
                    <a href="#" class="card-post__category badge badge-pill badge-info">Advance User Pack </a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021352/logo/logo_x6tjw6.png');">Workinground.com</a>
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
                  <div class="card-post__image" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021629/payment_plan/economy_ncgma9.jpg');">
                    <a href="#" class="card-post__category badge badge-pill badge-danger">Economy Users Pack </a>
                    <div class="card-post__author d-flex">
                      <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('https://res.cloudinary.com/workinground/image/upload/v1556021352/logo/logo_x6tjw6.png');">Workinground.com</a>
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
      @include('Payment.starter_model')
      @include('Payment.advance_model')
      @include('Payment.economy_model')
    <!-- end sub model -->
    <!-- ==================End Connection Expire===================== -->
    @endif
    <div class="container-fluid">
    <!-- <div id="counter-block">
      <span class="fb"></span>
    </div> -->
      <div class="row">
        <!-- Main Sidebar -->
        <aside style="z-index: 2;" class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="/" style="line-height: 25px;">
                <div class="d-table m-auto">
                
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="https://res.cloudinary.com/workinground/image/upload/v1556021352/logo/logo_x6tjw6.png" alt="workinground.com">
                  <span class="d-none d-md-inline ml-1">Workinground.com</span>

                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="far fa-arrow-alt-circle-left"></i>
              </a>
            </nav>
          </div>
          @inject('income', 'App\Http\Controllers\ReportController')
          @inject('expence', 'App\Http\Controllers\ReportController')
          <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            <div class="input-group input-group-seamless ml-3">
              <div class=" w-100 mr-0 d-inline-block col-sm-6 alert alert-success nav-link-icon__wrapper border border-primary">
                    <sup>Income</sup> {{ $income->income() }} LKR
                  </div>
                  <div class="w-100 mr-0 d-inline-block col-sm-6  alert alert-warning nav-link-icon__wrapper border border-primary">
                    <sup>Expence</sup> {{ $income->expence() }} LKR
                  </div>  
            </div>
          </form>
          <div class="nav-wrapper" id="style-7">
            <ul class="nav flex-column">
              @if(Auth::user()->role == 'super_admin' || Auth::user()->shop->type == 'Mobile_repair')
              <li class="nav-item">
                <a class="nav-link " href="/getjob">
                  <i class="far fa-handshake" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Get Job</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/receiveJob">
                  <i class="fas fa-tools" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Receive Job</span>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" target="_blank" href="https://www.youtube.com/channel/UCKKorc4sUHCg_v2T7DBWK-g">
                  <i class="fa fa-question" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Tutorial</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/stock">
                  <i class="far fa-chart-bar" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Stock</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/batch">
                  <i class="fa fa-tags" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Batch</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/billing-dashboard">
                  <i class="fa fa-calculator" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Billing</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/customer">
                  <i class="fa fa-address-book" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Customer</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/profile">
                  <i class="fa fa-id-badge" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>User Profile</span>
                </a>
              </li>
              @if(Auth::user()->role === 'super_admin')
              <li class="nav-item">
                <a class="nav-link " href="/manage-user-dashboard">
                  <i class="fa fa-users" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Manage Users</span>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link " href="/Sales-History">
                  <i class="fa fa-history" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Sales History</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/my-reports">
                  <i class="far fa-file-alt" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Reports</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/expence">
                  <i class="fas fa-chart-line" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Expence</span>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link " href="/payments">
                  <i class="fa fa-money" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Payment</span>
                </a>
              </li> -->
              @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
              <li class="nav-item">
                <a class="nav-link " href="/get-room">
                  <i class="fas fa-bed" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Rooms</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/get-reservation">
                  <i class="far fa-calendar-alt" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Reservation</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/calender">
                  <i class="fas fa-calendar-week" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Calender</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/get-reservation-details">
                  <i class="fas fa-calendar-day" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Reservation History</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/get-room-occupancy">
                  <i class="far fa-calendar-check" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Room Occupancy</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/guest-check-in">
                  <i class="fas fa-sign-in-alt" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Check-in</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/guest-check-out">
                  <i class="fas fa-sign-out-alt" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Check-Out</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/reservation-confirmation">
                  <i class="fas fa-user-check" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Reservation Confirmation</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="/current-guest-in-hotel">
                  <i class="fas fa-user-tag" style="font-size: 30px;" aria-hidden="true"></i>
                  <span>Current Guest Info</span>
                </a>
              </li>
              @endif
              <!-- <li class="nav-item">
                <a class="nav-link " href="errors.html">
                  <i class="material-icons">error</i>
                  <span>Errors</span>
                </a>
              </li> -->
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                <div class="input-group input-group-seamless ml-3">

                  <div id="counter-income" class="d-inline-block col-sm-6 alert alert-success nav-link-icon__wrapper border border-primary">
                    <sup>Income</sup> <span class="fb"> {{ $income->income() }}</span> LKR
                  </div>
                  <div id="counter-expence" class="d-inline-block col-sm-6  alert alert-warning nav-link-icon__wrapper border border-primary">
                    <sup>Expence</sup> <span class="ex"> {{ $income->expence() }}</span> LKR
                  </div>
                </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">
                <!-- start shop id -->
                <li class="nav-item border-right dropdown notifications">
                    <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <div class="nav-link-icon__wrapper">
                        <i class="fa fa-id-card" aria-hidden="true"></i>
                        <!-- <span class="badge badge-pill badge-danger">2</span> -->
                      </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink" style="display: none;">
                      <a class="dropdown-item" href="#">
                        <div class="notification__icon-wrapper">
                          <div class="notification__icon">
                            <i class="fa fa-hashtag" aria-hidden="true"></i>
                          </div>
                        </div>
                        <div class="notification__content">
                          <span class="notification__category">My Shop ID</span>
                          <p>Your shop id is &nbsp;<span style="font-size: 20px;" class="text-success text-semibold">#{{ Auth::user()->shop_id }}</span></p>
                        </div>
                      </a>
                      <a class="dropdown-item" href="#">
                        <div class="notification__icon-wrapper">
                          <div class="notification__icon">
                            <i class="fas fa-store"></i>
                          </div>
                        </div>
                        <div class="notification__content">
                          <span class="notification__category">Connection Expire</span>
                          <p><span style="font-size: 20px;" class="text-danger text-semibold">{{ Auth::user()->shop->expire_date }}</span></p>
                        </div>
                      </a>
                      <!-- <a class="dropdown-item notification__all text-center" href="#"> <p class="text-justify">You dont need to do any payment to use this system,because this is under testing period and please give us your valuable comment,During this testing period we will provide users to monthly based payment method including all functionality of this system,Monthly payment will be less than 2000 LKR</p></a> -->
                      <!-- <a class="dropdown-item notification__all text-center" href="#"> <p class="text-justify">ඔබට මෙම පද්ධතිය භාවිතය සඳහා කිසිදු ගෙවීමක් කිරීමට අවශ්‍ය නොවේ.මෙම පද්ධතිය පරික්ශන මට්ටමේ පවතින බැවින් ඔබගේ වටිනා අදහස් පහත ඇති චැට් මොඩුලය භාවිතයෙන් අපට ලබාදෙන්න,සියලු පද්ධති පරික්ශාවෙන් පසු ඔබහට රු.2000 ට අඩු මාසික ගෙවීම් පදනම මත පද්ධතිය භාවිතයට ඉඩ ලබාදෙනු ලැබේ</p></a> -->
                    </div>
                  </li>
                <!-- end shop id -->
                @include('alert-message')

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="{{ asset('user/') }}/{{ Auth::user()->profile_pic }}" alt="User Avatar">
                    <span class="d-none d-md-inline-block">
                    @if(isset(Auth::user()->username))
                    {{ Auth::user()->username }}
                    @endif
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="/profile">
                      <i class="fa fa-id-badge" style="font-size: 30px;" aria-hidden="true"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/signout">
                      <i class="fas fa-power-off" style="font-size: 30px;"></i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="fas fa-bars"></i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <!-- Main Container -->
          <div class="main-content-container container-fluid px-4">
          
         @include('system_messege.message-block')
          <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                  <span class="text-uppercase page-subtitle">@yield('pageurl')</span>
                  <h3 class="page-title">@yield('pagetitle')</h3>
              </div>
          </div>
            @yield('content')
          </div>
          <!-- End Main container -->

          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <!-- <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>
            </ul> -->
            <span style="padding-right: 50px;" class="copyright ml-auto my-auto mr-2">Copyright © 2018
              <a href="https://workinground.com" target="_blank" rel="nofollow">Workinground.com</a>
            </span>
          </footer>
        </main>
      </div>
    </div>
    <!-- <div class="promo-popup animated">
      <a href="#" class="pp-cta extra-action">
        <img src="{{ asset('logo/logo-full.png') }}"> 
      </a>
      <div class="pp-intro-bar"> Need Help?
        <span class="close">
          <i class="material-icons">close</i>
        </span>
        <span class="up">
          <i class="material-icons">keyboard_arrow_up</i>
        </span>
      </div>
      <div class="pp-inner-content">
        <h2>Contact Developers</h2>
        <p>Kasun Eranda <br>072-0782825</p>
        <a class="pp-cta extra-action" href="mailto:kasun1209@gmail.com?subject=workinground.com">Send Message</a>
      </div>
    </div> -->
    <input type="hidden" id="base_url" value="{{ URL::current() }}">
    
    <!-- <script async src="{{ asset('js/buttons.js') }}"></script> -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script defer src="https://res.cloudinary.com/workinground/raw/upload/v1556902010/js/master.min.js"></script>
  
    <script defer src="{{ asset('scripts/extras.1.0.0.min.js') }}"></script>
    <!-- <script  src="{{ asset('js/angular.min.js') }}"></script> -->

    @yield('printer')
    <script defer src="{{ asset('js/system.js') }}"></script>
    <script defer src="{{ asset('js/valid.js') }}"></script>
    <script async type="text/javascript">
    $(window).on('load', function() { // makes sure the whole site is loaded 
      $('#status').fadeOut(); // will first fade out the loading animation 
      $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
      $('body').delay(350).css({'overflow':'visible'});
    });
  </script>
  <script defer>
      $(document).ready(function(){
        $('#success').fadeOut(1000);
        $('[data-toggle="tooltip"]').tooltip();
      });
    
      function FullScreen() {
        var docElm = document.documentElement;
       if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
         }
         else if (docElm.mozRequestFullScree) {
           docElm.mozRequestFullScreen();
          }
        else if (docElm.webkitRequestFullScreen) {
          docElm.webkitRequestFullScreen();
           }
       }
@if(Auth::user()->verification_code != 0)
    $(window).on('load',function(){
        $('#verification_modal').modal('show');
    });
@endif

@if(Auth::user()->shop->payment_plan != 'life_time')
  @if(Auth::user()->shop->expire_date > Carbon\Carbon::now())

      @if(\Carbon\Carbon::parse(Carbon\Carbon::now())->diffInSeconds(Auth::user()->shop->expire_date) == 0 )
          $(window).on('load',function(){
              $('#connection_model').modal('show');
          });
      @endif
    @elseif(Auth::user()->shop->expire_date < Carbon\Carbon::now())
       $(window).on('load',function(){
              $('#connection_model').modal('show');
        });
  @endif
@endif
</script>
<script defer src="{{ asset('js/form-rule.js') }}"></script>
    @yield('script')
  </body>
</html>