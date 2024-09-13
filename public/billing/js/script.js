// start jquery
$(document).ready(function(){
//Start Billing Item Modal On Div Click
$(".dblckick").dblclick(function(e){
        e.preventDefault();
        console.log('Disabled Double Click');
        $(this).attr('disabled','disabled');
      });

var billingItems ='';
function OpenItemModal(details) {
	$('#billingModal').modal('show');
	$('#billingSubmitBtn').removeAttr('disabled');
	$('#itemName').text(details.display_name);
    $('#count_type').text(details.count_type);
    $('#selling_price').val(details.selling_price);
    $('#bill_item_id').val(details.product_id);
    $('#bill_item_type_id').val(details.type_id);
    $('#selling_qty').val('');
    $('#selling_batch_no').val('');
    $('#selling_discount').val('');
    $('#serial_no').val('');
}
//end Billing Item Modal On Div Click

//start unsettled bill count 
function billCount() {
	$.ajax({
		type: "get",
		url: '/unsettledBillCount',
		success:function(data)
		{
			$('#unsettle-bill').empty();
			$('#unsettle-bill').append("<em class='animated filpInX'>"+data+"</em>");
		}
	});
}
//end unsettled bill count

//start get Cart Total 
function CartTotal() {
	$.ajax({
		type: "get",
		url: '/cartTotal',
		success:function(data)
		{

			$('#cart-total').empty();
			$('#cart-total').append('<h4>Total Payble Amount : Rs.'+data.total+'</h4>');
		}
	});
}
//end get Cart Total 

//start get Cart Total on finalize 
$('#settleBillBtn').click(function(){
	$('#finishBillBtn').removeAttr('Disabled');
	$.ajax({
		type: "get",
		url: '/cartTotal',
		success:function(data)
		{
			$('#Bill_Total_Amount').empty();
			$('#Bill_Total_Amount').append('<h4>Total Payble Amount : Rs.'+data.total+'</h4>');
			$('#sette_bill_id').val(data.bill_no);
		}
	});
});
//end get Cart Total on finalize 

// start print receipt
$('#PrintreceiptBtn').click(function(){
	// alert('ssjs');
	webprint.printRaw(getEscSample($('#cutter').is(':checked'),$('#image').is(':checked')), $('#printerlist').val());
});
// BuildReceipt();
// end print receipt

//Start finalize form 
$('#finishBillBtn').on('click', function (e) {
    
    var form = $('#finishBillForm');
    var url = form.attr('action');
    $('#finishBillBtn').attr('Disabled','Disabled');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {

              billCount();// show response from the php script.
              // console.log('Item Add to cart'); // show response from the php script.
              // form.reset();
              $('#billingModal').modal('hide');

              if(data.success == true){
         			$('.modal').modal('hide');
         			// $.each(data.items,function(key,index) {
         			// 		console.log("index_key:"+index);
         			// });
         			// console.log("printItem:"+data.items);
         			// console.log("total:"+data.total);
         			// console.log("discount:"+data.dis);
         			// console.log("cash:"+data.cash);
         			// console.log("balance:"+data.balance);
         			// console.log("Bill No:"+data.bill_no);
         			$('#printBillReceiptModal').modal('show');
         			$('#total').val(data.total);
         			$('#dis').val(data.dis);
         			$('#cash').val(data.cash);
         			$('#balance').val(data.balance);
         			$('#bill_no').val(data.bill_no);
         			$('#cash_amount').val(null);
         			$('#customer_no').val(null);
         			billingItems = data.items;

         			
                     $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'success',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 3000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/definite_flo9zz.ogg");
	                    audio.play();
                  }else if(data.error == true){
                  	$('#finishBillBtn').removeAttr('Disabled');
                     $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'error',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 15000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/error_jydv0i.ogg");
	                    audio.play();
                  }
           },
         });
    e.preventDefault();
  });
//end finalize form 

//start get product category
$.ajax({
	type: "get",
	url: '/testyear',
	success:function(data)
	{
		$.each(data.type,function(index,value){
			// console.log(index);
			$('#category').append("<li><a href='#' class='waves-effect waves-block' id='type"+value.id+"' data-type='"+value.id+"'><span>"+value.type+"</span></a></li>");
		});
	}
});

// start get all product nav item
$('#all_product').click(function(e){
	e.preventDefault();
	$('#products').empty();
	productSelection(0);
});
// end get all product nav item

