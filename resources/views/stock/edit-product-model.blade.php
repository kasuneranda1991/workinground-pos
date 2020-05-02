<!-- edit Model -->
<div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="editItem1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editItemName">Edit Product Name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!--Edit form -->
            <div class="card card-small mb-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-3">
                        <form id="edit_item_form" action="/editproduct" method="POST">
                        {{ csrf_field() }}
                    <!-- location code -->
                    <strong class="text-muted d-block mb-2">Your Store Location</strong>
                    <label>Current Location: <small id="currentLocationCode"></small></label>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="editlocationService">
                      <label class="form-check-label" for="locationService">I Need Location Service</label>
                    </div>
                    <hr>
                    <!-- start input -->
                    <div class="row">
                        <div class="form-group col-md-4">
                          <label for="direction">Direction</label>
                          <select id="directionS" name="direction" class="form-control">
                            <option value="e" selected="">Choose..</option>
                            <option value="LS">Left</option>
                            <option value="RS">Right</option>
                            <option value="FS">Front</option>
                            <option value="BS">Back</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="row">Row No</label>
                          <select id="rowS" name="row" class="form-control">
                            <option value="e" selected="">Choose..</option>
                            <option value="R1">Row 1</option>
                            <option value="R2">Row 2</option>
                            <option value="R3">Row 3</option>
                            <option value="R4">Row 4</option>
                            <option value="R5">Row 5</option>
                            <option value="R6">Row 6</option>
                            <option value="R7">Row 7</option>
                            <option value="R8">Row 8</option>
                            <option value="R9">Row 9</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="column">Column No</label>
                          <select id="columnS" name="column" class="form-control">
                            <option value="e" selected="">Choose..</option>
                            <option value="C1">Column 1</option>
                            <option value="C2">Column 2</option>
                            <option value="C3">Column 3</option>
                            <option value="C4">Column 4</option>
                            <option value="C5">Column 5</option>
                            <option value="C6">Column 6</option>
                            <option value="C7">Column 7</option>
                            <option value="C8">Column 8</option>
                            <option value="C9">Column 9</option>
                            <option value="C10">Column 10</option>
                            <option value="C11">Column 11</option>
                            <option value="C12">Column 12</option>
                            <option value="C13">Column 13</option>
                            <option value="C14">Column 14</option>
                            <option value="C15">Column 15</option>
                            <option value="C16">Column 16</option>
                            <option value="C17">Column 17</option>
                            <option value="C18">Column 18</option>
                            <option value="C19">Column 19</option>
                            <option value="C20">Column 20</option>
                          </select>
                        </div>
                    </div>
                    <!-- end input -->

                    <!-- location code -->
                    <strong class="text-muted d-block mb-2">Product Details</strong>
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Product Name</span>
                        </div>
                        <input required type="text" class="form-control" id="Edit_product_name" name="product_name" placeholder="Product Name" aria-label="Product Name" aria-describedby="basic-addon1" value="Product Name"> 
                    </div>
                    <!-- end location code -->

                    <!-- input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Type</span>
                        </div>
                         <input required type="text" class="form-control" id="item_type" name="item_type" placeholder="Electronic, Food, Hardware, Software" aria-label="Item Name" aria-describedby="basic-addon1" value="Product Type">
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Count Type</span>
                        </div>
                        <input required type="text" class="form-control" id="count_type" name="count_type" placeholder="Ex : Box, pics, Tablet, Bottle, Kg, Liter, Meter, " aria-label="Count Type" aria-describedby="basic-addon1" value="Count Type"> 
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company Name</span>
                        </div>
                        <input required type="text" class="form-control" name="company_name" id="company_name" placeholder="Dell,Hp,Panadol,Veet" aria-label="Company Name" aria-describedby="basic-addon1" value="Company Name"> 
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Selling Price</span>
                        </div>
                        <input required type="text" class="form-control valied_number" name="selling_price" id="selling_price" placeholder="Ex 1200,1500,..." aria-label="unit_price" aria-describedby="basic-addon1" value="Selling Price"> 
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Out Of Stock Remainder</span>
                        </div>
                        <input required type="text" class="form-control valied_number" name="alert" id="alert" placeholder="Ex: Enter Some Quantity Here then you can have alert when reach that stock amount" value="Stock remainder" aria-label="Out Of Atock Remainder" aria-describedby="basic-addon1"> 
                    </div>
                    <!-- end input -->                
                    </li>
                  </ul>
                </div>
          </div>
          <input type="hidden" value="Product id" name="product_id" id="productid"></input>
          <input type="hidden" value="product type id" name="product_type_id" id="product_type_id"></input>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="editProductBtn" class="btn btn-primary">Save changes</button>
          </div>
          <!--/Edit form -->
          </form>
        </div>
      </div>
    </div>
<!-- edit Model -->