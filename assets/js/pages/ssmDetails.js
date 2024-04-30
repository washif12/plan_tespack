$(document).ready(function(){
    var ssm_id = $("#ssm-id").val();
    var user_id = $("#data-id").val();
    var info_id = $("#info-id").val();
    var latestLat;
    var latestLng;
    var lastSeen;
    var lastSeenTimeAgo;
    var lastSeenTZ;
    var newDateFormat;
    var sigStr;
    var imei;
    var emei;
    var remBat;
    var sos_act;
    var energyChartData;
    var chartUpdateVar;
    var lastIdForGraph;
    var bat_link;
    const iconCustom = {
        url: "assets/images/tespack-logo.png", // url
        scaledSize: new google.maps.Size(30, 30), // scaled size
    };
    var arr = {user_id: user_id, from_date: '', to_date: '', ssm: ssm_id};
    loadNotification(user_id);
    //console.log(Intl.DateTimeFormat().resolvedOptions().timeZone);
    /* Counting last seen times ago */
    function time2TimeAgo(ts) {
        var d=new Date();  // Gets the current time
        var offset = d.getTimezoneOffset();
        //var nowTs = Math.floor(d.getTime()/1000)+(offset*60);
        var nowTs = d.getTime()+(offset*60*1000);
        var seconds = Math.floor((nowTs-ts)/1000);
        var msg;
        // if (seconds > 2*24*3600) {
        //    return "a few days ago";
        // }
        // if (seconds > 24*3600) {
        //    return "yesterday";
        // }
        if (seconds >= 7200) {
            msg = Math.floor(seconds/3600) + " hours ago";
        }
        else if (seconds > 3600 && seconds< 7200) {
            msg = Math.floor(seconds/3600) + " hour ago";
        }
        else if (seconds >= 60 && seconds < 3600) {
            msg = Math.floor(seconds/60) + "min ago";
        }
        else if (seconds < 60) {
            msg = seconds+ "s ago";
        }
        return {message: msg, timeAgo: seconds};
    }
    function setTimeZone(givenTime) {
        var dbDateTime = new Date(givenTime);
        var dbDateTimeMs = Math.floor(dbDateTime.getTime());
        var dbOffset = dbDateTime.getTimezoneOffset();
        var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
        var thisTimeZone = new Date(thisTimeZoneMs);
        return thisTimeZone;
    }
    $.ajax({
        type: "POST",
        url: "/assets/api/ssm_select_by_id_pg.php",
        data: JSON.stringify({'user_id':user_id,'ssm_id':ssm_id}),
        success: function(result){
            console.log(result);
            result = result.res[0];
            if(result.gnss_location_details!=null) {
                latestLat = result.gnss_location_details[0].latitude;
                latestLng = result.gnss_location_details[0].longitude;
            }
            lastSeen = result.updated_at;
            imei = result.imei;
            emei = result.emei;
            remBat = result.total_charge+'%';
            sos_act = result.device_status;
            //console.log(Intl.DateTimeFormat().resolvedOptions());
            var dbDate = new Date(lastSeen);
            //var milliseconds = Math.floor(dbDate.getTime()/1000)
            var milliseconds = dbDate.getTime();
            lastSeenTimeAgo = time2TimeAgo(milliseconds);
            lastSeenTZ = setTimeZone(lastSeen);
            newDateFormat = lastSeenTZ.toLocaleString();
            var splitTime = lastSeenTZ.toString().split(' ');
            var countryTZ = lastSeenTZ.toString().match(/\(([^)]+)\)/)[1];
            var countrySplit = countryTZ.replace('Standard ','');
            console.log(lastSeenTZ);
            //$("#live_data_status").html('');
            if(lastSeenTimeAgo.timeAgo<=600) {
                $("#live_data_status").html(`<h6 class="text-white">Online <i class="mdi mdi-checkbox-blank-circle text-success font-10"></i></h6>`);
                $("#net").text(result.network_id);
                if(result.signal_strength>=0 && result.signal_strength<21){ $("#sig_st").text('Poor');sigStr='Poor';}
                else if(result.signal_strength>=21 && result.signal_strength<41){ $("#sig_st").text('Good');sigStr='Good';}
                else if(result.signal_strength>=41 && result.signal_strength<99){ $("#sig_st").text('Excellent');sigStr='Excellent';}
                else { $("#sig_st").text('Unknown Signal');sigStr='Unknown Signal';}
            }
            else {
                $("#live_data_status").html(`<h6 class="text-white">Offline <i class="mdi mdi-checkbox-blank-circle text-danger font-10"></i></h6>`);
                $("#net").text('--');
                $("#sig_st").text('--');sigStr='--';
            }
            if(result.total_charge_avg!=null) {
                $(".bat_status").text('Battery Status: '+result.total_charge_avg+'%');
                $("#total_charge").text(result.total_charge_avg+'%');
            } else {
                $(".bat_status").text('Battery Status: 0%');
                $("#total_charge").text('0%');
            }
            $(".imei").text('IMEI- '+result.imei);
            $(".emei").text('EMEI- '+result.emei);
            if(result.temperature!='') {
                $("#device_temperature").html(result.temperature+'&deg;'+'C');
            } else {$("#device_temperature").text('-');}
            if(result.total_session!='') {
                $("#total_session").text(result.total_session+'min');
            } else {$("#total_session").text('-');}
            $("#last_update").text(lastSeenTimeAgo.message+', '+newDateFormat+' '+splitTime[5]+' '+countrySplit);
            //$("#total_charge").text(result.total_charge_avg+'%');
            $("#power_source_status").text(result.power_source_status);
            if(result.power_source_status=='Disconnected') {
                $("#power_source_type").text('-');
            } else {$("#power_source_type").text(result.power_source_type);}
            /* If Sos is not activated */
            if(result.device_status=='1'){
                $(".gf-status").mouseover(function () {
                    $('.img-gf').attr('src', $('.img-gf').data("hover"));
                }).mouseout(function () {
                    $('.img-gf').attr('src', $('.img-gf').data("src"));
                });
                $(".gf-status").css('background-color', '');
                $('.img-gf').attr('src', $('.img-gf').data("src"));
                $('.sos-text').html('<b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="SSM not in Danger"></i>&nbsp;SOS Not Active</b>');
            }
            /* If Sos is activated */
            else {
                $(".gf-status").css('background-color', '#FF0000');
                $('.img-gf').attr('src', $('.img-gf').data("hover"));
                $(".gf-status").mouseover(function () {
                    $('.img-gf').attr('src', $('.img-gf').data("src"));
                    
                }).mouseout(function () {
                    $('.img-gf').attr('src', $('.img-gf').data("hover"));
                });
                $('.sos-text').html('<b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="SSM in danger"></i>&nbsp;SOS Activated</b>');
                
            }
            if(result.power_bank_details.length>0) {
                jQuery.each(result.power_bank_details.reverse(), function(index, item) {
                    if(item.poc>0 && item.poc<=15) {bat_link = 'assets/images/smb/bat_red.png';}
                    else if(item.poc>15 && item.poc<50) {bat_link = 'assets/images/smb/bat_yel.png';}
                    else if(item.poc>=50) {bat_link = 'assets/images/smb/bat_green.png';}
                    else if(item.poc==0) {bat_link = 'assets/images/smb/bat_zero.png';}
                    $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id.toUpperCase()+`</p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;"><b>`+item.battery_status+`</b></p>
                                                                        <div class="row">
                                                                            <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="`+bat_link+`" height="25px"></h5></div>
                                                                            <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">`+item.poc+`%</h4></div>
                                                                            <div class="col-6 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.capacity+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.cycle+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.type+`</b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    /*if(item.battery_status=='Charging') {
                        $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id+`</p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Battery Status- `+item.battery_status+`</p>
                                                                        <div class="row">
                                                                            <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                            <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">`+item.poc+`%</h4></div>
                                                                            <div class="col-6 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.capacity+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.cycle+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.type+`</b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    }
                    else if(item.battery_status=='Damaged') {
                        $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id+`</p>
                                                                        <div class="row">
                                                                            <div class="col-12" style="padding: 0;">
                                                                                <h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;">
                                                                                    <img src="assets/images/smb/critical-battery.png" style="max-width: 48px;">
                                                                                </h5>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 text-center" style="padding: 0;">
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;">
                                                                                    <b>Damage Detected</b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    }
                    else if(item.battery_status=='Disconnected') {
                        $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id+`</p>
                                                                        <div class="row">
                                                                            <div class="col-12" style="padding: 0;">
                                                                                <h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;">
                                                                                    <img src="assets/images/smb/dead-battery.png" style="max-width: 48px;">
                                                                                </h5>
                                                                            </div>
                                                                            
                                                                            <div class="col-12 text-center" style="padding: 0;">
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;">
                                                                                    <b>Power Bank Disconnected</b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    }
                    else {
                        $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id+`</p>
                                                                        <div class="row">
                                                                            <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="assets/images/smb/battery-blue.png" height="25px"></h5></div>
                                                                            <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">`+item.poc+`%</h4></div>
                                                                            <div class="col-6 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.capacity+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.cycle+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.type+`</b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    }*/
                });
            }else {
                $('#power_bank_container').html(`<div class="col-12 text-center"">
                    <p class="text-center text-danger" style="padding-left:15px">No Power Bank Attached to this SSM</p>
                </div>`);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
    /* Info Button click show details */
    $(".view_btn").click(function () {
        $("#viewModal").modal("show");
        var viewId = $(this).attr("id").split("_")[1];
        $.ajax({
            type: "POST",
            url: "backend/smb/modal.php",
            data: {id:viewId},
            success: function(result) {
                var data = jQuery.parseJSON(result);
                //console.log(data);
                $("#viewHeader").text(data.ref);
                $("#ref_no").text(data.ref);
                $("#model").text(data.model);
                $("#notes").text(data.note);
                $("#contact_no").text(data.contact);
                //$("#assign_date").text(data.assign_date);
                $("#deliver_date").text(data.deliver_date);
                $("#country_pro").text(data.country);
                if(data.pro_assigned.length>0) {
                    $("#project_assigned").text(data.pro_assigned[0]);
                    // jQuery.each(data.pro_assigned, function(index, item) {
                    //     $("#project_assigned").text(item+' ');
                    // });
                } else {
                    $("#project_assigned").text('None');
                }
                if(data.resp.length>0) {
                    $("#ssm_responsible").text(data.resp[0]);
                } else {
                    $("#ssm_responsible").text('None');
                }
                
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    // var ok_status = true;
    // if(ok_status) {
    //     $('.power_source_err').css('display','none');
    // }
    // else if(!ok_status) {
    //     $('.power_source_ok').css('display','none');
    //     $('.charging').css('display','none');
    // }
    // var block = false;
    // var activate = 0;
    /* Reset Line graphs */
    const resetLineGraph = () => {
        $('#lineChart').remove();
        $('.energyGraphContainer').append('<canvas id="lineChart" height="350"></canvas>');
    }
    
    /* Load graph on page load */
    
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
            if (result.total_report.length == 0) {
                $('#sol_energy_amount').text('0W');
                $('#grid_energy_amount').text('0W');
                $('#bat_energy_amount').text('0W');
            } else {
                $('#sol_energy_amount').text(result.total_report[0].total_solar_energy + 'Whr');
                $('#grid_energy_amount').text(result.total_report[0].total_grid_energy + 'Whr');
                $('#bat_energy_amount').text(result.total_report[0].total_battery + 'Whr');
            }
            if (result.energy_data.length == 0) {
                $("#errMsgGraph").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
            } else {
                chartData = result.energy_data;
                jQuery.each(chartData.reverse(), function(index, item) {
                    solarDataForGraph.push(item.a);
                    gridDataForGraph.push(item.b);
                    batteryDataForGraph.push(item.c);
                    /* Converting to current timezone */
                    var dbDateTime = new Date(item.y);
                    var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                    var dbOffset = dbDateTime.getTimezoneOffset();
                    var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                    var thisTimeZone = new Date(thisTimeZoneMs);
                    datesForGraph.push(thisTimeZone.toLocaleString());
                    //console.log(thisTimeZone.toLocaleString()+'---'+item.y);
                    //datesForGraph.push(item.y);
                    if(index == (chartData.length - 1)){
                        lastIdForGraph = item.id;
                    }
                });
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                //console.log(energyChartData);
                //console.log(lastIdForGraph);
                chartUpdateVar= $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts);
            }
        });
    //loadGraph(user_id, ssm_id);
    /* Updating data in time interval */
    setInterval(function() {
        $.ajax({
            type: "POST",
            url: "/assets/api/ssm_select_by_id_pg.php",
            data: JSON.stringify({'user_id':user_id,'ssm_id':ssm_id}),
            success: function(result){
                result = result.res[0];
                if(result.gnss_location_details!=null) {
                    latestLat = result.gnss_location_details[0].latitude;
                    latestLng = result.gnss_location_details[0].longitude;
                }
                lastSeen = result.updated_at;
                imei = result.imei;
                emei = result.emei;
                remBat = result.total_charge+'%';
                sos_act = result.device_status;
                //console.log(result);
                var dbDate = new Date(lastSeen); // some mock date
                //var milliseconds = Math.floor(dbDate.getTime()/1000)
                var milliseconds = dbDate.getTime();
                lastSeenTimeAgo = time2TimeAgo(milliseconds);
                lastSeenTZ = setTimeZone(lastSeen);
                newDateFormat = lastSeenTZ.toLocaleString();
                var splitTime = lastSeenTZ.toString().split(' ');
                var countryTZ = lastSeenTZ.toString().match(/\(([^)]+)\)/)[1];
                var countrySplit = countryTZ.replace('Standard ','');
                if(lastSeenTimeAgo.timeAgo<=600) {
                    $("#live_data_status").html(`<h6 class="text-white">Online <i class="mdi mdi-checkbox-blank-circle text-success font-10"></i></h6>`);
                    $("#net").text(result.network_id);
                    if(result.signal_strength>=0 && result.signal_strength<21){ $("#sig_st").text('Poor');sigStr='Poor';}
                    else if(result.signal_strength>=21 && result.signal_strength<41){ $("#sig_st").text('Good');sigStr='Good';}
                    else if(result.signal_strength>=41 && result.signal_strength<99){ $("#sig_st").text('Excellent');sigStr='Excellent';}
                    else { $("#sig_st").text('Unknown Signal');sigStr='Unknown Signal';}
                }
                else {
                    $("#live_data_status").html(`<h6 class="text-white">Offline <i class="mdi mdi-checkbox-blank-circle text-danger font-10"></i></h6>`);
                    $("#net").text('--');
                    $("#sig_st").text('--');sigStr='--';
                }
                //$(".bat_status").text('Battery Status: '+result.total_charge_avg+'%');
                if(result.total_charge_avg!=null) {
                    $(".bat_status").text('Battery Status: '+result.total_charge_avg+'%');
                    $("#total_charge").text(result.total_charge_avg+'%');
                } else {
                    $(".bat_status").text('Battery Status: 0%');
                    $("#total_charge").text('0%');
                }
                $(".imei").text('IMEI- '+result.imei);
                $(".emei").text('EMEI- '+result.emei);
                if(result.temperature!='') {
                    $("#device_temperature").html(result.temperature+'&deg;'+'C');
                } else {$("#device_temperature").text('-');}
                if(result.total_session!='') {
                    $("#total_session").text(result.total_session+'min');
                } else {$("#total_session").text('-');}
                $("#last_update").text(lastSeenTimeAgo.message+', '+newDateFormat+' '+splitTime[5]+' '+countrySplit);
                //$("#total_charge").text(result.total_charge_avg+'%');
                $("#power_source_status").text(result.power_source_status);
                if(result.power_source_status=='Disconnected') {
                    $("#power_source_type").text('-');
                } else {$("#power_source_type").text(result.power_source_type);}
                /* If Sos is Not activated */
                if(result.device_status=='1'){
                    $(".gf-status").mouseover(function () {
                        $('.img-gf').attr('src', $('.img-gf').data("hover"));
                    }).mouseout(function () {
                        $('.img-gf').attr('src', $('.img-gf').data("src"));
                    });
                    $(".gf-status").css('background-color', '');
                    $('.img-gf').attr('src', $('.img-gf').data("src"));
                    $('.sos-text').html('<b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="SSM not in Danger"></i>&nbsp;SOS Not Active</b>');
                }
                /* If Sos is activated */
                else {
                    $(".gf-status").css('background-color', '#FF0000');
                    $('.img-gf').attr('src', $('.img-gf').data("hover"));
                    $(".gf-status").mouseover(function () {
                        $('.img-gf').attr('src', $('.img-gf').data("src"));
                        
                    }).mouseout(function () {
                        $('.img-gf').attr('src', $('.img-gf').data("hover"));
                    });
                    $('.sos-text').html('<b><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="SSM in danger"></i>&nbsp;SOS Activated</b>');
                    
                }
                if(result.power_bank_details.length>0) {
                    $('#power_bank_container').html('');
                    jQuery.each(result.power_bank_details.reverse(), function(index, item) {
                        if(item.poc>0 && item.poc<=15) {bat_link = 'assets/images/smb/bat_red.png';}
                        else if(item.poc>15 && item.poc<50) {bat_link = 'assets/images/smb/bat_yel.png';}
                        else if(item.poc>=50) {bat_link = 'assets/images/smb/bat_green.png';}
                        else if(item.poc==0) {bat_link = 'assets/images/smb/bat_zero.png';}
                        $('#power_bank_container').append(`<div class="col-4" style="padding: 0;padding-right: 5px;">
                                                                <div class="card m-b-10">
                                                                    <div class="card-body" style="padding: 0;">
                                                                        <p class="text-white bg-plan text-center" style="margin-bottom: 0;"><b>Power Bank `+(index+1)+`</b></p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;">Serial No- `+item.battery_id.toUpperCase()+`</p>
                                                                        <p class="text-plan text-center" style="margin-bottom: 5px;"><b>`+item.battery_status+`</b></p>
                                                                        <div class="row">
                                                                            <div class="col-6" style="padding: 0;"><h5 class="text-center" style="margin-bottom: 5px;margin-top: 5px;"><img src="`+bat_link+`" height="25px"></h5></div>
                                                                            <div class="col-6" style="padding: 0;"><h4 class="text-plan text-left" style="margin-bottom: 5px;margin-top: 5px;">`+item.poc+`%</h4></div>
                                                                            <div class="col-6 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-center" style="margin-bottom: 5px;font-size: x-small;"><b>Capacity</b></p>
                                                                                <p class="text-plan text-center" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.capacity+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Cycles</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.cycle+`</b></p>
                                                                            </div>
                                                                            <div class="col-3 text-center" style="padding: 0;">
                                                                                <p class="text-muted text-left" style="margin-bottom: 5px;font-size: x-small;"><b>Type</b></p>
                                                                                <p class="text-plan text-left" style="margin-bottom: 5px;font-size: x-small;"><b>`+item.type+`</b></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    });
                }else {
                    $('#power_bank_container').html(`<div class="col-12 text-center"">
                        <p class="text-center text-danger" style="padding-left:15px">No Power Bank Attached to this SSM</p>
                    </div>`);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
        //resetLineGraph();
        //loadGraph(user_id, ssm_id);
        //console.log($.ChartJsLine.lineChart);
        
        $.ajax({
            type: "POST",
            url: "assets/api/new_map_data.php",
            data: JSON.stringify(arr)
        }).done(function(result) {
            //console.log(result);
            if (result.total_report.length == 0) {
                $('#sol_energy_amount').text('0W');
                $('#grid_energy_amount').text('0W');
                $('#bat_energy_amount').text('0W');
            } else {
                $('#sol_energy_amount').text(result.total_report[0].total_solar_energy + 'Whr');
                $('#grid_energy_amount').text(result.total_report[0].total_grid_energy + 'Whr');
                $('#bat_energy_amount').text(result.total_report[0].total_battery + 'Whr');
            }
            if (result.energy_data.length == 0) {
                $("#errMsgGraph").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
            } else {
                chartData;
                chartData = result.energy_data;
                // energyChartData.lineCharts.datasets[0].data.pop();
                // energyChartData.lineCharts.datasets[1].data.pop();
                // energyChartData.lineCharts.datasets[2].data.pop();
                // energyChartData.lineCharts.labels.pop();
                jQuery.each(chartData.reverse(), function(index, item) {
                    // solarDataForGraph.push(item.a);
                    // gridDataForGraph.push(item.b);
                    // batteryDataForGraph.push(item.c);
                    // datesForGraph.push(item.y);
                    // if(index == (chartData.length - 1)){
                        if(item.id>lastIdForGraph) {
                            energyChartData.lineCharts.datasets[0].data.push(item.a);
                            energyChartData.lineCharts.datasets[1].data.push(item.b);
                            energyChartData.lineCharts.datasets[2].data.push(item.c);
                            /* Converting to current timezone */
                            var dbDateTime = new Date(item.y);
                            var dbDateTimeMs = Math.floor(dbDateTime.getTime());
                            var dbOffset = dbDateTime.getTimezoneOffset();
                            var thisTimeZoneMs = dbDateTimeMs-(dbOffset*60*1000);
                            var thisTimeZone = new Date(thisTimeZoneMs);
                            energyChartData.lineCharts.labels.push(thisTimeZone.toLocaleString());
                            lastIdForGraph = item.id;
                        } else {lastIdForGraph=lastIdForGraph;}
                    //}
                });
                //energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                //console.log(energyChartData);
                chartUpdateVar.update();
            }
        });
    }, 30000);
    /* Filter graph by date */
    $(document).on('click', '#filterBtn', function() {
        arr = {user_id: user_id, ssm: ssm_id, from_date: $("#date-from").val(), to_date: $("#date-to").val()};
        $.ajax({
            type: "POST",
            url: "assets/api/new_map_data.php",
            data: JSON.stringify(arr)
        }).done(function(result) {
            //console.log(result);
            if (result.total_report.length == 0) {
                $('#sol_energy_amount').text('0W');
                $('#grid_energy_amount').text('0W');
                $('#bat_energy_amount').text('0W');
            } else {
                $('#sol_energy_amount').text(result.total_report[0].total_solar_energy + 'Whr');
                $('#grid_energy_amount').text(result.total_report[0].total_grid_energy + 'Whr');
                $('#bat_energy_amount').text(result.total_report[0].total_battery + 'Whr');
            }
            resetLineGraph();
            solarDataForGraph = [];
            gridDataForGraph = [];
            batteryDataForGraph = [];
            datesForGraph = [];
            if (result.energy_data.length == 0) {
                $("#errMsgGraph").text('Sorry! No data found for Graph.').show().delay(10000).hide("slow");
            } else {
                chartData = result.energy_data;
                jQuery.each(chartData.reverse(), function(index, item) {
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
                    datesForGraph.push(thisTimeZone.toLocaleString());
                    if(index == (chartData.length - 1) && item.id == lastIdForGraph){
                        lastIdForGraph = item.id;
                    } else {lastIdForGraph=lastIdForGraph}
                });
                //$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                energyChartData=$.ChartJsLine.init(solarDataForGraph, gridDataForGraph, batteryDataForGraph, datesForGraph);
                chartUpdateVar = $.ChartJsLine.respChart($("#lineChart"),'Line',energyChartData.lineCharts);
            }
        });
    });

     /* SMB edit popup */
     $('.info-edit-btn').click(function(){
        $('.info-form').toggle();
        $('.info-footer').css('display','flex');
        $('.info-view').css('display','none');
        $(this).css('display','none');
    });
    $('.info-cancel').click(function(){
        $('.info-form').toggle();
        $('.info-footer').css('display','none');
        $('.info-view').css('display','block');
        $('.info-edit-btn').css('display','inline-block');
    });
    /* SMB view page on hover change */
   $(".sos-status").mouseover(function () {
        $('.img-sos').attr('src', $('.img-sos').data("hover"));
    }).mouseout(function () {
        $('.img-sos').attr('src', $('.img-sos').data("src"));
    });
    /*$(".gf-status").mouseover(function () {
        $('.img-gf').attr('src', $('.img-gf').data("hover"));
    }).mouseout(function () {
        $('.img-gf').attr('src', $('.img-gf').data("src"));
    });*/
    $(".live-status").mouseover(function () {
        $('.img-live').attr('src', $('.img-live').data("hover"));
    }).mouseout(function () {
        $('.img-live').attr('src', $('.img-live').data("src"));
    });
    // $(".report-status").mouseover(function () {
    //     $('.img-report').attr('src', $('.img-report').data("hover"));
        
    // }).mouseout(function () {
    //     $('.img-report').attr('src', $('.img-report').data("src"));
    // });
    // $(".report-status").click(function () {
    //     block = !block;
    //     if(!block) {
    //         $(this).css('background-color', '');
    //         $(this).mouseover(function () {
    //             $('.img-report').attr('src', $('.img-report').data("hover"));
                
    //         }).mouseout(function () {
    //             $('.img-report').attr('src', $('.img-report').data("src"));
    //         });
    //         $('.block-smb-text').html('<b>Block SSM</b>');
    //     }
    //     else {
    //         $(this).css('background-color', '#707070');
    //         $(this).mouseover(function () {
    //             $('.img-report').attr('src', $('.img-report').data("src"));
                
    //         }).mouseout(function () {
    //             $('.img-report').attr('src', $('.img-report').data("hover"));
    //         });
    //         $('.block-smb-text').html('<b>SSM Blocked</b>');
    //     }
    // });

    $('.sos-status').click(function(){
        $('#timelineModal').modal('show');
        /* Filter location timeline */
        $(document).on('click', '#filter_btn', function() {
            var formDataTimeline = JSON.stringify({
                user_id: user_id,
                from_date: $("#start_date").val(),
                to_date: $("#end_date").val(),
                ssm_id: ssm_id
            });
            $.ajax({
                type: "POST",
                url: "/assets/api/location_select_by_ssm.php",
                data: formDataTimeline
            }).done(function(result) {
                //console.log(result);
                if (result.success == 1) {
                    $('#gmaps-markers').css('display', 'block');
                    mapTimeline = new GMaps({
                        div: '#gmaps-markers'
                    });
                    let infowindow = new google.maps.InfoWindow();
                    var bounds = new google.maps.LatLngBounds();
                    if(result.res.length > 0) {
                        
                        jQuery.each(result.res, function(index, item) {
                            // console.log(JSON.parse(item.device_responsible))
                            mapTimeline.addMarker({
                                lat: item.latitude,
                                lng: item.longitude,
                                details: {
                                    database_id: 42,
                                    author: 'HPNeo'
                                },
                                icon: iconCustom,
                                click: function(e) {
            
                                },
                                mouseover: function() {
                                    infowindow.open(mapTimeline, this);
                                    infowindow.setContent("<h4>" + item.latitude +
                                        "</h4><p><b>Latitude:</b> " + item.latitude + "</p><p><b>Longitude:</b> " + item.longitude +
                                        "</p><p><b>SSM Ref. No-:</b> " + item.ssm_id +
                                        "</p><p><b>Last Seen:</b> " + item.updated_at + "</p>")
                                },
                                mouseout: function() {
                                    infowindow.close();
                                }
                            });
                            bounds.extend(new google.maps.LatLng(item.latitude, item.longitude));
                        });
                    mapTimeline.fitBounds(bounds);
                    } else {
                        $("#errMsg").text('Sorry no data found in between the dates.').show().delay(5000).hide("slow");
                    }
                } else if (result.success == 0) {
                    $("#errMsg").text('Please set both start & end date to filter.').show().delay(5000).hide("slow");
                }
            });
        });
        // $('.timeline-map-btn').click(function(){
        //     $('#gmaps-markers').css('display', 'block');
        //     map = new GMaps({
        //         div: '#gmaps-markers',
        //         lat: 60.1699,
        //         lng: 24.9384
        //     });
        //     map.addMarker({
        //         lat: 60.1699,
        //         lng: 24.9384,
        //         title: 'Helsinki',
        //         details: {
        //         database_id: 42,
        //         author: 'HPNeo'
        //         },
        //         click: function(e){
        //         if(console.log)
        //             console.log(e);
        //         alert('You clicked in this marker');
        //         }
        //     });
        // });
    });
    $('.live-status').click(function(){
        $('#locateModal').modal('show');
        // Markers
        $('#locateModal').on('shown.bs.modal', function (e) {
            $('#gmaps-markers-locate').css('display', 'block');
            $('#myModalLabelLocate').text('Last Seen:'+lastSeenTZ.toLocaleString()+', Latitude:'+latestLat+', Longitude:'+latestLng);
            var mapCur = new GMaps({
                div: '#gmaps-markers-locate',
                lat: latestLat,
                lng: latestLng
            });
            let infowindowCur = new google.maps.InfoWindow();
            var marker = mapCur.addMarker({
                lat: latestLat,
                lng: latestLng,
                //title: 'Latitude:'+latestLat+',Longitude:'+latestLng,
                details: {
                animation: google.maps.Animation.DROP,
                author: 'HPNeo'
                },
                icon: iconCustom,
                click: function(e){
                
                },
                mouseover: function() {
                    infowindowCur.open(mapCur, this);
                    infowindowCur.setContent("<h4>" + ssm_id +
                        "</h4><p><b>Latitude:</b> " + latestLat + "</p><p><b>Longitude:</b> " + latestLng +
                        "</p><p><b>Last Seen:</b> " + lastSeenTZ.toLocaleString() + "</p>")
                },
                mouseout: function() {
                    infowindowCur.close();
                }
            });
            // function newLocation(newLat,newLng){
            //     var myCenter=new google.maps.LatLng(newLat, newLng);
            //     map.panTo({
            //         lat : newLat,
            //         lng : newLng
            //     });
            //     marker.setPosition(myCenter);
            // }
            // $('.change-loc').click(function(){
            //     newLocation(60.1710, 24.9500);
            // });
            // $("#range").ionRangeSlider({
            //     grid: true,
            //     from: 1,
            //     values: ["20:10:33", "20:12:44", "20:15:12", "20:16:18", "20:19:42", "20:21:12", "20:27:52", "20:29:12"],
            //     onChange: function(data) {
            //         if(data.from_value == '20:27:52') {
            //             newLocation(60.1710, 24.9500);
            //         }
            //         else if(data.from_value == '20:12:44') {
            //             newLocation(60.1699, 24.9384);
            //         }
            //     }
            // });
        });
    });
    $(".gf-status").click(function () {
        $('#sosModal').modal('show');
        $('#sosModal').on('shown.bs.modal', function (e) {
            $('#gmaps-markers-locate').css('display', 'block');
            map = new GMaps({
                div: '#gmaps-markers-sos',
                lat: latestLat,
                lng: latestLng
            });
            map.addMarker({
                lat: latestLat,
                lng: latestLng,
                title: 'Latitude:'+latestLat+',Longitude:'+latestLng,
                details: {
                database_id: 42,
                author: 'HPNeo'
                },
                icon: iconCustom,
                // click: function(e){
                // if(console.log)
                //     console.log(e);
                // alert('You clicked in this marker');
                // }
            });
            if(sos_act == '0') {
                $("#errMsgSOS").text('This device is in danger!!');
            }
            else {
                $("#msgSuccessSOS").text('This device is safe.');
            }
            $("#sosHeader").text(ssm_id);
            $("#sos_lat").text(latestLat);
            $("#sos_lng").text(latestLng);
            $("#sos_emei").text(emei);
            $("#sos_imei").text(imei);
            $("#sos_sig").text(sigStr);
            $("#sos_time").text(lastSeenTZ);
            $("#sos_bat").text(remBat);
            $("#sos_last_pos").text('Lat:'+latestLat+' Lng:'+latestLng);
            $.ajax({
                type: "POST",
                url: "backend/smb/modal.php",
                data: {id:info_id},
                success: function(result) {
                    var data = jQuery.parseJSON(result);
                    $("#sos_contact").text(data.contact);
                    if(data.resp.length>0) {
                        $("#sos_responsible").text(data.resp[0]);
                    } else {
                        $("#sos_responsible").text('None');
                    }
                    
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
    
});