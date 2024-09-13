@extends('master')
@section('web-page-title') {{ Auth::user()->username }} Reports @stop
@section('pageurl') Home > Reports @stop
@section('pagetitle') Shop Sales Reports @stop
@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Daily Sale Report</h6>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row border-bottom py-2 bg-light">
                      <div class="col-12 col-sm-6">
                      	<form action="/sale-data-update" method="post">
                        {{ csrf_field() }}
                        <div class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 500px;">
                        	<input type="date" class="input-sm form-control" name="start_date" placeholder="Start Date" value="{{ \Carbon\Carbon::now()->subDays(10)->format('Y-m-d') }}" data-toggle="tooltip" data-placement="top" title="Enter Sales Start Date">
                        	<input type="date" class="input-sm form-control" name="end_date" placeholder="End Date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-toggle="tooltip" data-placement="top" title="Enter Sales End Date">
                        	<input type="text" class="input-sm form-control valied_number" name="step_size" placeholder="Scale" value="{{$scale}}" data-toggle="tooltip" data-placement="top" title="You Can Change Scale Here">
                        	<div class="btn-group btn-group-sm">
                            <button type="submit" class="btn btn-white">
                            	<span class="text-success"><i class="material-icons">autorenew</i></span> Update
                            </button>
                        </div>
                        </div>
                        </form>
                      </div>
                    </div>
                    <canvas id="sale_report" height="234" style="max-width: 100% !important; display: block; width: 542px; height: 234px;" class="blog-overview-users chartjs-render-monitor" width="542"></canvas>
                  </div>
                </div>
              </div>
 <!-- ====================== -->
 <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
	<div class="card card-small">
    	<div class="card-header border-bottom">
        	<h6 class="m-0">Monthly Analysis Report</h6>
        </div>
        <div class="card-body pt-0">
        <div class="row border-bottom py-2 bg-light">
        <form action="/sale-data-update"  method="post">
        	{{csrf_field()}}
        	<div class="row">
                <div class="col">
                    <select name="month" class="custom-select custom-select-sm" style="max-width: 400px;">
                        <option value="{{$this_month}}" selected="">{{$this_month}}</option>
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
                        <option value="{{$this_year}}" selected="">{{$this_year}}</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
                <div class="btn-group btn-group-sm">
                        <button type="submit" class="btn btn-white">
                        	<span class="text-success"><i class="material-icons">autorenew</i></span> Update
                        </button>
                    </div>
            </form>
            </div>
        </div>
        <canvas id="monthy_analysis" height="234" style="max-width: 100% !important; display: block; width: 542px; height: 234px;" class="blog-overview-users chartjs-render-monitor" width="542"></canvas>
        </div>
    </div>

@stop
@section('script')
<script>
var sale = document.getElementById("sale_report");
var myChart = new Chart(sale, {
    type: 'line',
    data: {
        labels: [
        @foreach($months_array as $key => $date)
			'{{$key}}',
		@endforeach
        ],
        //Start sales data
        datasets: [{
	            label: 'Daily Sale Rs',
	            data: [
	             @foreach($months_array as $key => $date)
					{{$date}},
				@endforeach
	            ],
	            backgroundColor: [
	                'rgba(72,192,114, 0.2)',
	            ],
	            borderColor: [
	                'rgba(72,192,114)',
	            ],
	            borderWidth: 1
	        },
	        {
	            label: 'Daily Item Cost Rs',
	            data: [
	     			@foreach($item_cost_array as $cost)
	     			{{$cost}},
	     			@endforeach
	            ],
	            backgroundColor: [
	                'rgba(42,57,122, 0.2)',
	            ],
	            borderColor: [
	                'rgba(42,57,122)',
	            ],
	            borderWidth: 1
	        }, 
	        {
	            label: 'Daily Profit from Items Rs',
	            data: [
	     			@foreach($profit_array as $profit)
	     				{{$profit}},
	     			@endforeach
	            ],
	            backgroundColor: [
	                'rgba(236,19,216, 0.2)',
	            ],
	            borderColor: [
	                'rgba(236,19,216)',
	            ],
	            borderWidth: 1
	        },	        
        ],
        //Start sales data
    },
    options: {
        scales: {
            yAxes: [{
      			scaleLabel: { display:true,labelString: ["Sri Lankan Rupees(LKR)"] },
      			ticks: { min: @php echo min($profit_array); @endphp, stepSize: @if($scale) {{$scale}} @else 1000 @endif, suggestedMin: 10, suggestedMax: 5.5 },
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
		            }
		          ]
        }
    }
});

// ===================
var monthy_analysis = document.getElementById("monthy_analysis");
var monthy_analysis_chart = new Chart(monthy_analysis, {
	type: 'doughnut',
	data: {
		labels: [
		@foreach($month_expence_array as $key => $amount)
			'{{$key}}',
		@endforeach
		],
		datasets: [{
				data: [ 
					@foreach($month_expence_array as $key => $amount)
						{{$amount}},
					@endforeach
				],
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
			            fontSize: 16
			        }
			    },
				title: {
					display: true,
					text: 'All Amount in Sri Lankan Rupees(LKR)'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
  //   data:[
  //   	{
		// 	value: 300,
		// 	color:"#F7464A",
		// 	highlight: "#FF5A5E",
		// 	label: "Red"
		// },
		// {
		// 	value: 50,
		// 	color: "#46BFBD",
		// 	highlight: "#5AD3D1",
		// 	label: "Green"
		// },
		// {
		// 	value: 100,
		// 	color: "#FDB45C",
		// 	highlight: "#FFC870",
		// 	label: "Yellow"
		// }]
});

</script>

@stop

