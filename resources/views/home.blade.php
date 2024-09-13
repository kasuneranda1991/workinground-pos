@extends('master')
@section('web-page-title') Dashboard|WORKINGROUND.COM @stop
@section('pageurl') Home @stop
@section('pagetitle') Dashboard @stop
@section('header')
<style>
    .my-card
        {
            position:absolute;
            left:40%;
            top:-20px;
            border-radius:50%;
        }
</style>
@stop

@section('content')

<div class="row">
    @if(Auth::user()->role == 'super_admin' || Auth::user()->shop->type == 'Mobile_repair')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/getjob'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-dark p-3 my-card" ><span class="far fa-handshake" aria-hidden="true"></span></div>
            <div class="text-dark text-center mt-3"><small>Click</small></div>
            <div class="text-dark text-center mt-2"><em>Get Job</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/receiveJob'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-success p-3 my-card" ><span class="fa fa-wrench" aria-hidden="true"></span></div>
            <div class="text-success text-center mt-3"><small>Click</small></div>
            <div class="text-success text-center mt-2"><em>Receive Job</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/billing-dashboard'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-light p-3 my-card" ><span class="fa fa-calculator" aria-hidden="true"></span></div>
            <div class="text-light text-center mt-3"><small>Click</small></div>
            <div class="text-light text-center mt-2"><em>Billing</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/stock'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-danger p-3 my-card" ><span class="far fa-chart-bar" aria-hidden="true"></span></div>
            <div class="text-danger text-center mt-3"><small>Click</small></div>
            <div class="text-danger text-center mt-2"><em>Stock</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/batch'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-warning p-3 my-card" ><span class="fa fa-tags" aria-hidden="true"></span></div>
            <div class="text-warning text-center mt-3"><small>Click</small></div>
            <div class="text-warning text-center mt-2"><em>Batches</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>    
    
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/Sales-History'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-secondary p-3 my-card" ><span class="fa fa-history" aria-hidden="true"></span></div>
            <div class="text-secondary text-center mt-3"><small>Click</small></div>
            <div class="text-secondary text-center mt-2"><em>Sales History</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/customer'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-primary p-3 my-card" ><span class="fa fa-address-book" aria-hidden="true"></span></div>
            <div class="text-primary text-center mt-3"><small>Click</small></div>
            <div class="text-primary text-center mt-2"><em>Customers Details</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/my-reports'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="far fa-file-alt" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Reports</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    @if(Auth::user()->role === 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/manage-user-dashboard'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-success p-3 my-card" ><span class="fa fa-users" aria-hidden="true"></span></div>
            <div class="text-success text-center mt-3"><small>Click</small></div>
            <div class="text-success text-center mt-2"><em>Manage Users</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif

    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/expence'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-danger p-3 my-card" ><span class="fas fa-chart-line" aria-hidden="true"></span></div>
            <div class="text-danger text-center mt-3"><small>Click</small></div>
            <div class="text-danger text-center mt-2"><em>Expence</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/payments'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-warning p-3 my-card" ><span class="far fa-money-bill-alt"></span></div>
            <div class="text-warning text-center mt-3"><small>Click</small></div>
            <div class="text-warning text-center mt-2"><em>Payments</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>

    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/get-room'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-bed" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Rooms</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    
    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/get-reservation'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-danger p-3 my-card" ><span class="far fa-calendar-alt" aria-hidden="true"></span></div>
            <div class="text-danger text-center mt-3"><small>Click</small></div>
            <div class="text-danger text-center mt-2"><em>Reservation</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    
    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/calender'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-warning p-3 my-card" ><span class="fas fa-calendar-week" aria-hidden="true"></span></div>
            <div class="text-warning text-center mt-3"><small>Click</small></div>
            <div class="text-warning text-center mt-2"><em>Calender</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    
    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/get-reservation-details'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-calendar-day" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Reservation History</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    
    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/get-room-occupancy'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-danger p-3 my-card" ><span class="far fa-calendar-check" aria-hidden="true"></span></div>
            <div class="text-danger text-center mt-3"><small>Click</small></div>
            <div class="text-danger text-center mt-2"><em>Room Occupancy</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif

    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/guest-check-in'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-sign-in-alt" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Check-In</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
    
    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/guest-check-out'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-sign-out-alt" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Check-Out</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif

    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/reservation-confirmation'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-success p-3 my-card" ><span class="fas fa-user-check" aria-hidden="true"></span></div>
            <div class="text-success text-center mt-3"><small>Click</small></div>
            <div class="text-success text-center mt-2"><em>Reservation Confirm</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif

    @if(Auth::user()->shop->type == 'Guest_house' || Auth::user()->role == 'super_admin')
    <!-- StartTab -->
    <div class="col-md-3" onclick="window.location.href='/current-guest-in-hotel'" style="cursor: pointer">
        <div class="card border-info mx-sm-1 p-1">
            <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-info" aria-hidden="true"></span></div>
            <div class="text-info text-center mt-3"><small>Click</small></div>
            <div class="text-info text-center mt-2"><em>Current Guest Info</em></div>
        </div>
    </div>
    <!-- EndTab -->
    <br><br><br><br><br>
    @endif
</div>
@stop