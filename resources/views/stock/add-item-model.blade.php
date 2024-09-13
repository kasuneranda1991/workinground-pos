<div class="modal fade" id="add-item-model" tabindex="-1" role="dialog" aria-labelledby="add-item-modelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add-item-modelLabel">Add New Product To your Shop</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addNewItemForm" action="/addNewItem" method="post">
        {{ csrf_field() }}
      <div class="modal-body">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="addlocationService">
          <label class="form-check-label" for="addlocationService">I Need Location Service</label>
        </div>
        <hr>
        <!-- start input -->
        <div class="row">
            <div class="form-group col-md-4">
              <label for="direction">Direction</label>
              <select id="directione" name="direction" class="form-control">
                <option value="e">Choose..</option>
                <option value="LS">Left</option>
                <option value="RS">Right</option>
                <option value="FS">Front</option>
                <option value="BS">Back</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="row">Row No</label>
              <select id="rowe" name="row" class="form-control">
                <option value="e">Choose..</option>
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
              <select id="columne" name="column" class="form-control">
                <option value="e">Choose..</option>
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
      <strong class="text-muted d-block mb-2">Product Details</strong>

      <!-- start input -->
      <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Product Name</span>
            </div>
            <input type="text" class="form-control" name="product_name" placeholder="Product Name" aria-label="Product Name" aria-describedby="basic-addon1" > 
        </div>
      </div>
      <!-- end input -->

      <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Size</span>
                        </div>
                          <select name="size" class="form-control" >
                            <option value=" " selected>Choose Size if Available</option>
                            <option value="Small">Small</option>
                            <option value="Big">Big</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="Extra_Large">Extra Large</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                          </select>
                    </div>
                    </div>
                    <!-- end input -->
                    
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Type</span>
                        </div>
                        <input type="text" class="form-control" name="item_type" placeholder="Electronic, Food, Hardware, Software" aria-label="Item Name" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="right" title="your item will include to this catogery,when you bill"> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Count Type</span>
                        </div>
                        <input type="text" class="form-control" name="count_type" placeholder="Ex : Box, pics, Tablet, Bottle, Kg, Liter, Meter, " aria-label="Count Type" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="right" title="Minimum Quantity of your salling"> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Quantity</span>
                        </div>
                        <input type="text" class="form-control valied_number" name="qty" placeholder="Quantity" aria-label="Quantity Name" aria-describedby="basic-addon1"data-toggle="tooltip" data-placement="left" title="New Quantity amount which you want to add stock"> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Unit Price</span>
                        </div>
                        <input type="text" class="form-control valied_number" name="unit_price" placeholder="Ex 1200,1500,..." aria-label="unit_price" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="This your item cost price"> 
                    </div>
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Selling Price</span>
                        </div>
                        <input type="text" class="form-control valied_number" name="selling_price" placeholder="Ex 1200,1500,..." aria-label="unit_price" aria-describedby="basic-addon1"data-toggle="tooltip" data-placement="top" title="This your this item selling price to your customers"> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-0 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Expire Date</span>
                        </div>
                        <!-- <input type="date" class="form-control" id="datepicker" name="expire_date" placeholder="Ex DD/MM/YYYY" aria-label="expire_date" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="This will help you to notify when item reach to expire"> -->
                        <input data-provide="datepicker" type="text" class="form-control date" id="datepicker" name="expire_date" placeholder="Ex DD/MM/YYYY" aria-label="expire_date" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="This will help you to notify when item reach to expire">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Out Of Stock Remainder</span>
                        </div>
                        <input type="text" class="form-control valied_number" name="alert" placeholder="Ex: Enter Some Quantity Here then you can have alert when reach that stock amount" aria-label="Out Of Atock Remainder" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="this is your item trigger level when Salable item reach to this level system remind you to re-fill your stock "> 
                    </div>
                    </div>
                    <!-- end input -->

                    <strong class="text-muted d-block mb-2">Company Details</strong>
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company Name</span>
                        </div>
                        <input type="text" class="form-control" name="company_name" placeholder="Dell,Hp,Panadol,Veet" aria-label="Company Name" aria-describedby="basic-addon1"> 
                    </div>
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company Or Agent Contact No</span>
                        </div>
                        <input type="text" class="form-control" name="company_contact" placeholder="025xxxxxxxx" aria-label="Company contact" aria-describedby="basic-addon1"> 
                    </div>
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company Address</span>
                        </div>
                        <input type="text" class="form-control" name="company_address" placeholder="12 Stree,Colombo.." aria-label="Company Address" aria-describedby="basic-addon1"> 
                    </div>
                    </div>
                    <!-- end input -->
                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Company Reg Or VAT No</span>
                        </div>
                        <input type="text" class="form-control" name="company_regno" placeholder="Reg12584" aria-label="Company regno" aria-describedby="basic-addon1"> 
                    </div>
                    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="productaddbtn" class="btn btn-outline-success">Add</button>
      </div>
    </form>
    </div>
  </div>
</div>