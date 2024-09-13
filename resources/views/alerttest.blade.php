@extends('master')
@section('header')
@stop

@section('content')

  @foreach($alertArray as $key=>$data)
      <a class="dropdown-item" href="#">
        <div class="notification__icon-wrapper">
          <div class="notification__icon">
                <i class="material-icons" style="color: #F95F5F;">error</i>
            </div>
        </div>
        <div class="notification__content">
            <span class="notification__category">
            <span class="text-danger text-semibold">
               Warning! Reaching Out Of Stock Limits.
            </span>
            </span>
              <p>
              <span class="text-danger">{{$data['item']}}</span> About to end.
              <span class="text-danger font-weight-bold">
               {{$data['qty']}}
              </span>Item Remain
            .Please refill Stock</p>
        </div>
      </a>
  @endforeach
  @foreach($expArray as $key=>$data)
  <a class="dropdown-item" href="#">
    <div class="notification__icon-wrapper">
      <div class="notification__icon">
            <i class="material-icons" style="color: #F95F5F;">error</i>
        </div>
    </div>
    <div class="notification__content">
        <span class="notification__category">
        <span class="text-danger text-semibold">
           Warning! Item about to Expire.
        </span>
        </span>
          <p>
          @if($data['day'] != 0)
          {{$data['qty']}} 
          {{$data['type']}} of
          <span class="text-danger">
          {{$data['item']}}
          </span>will be Expire with in 
          <span class="text-danger font-weight-bold">
          {{$data['day']}}
          </span>
           Days
          @else
          {{$data['qty']}} 
          {{$data['type']}} of
          <span class="text-danger">
          {{$data['item']}}
          </span>
          will be Expire on  
          <span class="text-danger font-weight-bold">
          Tomorrow
          </span>
          @endif
        .Please Discard it form the Stock(Batch No: {{$data['batch_no']}})</p>
    </div> 
  </a>
  @endforeach
@stop

@section('script')
@stop