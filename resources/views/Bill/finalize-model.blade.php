
<div id="finishBill" class="modal modal-fixed-footer">
<form id="finishBillForm" action="/purchase" method="post">
    <div class="modal-content">
      
      <div class="row">
        <div class="input-field ">
          <input placeholder="Cash Amount" id="cash_amount" name="cash_amount" type="text" class="validate valied_number">
          <label for="cash_amount">Cash Amount</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field ">
          <input id="customer_no" name="customer_no" maxlength="11" type="text" placeholder="947xxxxxxxx" class="validate valied_number">
          <label for="customer_no">Customer Number If Available</label>
        </div>
      </div>
       <div class="row">
         <div class="col md-6">
           <p>
              <label>
                <input class="with-gap" value="cash" name="cash_credit" type="radio" checked />
                <span>Cash</span>
              </label>
            </p>
         </div>
         <div class="col md-6">
          <p>
            <label>
              <input class="with-gap" value="credit" name="cash_credit" type="radio" />
              <span>Credit</span>
            </label>
          </p>
         </div>
       </div>
      {{ csrf_field() }}
          <input id="printBillId" type="hidden" value="{{ $bill_id_un }}" name="bill_no">
    </div>
    <div class="modal-footer">
      <span class="badge left"> use SHIFT + F to get this interface</span>
      <input type="submit" id="billSubmitButton" class="modal-close waves-effect waves-green btn-flat" value="Purchase">
    </div>
</form>
</div>