<!DOCTYPE html>
<html>
<title>Billing</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body class="green darken-4">
<div class="container-fluid ">
 <nav>
    <div class="nav-wrapper teal darken-4" style="z-index: 1;">
      <a href="#!" class="brand-logo">
        <div class="input-field col s12" style="color: white;width: 400px;">
            <i class="material-icons prefix">search</i>
            <input type="text" id="autocomplete-input" data-position="bottom" data-tooltip="use CTRL button" style="color: white;" class="autocomplete tooltipped">
            <label style="color: white;" for="autocomplete-input">Search</label>
        </div>
      </a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a id="refresh" class="modal-trigger tooltipped" data-position="bottom" data-tooltip="use SHIFT + C button" href="#CurrentBillItemRemoveModel">Shopping Cart</a></li>
        <li><a href="/">Home</a></li>
        <li><a class="modal-trigger tooltipped" href="#return_item" data-position="bottom" data-tooltip="use SHIFT + R button">Return Bill</a></li>
      </ul>
    </div>
  </nav>

  <ul class="sidenav" id="mobile-demo">
    <li><a  class="modal-trigger" href="#CurrentBillItemRemoveModel">shopping Cart</a></li>
    <li><a href="/">home</a></li>
    <li><a class="modal-trigger" href="#return_item">Return Bill</a></li>
  </ul>
 
<div class="row">
@include('Bill.bill-details')
</div>
@include('Bill.item-type')
@include('Bill.finishbill-model')
@include('Bill.finalize-model')
@include('Bill.return-model')
@include('Bill.remove-bill-item-model')
</div>
<!-- Compiled and minified JavaScript -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.6.2/mousetrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  function CartTotal() {
    $.ajax({
      type: "get",
      url: '/current_bill_total',
      success: function(data)
      {
         // console.log(data); // show response from the php script.
         $('#current_bill_total').text(data);
      }
      });
  }
$('.tooltipped').tooltip();
  function search() {
  var search = $('#autocomplete-input');
    search.val('');
    search.focus();
  }

  Mousetrap.bind('ctrl', search);
  Mousetrap.bind('shift+f', function(e){
    $('#finishBill').modal('open');
  });
  Mousetrap.bind('escape', function(e){
    $('#finishBill').modal('close');
    $('#CurrentBillItemRemoveModel').modal('close');
  });
  Mousetrap.bind('backspace', function(e){
    $('#autocomplete-input').blur();
  });
  Mousetrap.bind('shift+c', function(e){
    CartTotal();
    table2 = $('#shoppingCart').DataTable();
    table2.ajax.reload( null, false );
    $('#CurrentBillItemRemoveModel').modal('open');
  });
  Mousetrap.bind('shift+r', function(e){
    $('#return_item').modal('open');
  });

    var table = $('#settledBillTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('settledBill.data') !!}',
        columns: [
            { data: 'transaction_id', name: 'transaction_id' },
            { data: 'product_name', name: 'product_name' },
            { data: 'size', name: 'size' },
            { data: 'qty', name: 'qty' },
            { data: 'discount', name: 'discount' },
            { data: 'total_price', name: 'total_price' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action' },
        ],
    });

    $('#settledBillTable tbody').on('click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $('#returnitemdetailsform').modal('open');
        $('#return_item_name').text(data.product_name);
        $('#return_discount').val(data.discount);
        $('#return_quantity').val(data.qty);
        $('#return_raw_id').val(data.id);
      });

    var table2 = $('#shoppingCart').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('shoppingCart.data') !!}',
        columns: [
            { data: 'batch_no', name: 'batch_no' },
            { data: 'product_name', name: 'product_name' },
            { data: 'qty', name: 'qty' },
            { data: 'discount', name: 'discount' },
            { data: 'serial_no', name: 'serial_no' },
            { data: 'total_price', name: 'total_price' },
            { data: 'action', name: 'action' },
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
                {
                text: 'Refresh',
                className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
                action: function ( e, dt, node, config ) {
                    dt.ajax.reload();
                },init: function(api, node, config) {
           $(node).removeClass('dt-button buttons-copy buttons-html5')
        },
            }
            ],
    });

    $('#refresh').on('click',function(){
      table2.ajax.reload( null, false );
      CartTotal();
    });

    $('#shoppingCart tbody').on('click', 'button', function () {
        var data = table2.row( $(this).parents('tr') ).data();
        $('#remove_item_id').val(data.id);
        var pid = data.product_id;
        var qtyy = data.qty;
        var form = $('#shoppingCartItemRemoveForm');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                    console.log('item Removed'); // show response from the php script.
                    table2.ajax.reload( null, false );
                    if(data.success == true){
                      var audio = new Audio("{{asset('/sound/appointed.ogg')}}");
                          audio.play();
                      M.toast({html: data.data,classes: 'rounded'});
                    }else if(data.error == true){
                      var audio = new Audio("{{asset('/sound/error.ogg')}}");
                          audio.play();
                      M.toast({html: data.data,classes: 'rounded red accent-2'});
                    }
                    CartTotal();
                    var x = parseFloat($('#itemQty'+pid).text());
                    var qt = parseFloat(qtyy);
                    var y = x + qt;
                    $('#itemQty'+pid).text(y);
               }
             });
      });

    $('#billingSubmitBtn').on('click', function (e) {
    
        var form = $('#itemBillingForm');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                  console.log('Item Add to cart'); // show response from the php script.
                  console.log(data); // show response from the php script.
                  if(data.success == true){
                    var audio = new Audio("{{asset('/sound/appointed.ogg')}}");
                        audio.play();
                    M.toast({html: data.data,classes: 'rounded'});
                    console.log(data.bill_id);
                    $('#printBillId').val(data.bill_id);
                  }else if(data.error == true){
                    var audio = new Audio("{{asset('/sound/error.ogg')}}");
                        audio.play();
                    M.toast({html: data.data,classes: 'rounded red accent-2'});
                  }
                  var id = $('#product_id').val();
                  var x = $('#itemQty'+id).text();
                  var y = x - $('#Quantity').val();
                  $('#itemQty'+id).text(y);
                  $('#Quantity').val(null);
                  $('#batch-no').val(null);
                  $('#default_selling_price').val(null);
                  $('#discount').val(null);
                  $('#serial_no').val(null);
               },
             });
        e.preventDefault();
      });

    $('#returnBtn').on('click',function(e){
        var form = $('#returnItemForm');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   // console.log('item Removed'); // show response from the php script.
                   if(data.success == true){
                    var audio = new Audio("{{asset('/sound/appointed.ogg')}}");
                        audio.play();
                    M.toast({html: data.data,classes: 'rounded'});
                  }else if(data.error == true){
                    var audio = new Audio("{{asset('/sound/error.ogg')}}");
                        audio.play();
                    M.toast({html: data.data,classes: 'rounded red accent-2'});
                  }
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    })

});
</script>
<!-- ______________End Table___________________ -->
@if(Auth::user()->print_type == 'pos')
  @if(Session::has('bill_no'))
    <script src="{{ asset('printer/webprint.js') }}"></script>
    <script src="{{ asset('js/billprintscript.js') }}"></script>  
  @endif
