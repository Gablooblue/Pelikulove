@extends('layouts.app')

@section('template_title')
    Showing Test 01
@endsection

@section('template_fastload_css')

@endsection

@section('content')
  <div class="container">
    <canvas id="myChart"></canvas>
  </div>
@endsection

@section('footer_scripts')
  <script src="{{ asset('/js/moment.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" 
    integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" 
    crossorigin="anonymous">
  </script>

  <script> 
    // var allVodStatsByDate = {!! $allVodStatsByDate->toJson() !!};
    // // var timeFormat = 'MMMM DD';    
    // var timeFormat = 'MM/DD/YYYY HH:mm';
    // var dates = [];  
    // var totalViews = [];  
    // var uniqueViews = [];  
    // var registeredViews = [];  
    // var guestViews = [];  

    // allVodStatsByDate.forEach(function(item, index){
    //   dates.push(moment(item.date.toString()).format(timeFormat));
    //   totalViews.push(item.totalViews);
    //   uniqueViews.push(item.uniqueViews);
    //   registeredViews.push(item.registeredViews);
    //   guestViews.push(item.guestViews);
    // });  
    
    var timeFormat = 'MM/DD/YYYY HH:mm';

    var dates = {!! $allVodStatsByDate->dates !!}; 
    var newDates = []; 

    dates.forEach(function(item, index){
      newDates.push(moment(item.toString()).format(timeFormat));
    });  

    var totalViews = {!! $allVodStatsByDate->totalViews !!};  
    var uniqueViews = {!! $allVodStatsByDate->uniqueViewsCount !!};  
    var registeredViews = {!! $allVodStatsByDate->registeredViews !!};  
    var guestViews = {!! $allVodStatsByDate->guestViews !!};  

    var ctx = document.getElementById('myChart').getContext('2d');
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        // labels: ['April 29','April 30','May 1','May 2','May 3','May 4','May 5','May 6','May 7','May 8',],
        labels: newDates,
        datasets: [{ 
            // data: [51,59,58,49,56,52,53,57,47,52],
            data: totalViews,
            label: "Total Views",
            borderColor: "#3e95cd",
            lineTension: 0,     
            fill: true
          }, { 
            // data: [16,18,21,20,24,19,22,25,24,21],
            data: registeredViews,
            label: "Registered Views",
            borderColor: "#8e5ea2",
            lineTension: 0,     
            fill: false
          }, { 
            // data: [35,41,37,29,32,33,31,32,23,31],
            data: guestViews,
            label: "Guest Views",
            borderColor: "#3cba9f",
            lineTension: 0,     
            fill: false
          }, { 
            // data: [12,14,16,11,9,10,13,13,15,9],
            data: uniqueViews,
            label: "Unique Views",
            borderColor: "#e8c3b9",
            lineTension: 0,     
            fill: false
          }, 
        ]
      },
      options: {
        title: {
          display: true,
          text: 'All Views per Day'
        },
				scales: {
					xAxes: [{
						type: 'time',
						time: {
							parser: timeFormat,
							// round: 'day'
							tooltipFormat: 'll HH:mm'
						},
						scaleLabel: {
							display: true,
							labelString: 'Date'
						}
					}],
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Views'
						}
					}]
				},
			}
    });
  </script>
  
  {{-- <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: speedData,
      options: chartOptions
    });
    
    var speedData = {
      labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
      datasets: [{
        label: "Car Speed",
        data: [0, 59, 75, 20, 20, 55, 40],
      }]
    };
    
    var chartOptions = {
      legend: {
        display: true,
        position: 'top',
        labels: {
          boxWidth: 80,
          fontColor: 'black'
        }
      }
    };
  </script> --}}

@endsection