$.ajax({
	type: "get",
	url: '/testyear',
	success:function(data)
	{
		$.each(data.type,function(index,value){
			$('#type'+value.id).attr('disabled','disabled');
			$('#type'+value.id).click(function(e){
				e.preventDefault();
				$('#catogery_name').text(value.type);
				// alert($(this).attr('data-type'));
				$(this).attr('disabled','disabled');
				productSelection($(this).attr('data-type'));
			});
		});
	}
});
//end get product category
window.onload = productSelection(0);
window.onload = billCount();
function productSelection(requestId) {
	$('#products').empty();
	$.ajax({
		type: "get",
		url: '/testyear',
		success:function(data)
		{
			$.each(data.products,function(index,details){
				// console.log(index);
				if(requestId == details.type_id ){
					$('#products').append("<div style='cursor: pointer;' id='"+details.product_id+"' class='col-lg-4 col-md-4 col-sm-6 col-xs-12 animated fadeInDown'><div class='card'><div class='header'><h2>"+details.display_name+"</h2><ul class='header-dropdown m-r--5'><span>Rs."+details.selling_price+"</span></ul></div><div class='body'><span class='label label-success'>"+details.qty+" "+details.count_type+"</span><span class='float-right label label-info'>"+details.alert+"</span></div></div></div>");
					$('#'+details.product_id).click(function(){
                        // alert(details.display_name);
                        OpenItemModal(details);
                    });
				}else if(requestId == 0){
					$('#products').append("<div style='cursor: pointer;' id='"+details.product_id+"' class='col-lg-4 col-md-4 col-sm-6 col-xs-12 animated fadeInDown'><div class='card'><div class='header'><h2>"+details.display_name+"</h2><ul class='header-dropdown m-r--5'><span>Rs."+details.selling_price+"</span></ul></div><div class='body'><span class='label label-success'>"+details.qty+" "+details.count_type+"</span><span class='float-right label label-info'>"+details.alert+"</span></div></div></div>");
					$('#'+details.product_id).click(function(){
                        // alert(details.display_name);
                        OpenItemModal(details);
                    });
				}
			});
		}
	});
}
//end get product

//start shopping_cart_trigger
$('#shopping_cart_trigger').click(function(){
	var data = $('#shoppingCart').DataTable();
	data.ajax.reload( null, false );
	$('#cartModal').modal('show');
	CartTotal();
});
//end shopping_cart_trigger


//start search autocomplete
$.ajax({
		type: "get",
		url: '/testjson',
		success:function(data)
		{
			$('.search-bar')
			  .search({
			    source: data,
			    onSelect: function(result, response) {
			        console.log(result, 'result');
			        console.log(response, 'response');
			        $('#billingSubmitBtn').removeAttr('disabled');
			        $('#billingModal').modal('show');
			        $('#itemName').text(result.title);
			        $('#count_type').text(result.count_type);
			        $('#selling_price').val(result.selling_price);
			        $('#bill_item_id').val(result.id);
			        $('#bill_item_type_id').val(result.type_id);
			        $('#selling_qty').val('');
			        $('#selling_batch_no').val('');
			        $('#selling_discount').val('');
			        $('#serial_no').val('');
			    },
			  });
		}
	});

//end search autocomplete

//start item submit
$('#billingSubmitBtn').on('click', function (e) {
    
    var form = $('#billing_item_form_validation');
    var url = form.attr('action');
    $(this).attr('disabled','disabled');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {

              billCount();// show response from the php script.
              // console.log('Item Add to cart'); // show response from the php script.
              // form.reset();
              $('#billingModal').modal('hide');

              if(data.success == true){
              	// -------------------
              	$('#products').empty();
					$.ajax({
						type: "get",
						url: '/testyear',
						success:function(obj)
						{
							$.each(obj.products,function(index,details){
								// console.log(index);
								if(data.type_id == details.type_id ){
									$('#products').append("<div style='cursor: pointer;' id='"+details.product_id+"' class='col-lg-4 col-md-4 col-sm-6 col-xs-12 animated pulse'><div class='card'><div class='header'><h2>"+details.display_name+"</h2><ul class='header-dropdown m-r--5'><span>Rs."+details.selling_price+"</span></ul></div><div class='body'><span class='label label-success'>"+details.qty+" "+details.count_type+"</span><span class='float-right label label-info'>"+details.alert+"</span></div></div></div>")
									$('#'+details.product_id).click(function(){
				                        // alert(details.display_name);
				                        OpenItemModal(details);
				                    });
								}
							});
						}
					});
              	// -------------------
                     $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'success',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 3000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/definite_flo9zz.ogg");
	                    audio.play();
                  }else if(data.error == true){
                     $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'error',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 15000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/error_jydv0i.ogg");
	                    audio.play();
                  }
           },
         });
    e.preventDefault();
  });
//end item submit

