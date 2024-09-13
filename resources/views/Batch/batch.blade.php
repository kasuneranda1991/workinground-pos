@extends('master')
@section('web-page-title') Batch Details of Shop Products @stop
@section('pageurl') Home > Stock @stop
@section('pagetitle') Your Batch @stop
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">  
@stop
@section('content')
<table class="ui celled selectable left aligned table" id="batchTable" style="width: 100%">
  <thead>
    <th>Batch No</th>
    <th>Product Id</th>
    <th>Receive Qty</th>
    <th>Available Qty</th>
    <th>Sold Qty</th>
    <th>Discard Qty</th>
    <th>Expire Date</th>
  </thead>
  <tbody></tbody>
</table>
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

<!-- ______________Create Table___________________ -->
<script type="text/javascript">
$(document).ready(function(){

    var table = $('#batchTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('batch.data') !!}',
        columns: [
            { data: 'batch_no', name: 'batch_no' },
            { data: 'product_name', name: 'product_name' },
            { data: 'receive_qty', name: 'receive_qty' },
            {  data : 'available_Qty',
                render : function(available, type, row) {
                    return '<span class="badge badge-info">'+available+'</span>'
                }    
             },
            { data: 'sold_qty', name: 'sold_qty' },
            { data: 'discard_qty', name: 'discard_qty' },
            { data: 'expire_date', name: 'expire_date' },
        ],
    });

});
</script>
<!-- ______________End Table___________________ -->
@stop
