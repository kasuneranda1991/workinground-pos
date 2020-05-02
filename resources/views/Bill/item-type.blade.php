    <div  class="col s12 ">
    	<ul id="itemTypes" class="tabs green darken-4">
    	@foreach( $itemTypes as $type)
      @if($type->shop_id == Auth::user()->shop_id)
    		<li class="tab col s3"><a href="#test-swipe-{{$type->id}}">{{$type->type}}</a></li>
      @endif
    	@endforeach
      </ul>
      	@foreach( $itemTypes as $type)
        @if($type->shop_id == Auth::user()->shop_id)

   		<div id="test-swipe-{{ $type->id }}" style="min-height:100px;overflow-y: scroll;overflow-x:hidden;x1  "   class="col s12 green darken-4">
   			<div class="row">
        @foreach( $products as $product)
        @if($product->shop_id == Auth::user()->shop_id)
        @if($type->id == $product->type_id)
        <!-- ___________________________ -->
        <div id="product-item-trigger{{ $product->id }}">
        <div id="product-item" class="col s12 m6 l3">
            <div class="card">
              <div class="card-content">
                <span class="card-title  grey-text text-darken-4"><span id="itemName{{ $product->id }}">{{ strtoupper($product->company->company_name) }} {{ strtoupper($product->product_name) }}</span><i class="right"><span>Rs.</span><span id="itemprice{{ $product->id }}">{{ $product->selling_price }}</label></i></span></span>
              </div>
              <div class="card-action">
              @if($product->stock->where('product_id',$product->id)->where('shop_id',Auth::user()->shop_id)->sum('qty')> $product->stock_remainder)
                <span class="new badge green" data-badge-caption="Remaining Stock"></span>
              @else
                <span class="new badge red" data-badge-caption="Stock About to end"></span>
              @endif
                <a href="#">
                  <span id="itemQty{{$product->id}}">
                    {{$product->stock->where('product_id',$product->id)->where('shop_id',Auth::user()->shop_id)->sum('qty')}}
                  </span>
                  {{$product->stock->count_type}}
                </a>
              </div>
            </div>
            <input id="countType{{$product->id}}" value="{{ $product->stock->count_type }}" type="hidden" >
        </div>
        </div>
        <!-- ___________________________ -->
         @endif
         @endif
        @endforeach  
        </div>
   		</div>
      @endif
   		@endforeach
</div>

<div id="productModel" class="modal bottom-sheet">
<form id="itemBillingForm" action="/postitem" method="post">
  <div class="modal-content">
    <h4 id="productNameOfModel">productName</h4>
    <p>Selling Details</p>
    <div class="row">
    <!-- product form -->
    {{ csrf_field() }}
      <div class="input-field col s12 m3 l2">
        <input required placeholder="Enter Selling Quantity" id="Quantity" type="text" name="selling_qty" class="validate valied_number">
        <label id="productCountTypeOfModel" for="Quantity" class="active">Quantity by countType</label>
      </div>

      <div class="input-field col s12 m3 l2">
        <input placeholder="Batch NO" id="batch-no" required name="selling_batch_no" type="text"  class="validate valied_number">
        <label for="batch-no">Batch No</label>
      </div>

      <div class="input-field col s12 m3 l2">
        <input placeholder="Default Selling Price" id="default_selling_price" name="selling_price" type="text" value="productPrice" class="validate valied_number">
        <label for="default_selling_price">Default Selling Price</label>
      </div>

      <div class="input-field col s12 m3 l2">
        <input placeholder="Enter Discount Amount By Precentage 20%" id="discount" min="0" max="100" name="selling_discount" type="number" class="validate valied_number">
        <label for="discount">Discount</label>
      </div>
      <div class="input-field col s12 m3 l2">
        <input placeholder="Enter Serial No If Available" id="serial_no" name="serial_no" type="text" class="validate">
        <label for="serial_no">SERIAL-NO</label>
      </div>
      <input type="hidden" id="product_id" value="productId" name="bill_item_id">
      <!-- <input type="hidden" name="bill_id" value="{{ (uniqid()) }}"> -->
      <!-- end product form -->
    </div>
  </div>
  <div class="modal-footer">
    <input type="submit" id="billingSubmitBtn" class="btn modal-close" value="add">
  </div>
  </form>
</div>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.valied_number').on('input', function() {
    match = (/(\d{0,100})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
    this.value = match[1] + match[2];
  });
  });
</script>