//start shopping cart table function
var table2 = $('#shoppingCart').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/ShoppingCartBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3',
        columns: [
            { data: 'batch_no', name: 'batch_no' },
            { data: 'product_name', name: 'product_name' },
            { data: 'qty', name: 'qty' },
            { data: 'discount', name: 'discount' },
            { data: 'serial_no', name: 'serial_no' },
            { data: 'total_price', name: 'total_price' },
            { data: 'action', name: 'action' },
        ],
        // dom: 'lBfrtip',
    });

// start remove cart item
$('#shoppingCart tbody').on('click', 'button', function (e) {
        var data = table2.row( $(this).parents('tr') ).data();
        $('#remove_item_id').val(data.id);
        var pid = data.product_id;
        var qtyy = data.qty;
        var form = $('#shoppingCartItemRemoveForm');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {	
               		billCount();
               		CartTotal();
                    console.log('item Removed'); // show response from the php script.
               }
             });
        e.preventDefault();	
      table2.ajax.reload( null, false );
      });
// end remove cart item

//end shopping cart table function

//start step
if($('#printer_type').val() == 'pos'){
// ______________start Printer Script__________________________
        var populatePrinters = function(printers){
            var printerlist = $("#printerlist");
            printerlist.html('');
            for (var i in printers){
                printerlist.append('<option value="'+printers[i]+'">'+printers[i]+'</option>');
            }
        };
        var populatePorts = function(ports){
            var portlist = $("#portlist");
            portlist.html('');
            for (var i in ports){
                portlist.append('<option value="'+ports[i]+'">'+ports[i]+'</option>');
            }
            if ($("#portlist option").length)
                webprint.openPort($("#portlist option:first-child").val(), {baud:"9600", databits:"8", stopbits:"1", parity:"1", flow:"none"});
        };
        
        webprint = new WebPrint(true, {
            relayHost: "127.0.0.1",
            relayPort: "8080",
            listPrinterCallback: populatePrinters,
            listPortsCallback: populatePorts,
            readyCallback: function(){
                webprint.requestPorts();
                webprint.requestPrinters();
                // getESCPImageString("https://wallaceit.com.au/webprint/wallaceit_receipt_logo.png", function (imgdata) {
                //     imgData = imgdata;
                //     console.log("image loaded");
                // });
            }
        });

        // ESC/P receipt generation
                var imgData = '';
                getEscSample = function(cut, image){
                    
                    var shop_name = document.getElementById("shop_name").value;
                    var address = document.getElementById("address").value;
                    var city = document.getElementById("city").value;
                    var contact_no = document.getElementById("contact_no").value;
                    var time = document.getElementById("time").value;
                    var cashier = document.getElementById("cashier").value;           
                    var total = document.getElementById("total").value;           
                    var balance = document.getElementById("balance").value;           
                    var cash = document.getElementById("cash").value;           
                    var bill_no = document.getElementById("bill_no").value;           
                    var dis = document.getElementById("dis").value;  
                
                    var data = '';
                    if (image)
                    data+=esc_p + esc_init + esc_a_c + esc_double + shop_name + "\n" + font_reset;
                    data+=esc_a_c + contact_no + "\n";
                    data+=esc_a_c + address + "\n";
                    data+=esc_a_c + city + "\n";
                    data+=esc_a_l + esc_font_A +'Teller:'+ cashier + "\n";
                    data+=esc_a_l + 'Time  :'+ time + "\n";
                    data+=esc_a_l + 'Bill No:#'+ bill_no + "\n";
                    data+=esc_a_c + '________________________________________________________'+ "\n";
                    data+=esc_a_l + 'Item                               Qty     Price'+ "\n";
                    data+=esc_a_c + '________________________________________________________'+ "\n";
        			if(billingItems){
						$.each(billingItems,function(key,index) {
							var itemx = '';
							$.each(index,function(keys,indexs) {
								itemx = itemx + indexs;
							});
							// console.log("index_key:"+itemx);
							data+=esc_a_l + itemx;
						});
				    }                    
                    data+=esc_a_c + '________________________________________________________'+ "\n" +esc_double;
                    data+=esc_a_l + 'Total    Rs.';
                    data+=esc_a_r +  total + "\n";
                    data+=esc_a_c + esc_font_A + '________________________________________________________'+ "\n";
                    data+=esc_a_l +  font_reset +'Discount :Rs.'+ dis + "\n";
                    data+=esc_a_l + 'Cash     :Rs.'+ cash + "\n";
                    data+=esc_a_l + 'Balance  :Rs.'+ balance + "\n" + esc_font_A + esc_bold_off;
                    data+=esc_a_c + '________________________________________________________'+ "\n";
                    data+=esc_a_c+ font_reset + 'Thank You.Come Again'+ "\n";
                    data+=esc_a_c+"\n";
                    data+=esc_a_c +esc_font_A+ 'Exchange Possible in 7 Days'+ "\n";
                    data+=esc_a_c + 'Item should be with its original state '+ "\n";
                    data+=esc_a_c + 'We do not Refund money '+ "\n";
                    data+=esc_a_c+"\n";
                    data+=esc_a_c + '________________________________________________________'+ "\n";
                    data+=esc_a_c +esc_select_codepage1252+ 'Copyright'+'\u00A9'+"workinground.com"+ "\n";
                    data+=esc_a_c + "All Rights Reserved"+"\n";
                    data+=esc_a_c + "072-0782825";
                    data+=esc_line_feed;
                    data+=esc_line_feed;
                    data+=esc_line_feed;
                    data+=esc_line_feed;
                    data+=esc_line_feed;
                    
                    // data+=gs_cut;
                    data+=esc_cut_receipt;
                  
                    return data;
                };

                var esc_init = "\x1B" + "\x40"; // initialize printer
                var esc_p = "\x1B" + "\x70" + "\x30"; // open drawer
                var gs_cut = "\x1D" + "\x56" + "\x4E"; // cut paper
                var esc_a_l = "\x1B" + "\x61" + "\x30"; // align left
                var esc_a_c = "\x1B" + "\x61" + "\x31"; // align center
                var esc_a_r = "\x1B" + "\x61" + "\x32"; // align right
                var esc_double = "\x1B" + "\x21" + "\x31"; // heading
                var esc_font_A = "\x1B" + "\x21" + "\x01"; // heading
                var esc_select_codepage437 = "\x1C" + "\x7D" + "\x26" + "\xB5" + "\x01"; // heading
                var esc_select_codepage1252 = "\x1C" + "\x7D" + "\x26" + "\xE4" + "\x04"; // heading
                var font_reset = "\x1B" + "\x21" + "\x02"; // styles off
                var esc_ul_on = "\x1B" + "\x2D" + "\x31"; // underline on
                var esc_line_feed = "\x0A"; // line feed on
                var esc_qr = "\x1C" + "\x7D" + "\x25"; // underline on
                var esc_bold_on = "\x1B" + "\x45" + "\x31"; // emphasis on
                var esc_bold_off = "\x1B" + "\x45" + "\x30"; // emphasis off
                var esc_cut_receipt = "\x1B" + "\x69"; // emphasis off

        function getEscTableRow(leftstr, rightstr, bold, underline) {
            var pad = "";
            if (leftstr.length + rightstr.length > 48) {
                var clip = (leftstr.length + rightstr) - 48; // get amount to clip
                leftstr = leftstr.substring(0, (leftstr.length - (clip + 3)));
                pad = ".. ";
            } else {
                var num = 48 - (leftstr.length + rightstr.length);
                for (num; num > 0; num--) {
                    pad += " ";
                }
            }
            var row = leftstr + pad + (underline ? esc_ul_on : '') + rightstr + (underline ? font_reset : '') + "\n";
            if (bold) { // format row
                row = esc_bold_on + row + esc_bold_off;
            }
            return row;
        }

        // function getESCPImageString(url, callback) {
        //     img = new Image();
        //     img.onload = function () {
        //         // Create an empty canvas element
        //         //var canvas = document.createElement("canvas");
        //         var canvas = document.createElement('canvas');
        //         canvas.width = img.width;
        //         canvas.height = img.height;
        //         // Copy the image contents to the canvas
        //         var ctx = canvas.getContext("2d");
        //         ctx.drawImage(img, 0, 0);
        //         // get image slices and append commands
        //         var bytedata = esc_init + esc_a_c + getESCPImageSlices(ctx, canvas) + font_reset;
        //         //alert(bytedata);
        //         callback(bytedata);
        //     };
        //     img.src = url;
        // }

        function getESCPImageSlices(context, canvas) {
            var width = canvas.width;
            var height = canvas.height;
            var nL = Math.round(width % 256);
            var nH = Math.round(height / 256);
            var dotDensity = 33;
            // read each pixel and put into a boolean array
            var imageData = context.getImageData(0, 0, width, height);
            imageData = imageData.data;
            // create a boolean array of pixels
            var pixArr = [];
            for (var pix = 0; pix < imageData.length; pix += 4) {
                pixArr.push((imageData[pix] == 0));
            }
            // create the byte array
            var final = [];
            // this function adds bytes to the array
            function appendBytes() {
                for (var i = 0; i < arguments.length; i++) {
                    final.push(arguments[i]);
                }
            }
            // Set the line spacing to 24 dots, the height of each "stripe" of the image that we're drawing.
            appendBytes(0x1B, 0x33, 24);
            // Starting from x = 0, read 24 bits down. The offset variable keeps track of our global 'y'position in the image.
            // keep making these 24-dot stripes until we've executed past the height of the bitmap.
            var offset = 0;
            while (offset < height) {
                // append the ESCP bit image command
                appendBytes(0x1B, 0x2A, dotDensity, nL, nH);
                for (var x = 0; x < width; ++x) {
                    // Remember, 24 dots = 24 bits = 3 bytes. The 'k' variable keeps track of which of those three bytes that we're currently scribbling into.
                    for (var k = 0; k < 3; ++k) {
                        var slice = 0;
                        // The 'b' variable keeps track of which bit in the byte we're recording.
                        for (var b = 0; b < 8; ++b) {
                            // Calculate the y position that we're currently trying to draw.
                            var y = (((offset / 8) + k) * 8) + b;
                            // Calculate the location of the pixel we want in the bit array. It'll be at (y * width) + x.
                            var i = (y * width) + x;
                            // If the image (or this stripe of the image)
                            // is shorter than 24 dots, pad with zero.
                            var bit;
                            if (pixArr.hasOwnProperty(i)) bit = pixArr[i] ? 0x01 : 0x00; else bit = 0x00;
                            // Finally, store our bit in the byte that we're currently scribbling to. Our current 'b' is actually the exact
                            // opposite of where we want it to be in the byte, so subtract it from 7, shift our bit into place in a temp
                            // byte, and OR it with the target byte to get it into the final byte.
                            slice |= bit << (7 - b);    // shift bit and record byte
                        }
                        // Phew! Write the damn byte to the buffer
                        appendBytes(slice);
                    }
                }
                // We're done with this 24-dot high pass. Render a newline to bump the print head down to the next line and keep on trucking.
                offset += 24;
                appendBytes(10);
            }
            // Restore the line spacing to the default of 30 dots.
            appendBytes(0x1B, 0x33, 30);
            // convert the array into a bytestring and return
            final = ArrayToByteStr(final);

            return final;
        }

        /**
         * @return {string}
         */
        function ArrayToByteStr(array) {
            var s = '';
            for (var i = 0; i < array.length; i++) {
                s += String.fromCharCode(array[i]);
            }
            return s;
        }
// ______________End printer Script__________________________
}

