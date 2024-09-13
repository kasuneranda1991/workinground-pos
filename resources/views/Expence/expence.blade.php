@extends('master')
@section('web-page-title'){{ Auth::user()->shop->shop_name }} Expence Details @stop
@section('pageurl') Home > Expence @stop
@section('pagetitle') Your Daily Expence @stop
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="expence" data-toggle="tab" href="#Expence" role="tab" aria-controls="Expence" aria-selected="true">Expence</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="record-tab" data-toggle="tab" href="#record" role="tab" aria-controls="record" aria-selected="false">Record</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
 <div class="tab-pane fade show active" id="Expence" role="tabpanel" aria-labelledby="expence">
 <div class="row">
    <div class="col-lg-8 mb-4">
    <div class="card card-small mb-4">
    <div class="card-header border-bottom"><h6 class="m-0">Record Your Daily Expence Here</h6></div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-0 px-3 pt-3">
            <div class="row">
            <div class="col-sm-12 mb-3">
            <!-- start form -->
            <form action="/expence_record" method="post">
            {{ csrf_field() }}
            <!-- start input -->
                <div class="form-group">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                   <span class="input-group-text">Expence Type</span>
                </div>
                    <select required name="category" class="form-control">
                        <option value="0" selected>Choose Category Available</option>
                        <option value="Advertising">Advertising</option>
                        <option value="Bank">Bank(Anual Fee/Panalty fee/OD Charges..)</option>
                        <option value="Bonus">Employee Bonus</option>
                        <option value="Commission">Commission Payment</option>
                        <option value="Cleaning">Cleaning service</option>
                        <option value="Clothing">Cloth</option>
                        <option value="Damage">Damage(Equipment..)</option>
                        <option value="Bavarage">Drinking Water or Tea,Coffe...</option>
                        <option value="Electricity">Electricity Bill</option>
                        <option value="Food">Food</option>
                        <option value="Fuel">Fuel</option>
                        <option value="Loan">Loans</option>
                        <option value="Salary">Labour Salary</option>
                        <option value="Rental">Monthly Rental(Equipment or Building)</option>
                        <option value="Other">Other</option>
                        <option value="ETF/EPF">Pension contributions(ETF/EPF)</option>
                        <option value="Personal">Personal</option>
                        <option value="Phone">Phone Bill</option>
                        <option value="Postage">Postages</option>
                        <option value="Maintanance">Repairs a building or equipment</option>           
                        <option value="Medical">Medical Claim</option>           
                        <option value="Security">Security(CCTV/Security Firm/Security Salary)</option>           
                        <option value="Stationary">Stationary Item</option>           
                        <option value="Transport">Transport</option>
                        <option value="Tax">Tax(VAT/NBT/City)</option>
                        <option value="Vehicle Service/Repair">Vehicle Service and Repair</option>
                        <option value="Water">Water Bill</option>
                        <option value="Cosmetics">Cosmetics</option>
                    </select>
                </div>
                </div>
            <!-- end input -->
             
            <!-- start input -->
                <div class="form-group">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Amount</span>
                </div>
                    <input required type="text" class="form-control valied_number" name="amount" placeholder="Expence Amount" aria-label="Item Name" aria-describedby="basic-addon1" data-bv-field="item_type"> 
                 </div>
                <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="item_type" data-bv-result="NOT_VALIDATED" style="display: none;">The Item Type is required</small>
                </div>
            <!-- end input -->
            <!-- start input -->
                <div class="form-group">
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Remarks</span>
                </div>
                    <input required type="text" class="form-control" name="remark" placeholder="Remark like invoice no../Name of person" aria-label="Item Name" aria-describedby="basic-addon1" data-bv-field="item_type"> 
                </div>
                <small class="invalid-feedback" data-bv-validator="notEmpty" data-bv-for="item_type" data-bv-result="NOT_VALIDATED" style="display: none;">The Item Type is required</small>
                </div>
            <!-- end input -->
            <div class="col">
                <button type="submit" class=" btn btn-outline-primary ">Save</button>
            </div>
            </form>
            <!-- end form -->
            </div>
            </div>
            </li>
        </ul>
    </div>
</div>
<div id="style-7" class="col-lg-4 mb-4"  style="max-height: 400px;overflow-y: scroll;">
    <div class="card card-small mb-4">
    <div class="card-header border-bottom">
        <h6 class="m-0">Expence This Month Rs.</h6>
    </div>
    <ul class="list-group list-group-flush">
    @if($month_expence_array)
    @foreach($month_expence_array as $key => $expence)
    <!-- start expence catogary -->
        <li class="list-group-item d-flex px-3">
            <span class="text-semibold text-fiord-blue">{{ $key }}</span>
            <span class="ml-auto text-right text-semibold text-reagent-gray">{{ $expence}}</span>
        </li>
    <!-- end expence catogary -->
    @endforeach
    @endif
    </ul>
    </div>
</div>
</div>
</div>
<div class="tab-pane fade" id="record" role="tabpanel" aria-labelledby="record-tab">
    <br>
        <table style="width: 100%;padding: 10px;" class="ui celled selectable center aligned table" id="expenceTable">
        <thead>
            <tr>
                <th scope="col" class="border-bottom-0">#</th>
                <th scope="col" class="border-bottom-0">Category</th>
                <th scope="col" class="border-bottom-0">Payment Done By</th>
                <th scope="col" class="border-bottom-0">Amount</th>
                <th scope="col" class="border-bottom-0">Remark</th>
                <th scope="col" class="border-bottom-0">Created_at</th>
                <th scope="col" class="border-bottom-0">action</th>
            </tr>
        </thead>
        <tbody>             
        </tbody>
        </table>
    <form id="deleteExpenceForm" method="post" action="/delete_expence_record">
    <input type="hidden" id="record_id" value="" name="record_id">
    {{csrf_field()}}
    </form> 
    <input type="hidden" id="user_role" value="{{Auth::user()->role}}">
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
<script type="text/javascript">
    $(document).ready(function(){
        var role = $('#user_role').val();
        if( role == 'user'){
            var table = $('#expenceTable').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            responsive: true,
            scroller: true,
            ajax: '{!! route('expence.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'category', name: 'category' },
                { data: 'user_id', name: 'user_id' },
                { data: 'amount', name: 'amount' },
                { data: 'remark', name: 'remark' },
                { data: 'created_at', name: 'created_at' },
                { data: 'intro', name: 'intro' },
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
                ],
            "columnDefs": [
                {
                    "targets": [ 6 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "searchable": false
                }
            ],
        });
        }else{
            var table = $('#expenceTable').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            responsive: true,
            ajax: '{!! route('expence.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'category', name: 'category' },
                { data: 'user_id', name: 'user_id' },
                { data: 'amount', name: 'amount' },
                { data: 'remark', name: 'remark' },
                { data: 'created_at', name: 'created_at' },
                { data: 'intro', name: 'intro' },
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
                ],
        });
        }

        $('#expenceTable tbody').on('click', 'button', function (){
            var data = table.row( $(this).parents('tr') ).data();
            console.log(data.id);
            $('#record_id').val(data.id);
            $('#deleteExpenceForm').submit();
           
        });
    });
</script>
@stop