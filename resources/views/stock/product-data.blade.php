
<table class="ui celled selectable center aligned table" style="width:100%" id="product">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity Remain</th>
            <th scope="col">Selling Price(LKR)</th>
            <th scope="col">Avg Sale(Mo)</th>
            <th scope="col">Last Update</th>
            <th scope="col" data-orderable="false"></th>
        </tr>
    </thead>
<tbody>
</tbody>
</table>
<!-- Delete Model -->
@include('stock.delete-product-model')
<!-- Delete Model -->

<!-- edit model -->
@include('stock.edit-product-model')
<!-- edit model -->

<!-- update Model -->
@include('stock.update-product-model')
<!-- update Model -->

<!-- discard Model -->
@include('stock.discard-item-model')
<!-- discard Model -->

<!-- add item  Model -->
@include('stock.add-item-model')
<!-- add item Model -->
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
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script src="js/notification.min.js"></script>
@stop