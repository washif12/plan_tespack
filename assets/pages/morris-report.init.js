/*
 Template Name: Fonik - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Morris chart Init
 */


 !function ($) {
    "use strict";

    var MorrisCharts = function () {
    };

        //creates line chart
        MorrisCharts.prototype.createLineChart = function (element, data, xkey, ykeys, labels, lineColors) {
            Morris.Line({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true, //defaulted to true
                lineColors: lineColors,
                lineWidth: 1,
                yLabelFormat: function (y) { return y.toString() + 'W'; }
            });
        },
        MorrisCharts.prototype.createCarbonLineChart = function (element, data, xkey, ykeys, labels, lineColors) {
            Morris.Line({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true, //defaulted to true
                lineColors: lineColors,
                lineWidth: 1,
                yLabelFormat: function (y) { return y.toString() + 'Kg'; }
            });
        },
        MorrisCharts.prototype.init = function ($data, $data_carbon) {

            //create line chart
            /*var $data = [
                {y: '2009', a: 50, b: 80, c: 20},
                {y: '2010', a: 130, b: 100, c: 80},
                {y: '2011', a: 80, b: 60, c: 70},
                {y: '2012', a: 70, b: 200, c: 140},
                {y: '2013', a: 180, b: 140, c: 150},
                {y: '2014', a: 105, b: 100, c: 80},
                {y: '2015', a: 250, b: 150, c: 200}
            ];*/
            this.createLineChart('morris-line-example', $data, 'y', ['a', 'b', 'c'], ['Solar', 'Wall Socket', 'Battery'], ['#fddd3e', '#000', '#a5a5a5']);
            this.createCarbonLineChart('morris-line-carbon', $data_carbon, 'date', ['total_foot_print'], ['Carbon Emission Reduced'], ['#ffcc05']);

            
        },
        //init
        $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
}(window.jQuery),

//initializing 
    function ($) {
        "use strict";
        //$.MorrisCharts.init();
    }(window.jQuery);