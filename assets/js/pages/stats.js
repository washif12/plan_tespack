$(document).ready(function() {
    var user_id = $("#data-id").val();
    loadNotification(user_id);
    /* Ajax Loader */
    $(document).ajaxSend(function() {
        $("#overlay-loader").fadeIn(300);
    });
    $(document).ajaxStop(function() {
        $("#overlay-loader").fadeOut(300);
    });
    /* Reset Line graphs */
    const resetLineGraph = () => {
        $('#lineChart').remove();
        $('.energyGraphContainer').append('<canvas id="lineChart" height="350"></canvas>');
    }
    var energyChartData;
    /* Load Graph data initially */
    var user_id = $("#data-id").val();
    var initialRole = $("#user-role").val();
    var initialCountry = $("#user-country").val();
    var initialPM = $('#pro_manager').val();
    
    var arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
    if(initialRole=='3') {
        arr = {'user_id': user_id, 'country': initialCountry, 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
    }
    else if(initialRole=='2') {
        arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number($('#pro_manager').val()), 'ssm': '', 'from_date': '', 'to_date': ''}
    }
    else if(initialRole=='4') {
        arr = {'user_id': user_id, 'country': '', 'project': Number($('#project').val()), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
    }
    else {
        arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
    }
    var chartData;
    var solarDataForGraph = [];
    var gridDataForGraph = [];
    var batteryDataForGraph = [];
    var datesForGraph = [];
    $.ajax({
        type: "POST",
        url: "assets/api/new_map_data.php",
        data: JSON.stringify(arr)
    }).done(function(result) {
        console.log(result);
        $("#smb_count").text(result.total_device);
        $("#total_ssm_imp").text(result.total_device);
        if (result.total_report.length == 0) {
            $('#info_solar').text('0W');
            $('#info_grid').text('0W');
            $('#info_battery').text('0W');
            $('#total_rt').text('0 Hrs');
            $('#info_carbon').text('0kg');
        } else {
            $('#info_solar').text(result.total_report[0].total_solar_energy + 'W');
            $('#info_grid').text(result.total_report[0].total_grid_energy + 'W');
            $('#info_battery').text(result.total_report[0].total_battery + 'W');
            // $('#total_rt').text(formatTime(result.total_report[0].device_runtime));
            $('#total_rt').text(convertMinutesToDHM(result.total_report[0].device_runtime));
            $('#info_carbon').text(result.total_report[0].total_footprint.toFixed(2) + 'kg');
        }
        if (result.energy_data.length == 0) {
            $("#errMsg").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
            // $('#info_solar').text('0W');
            // $('#info_grid').text('0W');
            // $('#info_battery').text('0W');
            // $('#info_carbon').text('0kg');
            energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
            $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
        } else {
            // $('#info_solar').text(result.total_report.total_solar_energy + 'W');
            // $('#info_grid').text(result.total_report.total_grid_energy + 'W');
            // $('#info_battery').text(result.total_report.total_battery + 'W');
            // $('#info_carbon').text(result.total_report.total_footprint.toFixed(2) + 'kg');
            // $('#info_solar').text('W');
            // $('#info_grid').text('W');
            // $('#info_battery').text('W');
            // $('#info_carbon').text('kg');
            //chartData = result.energy_data;
            //$.MorrisCharts.init(chartData);
            chartData = result.energy_data;
            jQuery.each(chartData, function(index, item) {
                solarDataForGraph.push(item.a);
                gridDataForGraph.push(item.b);
                batteryDataForGraph.push(item.c);
                //datesForGraph.push(item.y);
                /* Converting to current timezone */
                var dbDateTime = new Date(item.y);
                var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                var dbOffset = dbDateTime.getTimezoneOffset();
                var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                var thisTimeZone = new Date(thisTimeZoneMs);
                //datesForGraph.push(thisTimeZone.toLocaleString());
                datesForGraph.push(thisTimeZone.toLocaleDateString());
            });
            //console.log(datesForGraph);
            //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
            energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
            $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
        }
    });
    /* Get SMB count */
    var userData = {
        role: initialRole,
        country: initialCountry
    }
    var projectHtml = $('#project').get(0).innerHTML;
    var countryHtml = $('#country').get(0).innerHTML;
    var pmHtml = $('#pro_manager').get(0).innerHTML;
    var ssmHtml = $('#ssm_device').get(0).innerHTML;
    /* Filter button with date and SSM */
    $('#filterBtn').prop('disabled', true);
    $(document).on('change', 'input[type=date]', function() {
        if ($(this).val() == '') {
            $('#filterBtn').prop('disabled', true);
        } else {
            $('#filterBtn').prop('disabled', false);
        }
    });
    //$('#morris-line-example').css('display', 'hidden');
    $(document).on('click', '#filterBtn', function() {
        // var formData = JSON.stringify({
        //     user_id: user_id,
        //     ssm: $("#ssm_device").val(),
        //     from_date: $("#date-from").val(),
        //     to_date: $("#date-to").val(),
        //     project: $("#project").val(),
        //     country: $("#country").val(),
        //     pro_manager: $("#pro_manager").val()
        // });
        arr.from_date = $("#date-from").val();
        arr.to_date = $("#date-to").val();
        $.ajax({
            type: "POST",
            url: "assets/api/new_map_data.php",
            data: JSON.stringify(arr)
        }).done(function(result) {
            console.log(result);
            //$("#morris-line-example").empty();
            $("#smb_count").text(result.total_device);
            $("#total_ssm_imp").text(result.total_device);
            if (result.total_report.length == 0) {
                $('#info_solar').text('0W');
                $('#info_grid').text('0W');
                $('#info_battery').text('0W');
                $('#total_rt').text('0Hrs');
                $('#info_carbon').text('0kg');
            } else {
                $('#info_solar').text(result.total_report[0].total_solar_energy + 'W');
                $('#info_grid').text(result.total_report[0].total_grid_energy + 'W');
                $('#info_battery').text(result.total_report[0].total_battery + 'W');
                // $('#total_rt').text(formatTime(result.total_report[0].device_runtime));

                $('#total_rt').text(convertMinutesToDHM(result.total_report[0].device_runtime));
                $('#info_carbon').text(result.total_report[0].total_footprint.toFixed(2) + 'kg');
            }
            resetLineGraph();
            solarDataForGraph = [];
            gridDataForGraph = [];
            batteryDataForGraph = [];
            datesForGraph = [];
            if (result.energy_data.length == 0) {
                $("#errMsg").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
            } else {
                chartData = result.energy_data;
                //$.MorrisCharts.init(chartData);
                jQuery.each(chartData, function(index, item) {
                    solarDataForGraph.push(item.a);
                    gridDataForGraph.push(item.b);
                    batteryDataForGraph.push(item.c);
                    //datesForGraph.push(item.y);
                    /* Converting to current timezone */
                    var dbDateTime = new Date(item.y);
                    var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                    var dbOffset = dbDateTime.getTimezoneOffset();
                    var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                    var thisTimeZone = new Date(thisTimeZoneMs);
                    //datesForGraph.push(thisTimeZone.toLocaleString());
                    datesForGraph.push(thisTimeZone.toLocaleDateString());
                });
                //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
            }
        });
        //$.MorrisCharts.init();
        //console.log(formData);
    });
    /* Changing dropdowns on select */
    var selected_project;
    var selected_pm;
    var selected_ssm;
    $(document).on('change', 'select', function() {
        arr = {
            'user_id': user_id,
            'country': '',
            'project': '',
            'pro_manager': '',
            'ssm': ''
        };
        if ($(this).attr("id") == 'country') {
            arr.country = $(this).val();
            arr.project = Number('0');
            arr.pro_manager = Number('0');
        } else if ($(this).attr("id") == 'project') {
            arr.project = Number($(this).val());
            selected_project = $(this).find("option:selected").text();
            arr.pro_manager = Number('0');
        } else if ($(this).attr("id") == 'pro_manager') {
            arr.pro_manager = Number($(this).val());
            selected_pm = $(this).find("option:selected").text();
            arr.project = Number('0');
        } else if ($(this).attr("id") == 'ssm_device') {
            arr.ssm = $(this).val();
            selected_ssm = $(this).find("option:selected").text();
            arr.project = Number('0');
            arr.pro_manager = Number('0');
            /*if($(this).val() != null){
                $('#filterBtn').prop('disabled', false);
            }
            else {
                $('#filterBtn').prop('disabled', true);
            }*/
        }
        console.log(arr);
        var selectData = {
            type: $(this).attr("id"),
            value: $(this).val()
        };
        $.ajax({
            type: "POST",
            url: "assets/api/new_map_data.php",
            data: JSON.stringify(arr),
            success: function(result) {
                //var data = jQuery.parseJSON(result);
                //console.log(result);
                //$("#morris-line-example").empty();
                resetLineGraph();
                solarDataForGraph = [];
                gridDataForGraph = [];
                batteryDataForGraph = [];
                datesForGraph = [];
                if (result.success == 1) {
                    $("#smb_count").text(result.total_device);
                    $("#total_ssm_imp").text(result.total_device);
                    if (result.total_report.length == 0) {
                        $('#info_solar').text('0W');
                        $('#info_grid').text('0W');
                        $('#info_battery').text('0W');
                        $('#total_rt').text('0Hrs');
                        $('#info_carbon').text('0kg');
                    } else {
                        $('#info_solar').text(result.total_report[0].total_solar_energy + 'W');
                        $('#info_grid').text(result.total_report[0].total_grid_energy + 'W');
                        $('#info_battery').text(result.total_report[0].total_battery + 'W');
                        // $('#total_rt').text(formatTime(result.total_report[0].device_runtime));
                        $('#total_rt').text(convertMinutesToDHM(result.total_report[0].device_runtime));
                        $('#info_carbon').text(result.total_report[0].total_footprint.toFixed(2) + 'kg');
                    }
                    $("#smb_infos").text('In ' + arr.country);
                    // if (result.total_report.total_solar_energy === null) {
                    //     $('#info_solar').text('0W');
                    // } else {
                    //     $('#info_solar').text(result.total_report.total_solar_energy + 'W');
                    // }
                    // if (result.total_report.total_grid_energy === null) {
                    //     $('#info_grid').text('0W');
                    // } else {
                    //     $('#info_grid').text(result.total_report.total_grid_energy + 'W');
                    // }
                    // if (result.total_report.total_battery === null) {
                    //     $('#info_battery').text('0W');
                    // } else {
                    //     $('#info_battery').text(result.total_report.total_battery + 'W');
                    // }
                    // if (result.total_report.total_footprint === null) {
                    //     $('#info_carbon').text('0W');
                    // } else {
                    //     $('#info_carbon').text(result.total_report.total_footprint.toFixed(2) + 'kg');
                    // }
                    if (result.energy_data.length == 0) {
                        $("#errMsg").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
                        energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
                    } else {
                        chartData = result.energy_data;
                        //$.MorrisCharts.init(chartData);
                        jQuery.each(chartData, function(index, item) {
                            solarDataForGraph.push(item.a);
                            gridDataForGraph.push(item.b);
                            batteryDataForGraph.push(item.c);
                            //datesForGraph.push(item.y);
                            /* Converting to current timezone */
                            var dbDateTime = new Date(item.y);
                            var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                            var dbOffset = dbDateTime.getTimezoneOffset();
                            var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                            var thisTimeZone = new Date(thisTimeZoneMs);
                            //datesForGraph.push(thisTimeZone.toLocaleString());
                            datesForGraph.push(thisTimeZone.toLocaleDateString());
                        });
                        //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                        $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
                    }
                    if (result.project.length > 0) {
                        $('#project').find('option').not(':first').remove();
                        jQuery.each(result.project, function(index, item) {
                            $('#project').append($('<option/>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                    } else if (result.project.length == 0) {
                        $('#project').find('option').not(':first').remove();
                        $('#project').append('<option disabled>No Data Found</option>');
                    }
                    if (result.project_manager.length > 0) {
                        $('#pro_manager').find('option').not(':first').remove();
                        jQuery.each(result.project_manager, function(index, item) {
                            $('#pro_manager').append($('<option/>', {
                                value: item.id,
                                text: item.name
                            }));
                        });
                    } else if (result.project_manager.length == 0) {
                        $('#pro_manager').find('option').not(':first').remove();
                        $('#pro_manager').append('<option disabled>No Data Found</option>');
                    }
                    if (result.device.length > 0) {
                        $('#ssm_device').find('option').not(':first').remove();
                        //$('#ssm_device').find('option').remove();
                        //$('#ssm_device').append('<option selected disabled>SSM</option>');
                        jQuery.each(result.device, function(index, item) {
                            $('#ssm_device').append($('<option/>', {
                                value: item.ssm_id,
                                text: item.ref
                            }));
                        });
                    } else if (result.device.length == 0) {
                        $('#ssm_device').find('option').not(':first').remove();
                        $('#ssm_device').append('<option disabled>No Data Found</option>');
                    }
                    $('#country').find('option').remove();
                    //$('#country').append('<option selected disabled>Country</option>');
                    jQuery.each(result.country, function(index, item) {
                        $('#country').append($('<option/>', {
                            value: item.country,
                            text: item.country,
                        }));
                    });
                }
            }
        });
    });
    /* Reset Button*/
    $(document).on('click', '#resetBtn', function() {
        //$('#country').prop('selectedIndex',0);
        // $('#project').find('option').remove().end().append(projectHtml);
        // $('#country').find('option').remove().end().append(countryHtml);
        // $('#pro_manager').find('option').remove().end().append(pmHtml);
        // $('#ssm_device').find('option').remove().end().append(ssmHtml);
        // $("input[type=date]").val("");
        //arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''};
        if(initialRole=='3') {
            arr = {'user_id': user_id, 'country': initialCountry, 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
        }
        else if(initialRole=='2') {
            arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number(initialPM), 'ssm': '', 'from_date': '', 'to_date': ''}
        }
        else if(initialRole=='4') {
            arr = {'user_id': user_id, 'country': '', 'project': Number($('#project').val()), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
        }
        else {
            arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''}
        }
        $("#smb_infos").text('');
        $('#filterBtn').prop('disabled', true); 
        $.ajax({
            type: "POST",
            url: "assets/api/new_map_data.php",
            data: JSON.stringify(arr)
        }).done(function(result) {
            //console.log(result);
            $("#smb_count").text(result.total_device);
            $("#total_ssm_imp").text(result.total_device);
            if (result.total_report.length == 0) {
                $('#info_solar').text('0W');
                $('#info_grid').text('0W');
                $('#info_battery').text('0W');
                $('#total_rt').text('0Hrs');
                $('#info_carbon').text('0kg');
            } else {
                $('#info_solar').text(result.total_report[0].total_solar_energy + 'W');
                $('#info_grid').text(result.total_report[0].total_grid_energy + 'W');
                $('#info_battery').text(result.total_report[0].total_battery + 'W');
                // $('#total_rt').text(formatTime(result.total_report[0].device_runtime));
                $('#total_rt').text(convertMinutesToDHM(result.total_report[0].device_runtime));
                $('#info_carbon').text(result.total_report[0].total_footprint.toFixed(2) + 'kg');
            }
            resetLineGraph();
            solarDataForGraph = [];
            gridDataForGraph = [];
            batteryDataForGraph = [];
            datesForGraph = [];
            if (result.energy_data.length == 0) {
                $("#errMsg").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
            } else {
                chartData = result.energy_data;
                //$.MorrisCharts.init(chartData);
                jQuery.each(chartData, function(index, item) {
                    solarDataForGraph.push(item.a);
                    gridDataForGraph.push(item.b);
                    batteryDataForGraph.push(item.c);
                    //datesForGraph.push(item.y);
                    /* Converting to current timezone */
                    var dbDateTime = new Date(item.y);
                    var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                    var dbOffset = dbDateTime.getTimezoneOffset();
                    var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                    var thisTimeZone = new Date(thisTimeZoneMs);
                    //datesForGraph.push(thisTimeZone.toLocaleString());
                    datesForGraph.push(thisTimeZone.toLocaleDateString());
                });
                //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts, energyChartData.lineOpt);
            }
            if (result.project.length > 0) {
                $('#project').find('option').remove();
                $('#project').append('<option selected disabled>Project</option>');
                jQuery.each(result.project, function(index, item) {
                    $('#project').append($('<option/>', {
                        value: item.id,
                        text: item.name
                    }));
                });
            } else if (result.project.length == 0) {
                $('#project').find('option').not(':first').remove();
                $('#project').append('<option disabled>No Data Found</option>');
            }
            if (result.project_manager.length > 0) {
                $('#pro_manager').find('option').remove();
                $('#pro_manager').append('<option selected disabled>Team Leader</option>');
                jQuery.each(result.project_manager, function(index, item) {
                    $('#pro_manager').append($('<option/>', {
                        value: item.id,
                        text: item.name
                    }));
                });
            } else if (result.project_manager.length == 0) {
                $('#pro_manager').find('option').not(':first').remove();
                $('#pro_manager').append('<option disabled>No Data Found</option>');
            }
            if (result.device.length > 0) {
                $('#ssm_device').find('option').remove();
                $('#ssm_device').append('<option selected disabled>SSM</option>');
                jQuery.each(result.device, function(index, item) {
                    $('#ssm_device').append($('<option/>', {
                        value: item.ssm_id,
                        text: item.ref
                    }));
                });
            } else if (result.device.length == 0) {
                $('#ssm_device').find('option').not(':first').remove();
                $('#ssm_device').append('<option disabled>No Data Found</option>');
            }
            $('#country').find('option').remove();
            $('#country').append('<option selected disabled>Country</option>');
            jQuery.each(result.country, function(index, item) {
                $('#country').append($('<option/>', {
                    value: item.country,
                    text: item.country,
                }));
            });
        });
    });

    // var table = $('.teaching-hours-table').DataTable({
    //     searching: false,
    //     dom: 'frt',
    //     data: [
    //         [
    //             "1",
    //             '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
    //             "Country",
    //             "5421 hrs"
    //         ],
    //         [
    //             "2",
    //             '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
    //             "Country",
    //             "8422 hrs"
    //         ],
    //         [
    //             "3",
    //             '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
    //             "Country",
    //             "1562 hrs"
    //         ],
    //         [
    //             "4",
    //             '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
    //             "Country",
    //             "6224 hrs"
    //         ]
    //     ],
    //     pageLength: 3,
    //     lengthMenu: [
    //         [3, 10, 20],
    //         [3, 10, 20]
    //     ],
    //     drawCallback: function() {
    //         // If there is some more data
    //         if ($('#btn-example-load-more').is(':visible')) {
    //             // Scroll to the "Load more" button
    //             $('html, body').animate({
    //                 scrollTop: $('#btn-example-load-more').offset().top
    //             }, 1000);
    //         }

    //         // Show or hide "Load more" button based on whether there is more data available
    //         $('#btn-example-load-more').toggle(this.api().page.hasMore());
    //     },
    //     "createdRow": function(row, data, index) {
    //         if (data[0].replace(/[\$,]/g, '') * 1 < 4) {
    //             $('td', row).eq(0).html("<i class='fa fa-trophy'></i> " + data[0]);
    //         }
    //     }
    // });
    // Handle click on "Load more" button
    $('#btn-example-load-more').on('click', function() {
        //table.page.loadMore();
        swal({
            title: 'Download',
            text: "You have to download to see the rest of the list.",
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            buttonsStyling: false
        }).then(function() {
            swal(
                'Downloaded!',
                'Your file has been Downloaded.',
                'success'
            )
        }, function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    '',
                    'error'
                )
            }
        });
    });

    var formData = {
        user_id: $("#data-id").val(),
        limit: '100',

    };
    $.ajax({
        url: `/assets/api/solar_energy_list.php`,
        type: 'post',
        data: JSON.stringify(formData),
        contentType: "application/json",
        success: function(data) {
            var solar_table = $('.solar').DataTable({
                searching: false,
                dom: 'frt',
                data: data.ret_data,
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'country'
                    },
                    {
                        data: 'total_solar_energy' 
                    }

                ],
                // data: [
                //     [
                //         "1",
                //         '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
                //         "Country",
                //         "9421W"
                //     ],
                //     [
                //         "2",
                //         '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
                //         "Country",
                //         "8422W"
                //     ],
                //     [
                //         "3",
                //         '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
                //         "Country",
                //         "1562W"
                //     ],
                //     [
                //         "4",
                //         '<img src="assets/images/backImage.jpg" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',
                //         "Country",
                //         "62W"
                //     ]
                // ],
                pageLength: 3,
                lengthMenu: [
                    [3, 10, 20],
                    [3, 10, 20]
                ],
                drawCallback: function() {
                    // If there is some more data
                    if ($('#btn-example-load-more-solar').is(':visible')) {
                        // Scroll to the "Load more" button
                        $('html, body').animate({
                            scrollTop: $('#btn-example-load-more-solar').offset().top
                        }, 1000);
                    }

                    // Show or hide "Load more" button based on whether there is more data available
                    $('#btn-example-load-more-solar').toggle(this.api().page.hasMore());
                },
                // "createdRow": function(row, data, index) {
                //     if (data[0].replace(/[\$,]/g, '') * 1 < 4) {
                //         $('td', row).eq(0).html("<i class='fa fa-trophy'></i> " + data[0]);
                //     }
                // }
            });

            var device_runtime = $('.teaching-hours-table').DataTable({
                searching: false,
                dom: 'frt',
                data: data.device_runtime,
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'country'
                    },
                    {
                        data: 'total_runtime',

                        render: function(data, type, row, meta) {
                            // Assuming 'imagePath' contains the path to your image
                            return formatTime(data);
                          }

                        
                    }

                ],
                pageLength: 3,
                lengthMenu: [
                    [3, 10, 20],
                    [3, 10, 20]
                ],
                drawCallback: function() {
                    // If there is some more data
                    if ($('#btn-example-load-more-solar').is(':visible')) {
                        // Scroll to the "Load more" button
                        $('html, body').animate({
                            scrollTop: $('#btn-example-load-more-solar').offset().top
                        }, 1000);
                    }

                    // Show or hide "Load more" button based on whether there is more data available
                    $('#btn-example-load-more-solar').toggle(this.api().page.hasMore());
                },
                // "createdRow": function(row, data, index) {
                //     if (data[0].replace(/[\$,]/g, '') * 1 < 4) {
                //         $('td', row).eq(0).html("<i class='fa fa-trophy'></i> " + data[0]);
                //     }
                // }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error: ' + textStatus + ' - ' + errorThrown);
        }
    });

    // Handle click on "Load more" button
    $('#btn-example-load-more-solar').on('click', function() {
        //$('#moreData').modal('show');
        swal({
            title: 'Download',
            text: "You have to download to see the rest of the list.",
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            buttonsStyling: false
        }).then(function() {
            swal(
                'Downloaded!',
                'Your file has been Downloaded.',
                'success'
            )
        }, function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    '',
                    'error'
                )
            }
        });
    });

    function formatTime(time) {
        try {
            const parts = time.split(':');
            const hours = parseInt(parts[0]);
            const minutes = parseInt(parts[1]);
            const seconds = parseFloat(parts[2]);
          
            let formattedTime = '';
          
            if (hours > 0) {
              formattedTime += hours + ' hour';
              if (hours > 1) {
                formattedTime += 's';
              }
              formattedTime += ' ';
            }
          
            if (minutes > 0) {
              formattedTime += minutes + ' min';
              if (minutes > 1) {
                formattedTime += 's';
              }
              formattedTime += ' ';
            }
          
            if (hours === 0 && minutes === 0) {
              formattedTime += seconds.toFixed(2) + ' sec';
            }
          
            return formattedTime.trim();
        } catch (error) {
            console.log(error)
        }
      }
});

function convertMinutesToDHM(minutes) {
    if (isNaN(minutes) || minutes < 0) {
        return "Invalid input";
    }

    const minutesInAnHour = 60;
    const hours = Math.floor(minutes / minutesInAnHour);
    const remainingMinutes = Math.floor(minutes % minutesInAnHour);

    if (hours >= 24) {
        const days = Math.floor(hours / 24);
        const remainingHours = hours % 24;
        if (remainingHours > 0 && remainingMinutes > 0) {
            return `${days}d, ${remainingHours}hr, ${remainingMinutes}min`;
        } else if (remainingHours > 0) {
            return `${days}d, ${remainingHours}hr`;
        } else {
            return `${days}d`;
        }
    } else if (hours > 0) {
        if (remainingMinutes > 0) {
            return `${hours}hr, ${remainingMinutes}min`;
        } else {
            return `${hours}hr`;
        }
    } else {
        if (remainingMinutes > 0) {
            return `${remainingMinutes}min`;
        } else {
            return "0min";
        }
    }
}




