@extends('master')
@section('pageurl') Home > Received Recervation @stop
@section('pagetitle') Your reservation history @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="{{ asset('fullCalender/css/fullcalendar.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.css">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('fullCalender/css/fullcalendar.print.css') }}"> -->
<style>
.fc-title{
  color: white;
}
.fc-content{
  background-color:green; 
}
</style>
@stop
@section('content')
<div id="calendar"></div>
@stop
@section('script')
<script type="text/javascript" src="{{ asset('fullCalender/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('fullCalender/js/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.js"></script>
<script>

  $(document).ready(function() {

   var data = $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      // defaultView: 'listWeek',
      defaultDate: '{{Carbon\Carbon::now()}}',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: function(start, end, timezone, callback,){
         $.ajax({
            url: '{{URL('/roomStatus')}}',
            type: 'get',
            data: {
              // our hypothetical feed requires UNIX timestamps
              start: start.unix(),
              end: end.unix()
            },
            success: function(data) {
              var events = [];
              $.each(data,function(index,value){
                events.push({
                  title: value.tour_no,
                  start: value.checkin, // will be parsed
                  end: value.checkout, // will be parsed
                  description:value.special_note,
                });
              });
              // $.each(function() {
                
              // });
              callback(events);
            }
          });
      },
      eventClick: function(calEvent, jsEvent, view) {
        alert(calEvent.title);
      },
      eventRender: function(event, element) {
        element.qtip({
          content: event.title,
          style: {
            // widget: true, // Use the jQuery UI widget classes
            // def: false, // Remove the default styling (usually a good idea, see below)
            // classes: 'qtip-red',
            color: '#FFFFFF',
          },
          // position: {
          //     my: 'top left',  // Position my top left...
          //     at: 'bottom right', // at the bottom right of...
          //     // target: $('.selector') // my target
          // },
        });
      }
    });

   // console.log(data[0 ]);

  });

</script>
@stop