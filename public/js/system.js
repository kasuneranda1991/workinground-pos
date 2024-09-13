// start project ajax settup
 $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
// start project ajax settup

// stock page ajax pagination==============================================
$(window).on('hashchange', function() {

          if (window.location.hash) {

              var page = window.location.hash.replace('#', '');

              if (page == Number.NaN || page <= 0) {

                  return false;

              }else{

                  getData(page);

              }

          }

      });



  $(document).ready(function()

  {

       $(document).on('click', '.pagination a',function(event)

      {

          event.preventDefault();

          $('li').removeClass('active');

          $(this).parent('li').addClass('active');

          var myurl = $(this).attr('href');

          var page=$(this).attr('href').split('page=')[1];

          getData(page);

      });

  });



  function getData(page){

          $.ajax(

          {

              url: '?page=' + page,

              type: "get",

              datatype: "html"

          })

          .done(function(data)

          {

              $("#history").empty().html(data);

              location.hash = page;

          })

          .fail(function(jqXHR, ajaxOptions, thrownError)

          {

                alert('No response from server');

          });

  }
// stock page ajax pagination==============================================
//count


$(document).ready(function(){
  $("#printform").on('click',function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
               // console.log(data); // show response from the php script.
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
        });
  // end delete user
  });
// ------------End Print receipt job model------------------

// ------------start alert count----------------
  $(document).ready(function(){
     $('#displayCount').text($('#count').val());
  });
// ------------End alert count------------------

