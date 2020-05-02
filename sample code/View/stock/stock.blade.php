@extends('master')
@section('web-page-title') Shop Products Details @stop
@section('pageurl') Home > Stock @stop
@section('pagetitle') Your Online stock @stop
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
<link rel="stylesheet" href="css/notification.css">
@stop
@section('content')
<input type="hidden" id="stockURL" value="{{ URL('/stock') }}">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="Stock-tab" data-toggle="tab" href="#Stock" role="tab" aria-controls="Stock" aria-selected="true">Stock Balance</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="discardedItem-tab" data-toggle="tab" href="#discardedItem" role="tab" aria-controls="discardedItem" aria-selected="false">Discarded Stock Item</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
<div class="tab-pane fade show active" id="Stock" role="tabpanel" aria-labelledby="Stock-tab">
<!-- stock tab -->

    @include('stock.product-data')
<!-- stock tab -->
</div>
  <div class="tab-pane fade" id="discardedItem" role="tabpanel" aria-labelledby="discardedItem-tab">
      @include('stock.discard-item-details')
  </div>
  <!-- History tab -->
  <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
<!-- history table -->
    @if (count($items) > 0)
	        @include('stock.item-data')
    @endif
<!-- history table -->
  </div>
  <!-- History tab -->
</div>
@stop
@section('script')
<script type="text/javascript">
$(document).ready(function(){
    $('#datepicker').datepicker({
       maxViewMode: 1
    });
});
</script>
@stop