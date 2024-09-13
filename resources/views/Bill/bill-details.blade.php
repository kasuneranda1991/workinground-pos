
<div id="CurrentBillItemRemoveModel" class="modal modal-fixed-footer" style="z-index: 20000;">
  <div class="modal-content">
  <h4>Total Bill Amount is Rs.<lable id="current_bill_total"></lable></h4>
    <table id="shoppingCart" style="width: 100%">
      <thead>
          <th>Batch No</th>
          <th>Product Name</th>
          <th>Qty</th>
          <th>Discount</th>
          <th>Serial No</th>
          <th>Total(LKR)</th>
          <th></th>
      </thead>
      <tbody></tbody>
    </table>      
  </div>
  <div class="modal-footer">
    <!-- <button id="refresh" >refresh</button> -->
    <a href="#!" class="modal-close waves-effect waves-green btn-small">close</a>
    <a href="#finishBill" class="modal-close modal-trigger waves-effect waves-green btn-small">Settle</a>
   </div>
</div>
<form id="shoppingCartItemRemoveForm" action="/removeBillItem" method="post">
  {{ csrf_field() }}
  <input type="hidden" id="remove_item_id" name="bill_id" value="">
</form>