// ------------start payment math profile.blade------------------
$(document).ready(function(){
  $('#user_sender_id').empty();
  $('#discount').hide();
  $('#save_price').hide();
    $('#payment_duration').on('change', function() {
      var dd = $(this).val();
      var mo = $('#monthly_starter').val();
      
      if (dd == '3M') {
        var tot = ((mo/100)*90)*3;
        var save = ((mo/100)*10)*3;
        $('#discount').hide();
        $('#save_price').show();
        $('#duration').val(dd);
        $('#total_price').text(tot);
        $('#save').text(save);
        $('#total_amount').val(tot);
      }else if(dd == '6M'){
        $('#discount').hide();
        $('#save_price').show()
        $('#duration').val(dd);;
        var tot = ((mo/100)*85)*6;
        var save = ((mo/100)*15)*6;
        $('#total_price').text(tot);
        $('#save').text(save);
        $('#total_amount').val(tot);
      }else if(dd == '1Y'){
        $('#discount').hide();
        $('#save_price').show();
        $('#duration').val(dd);
        var tot = ((mo/100)*80)*12;
        var save = ((mo/100)*20)*12;
        $('#total_price').text(tot);
        $('#save').text(save);
        $('#total_amount').val(tot);
      }else if(dd == '5Y'){
        $('#discount').hide();
        $('#save_price').show();
        $('#duration').val(dd);
        var tot = ((mo/100)*75)*60;
        var save = ((mo/100)*25)*60;
        $('#total_price').text(tot);
        $('#save').text(save);
        $('#total_amount').val(tot);
      }else if(dd == '1M'){
        $('#save_price').hide();
        $('#discount').show();
        $('#duration').val(dd);
        $('#discount').text('Your Total Price For One Month Rs.' + mo);
        $('#total_amount').val(mo);
      }

    });
    $('#discount').hide();

  $('#save_price').hide();

    $('#advance_payment_duration').on('change', function() {
      var dd = $(this).val();
      var mo = $('#advance_monthly_starter').val();
      
      if (dd == '3M') {
        var tot = ((mo/100)*90)*3;
        var save = ((mo/100)*10)*3;
        $('#advance_discount').hide();
        $('#advance_save_price').show();
        $('#advance_duration').val(dd);
        $('#advance_total_price').text(tot);
        $('#advance_save').text(save);
        $('#advance_total_amount').val(tot);
      }else if(dd == '6M'){
        $('#advance_discount').hide();
        $('#advance_save_price').show()
        $('#advance_duration').val(dd);;
        var tot = ((mo/100)*85)*6;
        var save = ((mo/100)*15)*6;
        $('#advance_total_price').text(tot);
        $('#advance_save').text(save);
        $('#advance_total_amount').val(tot);
      }else if(dd == '1Y'){
        $('#advance_discount').hide();
        $('#advance_save_price').show();
        $('#advance_duration').val(dd);
        var tot = ((mo/100)*80)*12;
        var save = ((mo/100)*20)*12;
        $('#advance_total_price').text(tot);
        $('#advance_save').text(save);
        $('#advance_total_amount').val(tot);
      }else if(dd == '5Y'){
        $('#advance_discount').hide();
        $('#advance_save_price').show();
        $('#advance_duration').val(dd);
        var tot = ((mo/100)*75)*60;
        var save = ((mo/100)*25)*60;
        $('#advance_total_price').text(tot);
        $('#advance_save').text(save);
        $('#advance_total_amount').val(tot);
      }else if(dd == '1M'){
        $('#advance_save_price').hide();
        $('#advance_discount').show();
        $('#advance_duration').val(dd);
        $('#advance_discount').text('Your Total Price For One Month Rs.' + mo);
        $('#advance_total_amount').val(mo);
      }

    });

    $('#expired_payment_duration').on('change', function() {
      var dd = $(this).val();
      var mo = $('#expired_monthly_starter').val();
      
      if (dd == '3M') {
        var tot = ((mo/100)*90)*3;
        var save = ((mo/100)*10)*3;
        $('#expired_discount').hide();
        $('#expired_save_price').show();
        $('#expired_duration').val(dd);
        $('#expired_total_price').text(tot);
        $('#expired_save').text(save);
        $('#expired_total_amount').val(tot);
      }else if(dd == '6M'){
        $('#expired_discount').hide();
        $('#expired_save_price').show()
        $('#expired_duration').val(dd);;
        var tot = ((mo/100)*85)*6;
        var save = ((mo/100)*15)*6;
        $('#expired_total_price').text(tot);
        $('#expired_save').text(save);
        $('#expired_total_amount').val(tot);
      }else if(dd == '1Y'){
        $('#expired_discount').hide();
        $('#expired_save_price').show();
        $('#expired_duration').val(dd);
        var tot = ((mo/100)*80)*12;
        var save = ((mo/100)*20)*12;
        $('#expired_total_price').text(tot);
        $('#expired_save').text(save);
        $('#expired_total_amount').val(tot);
      }else if(dd == '5Y'){
        $('#expired_discount').hide();
        $('#expired_save_price').show();
        $('#expired_duration').val(dd);
        var tot = ((mo/100)*75)*60;
        var save = ((mo/100)*25)*60;
        $('#expired_total_price').text(tot);
        $('#expired_save').text(save);
        $('#expired_total_amount').val(tot);
      }else if(dd == '1M'){
        $('#expired_save_price').hide();
        $('#expired_discount').show();
        $('#expired_duration').val(dd);
        $('#expired_discount').text('Your Total Price For One Month Rs.' + mo);
        $('#expired_total_amount').val(mo);
      }

    });

    $('#economy_payment_duration').on('change', function() {
      var dd = $(this).val();
      var mo = $('#economy_monthly_starter').val();
      
      if (dd == '3M') {
        var tot = ((mo/100)*90)*3;
        var save = ((mo/100)*10)*3;
        $('#economy_discount').hide();
        $('#economy_save_price').show();
        $('#economy_duration').val(dd);
        $('#economy_total_price').text(tot);
        $('#economy_save').text(save);
        $('#economy_total_amount').val(tot);
      }else if(dd == '6M'){
        $('#economy_discount').hide();
        $('#economy_save_price').show()
        $('#economy_duration').val(dd);;
        var tot = ((mo/100)*85)*6;
        var save = ((mo/100)*15)*6;
        $('#economy_total_price').text(tot);
        $('#economy_save').text(save);
        $('#economy_total_amount').val(tot);
      }else if(dd == '1Y'){
        $('#economy_discount').hide();
        $('#economy_save_price').show();
        $('#economy_duration').val(dd);
        var tot = ((mo/100)*80)*12;
        var save = ((mo/100)*20)*12;
        $('#economy_total_price').text(tot);
        $('#economy_save').text(save);
        $('#economy_total_amount').val(tot);
      }else if(dd == '5Y'){
        $('#economy_discount').hide();
        $('#economy_save_price').show();
        $('#economy_duration').val(dd);
        var tot = ((mo/100)*75)*60;
        var save = ((mo/100)*25)*60;
        $('#economy_total_price').text(tot);
        $('#economy_save').text(save);
        $('#economy_total_amount').val(tot);
      }else if(dd == '1M'){
        $('#economy_save_price').hide();
        $('#economy_discount').show();
        $('#economy_duration').val(dd);
        $('#economy_discount').text('Your Total Price For One Month Rs.' + mo);
        $('#economy_total_amount').val(mo);
      }

    });

    // new start
    if($('#payment_plan').val() != 'demo'){
      $('#my_save_price').hide();
      $('#payment_duration_selector').on('change',function(){
        // console.log($('#payment_duration_selector').val());
  
        // -------------------------------
        $('#my_save_price').show();
         var mrate = $('#monthly_rate').val();
         var dd = $('#payment_duration_selector').val();
        // -------------------------------
        if (dd == '1M') {
          $('#user_sender_id').empty();
            var tot = ((mrate/100)*100)*1;
            var save = ((mrate/100)*0)*1;
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }else if (dd == '3M') {
            $('#user_sender_id').empty();
            var tot = ((mrate/100)*90)*3;
            var save = ((mrate/100)*10)*3;
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }else if (dd == '6M') {
            $('#user_sender_id').empty();
            var tot = ((mrate/100)*85)*6;
            var save = ((mrate/100)*15)*6;
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }else if (dd == '1Y') {
            $('#user_sender_id').empty();
            var tot = ((mrate/100)*80)*12;
            var save = ((mrate/100)*20)*12;
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }else if (dd == '5Y') {
            $('#user_sender_id').empty();
            var tot = ((mrate/100)*75)*60;
            var save = ((mrate/100)*25)*60;
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }else if (dd == 'sender_id') {
            var tot = ((2500/100)*100)*1;
            var save = ((2500/100)*0)*1;
            $('#user_sender_id').append('<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Your Sender ID</span></div><input type="text" class="form-control" maxlength="11" placeholder="Ex:-Shop Name"  name="request_sender_id"></div></div>');
            $('#my_discount').hide();
            $('#my_save_price').show();
            $('#my_duration').val(dd);
            $('#my_total_price').text(tot);
            $('#my_save').text(save);
            $('#my_total_amount').val(tot);
            $('#monthly_rate').val(mrate);
          }
        // -------------------------------

      });
    }
  });
