$(document).ready(function(){
  var table = $('#reservationDetails').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/hotelreservationDetails',
        columns: [
            { data: 'reservation_ref', name: 'reservation_ref' },            
            { data: 'tour_no', name: 'tour_no' },                       
            { data: 'travelagent_id', name: 'travelagent_id' },
            { data: 'guest', name: 'guest' },
            { data: 'contact', name: 'contact' },
            { data: 'checkin', name: 'checkin' },            
            { data: 'checkout', name: 'checkout' },             
            { data: 'state', name: 'state' },             
            { data: 'action', name: 'action' },            
        ],
    });

$('#reservationDetails tbody').on('click', 'button.detailModel', function () {
    var data = table.row( $(this).parents('tr') ).data();
console.log('rate'+data.rate);
//     if('super_admin' = role){
//         // $("#descrip").prop("readonly",true);
// console.log('loop work1');
//         $('#reservationRef').attr('readonly', true);
//         $('#first_name').attr('readonly', true);
//         $('#last_name').attr('readonly', true);
//         $('#address').attr('readonly', true);
//         $('#email').attr('readonly', true);
//         $('#contact_no').attr('readonly', true);
//         $('#passport').attr('readonly', true);
//         $('#tour_no').attr('readonly', true);
//         $('#check_in').attr('readonly', true);
//         $('#check_out').attr('readonly', true);
//         $('#reservationRateCode').attr('readonly', true);
//         $('#room_count').attr('readonly', true);
//         $('#adult_count').attr('readonly', true);
//         $('#child_count').attr('readonly', true);
//         $('#night_count').attr('readonly', true);
//         $('#advance_payment').attr('readonly', true);
//         $('#special_note').attr('readonly', true);
//         $('#reservationGrossamount').attr('readonly', true);
//         $('#reservation_discount').attr('readonly', true);
//         $('#reservation_type').attr('readonly', true);
//         $('#reservationroomtype').attr('readonly', true);
//         $('#reservation_bed_type').attr('readonly', true);
//         $('#payment_collect').attr('readonly', true);
//     }else{
//       console.log('loop work2');  
//     }
    if(data.nationality == 'lk'){
        $('#rateType').text('Local Rate');
    }else{
        $('#rateType').text('Foreign Rate');
    }
     $('#detailModel').modal('show');
     $('#reservationRef').text(data.reservation_ref);
     $('#first_name').val(data.guest);
     $('#last_name').val(data.last_name);
     $('#address').val(data.address);
     $('#email').val(data.email);
     $('#contact_no').val(data.contact_no);
     $('#passport').val(data.passport_no);
     $('#tour_no').val(data.tour_no);
     $('#check_in').val(data.checkin);
     $('#check_out').val(data.checkout);
     $('#reservationRateCode').val(data.rate_code);
     $('#room_count').val(data.room_count);
     $('#adult_count').val(data.adult_count);
     $('#child_count').val(data.child_count);
     $('#night_count').val(data.night);
     $('#totalPaymentAmount').val(data.rate);
     $('#advance_payment').val(data.advance_payment);
     $('#edit_reservation_id').val(data.id);
     $('#special_note').text(data.special_note);
     $('#reservationGrossamount').text(data.reservationPayment+'LKR');
     $('#reservation_discount').val(data.discount);
     $('#reservation_type option[value='+data.reservation_Type+']').attr('selected','selected');
     $('#reservationroomtype option[value='+data.reservation_room_type+']').attr('selected','selected');
     $('#reservation_bed_type option[value='+data.reservation_bed_type+']').attr('selected','selected');
     $('#payment_collect option[value='+data.payment_collect+']').attr('selected','selected');
     $('#check_in_to option[value='+data.checkinTo+']').attr('selected','selected');
     $('#check_out_after option[value='+data.checkinOutAfter+']').attr('selected','selected');
     $('#countryData option[value='+data.nationality+']').attr('selected','selected');
     $('#travel_agents option[value='+data.travelagent+']').attr('selected','selected');
     // __________________________
     $.ajax({
      type: "post",
      url: '/get-travel-agent-data',
      success: function(data)
      {
        $.each(data,function(index,value){
          // console.log(value.room_no);
          $('#travel_agents').append($('<option>', {
              value: value.id,
              text: value.name,
          }));
        });
      }
    });
     // __________________________
   $.ajax({
      type: "post",
      url: '/get-country-data',
      success: function(data)
      {
        $.each(data,function(index,value){
          // console.log(value.room_no);
          $('#countryData').append($('<option>', {
              value: value.value,
              text: value.name,
          }));
        });
      }
    });
   // __________________________
   console.log(data.nationality);
   var countryValue = data.nationality;
   // $('#countryIcon').addClass('flag-icon flag-icon-'+data.nationality);

  var a =data.reservation_Type;
  var b =data.reservation_room_type;
  var c =data.reservation_bed_type;
   $('#reservation_type').change(function(){
      console.log($(this).val());
      a = $(this).val();
      return public();
   });
   $('#reservationroomtype').change(function(){
      console.log($(this).val());
      b = $(this).val();
      return public();
   });
   $('#reservation_bed_type').change(function(){
      console.log($(this).val());
      c = $(this).val();
      return public();
   });
   $('#room_count').on('keyup',function(){
      return public();
   });
   $('#night_count').on('keyup',function(){
      return public();
   });
   $('#countryData').change(function(){
      // console.log('change');
      countryValue = $('#countryData').val();
      return public();
   });
   // function getGross(){
   //  total = $('#room_count').val() * value.local_rate;
    
   //  $('#reservationGrossamount').text(total+'LKR');
   // }
   function public(){
      if(a != 0 && b != 0 && c != 0){
        console.log('a b c true');
        console.log(a+b+c);
        $('#reservationRateCode').val(a+b+c);
        $.ajax({
          type    : "POST",
          url   : "/get-room-rate-data", 
          success   : function(data)
                    {   
                    // console.log(data); 
                    var tota = '';      
                      $.each( data, function( key, value ) {
                        if(a+b+c == value.rateCode){
                          // console.log('exact match');
                          // console.log(value.local_rate);
                          if (countryValue == 'lk') {
                            $('#totalPaymentAmount').val(value.local_rate);
                            total = $('#room_count').val() * value.local_rate * $('#night_count').val();
                            $('#reservationGrossamount').text(total+'LKR');
                            $('#rateType').text('Local Rate');
                          }else if(countryValue != 'lk'){
                            $('#totalPaymentAmount').val(value.foreign_rate);
                            total = $('#room_count').val() * value.foreign_rate * $('#night_count').val();
                            $('#reservationGrossamount').text(total+'LKR');
                            $('#rateType').text('Foreign Rate');
                          }
                        }else{
                          $('#reservationGrossamount').val(0);
                        }
                      });
                    }
          });
       }else{
        $('#reservationGrossamount').val(0);
       }
   }   
  });
$('#editReservationButton').click(function(e){
    // $('#editReservationForm').submit();
    // console.log($('#edit_reservation_id').val());
    $('#detailModel').modal('hide');
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
});