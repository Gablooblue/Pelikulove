
<script src="{{ asset('/js/moment.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" 
    integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" 
    crossorigin="anonymous">
</script>

<script>     
    var timeFormat = 'MM/DD/YYYY HH:mm';

    var dates = {!! $allVodStatsByDate->dates !!}; 
    var newDates = []; 

    // console.log(dates);

    dates.forEach(function(item, index){
        newDates.push(moment(item.toString()).format(timeFormat));
    });  

    // console.log(newDates);

    var totalViews = {!! $allVodStatsByDate->totalViews !!};  
    var uniqueViews = {!! $allVodStatsByDate->uniqueViewsCount !!};  
    var uniqueRegViews = {!! $allVodStatsByDate->uniqueRegViewsCount !!};  
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
                borderColor: "#9268A4",
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
                borderColor: "#F08080",
                lineTension: 0,     
                fill: false
            }, { 
                // data: [9,11,11,7,4,6,5,10,11,3],
                data: uniqueRegViews,
                label: "Unique Registered Views",
                borderColor: "#EFD260",
                lineTension: 0,     
                fill: false
            }, 
            ]
        },
        options: {
            title: {
            display: true,
            text: 'All Views vs Time'
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        // round: 'day'
                        tooltipFormat: 'll',
                        minUnit: 'day',
                        displayFormats: {
                            day: 'ddd. MMM D'
                        }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    },
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