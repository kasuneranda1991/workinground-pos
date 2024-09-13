$(document).ready(function(){
 //start payment confirmation table
var tableData = $('#confirmationTable').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/paymentConfirmationData',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'payment_state', name: 'payment_state' },
            { data: 'collect_method', name: 'collect_method' },
            { data: 'advance_payment', name: 'advance_payment' },
            { data: 'discount', name: 'discount' },
            { data: 'total_payment', name: 'total_payment' },
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
            {
              text: 'Refresh',
              className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
              action: function ( e, dt, node, config ) {
                  dt.ajax.reload();
              },init: function(api, node, config) {
                 $(node).removeClass('dt-button buttons-copy buttons-html5')
              },
            },
        ],
  });
//end payment confirmation table

//click confirm start
$('#confirmationTable tbody').on('click', 'button.confirmButton', function () {
	console.log('confirmed');
	var data = tableData.row( $(this).parents('tr') ).data();
	$('#confirm_payment_id').val(data.id);
	var form = $('#editReservationForm');
      var url = form.attr('action');
      $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              if(data.success == true){
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
                var audio = new Audio("sound/definite.ogg");
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
                  duration: 6000
                  
                });
                var audio = new Audio("sound/error.ogg");
                    audio.play();
              }
           },
         });
      e.preventDefault();
      var table = $('#reservationDetails').DataTable();
      table.ajax.reload( null, false );
	});
//click confirm end

//click reject start
$('#confirmationTable tbody').on('click', 'button.rejectmButton', function () {
	console.log('confirmed');
	var data = tableData.row( $(this).parents('tr') ).data();
	$('#reject_payment_id').val(data.id);
	});
//click reject end
});