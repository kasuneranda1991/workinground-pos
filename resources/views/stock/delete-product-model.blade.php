    <div class="modal fade" style="background:-webkit-linear-gradient(-45deg, #c92a2a 0%,#ef4832 25%,#ff1919 63%,#ff1919 84%,#ff1919 84%,#e73827 100%);" id="deleteItem" tabindex="2" role="dialog" aria-labelledby="deleteItem1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteItem1">Delete Product Name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Warning! This Action Could not Be Undone,Really do you want to perform this action ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">No</button>
          <form id="deleteitemform" action="/deleteItem" method="POST">
            {{ csrf_field() }}
            <button type="submit" id="deleteItemButton" class="btn btn-outline-danger">Yes</button>
            <input type="hidden" placeholder="product id" id="product_id" name="product_id" value="product id"></input>
            <input type="hidden" placeholder="product quantity" id="product_quantity" name="product_quantity" value="product qantity"></input>
          </form>
          </div>
        </div>
      </div>
    </div>

 