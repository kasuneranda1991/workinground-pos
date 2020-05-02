@extends('master')
@section('web-page-title') {{ Auth::user()->shop->shop_name }} Analysis Reports @stop
@section('pageurl') Home > Reports @stop
@section('pagetitle') Shop Sales Reports @stop
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.css">
<style>
	.bgc-1{
		background: -moz-linear-gradient(45deg, rgba(0,255,102,1) 22%, rgba(0,206,128,1) 51%, rgba(0,179,142,1) 67%, rgba(0,156,156,1) 81%); /* ff3.6+ */
		background: -webkit-gradient(linear, left bottom, right top, color-stop(22%, rgba(0,255,102,1)), color-stop(51%, rgba(0,206,128,1)), color-stop(67%, rgba(0,179,142,1)), color-stop(81%, rgba(0,156,156,1))); /* safari4+,chrome */
		background: -webkit-linear-gradient(45deg, rgba(0,255,102,1) 22%, rgba(0,206,128,1) 51%, rgba(0,179,142,1) 67%, rgba(0,156,156,1) 81%); /* safari5.1+,chrome10+ */
		background: -o-linear-gradient(45deg, rgba(0,255,102,1) 22%, rgba(0,206,128,1) 51%, rgba(0,179,142,1) 67%, rgba(0,156,156,1) 81%); /* opera 11.10+ */
		background: -ms-linear-gradient(45deg, rgba(0,255,102,1) 22%, rgba(0,206,128,1) 51%, rgba(0,179,142,1) 67%, rgba(0,156,156,1) 81%); /* ie10+ */
		background: linear-gradient(45deg, rgba(0,255,102,1) 22%, rgba(0,206,128,1) 51%, rgba(0,179,142,1) 67%, rgba(0,156,156,1) 81%); /* w3c */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#009C9C', endColorstr='#00FF66',GradientType=1 ); /* ie6-9 */
	}
	.bgc-2{
		background: -moz-linear-gradient(45deg, rgba(202,186,255,1) 0%, rgba(47,214,75,1) 100%); /* ff3.6+ */
background: -webkit-gradient(linear, left bottom, right top, color-stop(0%, rgba(202,186,255,1)), color-stop(100%, rgba(47,214,75,1))); /* safari4+,chrome */
background: -webkit-linear-gradient(45deg, rgba(202,186,255,1) 0%, rgba(47,214,75,1) 100%); /* safari5.1+,chrome10+ */
background: -o-linear-gradient(45deg, rgba(202,186,255,1) 0%, rgba(47,214,75,1) 100%); /* opera 11.10+ */
background: -ms-linear-gradient(45deg, rgba(202,186,255,1) 0%, rgba(47,214,75,1) 100%); /* ie10+ */
background: linear-gradient(45deg, rgba(202,186,255,1) 0%, rgba(47,214,75,1) 100%); /* w3c */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2FD64B', endColorstr='#CABAFF',GradientType=1 ); /* ie6-9 */
	}
	.bgc-3{
		/*background-image: linear-gradient(to right top, #d16ba5, #c777b9, #ba83ca, #aa8fd8, #9a9ae1, #84a1e6, #6ea7e7, #58ade4, #2eb0dc, #00b2ce, #00b2bc, 
		#0cb1a7);*/
		/*background-image: linear-gradient(to right, #051937, #3b1f58, #7e0a60, #ba004a, #de1616);*/
		/*background-image: linear-gradient(to right, #051937, #311a48, #5e0947, #830033, #960c0c);*/
		background-image: linear-gradient(to right bottom, #273f64, #4e426a, #6e4568, #864b60, #965656);
	}
	.bgc-4{
		background-image: linear-gradient(to right bottom, #bc5c7e, #b76b54, #988048, #738f5f, #569685);
	}
</style>
@stop
@section('content')
<!-- start sales analysis chart -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small ">
    	<div class="card-header border-bottom">
        	<h6 class="m-0">Daily Sale Analysis</h6>
        </div>
        <div class="card-body pt-0">
        <div class="row border-bottom py-2">
        	<form action="/sales-chart-data-flow" id="saleChartForm">
           	<div class="col-md-12">
            {{ csrf_field() }}
            	<div class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" >
                    <input type="date" class="input-sm form-control" id="start_date" name="start_date" placeholder="Start Date" value="{{ \Carbon\Carbon::now()->subDays(10)->format('Y-m-d') }}" data-toggle="tooltip" data-placement="top" title="Enter Sales Start Date">
                    <input type="date" class="input-sm form-control" id="end_date" name="end_date" placeholder="End Date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-toggle="tooltip" data-placement="top" title="Enter Sales End Date">
                    <input type="text" class="input-sm form-control valied_number" name="step_size" placeholder="Scale" value="10000" data-toggle="tooltip" data-placement="top" title="You Can Change Scale Here">
                    
                 	<div class="btn-group btn-group-sm">
                        <button type="button" id="updateBtn" class="btn btn-white">
                        	<span class="text-success"><i class="material-icons">autorenew</i></span> Update
                        </button>
                    </div>
                </div>
            
            </div>
           	</form>
        </div>
        <canvas id="sale_report" height="234" style="max-width: 100% !important; display: block; width: 542px; height: 234px;" class="blog-overview-users chartjs-render-monitor" width="542"></canvas>
        </div>
    </div>
</div>
<!-- end salses analysis chart -->

<!-- start month expence analysis chart -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small ">
    	<div class="card-header border-bottom">
        	<h6 class="m-0">Monthly Analysis Report</h6>
        </div>
        <div class="card-body pt-0">
        <div class="row border-bottom py-2 bg-light">
        	<form action="/expenceDataFlow" id="ExpencePieChartForm">
        	<div class="row">
                <div class="col">
                    <select name="month" class="custom-select custom-select-sm" style="max-width: 400px;">
                        <option value="0" selected="">Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="col">
                    <select name="year" class="custom-select custom-select-sm" style="max-width: 400px;">
                        <option value="0" selected="">Select Year</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" id="expenceupdateBtn" class="btn btn-white">
                    	<span class="text-success"><i class="material-icons">autorenew</i></span> Update
                    </button>
                </div>
            </div>
            </form>
        </div>
        <canvas id="monthy_analysis" height="234" style="max-width: 100% !important; display: block; width: 542px; height: 234px;" class="blog-overview-users chartjs-render-monitor" width="542"></canvas>
        </div>
    </div>
</div>
<!-- end month expence analysis chart -->

<!-- start void report table -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small ">
    	<div class="card-header border-bottom">
        	<h6 id="voidtable-title" class="m-0">Void Sales Report</h6>
        </div>
        <div class="card-body pt-0">
        <!-- ________________________ -->
        <table class="ui single line table left aligned selectable green small compact" style="width: 100%;" id="voidData">
		    <thead>
		        <tr>
		            <th scope="col" data-orderable='false'>Bill NO</th>
		            <th scope="col"data-orderable='false'>Product Name</th>
		            <th scope="col">Sale Type</th>
		            <th scope="col">Quantity</th>
		            <th scope="col">Reason</th>
		            <th scope="col">User</th>
		            <th scope="col">Date</th>
		            <!-- <th scope="col">action</th> -->
		        </tr>
		    </thead>
		</table>
        <!-- ________________________ -->
        </div>
    </div>
</div>
<!-- end void report table -->

<!-- start sales report table -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small ">
    	<div class="card-header border-bottom">
        	<h6 id="billwise-table-title" class="m-0">Bill wise Sales Report</h6>
        </div>
        <div class="card-body pt-0">
        <!-- ________________________ -->
        <table class="ui single line table left aligned selectable green small compact" style="width: 100%;" id="salesData">
		    <thead>
		        <tr>
		            <th scope="col" data-orderable='false'>Bill NO</th>
		            <th scope="col"data-orderable='false'>Product Name</th>
		            <th scope="col">Sale Type</th>
		            <th data-orderable="false"></th>
		            <th scope="col">Quantity</th>
		            <th scope="col">Discount(%)</th>
		            <th scope="col">Item Total Price(LKR)</th>
		            <th scope="col">Teller</th>
		            <th scope="col">Bill Date</th>
		            <!-- <th scope="col">action</th> -->
		        </tr>
		    </thead>
		</table>
        <!-- ________________________ -->
        </div>
    </div>
</div>
<!-- end sales report table -->

<!-- start item wise report table -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small">
    	<div class="card-header border-bottom">
        	<h6 id="itemwise-table-title" class="m-0">Itemwise Report</h6>
        	<em class="m-0">All Records showing in Sri lankan Rupees</em>
        </div>
        <div class="card-body pt-0">
        <!-- ________________________ -->
        <table class="ui single line table left aligned selectable green small compact" style="width: 100%;" id="itemWiseTable">
		    <thead>
		        <tr>
		            <th scope="col">#</th>
		            <th scope="col" data-orderable='false'>L.Code</th>
		            <th scope="col" >Product</th>
		            <th scope="col" >Qty</th>
		            <th scope="col" >Discount</th>
		            <th scope="col" >Total</th>
		        </tr>
		    </thead>
		</table>
        <!-- ________________________ -->
        </div>
    </div>
</div>
<!-- end item wise report table -->

<!-- start item wise report table -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small">
    	<div class="card-header border-bottom">
        	<h6 id="table-title" class="m-0">Cash Reconsilation Report</h6>
        	<em class="m-0">All Records showing in Sri lankan Rupees</em>
        </div>
        <div class="card-body pt-0">
        <!-- ________________________ -->
        <table class="ui single line table left aligned selectable green small compact" style="width: 100%;" id="cashReconsilation">
		    <thead>
		        <tr>
		            <th scope="col">date</th>
		            <th scope="col" data-orderable='false'>T.Cash Sale</th>
		            <th scope="col" data-orderable='false'>T.Credit Sale</th>
		            <th scope="col" data-orderable='false'>Void Cash Sale</th>
		            <th scope="col" data-orderable='false'>Void Credit Sale</th>
		            <th scope="col" data-orderable='false'>Discount Cash Sale</th>
		            <th scope="col" data-orderable='false'>Discount Credit Sale</th>
		            <th scope="col" data-orderable='false'>Total Sale</th>
		        </tr>
		    </thead>
		</table>
        <!-- ________________________ -->
        </div>
    </div>
</div>
<!-- end item wise report table -->

<!-- <h3>Input</h3>
<div class="ui calendar" id="example1">
  <div class="ui input left icon">
    <i class="calendar icon"></i>
    <input type="text" placeholder="Date/Time">
  </div>
</div> -->

@stop
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.js"></script>
<script>
$(document).ready(function(){
	var date = '{{ Carbon\Carbon::now() }}';
	var dates = new Array();
	var sales = new Array();
	var cost = new Array();
	var profit = new Array();
	var expCatogery = new Array();
	var expence = new Array();
	// var expCatogery = ['A','B','C',];
	// var expence = [15,52,41];
	var min = 0;
	var stepSize;
	// window.onload = createSalesChart();
	// start chart form submit
	$('#updateBtn').click(function(e){
		var form = $('#saleChartForm');
        var url = form.attr('action');
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
               		createSalesChart(data);  
               }
             });
	});
	// end chart form submit

	// start expence pie chart form submit
	$('#expenceupdateBtn').click(function(e){
		var form = $('#ExpencePieChartForm');
        var url = form.attr('action');

        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
               		expencePieChart(data);  
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
	});
	// end expence pie chart form submit

	// start chart
	function createSalesChart(data) {
			dates = [];
			sales = [];
			cost = [];
			profit = [];
			min = 0;
			stepSize = 0;
	   		console.log(data.success);
			// console.log(data.sales);
			stepSize = data.stepSize;
			$.each(data.sales,function(index,value){
				// console.log(index);
				dates.push(index);
				sales.push(value);
		    });
		    $.each(data.cost,function(index,value){
				// console.log(index);
				cost.push(value);
		    });
		    $.each(data.profit,function(index,value){
				// console.log(index);
				profit.push(value);
		    });
		    // console.log(dates);

	       	var sale = document.getElementById("sale_report");
			var myChart = new Chart(sale, {
			    type: 'line',
			    data: {
			        labels: dates,
			        //Start sales data
			        datasets: [

			        	//start sales 
			      		{
				            label: 'Daily Sale Rs',
				            data:sales,
				            backgroundColor: [
				                'rgba(72,192,114, 0.2)',
				            ],
				            borderColor: [
				                'rgba(72,192,114)',
				            ],
				            borderWidth: 1
				        },
				        // end sales

				        //start cost
				        {
				            label: 'Daily Item Cost Rs',
				            data:cost,
				            backgroundColor: [
				                'rgba(42,57,122, 0.2)',
				            ],
				            borderColor: [
				                'rgba(42,57,122)',
				            ],
				            borderWidth: 1
				        },
				        // end cost

				        //start profit
				        {
				            label: 'Daily Profit from Items Rs',
				            data:profit,
				            backgroundColor: [
				                'rgba(236,19,216, 0.2)',
				            ],
				            borderColor: [
				                'rgba(236,19,216)',
				            ],
				            borderWidth: 1
				        },
				        //end profit        
			        ],
			        //end sales data
			    },
			    options: {
			        scales: {
			            yAxes: [{
			      			scaleLabel: { display:true,labelString: ["Sri Lankan Rupees(LKR)"] },
			      			ticks: { min:min, stepSize:stepSize, suggestedMin: 10, suggestedMax: 5.5 },
			      			gridLines: {display: true},
			    		}],
			    		xAxes: [{
					        display: true,
					        scaleLabel: { display:true,labelString: ["Sales Date"] },
					        position: 'bottom',
					        //type: 'linear',

					        ticks: {
						        display:true,          
						        min: 1,
						        max: 31,
						        stepSize: 10,
						        autoSkip: true
					        }
					    }]
			        }
			    }
			});
	}
	//end chart
		$.ajax({
	        type: "post",
	        url: '/sales-chart-data',
	        success: function(data)
	        {
	        	createSalesChart(data);
	        	expencePieChart(data);
            }
    });
	// end chart
// start expence analysis chart
	function expencePieChart(data){
		expence = [];
		expCatogery = [];
		$.each(data.expence,function(index,value){
				// console.log(index);
				expCatogery.push(index);
				expence.push(value);
		});

		var monthy_analysis = document.getElementById("monthy_analysis");
		var monthy_analysis_chart = new Chart(monthy_analysis, {
			type: 'doughnut',
			data: {
				labels: expCatogery,
				datasets: [{
						data:expence,
						backgroundColor:["#fdbdc6","#36d44a","#fc1e0d","#7b72b6","#2441e2","#ffbb52","#990027","#fcff66","#00cccc","#282828","#566427","#850da5","#07b3de","#000000","#ff7f19","#c6e2ff","#a2a39f","#d2b48c","#ec1375","#ecac13"],
						hoverBorderColor:['#124856',"#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856","#124856"],
						// label: 'Dataset 1'
						// borderColor: "black",
		            	// borderWidth: 12
					}],
				},
			options: {
				// cutoutPercentage:50,
				// rotation:0.4,
				// circumference:1,
				responsive: true,
				legend: {
			        display: true,
			        position: "left",
			        labels: {
			            fontColor: "#333",
			            fontSize: 16,
			        }
			    },
				title: {
					display: true,
					text: 'All Amount in Sri Lankan Rupees(LKR)',
				},
				animation: {
					animateScale: true,
					animateRotate: true,
				}
			}
		});
	}
// end expence analysis chart

// start void table	
 var tableVoid = $('#voidData').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('voidBill.data') !!}',
        columns: [
            { data: 'transaction_id', name: 'id' },
            { data: 'product_id', name: 'product_name' },
            { data: 'cash_credit', name: 'cash_credit' },
            { data: 'qty', name: 'qty' },
            { data: 'remark', name: 'remark' },
            { data: 'user_id', name: 'user_id' },
            { data: 'created_at', name: 'created_at' },
            // { data: 'action', name: 'action' },
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
        {
        	extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
        	title: $('#voidtable-title').text(),
        	customize: function(win) {
                $(win.document.body).find('table').addClass('compact').css('font-size', '10pt','color' ,'red');
            },
            init: function(api, node, config) {
   				$(node).removeClass('dt-button buttons-copy buttons-html5')
		    } 
        },
            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
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
        ],select: {
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
// end void table	

// start sales table	
 var tablesales = $('#salesData').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '{!! route('salesBill.data') !!}',
        columns: [
            { data: 'transaction_id', name: 'id' },
            { data: 'product_id', name: 'product_name' },
            { data: 'cash_credit', name: 'cash_credit' },
            { data: 'count_type', name: 'count_type' },
            { data: 'qty', name: 'qty' },
            { data: 'discount', name: 'discount' },
            { data: 'total_price', name: 'total_price' },
            { data: 'user_id', name: 'user_id' },
            { data: 'created_at', name: 'created_at' },
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
            { 	
            	extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
            	title: $('#billwise-table-title').text(),
            	customize: function(win) {
                    $(win.document.body).find('table').addClass('compact').css('font-size', '10pt','color' ,'red');
                },
                init: function(api, node, config) {
       				$(node).removeClass('dt-button buttons-copy buttons-html5')
			    } 
			},
            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
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
        ],select: {
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
// end sales table	

// start itemwise table
	var url = '/ItemWiseDataShouldBeEncriptedToRemoveUnauthorizedAccess3/'+date;
	var tableItemwise = $('#itemWiseTable').DataTable({
		processing: true,
		serverSide: true,
		deferRender: true,
		responsive: true,
		ajax: url,
		columns: [
		    { data: 'id', name: 'id' },
		    { data: 'location_code', name: 'location_code' },
		    { data: 'product_name', name: 'product_name' },
		    { data: 'qty_sold', name: 'qty_sold' },
		    { data: 'total_discount', name: 'total_discount' },
		    { data: 'total_sale', name: 'total_sale' },
		],
		dom: '<"toolbar">lBfrtip',
		buttons: [
		    { extend: 'copyHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
		       		$(node).removeClass('dt-button buttons-copy buttons-html5')
		    	} 
			},
		    { extend: 'excelHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
		       		$(node).removeClass('dt-button buttons-copy buttons-html5')
		   		}
		   	},
		    { extend: 'pdfHtml5', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
		       		$(node).removeClass('dt-button buttons-copy buttons-html5')
		    	} 
			},
		    { 	
		    	extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
            	title: $('#itemwise-table-title').text(),
            	customize: function(win) {
                    $(win.document.body).find('table').addClass('compact').css('font-size', '10pt','color' ,'red');
                },
                init: function(api, node, config) {
       				$(node).removeClass('dt-button buttons-copy buttons-html5')
			    } 
			},
		    { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
		    	   $(node).removeClass('dt-button buttons-copy buttons-html5')
		    	} 
			},
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
 $("div.toolbar").html('<div class="form-group"><div class="input-group mb-0 "><div class="input-group-prepend"><span class="input-group-text">Enter Report Date</span></div><input type="date" class="form-control col-md-3" id="itemwiseDate" name="itemwiseDate" placeholder="Ex DD/MM/YYYY" aria-label="expire_date" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="top" title="Enter Report Date"></div></div>');
 $('#itemwiseDate').change(function(){
 	// alert('sds');
 	date = $(this).val();
 	url = '/ItemWiseDataShouldBeEncriptedToRemoveUnauthorizedAccess3/'+date;
 	console.log($(this).val());
 	console.log(url);
 	 var table = $('#itemWiseTable').DataTable();
 	 table.ajax.url(url).load();
 });
// end itemwise table	

// start Cash Reconsilation table	
 var tableVoid = $('#cashReconsilation').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        ajax: '/CashReconsilDataShouldBeEncriptedToRemoveUnauthorizedAccess',
        columns: [
            { data: 'date', name: 'date' },
            { data: 'cash', name: 'cash' },
            { data: 'credit', name: 'credit' },
            { data: 'void_cash', name: 'void_cash' },
            { data: 'void_credit', name: 'void_credit' },
            { data: 'cash_discount', name: 'cash_discount' },
            { data: 'credit_discount', name: 'credit_discount' },
            { data: 'total', name: 'total' },
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
        {
        	extend: 'print', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',
        	title: $('#table-title').text(),
        	customize: function(win) {
                $(win.document.body).find('table').addClass('compact').css('font-size', '10pt','color' ,'red');
            },
            init: function(api, node, config) {
   				$(node).removeClass('dt-button buttons-copy buttons-html5')
		    } 
        },
            { extend: 'colvis', className: 'mb-2 btn btn-sm btn-outline-dark mr-1',init: function(api, node, config) {
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
        ],select: {
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
// end Cash Reconsilation table
});
</script>

@stop