// ------------End payment math profile.blade------------------

if($('#base_url').val() == $('#stockURL').val()){
  // ------------start stock js------------------
$(document).ready(function(){
  $('#directionS').prop('disabled','disabled');
  $('#rowS').prop('disabled','disabled');
  $('#columnS').prop('disabled','disabled');
    var table = $('#product').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/CurrentSockProductDataShouldBeEncriptedToRemoveUnauthorizedAccess',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'location_code', name: 'code' },
            { data: 'product_name', name: 'product_name' },
            { data: 'current_qty', name: 'qty_remain' },
            { data: 'selling_price', name: 'unit_price' },
            { data: 'avarage_sale', name: 'avarage_sale' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action' },
            
        ],
        dom: 'lBfrtip',
        buttons: [
                    { extend: 'copyHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'excelHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'pdfHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                    {
                      text: 'add New Item',
                      className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
                      action: function () {
                          $('#add-item-model').modal('show');
                          $('#directione').prop('disabled','disabled');
                          $('#rowe').prop('disabled','disabled');
                          $('#columne').prop('disabled','disabled');
                      },init: function(api, node, config) {
                         $(node).removeClass('dt-button buttons-copy buttons-html5')
                      },
                    }
                ],
                select: {
                    style: 'os',
                    blurable: true
                },
            //     buttons: [
            //     {
            //         text: 'Reload',
            //         action: function ( e, dt, node, config ) {
            //             dt.ajax.reload();
            //         }
            //     }
            // ],
    });

    $('#product tbody').on('click', 'button.updateItemModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        // alert( 'You clicked on update '+data.id+'\'s row' );
        $('#updateItemname').text(data.product_name);
        $('#update_product_id').val(data.id);
    } );

    $('#product tbody').on('click', 'button.editItemModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var direction = data.direction;
        var row = data.row;
        var column = data.column;
        $('#edit_item_form').trigger("reset");
        
        if(data.direction){
          // console.log('checked true');
          $('#editlocationService').prop('checked',true);
          $('#directionS').prop('disabled',false);
          $('#rowS').prop('disabled',false);
          $('#columnS').prop('disabled',false);
        }
        // alert( 'You clicked on edit'+data.id+'\'s row' );
        $('#editItemName').text(data.product_name);
        $('#Edit_product_name').val(data.productName);
        $('#item_type').val(data.type_name);
        $('#count_type').val(data.count_type);
        $('#company_name').val(data.company_name);
        $('#selling_price').val(data.selling_price);
        $('#alert').val(data.stock_remainder);
        $('#productid').val(data.id);
        $('#product_type_id').val(data.type_id);
        $('#currentLocationCode').text(data.location_code);
        $('#directionS option[value='+direction+']').attr('selected','selected');
        $('#rowS option[value='+row+']').attr('selected','selected');
        $('#columnS option[value='+column+']').attr('selected','selected');

        $('#directionS').val(direction);
        $('#rowS').val(row);
        $('#columnS').val(column);
    } );
    $('#product tbody').on('click', 'button.discardItemModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        // alert( 'You clicked on discard'+data.id+'\'s row' );
        $('#discard_product_id').val(data.id);
    } );
    $('#product tbody').on('click', 'button.deleteItemModel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $('#deleteItem1').text(data.product_name);
        $('#product_id').val(data.id);
        $('#product_quantity').val(data.current_qty);
        // alert( 'You clicked on delete'+data.id+'\'s row' );
    } );
  $('#addlocationService').click(function(){
    // alert('work click');
    // console.log($('#locationService').val());
    if($('#addlocationService').prop('checked') == true){
      // console.log('checked');
      $('#directione').prop('disabled',false);
      $('#rowe').prop('disabled',false);
      $('#columne').prop('disabled',false);
    }else{
      // console.log('unchecked');
      $('#directione').prop('disabled','disabled');
      $('#rowe').prop('disabled','disabled');
      $('#columne').prop('disabled','disabled');
    }
  });
  $('#editlocationService').click(function(){
    // alert('work click');
    // console.log($('#locationService').val());
    if($('#editlocationService').prop('checked') == true){
      // console.log('checked');
      $('#directionS').prop('disabled',false);
      $('#rowS').prop('disabled',false);
      $('#columnS').prop('disabled',false);
    }else{
      // console.log('unchecked');
      $('#directionS').prop('disabled','disabled');
      $('#rowS').prop('disabled','disabled');
      $('#columnS').prop('disabled','disabled');
    }
  });

  $('#productaddbtn').click(function(e){
    $('#add-item-model').modal('hide');
    var form = $('#addNewItemForm');
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 10000
                  
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
                  position: 3,

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
    var table = $('#product').DataTable();
    table.ajax.reload( null, false );
  });

  // delete item button start
  $('#deleteItemButton').click(function(e){
    $('#deleteItem').modal('hide');
    var form = $('#deleteitemform');
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 4000
                  
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
                  position: 3,

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
    var table = $('#product').DataTable();
    table.ajax.reload( null, false );
  });
  // delete item button end

  // discard item form start
  $('#discardItemButton').click(function(e){
    $('#discardItem').modal('hide');
    var form = $('#discardform');
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 4000
                  
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
                  position: 3,

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
    var table = $('#product').DataTable();
    table.ajax.reload( null, false );
    var tableDis = $('#discardItemTable').DataTable();
    tableDis.ajax.reload( null, false );
  });
  // discard item form end

  // update item form start
  $('#updateBtn').click(function(e){
    $('#updateItem').modal('hide');
    var form = $('#updateform');
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 10000
                  
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
                  position: 3,

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
    var table = $('#product').DataTable();
    table.ajax.reload( null, false );
  });
  // update item form end

  // edit product item form start
  $('#editProductBtn').click(function(e){
    $('#editItem').modal('hide');
    var form = $('#edit_item_form');
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 3000
                  
                });
                var audio = new Audio("https://res.cloudinary.com/workinground/video/upload/v1556016673/sound/error_jydv0i.ogg");
                    audio.play();
              }
           },
         });
    e.preventDefault();
    var table = $('#product').DataTable();
    table.ajax.reload( null, false );
  });
  // edit product item form end
});
// ------------end stock js------------------
}

