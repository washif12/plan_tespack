/*
 Template Name: Fonik - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Chart js 
 */

!function($) {
    "use strict";

    var ChartJs = function() {};

    ChartJs.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        //var ctx = document.getElementById("lineChart").getContext("2d");
        //var ctxPie = document.getElementById("pie").getContext("2d");
        var ctxBar = document.getElementById("bar").getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                // case 'Pie':
                //     new Chart(ctxPie, {
                //         type: 'pie', 
                //         data: data, 
                //         options: {title: {display: true,text: 'SOS Activated',color: '#005aa7', position: 'bottom'}}
                //     });
                //     break;
                case 'Bar':
                    new Chart(ctxBar, {
                        type: 'bar', 
                        data: data, 
                        options: {
                            scales: {
                            yAxes: [{
                              scaleLabel: {
                                display: true,
                                labelString: 'Number of Batteries'
                              }
                            }],
                            xAxes: [{
                                barThickness : 73,
                                scaleLabel: {
                                  display: true,
                                  labelString: 'Cycles'
                                }
                              }]
                          }
                        }
                    });
                    break;
            }
            /*switch(type){
                case 'Line':
                    new Chart(ctx, {type: 'line', data: data, options: options});
                    break;
                case 'Doughnut':
                    new Chart(ctx, {type: 'doughnut', data: data, options: options});
                    break;
                case 'Pie':
                    new Chart(ctxPie, {type: 'pie', data: data, options: options});
                    break;
                case 'Bar':
                    new Chart(ctx, {type: 'bar', data: data, options: options});
                    break;
                case 'Radar':
                    new Chart(ctx, {type: 'radar', data: data, options: options});
                    break;
                case 'PolarArea':
                    new Chart(ctx, {data: data, type: 'polarArea', options: options});
                    break;
            }*/
            // Initiate new chart or Redraw

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJs.prototype.init = function($barData,$barLabels) {
        
        //Pie chart
        // var pieChart = {
        //     labels: [
        //         "India",
        //         "Nigeria",
        //         "Bangladesh",
        //         "Columbia",
        //         "Zambia"
        //     ],
        //     datasets: [{
        //         data: [11, 23, 5, 13, 9],
        //         backgroundColor: [
        //             "#d7443c",
        //             "#45539e",
        //             "#60b65d",
        //             "#fbd738",
        //             "#1c94d1"
        //         ],
        //         hoverBorderColor: "#fff"
        //     }]
        // };
        // this.respChart($("#pie"),'Pie',pieChart);


        //barchart
        var barChart = {
            //labels: ["0-50", "51-100", "101-150", "151-200", "201-250", "251-300", "301-350", "351-400"],
            labels: $barLabels,
            datasets: [
                {
                    label: 'Battery Count within cycles',
                    backgroundColor: "#ffcc05",
                    borderColor: "#ffcc05",
                    borderWidth: 1,
                    data: $barData
                    //data: [800, 345, 441, 669, 560, 768, 234, 498, 678]
                }
            ]
        };
        this.respChart($("#bar"),'Bar',barChart);


        //radar chart
        /*var radarChart = {
            labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
            datasets: [
                {
                    label: "Desktops",
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderColor: "rgba(179,181,198,1)",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(179,181,198,1)",
                    data: [65, 59, 90, 81, 56, 55, 40]
                },
                {
                    label: "Tablets",
                    backgroundColor: "rgba(103, 168, 228, 0.2)",
                    borderColor: "#67a8e4",
                    pointBackgroundColor: "#67a8e4",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "#67a8e4",
                    data: [28, 48, 40, 19, 96, 27, 100]
                }
            ]
        };
        this.respChart($("#radar"),'Radar',radarChart);

        //Polar area  chart
        var polarChart = {
            datasets: [{
                data: [
                    11,
                    16,
                    7,
                    18
                ],
                backgroundColor: [
                    "#77c949",
                    "#0097a7",
                    "#ffbb44",
                    "#f32f53"
                ],
                label: 'My dataset', // for legend
                hoverBorderColor: "#fff"
            }],
            labels: [
                "Series 1",
                "Series 2",
                "Series 3",
                "Series 4"
            ]
        };
        this.respChart($("#polarArea"),'PolarArea',polarChart);*/
    },
    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

    /* New Power Bank Bar Chart */
    var ChartJsBattery = function() {};

    ChartJsBattery.prototype.respChart = function(selector,type,data, options) {
        var ctxBarBattery = document.getElementById("barBattery").getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Bar':
                    new Chart(ctxBarBattery, {
                        type: 'bar', 
                        data: data, 
                        options: {
                            scales: {
                            yAxes: [{
                              scaleLabel: {
                                display: true,
                                labelString: 'Number of Cycles'
                              }
                            }],
                            xAxes: [{
                                barThickness : 73,
                                barPercentage: 2,
                                scaleLabel: {
                                  display: true,
                                  labelString: 'Power Banks'
                                }
                              }]
                          },
                          tooltips: {
                              callbacks: {
                                  title: function(item, data) {
                                  return 'Battery ID: ' +item[0].xLabel;
                                  //console.log(item[0].xLabel)
                                  },
                                  label: function(item, data) {
                                  //var datasetLabel = data.datasets[item.datasetIndex].label || "";
                                  var dataPoint = item.yLabel;
                                  return "Cycles: " + dataPoint;
                                  }
                              }
                          }
                        }
                    });
                    break;
            }
        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJsBattery.prototype.init = function($barData,$barLabels) {
        //barchart
        var bgColors = $barData.map(x=> {
            if(x<=600) {return '#2dc937';}
            else if(x>600 && x<=1200) {return '#e7b416';}
            else {return '#cc3232';}
        })
        var barChartBattery = {
            //labels: ["A", "B", "C", "D", "E", "F", "G", "H"],
            labels: $barLabels,
            datasets: [
                {
                    label: 'Ok',
                    backgroundColor: '#2dc937',
                    borderWidth: 1,
                    data: $barData.map(x=> {
                        if(x<=600) {return x;}
                    })
                    //data: batCycles
                },
                {
                    label: 'Check',
                    backgroundColor: '#e7b416',
                    borderWidth: 1,
                    data: $barData.map(x=> {
                        if(x>600 && x<=1200) {return x;}
                    })
                    //data: batCycles
                },
                {
                    label: 'Recycle',
                    backgroundColor: '#cc3232',
                    borderWidth: 1,
                    data: $barData.map(x=> {
                        if(x>1200) {return x;}
                    })
                    //data: batCycles
                }
            ]
        };
        this.respChart($("#barBattery"),'Bar',barChartBattery);
    },
    $.ChartJsBattery = new ChartJsBattery, $.ChartJsBattery.Constructor = ChartJsBattery
    /* Pie chart starts */
    var ChartJsPie = function() {};
    ChartJsPie.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        var ctxPie = document.getElementById("pie").getContext("2d");
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Pie':
                    new Chart(ctxPie, {
                        type: 'pie', 
                        data: data, 
                        options: {title: {display: true,text: 'Total Geofence Alerts Activated',color: '#005aa7', position: 'bottom'}}
                    });
                    break;
            }

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJsPie.prototype.init = function($pieData,$pieLabels) {
        function getRandomColor() { //generates random colours and puts them in string
            var colors = [];
            for (var i = 0; i < $pieData.length; i++) {
              var letters = '0123456789ABCDEF'.split('');
              var color = '#';
              for (var x = 0; x < 6; x++) {
                color += letters[Math.floor(Math.random() * 16)];
              }
              colors.push(color);
            }
            return colors;
          }
        //Pie chart
        var pieChart = {
            labels: $pieLabels,
            datasets: [{
                data: $pieData,
                backgroundColor: getRandomColor(),
                hoverBorderColor: "#fff"
            }]
        };
        this.respChart($("#pie"),'Pie',pieChart);
    },
    $.ChartJsPie = new ChartJsPie, $.ChartJsPie.Constructor = ChartJs
    /* Pie chart ends */
    /* Energy Chart Starts */
    var ChartJsLine = function() {};

    ChartJsLine.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        var ctx = document.getElementById("lineChart").getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        //$(window).resize( generateChart );

        // this function produce the responsive Chart JS
        
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                    return new Chart(ctx, {type: 'line', data: data, options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    displayFormats: {
                                        quarter: 'MMM YYYY'
                                    }
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 5
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    precision: 0,
                                    // Include whr in the ticks
                                    callback: function(value, index, values) {
                                        return value.toFixed(2)+'Whr';
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                title: function(item, data) {
                                return item[0].xLabel;
                                //console.log(item[0].xLabel)
                                },
                                label: function(item, data) {
                                var datasetLabel = data.datasets[item.datasetIndex].label || "";
                                var dataPoint = item.yLabel;
                                return datasetLabel + ": " + dataPoint + "Whr";
                                }
                            }
                        }
                    }});
                    break;
            }
        // run function - render chart at first load
        //generateChart();
    },
    //init
    ChartJsLine.prototype.init = function($solarData,$gridData,$batteryData,$dateLabels) {
        //creating lineChart
        var lineChart = {
            //labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September","October"],
            labels: $dateLabels,
            datasets: [
                {
                    label: "Solar",
                    fill: false,
                    lineTension: 0.5,
                    backgroundColor: "rgba(51, 141, 221, 0.2)",
                    borderColor: "#fddd3e",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#fddd3e",
                    pointBackgroundColor: "#fddd3e",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#fddd3e",
                    pointHoverBorderColor: "#fddd3e",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    data: $solarData
                },
                {
                    label: "Grid",
                    fill: false,
                    lineTension: 0.5,
                    backgroundColor: "rgba(235, 239, 242, 0.2)",
                    borderColor: "#000",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#000",
                    pointBackgroundColor: "#000",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#000",
                    pointHoverBorderColor: "#000",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    data: $gridData
                },
                {
                    label: "Battery",
                    fill: false,
                    lineTension: 0.5,
                    backgroundColor: "rgba(235, 239, 242, 0.2)",
                    borderColor: "#45eb80",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#45eb80",
                    pointBackgroundColor: "#45eb80",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#45eb80",
                    pointHoverBorderColor: "#45eb80",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    data: $batteryData
                }
            ]
        };

        var lineOpts = {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month'
                    }
                }
            }
        };

        //this.respChart($("#lineChart"),'Line',lineChart, lineOpts);
        //return lineChart;
        return {lineCharts: lineChart, lineOpt: lineOpts};
    },
    $.ChartJsLine = new ChartJsLine, $.ChartJsLine.Constructor = ChartJsLine
    /* Energy Chart ends */
    /* Carbon Charts Start */
    var ChartJsCarbon = function() {};

    ChartJsCarbon.prototype.respChart = function(selector,type,data, options) {
        // get selector by context
        var ctxCarbon = document.getElementById("morris-line-carbon").getContext("2d");
        // pointing parent container to make chart js inherit its width
        var container = $(selector).parent();

        // enable resizing matter
        $(window).resize( generateChart );

        // this function produce the responsive Chart JS
        function generateChart(){
            // make chart width fit with its container
            var ww = selector.attr('width', $(container).width() );
            switch(type){
                case 'Line':
                    new Chart(ctxCarbon, {type: 'line', data: data, options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    // Include a dollar sign in the ticks
                                    callback: function(value, index, values) {
                                        return value.toFixed(2)+'Kg';
                                    }
                                }
                            }]
                        }
                    }});
                    break;
            }

        };
        // run function - render chart at first load
        generateChart();
    },
    //init
    ChartJsCarbon.prototype.init = function($carbonData,$dateLabels) {
        //creating lineChart
        var lineChartCarbon = {
            labels: $dateLabels,
            datasets: [
                {
                    label: "Carbon Emission Reduced",
                    fill: false,
                    lineTension: 0.5,
                    backgroundColor: "rgba(51, 141, 221, 0.2)",
                    borderColor: "#fddd3e",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "#fddd3e",
                    pointBackgroundColor: "#fddd3e",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#fddd3e",
                    pointHoverBorderColor: "#fddd3e",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    data: $carbonData
                }
            ]
        };

        var lineOptsCarbon = {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month'
                    }
                }
            }
        };

        this.respChart($("#morris-line-carbon"),'Line',lineChartCarbon, lineOptsCarbon);
    },
    $.ChartJsCarbon = new ChartJsCarbon, $.ChartJsCarbon.Constructor = ChartJsCarbon
    /* Carbon Chart ends */

}(window.jQuery),

//initializing
function($) {
    "use strict";
    //$.ChartJs.init()
}(window.jQuery);
