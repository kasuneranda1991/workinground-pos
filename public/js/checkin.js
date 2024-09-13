$(document).ready(function(){
  $('#available_room_no').select2({
      placeholder: 'Select Rooms'
    });
// __________________________
var table = $('#checkinTable').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/checkingData',
        columns: [
            { data: 'nationality', name: 'nationality' },
            { data: 'reservation_ref', name: 'id' },
            { data: 'guest_name', name: 'guest_name' },
            { data: 'special_note', name: 'special_note' },
            { data: 'passport', name: 'passport' },
            { data: 'night', name: 'night' },
            { data: 'contact', name: 'contact' },
            { data: 'rate_code', name: 'rate_code' },
            { data: 'action', name: 'action' },
            ],
        });
// __________________________
$('#checkinTable tbody').on('click', 'button.deleteReservationModal', function () {
    var data = table.row( $(this).parents('tr') ).data();
    console.log('he');
    $('#deleteReservationModal').modal('show');
    $('#noshow-reservation_id').val(data.id);
  });
// __________________________
$('#noshowButton').on('click',function(e){
  $('#deleteReservationModal').modal('hide');
var form = $('#deleteReservationform');
var url = form.attr('action');
$.ajax({
       type: "POST",
       url: url,
       data: form.serialize(), // serializes the form's elements.
       success: function(data)
       {
        $('#available_room_no').empty();
          console.log('Guest Checked IN'); // show response from the php script.
          console.log(data); // show response from the php script.
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
var table = $('#checkinTable').DataTable();
table.ajax.reload( null, false );
});
// __________________________
$('#checkinTable tbody').on('click', 'button.checkingModal', function () {
    var data = table.row( $(this).parents('tr') ).data();
    console.log('ce');
    $('#checkingModal').modal('show');
    $('#reservation_id').val(data.id);
  });
// __________________________
$('#checkinSubmit').click(function(e){

  // $('#checkinForm').submit();
  console.log($('#available_room_no').val());
  $('#checkingModal').modal('hide');
  var form = $('#checkinForm');
  var url = form.attr('action');
  $.ajax({
         type: "POST",
         url: url,
         data: form.serialize(), // serializes the form's elements.
         success: function(data)
         {
          $('#available_room_no').empty();
            $.ajax({
                type: "post",
                url: '/get-available-room-data',
                success: function(data)
                {
                  $.each(data,function(index,value){
                    // console.log(value.room_no);
                    $('#available_room_no').append($('<option>', {
                        value: value.id,
                        text: value.room_no,
                    }));
                  });
                }
              });
            // reloadRoomData();
            console.log('Guest Checked IN'); // show response from the php script.
            console.log(data); // show response from the php script.
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
  var table = $('#checkinTable').DataTable();
  table.ajax.reload( null, false );
});
window.onload = reloadRoomData();
// __________________________
function reloadRoomData() {
  $.ajax({
      type: "post",
      url: '/get-available-room-data',
      success: function(data)
      {
        $.each(data,function(index,value){
          // console.log(value.room_no);
          $('#available_room_no').append($('<option>', {
              value: value.id,
              text: value.room_no,
          }));
        });
      }
    });
}
// __________________________

});