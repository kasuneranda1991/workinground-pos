<!-- Modal -->
<div class="modal fade cartModal" id="cartModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="cartModal" aria-hidden="true">
  <div class="modal-dialog-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cart-total"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
              <table class="ui celled selectable center aligned table" style="width: 100%;" id="shoppingCart">
                  <thead>
                      <tr>
                          <th style="max-width:10px;">Batch No</th>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Discount</th>
                          <th>Serial No</th>
                          <th>Total(LKR)</th>
                          <th data-orderable="false"></th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th style="max-width:10px;">Batch No</th>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Discount</th>
                          <th>Serial No</th>
                          <th>Total(LKR)</th>
                          <th data-orderable="false"></th>
                      </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
              </table>
          </div>
      </div>
      <div class="modal-footer">
        <button id="settleBillBtn" data-toggle="modal" data-target="#finalizeBilModal" class="btn btn-success waves-effect">Settle this bill</button>
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!--start remove current shopping item -->
<form id="shoppingCartItemRemoveForm" action="/removeBillItem" method="post">
  {{ csrf_field() }}
  <input type="hidden" id="remove_item_id" name="bill_id" value="">
</form>
<!--end remove current shopping item -->

<!-- Modal -->
<div class="modal fade returnItemModal" id="returnItemModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="returnItemModal" aria-hidden="true">
  <div class="modal-dialog-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemName">Return Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width: 100%;" id="settledBillTable">
              <thead>
                <th>Bill NO</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Bill Date</th>
                <th data-orderable="false" >action</th>
              </thead>
              <tfoot>
                <tr>
                  <th>Bill NO</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Discount</th>
                  <th>Total Price</th>
                  <th>Bill Date</th>
                  <th data-orderable="false" >action</th>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
            </table>
          </div>
      </div>
      <div class="modal-footer">
        <!-- <button id="billingSubmitBtn" class="btn btn-success waves-effect" type="submit">SUBMIT</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- start return item form -->
<div class="modal returnItemFormModal" id="returnItemFormModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="return_item_name">Return Item </h4>
            </div>
            <form id="returnItemFormnew" action="/itemreturn" method="post">
              {{ csrf_field() }}
            <div class="modal-body">
              
              <!-- start input -->
              <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" id="return_quantity" class="form-control" name="qty" required aria-required="true" autofocus>
                    <label class="form-label">Quantity</label>
                </div>
              </div>
              <!-- end input -->

              <!-- start input -->
              <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="reason" required="required">
                    <label class="form-label">Reason</label>
                </div>
              </div>
              <!-- end input -->

              <input id="return_discount" name="discount" value="" type="hidden" placeholder="discount if available">
              <input type="hidden" id="return_raw_id" value="return_raw_id" name="return_item" placeholder="return row id of billing" />
            </div>
            <div class="modal-footer">
                <button type="submit" id="returnBtn" class="btn btn-success waves-effect">Get Return</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!-- end return item form -->

<!--finalize bill Modal -->
<div class="modal finalizeBilModal" id="finalizeBilModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="finalizeBilModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Bill_Total_Amount">Settle Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="finishBillForm" action="/purchase" method="post">
        {{ csrf_field() }}
      <div class="modal-body">
          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="cash_amount" id="cash_amount" required autofocus>
                  <label class="form-label">Cash Amount</label>
              </div>
          </div>
          <!-- end input -->

           <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="customer_no" id="customer_no" >
                  <label class="form-label">Customer No(customer will be notify about shop promotion and much more.... ) </label>
              </div>
          </div>
          <!-- end input -->
          
          <!-- end input -->
            <div class="form-group">
                <input type="radio" value="cash" name="cash_credit" id="cash" class="form-control with-gap" checked required aria-required="true">
                <label for="cash">cash</label>

                <input type="radio" value="credit" name="cash_credit" id="credit" class="form-control with-gap">
                <label for="credit" class="m-l-20">credit</label>
            </div>
          <!-- end input -->

          <input id="sette_bill_id" type="hidden" value="settle_bill_no" name="bill_no">
      </div>
      <div class="modal-footer">
        <button id="finishBillBtn" class="btn btn-success waves-effect" type="submit">Finish</button>
        <button type="button" class="btn btn-warning waves-effect" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!--print bill Modal -->
<div class="modal fade printBillReceiptModal animated pulse" id="printBillReceiptModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="printBillReceiptModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Bill_Total_Amount">Print Receipt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">  
      <a href="javascript:void(0);" class="thumbnail">
          <img src="printReceiptgif/printer-icon-loop-dribbble-davegamez.gif" width="50%" height="30%" class="img-responsive">
      </a>  
      <input type="hidden" id="total" value="">    
      <input type="hidden" id="dis" value="">    
      <input type="hidden" id="cash" value="">    
      <input type="hidden" id="balance" value="">    
      <input type="hidden" id="shop_name" value="{{Auth::user()->shop->shop_name}}">    
      <input type="hidden" id="cashier" value="{{Auth::user()->username}}">
      <input type="hidden" id="time" value="{{Carbon\Carbon::now()->timezone('Asia/Colombo')->toDayDateTimeString()}}">
      <input type="hidden" id="address" value="{{Auth::user()->shop->address}}">
      <input type="hidden" id="bill_no" value="">
      <input type="hidden" id="city" value="{{Auth::user()->shop->city}}">
      <input type="hidden" id="contact_no" value="{{Auth::user()->shop->contact_no}}">
      <input id="printerlist" hidden="true" value="{{ Auth::user()->user_printer }}">
      <input id="cutter" hidden="true" type="checkbox" checked="checked"/><br/>
      <input id="image" hidden="true" type="checkbox" checked="checked"/>
      <div id="printItem"></div>
      </div>
      <div class="modal-footer">
        <button id="PrintreceiptBtn" class="btn btn-success waves-effect" type="submit">Finish</button>
        <button type="button" class="btn btn-warning waves-effect" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!--Help Modal -->
<div class="modal fade helpModal animated pulse" id="helpModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="helpModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Bill_Total_Amount">Help Tips</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">  
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Press  together for Help Tips.
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>H</kbd></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Press to close Pop up modals.
            <span class="badge bg-pink"><kbd>esc</kbd></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            To switch Bill Settle Window instant, Press  together
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>F</kbd></span>
          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center">
            To switch Return Bill item Window instant, Press together
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>R</kbd></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            To switch Shopping Cart Window instant, Press together
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>C</kbd></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            For Get Search Bar instant, Press together
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>S</kbd></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            For Get Category Left Side Bar instant, Press together
            <span class="badge bg-pink"><kbd>shift</kbd> + <kbd>TAB</kbd></span>
          </li>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning waves-effect" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- end help mpdal -->