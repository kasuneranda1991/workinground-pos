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
            var description = "Description:"+document.getElementById("description").value;
            var priority = "Priority:"+document.getElementById("priority").value;
            var price = "Price:Rs."+document.getElementById("job_price").value;
            var remark = "Remark:"+document.getElementById("remark").value;
            var shop_name = document.getElementById("shop_name").value;
            var address = document.getElementById("address").value;
            var city = document.getElementById("city").value;
            var contact_no = document.getElementById("contact_no").value;
            var time = document.getElementById("time").value;
            var cashier = document.getElementById("cashier").value;
            var jobNo = document.getElementById("jobNo").value;
            var advance = "Advance:Rs."+document.getElementById("advance_payment").value;
        
            var data = '';
            if (image)
            //     data+= imgData; // add the logo
            // data+= esc_init + esc_a_c + esc_double + 'Heading Text' + "\n" + font_reset; // heading centered example
            // data+= esc_bold_on + 'bold text' + "\n"  + font_reset; // bold example
            // data+= 'standard text' + "\n"; // normal
            // data+= esc_a_r + 'right aligned text' + "\n" + font_reset; // right aligned
            // data+= esc_a_l + esc_ul_on + 'underlined text' + "\n" + font_reset; // underlined
            // data+= esc_bold_on + esc_ul_on + 'bold underlined text' + "\n"  + font_reset; // bold underlined
            // 2 column table
            // data+= getEscTableRow("left text", "right text", false, false);
            // data+= getEscTableRow("left text", "right text", true, true);
            // cut the ticket
            data+= esc_init + esc_a_c + esc_double + shop_name + "\n" + esc_font_A;
            data+=esc_a_c +'Job Receive Note' + "\n";
            data+=esc_a_c + contact_no + "\n";
            data+=esc_a_c + address + "\n";
            data+=esc_a_c + city + "\n";
            data+=esc_a_l + 'Teller:'+ cashier + "\n";
            data+=esc_a_l + 'Time:'+ time + "\n";
            data+=esc_a_l + 'Job No:#'+ jobNo + "\n";
            data+=esc_a_c + '________________________________________________________'+ "\n";
            data+=esc_a_l + description + "\n";
            data+=priority + "\n";
            data+=remark + "\n";
            data+=advance + "\n";
            data+=esc_a_c + '________________________________________________________'+ "\n" + font_reset;
            data+=esc_bold_on + price + "\n" + esc_font_A + esc_bold_off;
            data+=esc_a_c + '________________________________________________________'+ "\n";
            data+=esc_a_c + 'Thank You.Come Again'+ "\n";
            data+=esc_a_c + 'Copyright'+'\u00A9'+"workinground.com"+ "\n";
            data+=esc_a_c + "All Rights Reserved";
            data+=esc_line_feed;
            data+=esc_line_feed;
            data+=esc_line_feed;
            if (cut)
                data+= "\n\n\n\n" + gs_cut + "\r";

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

// ------------Start Print receipt job model------------------