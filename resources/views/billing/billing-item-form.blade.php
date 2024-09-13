<!-- Modal -->
<div class="modal billingModal" id="billingModal" tabindex="-1" style="top:10%;" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemName">item title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="billing_item_form_validation" action="/postitem" method="POST">
        {{ csrf_field() }}
      <div class="modal-body">
          
          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="selling_qty" id="selling_qty" required autofocus>
                  <label class="form-label">Quantity by(<small id="count_type"></small>) </label>
              </div>
          </div>
          <!-- end input -->

          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="selling_batch_no" id="selling_batch_no" required>
                  <label class="form-label">Batch No</label>
              </div>
          </div>
          <!-- end input -->

          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="selling_price" id="selling_price" required focus>
                  <label class="form-label">Selling Price</label>
              </div>
          </div>
          <!-- end input -->

          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="selling_discount" id="selling_discount" >
                  <label class="form-label">Discount(%)</label>
              </div>
          </div>
          <!-- end input -->

          <!-- start input -->
          <div class="form-group form-float">
              <div class="form-line">
                  <input type="text" class="form-control" name="serial_no" id="serial_no" >
                  <label class="form-label">Serial No</label>
              </div>
          </div>
          <!-- end input -->

          <input type="hidden" name="bill_item_type_id" id="bill_item_type_id" placeholder="billing_item_id">
          <input type="hidden" name="bill_item_id" id="bill_item_id" placeholder="billing_item_id">
      
      </div>
      <div class="modal-footer">
        <button id="billingSubmitBtn" class="btn btn-success waves-effect" type="submit">SUBMIT</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>