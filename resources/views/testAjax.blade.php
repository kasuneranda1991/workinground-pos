@extends('master')
@section('pageurl') Home > Stock @stop
@section('pagetitle') Ajax Test @stop
@section('content')
  <div id="carlistdiv">
    
  </div>
  <form id="submitform" action="/data_post" method="post">
    {{ csrf_field() }}
    <input name="shop_name" >
    <input type="button" value="post" id="returnBtn">
  </form>
@stop
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      type    : "POST",
      url   : "/data_123",
      data    : 'json',
      cache   : false,  
      success   : function(data) {          
              // $("#carlistdiv").text(data[0].shop_name);
              $.each( data, function( key, value ) {
                    // alert( key + ": " + value.id );
                    $('#carlistdiv').append("<h1>"+value.shop_name+"</h1");
                  });
              console.log(data);
            } //end function
    });//close ajax

    $('#returnBtn').on('click',function(){
        var form = $('#submitform');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                    $.ajax({
                          type    : "POST",
                          url   : "/data_123",
                          data    : 'json',
                          cache   : false,  
                          success   : function(data) {          
                                  $.each( data, function( key, value ) {
                                  // alert( key + ": " + value.id );
                                  $('#carlistdiv').empty();
                                  $('#carlistdiv').append("<h1>"+value.shop_name+"</h1");
                                });
                                  console.log(data);
                                } //end function
                        });//close ajax
               }
             });

        // e.preventDefault(); // avoid to execute the actual submit of the form.
    });
  });
</script>
@stop