// ------------Start Print receipt job model------------------
//end step
// start return billing item table
 var tabledd = $('#settledBillTable').DataTable({

        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/SettledBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3',
        columns: [
            { data: 'transaction_id', name: 'transaction_id' },
            { data: 'product_name', name: 'product_name' },
            { data: 'qty', name: 'qty' },
            { data: 'discount', name: 'discount' },
            { data: 'total_price', name: 'total_price' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action' },
        ],
    });

    $('#settledBillTable tbody').on('click', 'button.returnItemForm', function () {
        var data = tabledd.row( $(this).parents('tr') ).data();
        $('#returnItemFormModal').modal('show');
        $('#returnItemModal').modal('hide');
        $('#returnBtn').removeAttr('disabled');
        $('#return_item_name').text(data.product_name);
        $('#return_discount').val(data.discount);
        $('#return_quantity').val(data.qty);
        $('#return_raw_id').val(data.id);
      
      });
// end return billing item table

// start item return button on form
$('#returnBtn').on('click',function(e){
	$(this).attr('disabled','disabled');
	$('#returnItemModal').modal('show');
    var form = $('#returnItemFormnew');
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
           		if(data.success == true){
           		$('#returnItemFormModal').modal('hide');
                $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'success',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 3000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/definite_flo9zz.ogg");
	                    audio.play();
                  }else if(data.error == true){
                     $.notify({
	                  // where to append the toast notification
	                  wrapper: 'body',

	                  // toast message
	                  message: data.data,

	                  // success, info, error, warn
	                  type: 'error',

	                  // 1: top-left, 2: top-center, 3: top-right
	                  // 4: mid-left, 5: mid-right
	                  // 6: bottom-left, 7: bottom-center, 8: bottom-right
	                  position: 8,

	                  //ltl or 'rtl'
	                  dir: 'ltr',

	                  // enable/disable auto close
	                  autoClose: true,

	                  // timeout in milliseconds
	                  duration: 15000
	                  
	                });
	                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/error_jydv0i.ogg");
	                    audio.play();
                  }
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
    tabledd.ajax.reload( null, false );
})
// end item return button on form
});
// end jquery