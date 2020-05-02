@extends('master')
@section('web-page-title'){{ Auth::user()->shop->shop_name }} Customers Details @stop
@section('pageurl') Home > Stock @stop
@section('pagetitle') Your Online stock @stop
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
@stop
@section('content')
<span class="m-0 float-right"><input class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal" data-target="#bulkMessage" type="button" value="Send Message" data-toggle="tooltip" data-placement="top" title="maximum charactor count is 160"></span>
<br>
<br>
<br>
<table class="ui table" id="CustomerData">
    <thead>
        <tr>
            <th scope="col" class="border-0">Customer No</th>
            <th scope="col" class="border-0" data-orderable="false" data-toggle="tooltip" data-placement="top" title="This show you customer join date to your customer contact form">created at</th>
            <th scope="col" class="border-0" data-orderable="false" data-toggle="tooltip" data-placement="top" title="This is show this customer last transaction date">Last show Up</th>
            <th scope="col" class="border-0" data-orderable="false"></th>
        </tr>
    </thead>
</table>

<!-- start modal -->
<div class="modal fade" id="bulkMessage" tabindex="-1" role="dialog" aria-labelledby="bulkMessage" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulkMessage">Send message to your all customers</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/sendBulkMessage" method="post">
      {{csrf_field()}}
      <div class="modal-body">
        <div class="form-group">
        @if( Auth::user()->role === 'super_admin')
          <textarea class="form-control" name="bulkMessage" placeholder="What's on your mind for your customers..."></textarea>
        @else
          <textarea class="form-control" name="bulkMessage" placeholder="What's on your mind for your customers..." maxlength="160"></textarea>
        @endif
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-success">Publish</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal -->

@stop
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#CustomerData').DataTable({
    processing: true,
    serverSide: true,
    deferRender: true,
    responsive: true,
    ajax: '{!! route('customer.data') !!}',
    columns:[
       { data: 'contact_no', name: 'contact_no' },
       { data: 'created_at', name: 'created at' },
       { data: 'updated_at', name: 'updated_at' },
       { data: 'action', name: 'action' },
    ],
  });
});
</script>
@stop
