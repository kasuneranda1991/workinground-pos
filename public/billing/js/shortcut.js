$(document).ready(function(){

// start event
Mousetrap.bind('shift+f', function(e){
	e.preventDefault();
	$('#finalizeBilModal').modal('show');
	$('#finishBillBtn').removeAttr('Disabled');
	$('#cash_amount').val(null);
    $('#customer_no').val(null);
    $('#cash_amount').focus();
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
// end event

// start event
Mousetrap.bind('shift+h', function(e){
	$('#helpModal').modal('show');
});
// end event

// start event
Mousetrap.bind('shift+r', function(e){
	$('#returnItemModal').modal('show');
});
// end event

// start event
Mousetrap.bind('esc', function(e){
	$('.modal').modal('hide');
	$('.search-bar').removeClass('open');
	$('body').removeClass('overlay-open');
	// $('.navbar-collapse').removeClass('in').removeAttr('style');
});
// end event

// start event
Mousetrap.bind('shift+c', function(e){
	var data = $('#shoppingCart').DataTable();
	data.ajax.reload( null, false );
	$('#cartModal').modal('show');
});
// end event

// start event
Mousetrap.bind('shift+s', function(e){
	e.preventDefault();
	$('.search-bar').addClass('open');
	$('.prompt').focus();
});
// end event
// start event
Mousetrap.bind('shift+tab', function(e){
	// $('.search-bar').addClass('open');
	$('body').toggleClass('overlay-open');
});
// end event

});