@endif
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    @foreach($products as $product)
      $('#product-item-trigger{{ $product->id }}').click(function(e){
        $('#productModel').modal('open');
        $('#productNameOfModel').text($('#itemName{{ $product->id }}').text());
        $('#productCountTypeOfModel').text('Quantity by '+'{{ $product->stock->count_type }}');
        $('#default_selling_price').val('{{ $product->selling_price }}');
        $('#product_id').val({{ $product->id }});
      });
    @endforeach

  $('.modal').modal();
  $('.collapsible').collapsible();
  $('.fixed-action-btn').floatingActionButton({
      direction:'left',
    });
  $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.datepicker').datepicker({
      autoClose: true,
      minDate: new Date(),
    });
    $('.tabs').tabs();
    $('ul.tabs').tabs({

      swipeable : true,
      responsiveThreshold : 1920,
    });
    $('input.autocomplete').autocomplete({
      data: {
        @foreach($products as $product)
        @if($product->shop_id == Auth::user()->shop_id)
        "[{{$product->id}}] {{ $product->company->company_name }} {{ $product->product_name }}": null,
        @endif
        @endforeach
      },
    });
  });
</script>
<script>
$(document).ready(function(){
  $('#autocomplete-input').bind('keyup', function(e){
    var searchString = $(this).val();
    e.preventDefault();
    if (event.keyCode === 13) {
      var matches = searchString.match(/\[(.*?)\]/);
      var submatch = matches[1];

      $('#productModel').modal('open');
      $('#productNameOfModel').text($('#itemName'+submatch).text());
      $('#productCountTypeOfModel').text('Quantity by '+$('#countType'+submatch).val());
      $('#default_selling_price').val($('#itemprice'+submatch).text());
      $('#product_id').val(submatch);
    }
  });
});
</script>

<script type="text/javascript">
@if(Session::has('bill_no'))
 $(document).ready(function(){
    $('#finishBillrem').modal();
    $('#finishBillrem').modal('open'); 
 });
@endif
</script>
</body>
</html>