@extends('master')
@section('web-page-title'){{ Auth::user()->shop->shop_name }} Sales Records @stop
@section('pageurl') Home > Stock @stop
@section('pagetitle') Sales Record @stop
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css"> 
@stop
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="add-tab" data-toggle="tab" href="#add" role="tab" aria-controls="add" aria-selected="false">Add+</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><br>
      <table style="width: 100%" class="ui celled selectable right aligned table" id="stockHistory">
            <thead>
                <tr>
                    <th scope="col" class="border-0">Stock ID</th>
                    <th scope="col" class="border-0">Location Code</th>
                    <th scope="col" class="border-0">Product</th>
                    <th scope="col" class="border-0">Size</th>
                    <th scope="col" class="border-0">Qty</th>
                    <th scope="col" class="border-0">remark</th>
                    <th scope="col" class="border-0">created</th>
                </tr>
            </thead>
        </table>
  </div>
  <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add-tab"><br>
      <table style="width: 100%" class="ui celled selectable right aligned table" id="stockHistoryAdd">
            <thead>
                <tr>
                    <th scope="col" class="border-0">Stock ID</th>
                    <th scope="col" class="border-0">Location Code</th>
                    <th scope="col" class="border-0">Product</th>
                    <th scope="col" class="border-0">Size</th>
                    <th scope="col" class="border-0">Qty</th>
                    <th scope="col" class="border-0">remark</th>
                    <th scope="col" class="border-0">created</th>
                </tr>
            </thead>
        </table>
  </div>
</div>
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

    var table = $('#stockHistory').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        // scrollY:        200,
        responsive: true,
        ajax: '{!! route('stocks.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'location_code', name: 'location_code' },
            { data: 'product_name', name: 'product_name' },
            { data: 'size', name: 'size' },
            { data: 'qty', name: 'qty' },
            { data: 'remark', name: 'remark' },
            { data: 'created_at', name: 'created_at' },
        ],
    });

    var table2 = $('#stockHistoryAdd').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('addNewstocks.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'location_code', name: 'location_code' },
            { data: 'product_name', name: 'product_name' },
            { data: 'size', name: 'size' },
            { data: 'qty', name: 'qty' },
            { data: 'remark', name: 'remark' },
            { data: 'created_at', name: 'created_at' },
        ],
    });

});
</script>
<!-- ______________End Table___________________ -->
@stop
