<div id="return_item" class="modal modal-fixed-footer">
  <div class="modal-content">

  <table class="highlight" id="settledBillTable">
    <thead>
      <th>Bill NO</th>
      <th>Product</th>
      <th>Size</th>
      <th>Qty</th>
      <th>Discount</th>
      <th>Total Price</th>
      <th>Bill Date</th>
      <th>action</th>
    </thead>
  <tbody>
  </tbody>
  </table>
  
  <form id="returnItemForm" action="/itemreturn" method="post">
  {{ csrf_field() }}
  <div id="returnitemdetailsform" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h5 id="return_item_name">return item Name</h5>
          <input id="return_discount" name="discount" value="" type="hidden">
        <div class="input-field col s6">
          <input placeholder="Quantity" id="return_quantity" type="text" name="qty" value="return_quantity" class="validate">
          <input placeholder="reason" type="text" name="reason" class="validate" required="required">
          <label for="quantity" class="active"></label>
        </div>
      </div>
      <div class="modal-footer">
      <input type="hidden" id="return_raw_id" value="return_raw_id" name="return_item" />
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
        <input type="button" id="returnBtn" class="modal-close waves-effect waves-green btn-flat" value="Return">
      </div>
    </div>
  </form> 