// ------------start discard table js------------------
if($('#base_url').val() == $('#stockURL').val()){
  $(document).ready(function(){
//start discard item table
var table = $('#discardItemTable').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/DiscardItemsDataShouldBeEncriptedToRemoveUnauthorizedAccess',
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'reason', name: 'reason' },
            { data: 'quantity', name: 'quantity' },
            { data: 'batch_no', name: 'batch_no' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action' },
            
        ],
        dom: 'lBfrtip',
        buttons: [
                    { extend: 'copyHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'excelHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'pdfHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
                       $(node).removeClass('dt-button buttons-copy buttons-html5')
                    } },
                ],
                select: {
                    style: 'os',
                    blurable: true
                },
            //     buttons: [
            //     {
            //         text: 'Reload',
            //         action: function ( e, dt, node, config ) {
            //             dt.ajax.reload();
            //         }
            //     }
            // ],
    });
// start discard item pending button approveItem
$('#discardItemTable tbody').on('click', 'button.approveItem', function (e) {
  var data = table.row( $(this).parents('tr') ).data();
  // alert( 'You clicked on discard'+data.id+'\'s row' );
  $('#approve_id').val(data.id);
  var form = $('#discardItemApproveform');
  var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 4000
                  
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
                  position: 3,

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
    // var table = $('#product').DataTable();
    table.ajax.reload( null, false );
} );
// end discard item pending button

// start discard item disapprove button approveItem
$('#discardItemTable tbody').on('click', 'button.disApproveItem', function (e) {
  var data = table.row( $(this).parents('tr') ).data();
  // alert( 'You clicked on discard'+data.id+'\'s row' );
  $('#approve_id').val(data.id);
  $('#disapprove_state').val(1);
  var form = $('#discardItemApproveform');
  var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              // console.log('success');
              // $('#addNewItemForm').reset();
              if(data.success == true){
                $("form").trigger("reset");
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
                  position: 3,

                  //ltl or 'rtl'
                  dir: 'ltr',

                  // enable/disable auto close
                  autoClose: true,

                  // timeout in milliseconds
                  duration: 4000
                  
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
                  position: 3,

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
    // var table = $('#product').DataTable();
    table.ajax.reload( null, false );
} );
// end discard item disapprove button

//end discard item table
});
}
// ------------end discard table js------------------



