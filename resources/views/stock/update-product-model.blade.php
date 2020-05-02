<div class="modal fade" id="updateItem" tabindex="-1" role="dialog" aria-labelledby="editItem1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="updateform" method="POST" action="/updateItem">
                      {{ csrf_field() }}
        <div class="modal-header">
          <h5 class="modal-title" id="updateItemname">Update Item Name</h5>
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
                        <strong class="text-muted d-block mb-2">Update Item Details</strong>
                        <!-- User input -->
                        <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Quantity</span>
                          </div>
                          <input type="text" class="form-control form-control-sm valied_number" pattern="\d+" name="qty" placeholder="Enter Quantity Here" aria-label="Item Name" aria-describedby="basic-addon1">
                        </div>
                        </div>
                        <!-- end user input -->

                        <!-- User input -->
                        <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Unit Price</span>
                          </div>
                          <input type="text" pattern="\d+" class="form-control form-control-sm valied_number" name="unit_price" placeholder="Enter Unit Price Here" aria-label="Company Name" aria-describedby="basic-addon1">
                        </div>
                        </div>
                        <!-- end user input -->
                        
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Expire Date</span>
                        </div>
                        <input data-provide="datepicker" type="text" class="form-control date" id="datepicker" name="update_item_expireDate" placeholder="Ex DD/MM/YYYY" aria-label="update_item_expireDate" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="bottom" title="This will help you to notify when item reach to expire">
                        <!-- <input type="date" class="form-control" name="update_item_expireDate" placeholder="Ex DD/MM/YYYY" aria-label="update_item_expireDate">  -->
                    </div>
                    </div>
                    <!-- end input -->

                    </li>
                  </ul>
                </div>
          <!--/Edit form -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="updateBtn" class="btn btn-primary">Save changes</button>
        </div>
        <input type="hidden" value="update product id " id="update_product_id" name="update_product_id"></input>
        </form>
    </div>
  </div>
</div>