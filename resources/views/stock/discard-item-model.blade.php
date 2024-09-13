<div class="modal fade" id="discardItem" tabindex="-1" role="dialog" aria-labelledby="editItem1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="discardform" action="/discardproduct" method="post">
        {{ csrf_field() }}
        <div class="modal-header">
          <h5 class="modal-title" id="editItem1">Discard item name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <!--Edit form -->
          <div class="card card-small mb-4">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-3">
                        <!-- Input Groups -->
                        <strong class="text-muted d-block mb-2">Discard Item Details</strong>
                        <p class="alert alert-warning">Warning! Please Make sure to enter exact Details of discard product.Unless item not be discard from stock</p>
                        <!-- User input -->
                        <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Quantity</span>
                          </div>
                          <input type="text" class="form-control form-control-sm valied_number" name="qty" placeholder="Enter Quantity Here" aria-label="Item Name" aria-describedby="basic-addon1">
                        </div>
                        </div>
                        <!-- end user input -->

                        <!-- User input -->
                        <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Batch No</span>
                          </div>
                          <input type="text" class="form-control form-control-sm valied_number" name="batch_no" placeholder="Enter Batch No Here" aria-label="batch No" aria-describedby="basic-addon1">
                        </div>
                        </div>
                        <!-- end user input -->

                        <!-- User input -->
                        <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Reason for Discard</span>
                          </div>
                          <input type="text" class="form-control form-control-sm" name="reason" placeholder="reason for discard" aria-label="Company Name" aria-describedby="basic-addon1">
                        </div>
                        </div>
                    </li>
                  </ul>
                </div>
          <!--/Edit form -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="discardItemButton" class="btn btn-primary">Procceed</button>
        </div>
        <input type="hidden" value="product id" id="discard_product_id" name="discard_product_id"></input>
      </form>
    </div>
  </div>
</div>