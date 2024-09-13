@section('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
@stop
<div class="card card-small mb-4">
        <div class="card-header border-bottom">
            <h6 class="m-0">Groups</h6>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item px-3">
                <form id="new_item_form" action="/addNewItem" method="post">
                {{ csrf_field() }}
                    <!-- location code -->
                    <strong class="text-muted d-block mb-2">Your Store Location</strong>
                    <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox" onclick="locationService()"  class="custom-control-input" id="formsCheckboxChecked" checked="true">
                        <label class="custom-control-label" for="formsCheckboxChecked">If You Need Location Code Service Simply Put Tick Mark</label>
                    </div>
                    <div class="input-group mb-3">
                        
                        <div class="form-group col-md-4">
                            <select name="direction" id="direction" class="form-control">
                                <option selected="">Select Direction</option>
                                <option value="LS">Left</option>
                                <option value="RS">Right</option>
                                <option value="FS">Front</option>
                                <option value="BS">Back</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <select name="row" id="row" class="form-control">
                                <option selected="">Select Row No</option>
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
                            <select name="column" id="column" class="form-control">
                                <option selected="">Select Column No</option>
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
                    <!-- end location code -->

                    <!-- location code -->
                    <strong class="text-muted d-block mb-2">Product Details</strong>

                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Product Name</span>
                        </div>
                        <input type="text" class="form-control" name="product_name" placeholder="Product Name" aria-label="Product Name" aria-describedby="basic-addon1" > 
                    </div>
                    </div>
                    <!-- end location code -->
    
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
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Expire Date</span>
                        </div>
                        <input type="date" class="form-control" name="expire_date" placeholder="Ex DD/MM/YYYY" aria-label="expire_date" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="This will help you to notify when item reach to expire"> 
                    </div>
                    </div>
                    <!-- end input -->

                    <!-- input -->
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Out Of Stock Remainder</span>
                        </div>
                        <input type="text" class="form-control" name="alert" placeholder="Ex: Enter Some Quantity Here then you can have alert when reach that stock amount" aria-label="Out Of Atock Remainder" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="this is your item trigger level when Salable item reach to this level system remind you to re-fill your stock "> 
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
                    <!-- end input -->
                    <button type="submit" class="btn btn-outline-primary">Add Item</button>
                </form>
            </li>
        </ul>
    </div>
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.ui.dropdown').dropdown();
    });
</script>
<script>
function locationService(){
    var checkbox = document.getElementById('formsCheckboxChecked').checked;
    console.log(checkbox);
    if (checkbox === false )
    {
        document.getElementById("direction").setAttribute("disabled", true);
        document.getElementById("row").setAttribute("disabled", true);
        document.getElementById("column").setAttribute("disabled", true);
    }
    else
    {
        document.getElementById("direction").removeAttribute("disabled");
        document.getElementById("row").removeAttribute("disabled");
        document.getElementById("column").removeAttribute("disabled");
    }
  }
</script>
@stop