$(document).ready(function() {
    /* Ajax Loader */
    $(document).ajaxSend(function() {
        $("#overlay-loader").fadeIn(300);
    });
    $(document).ajaxStop(function() {
        $("#overlay-loader").fadeOut(300);
    });

    var user_id = $("#data-id").val();
    loadNotification(user_id);
    /* Load data initially */
    var user_id = $("#data-id").val();
    var initialRole = $("#user-role").val();
    var initialCountry = $("#user-country").val();
    var initialPM = $('#pro_manager').val();
    var userData = {
        role: initialRole,
        country: initialCountry
    };
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
    var liveSSMData;
    var liveGFData= [];
    let liveDeviceTable = "";
    let liveGfTable = "";
    const iconCustom = {
        url: "assets/images/tespack-logo.png", // url
        scaledSize: new google.maps.Size(30, 30), // scaled size
    };
    $.ajax({
        type: "POST",
        url: "assets/api/ssm_data_for_map.php",
        data: JSON.stringify(arr)
    }).done(function(result) {
        console.log(result);
        if(result.res.length>0) {
            $("#smb_count").text(result.res.length);
            $("#ssm_count").text(result.res.length);
            liveSSMData = result.res;
            liveDevicesLoad(liveSSMData);
            map = new GMaps({
                div: '#gmaps-markers'
            });
            let infowindow = new google.maps.InfoWindow();
            var bounds = new google.maps.LatLngBounds();
            jQuery.each(result.res, function(index, item) {
                if(item.device_status==0) {
                    liveGFData.push(item);
                }
                // console.log(JSON.parse(item.device_responsible))
                //console.log(item.gnss_location_details.length);
                //if(item.gnss_location_details.length > 0) {
                if(item.gnss_location_details!=null) {
                    map.addMarker({
                        lat: item.gnss_location_details[0].latitude,
                        lng: item.gnss_location_details[0].longitude,
                        details: {
                            database_id: 42,
                            author: 'HPNeo'
                        },
                        icon: iconCustom,
                        click: function(e) {

                        },
                        mouseover: function() {
                            infowindow.open(map, this);
                            infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                        },
                        mouseout: function() {
                            infowindow.close();
                        }
                    });
                    bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                    }
                });
            map.fitBounds(bounds);
        } else {
            $("#smb_count").text('0');
            $("#ssm_count").text('0');
            $("#errMsg").text('Sorry no device found.').show().delay(5000).hide("slow");
        }
        liveGfLoad(liveGFData);
        $("#sos_count").text(liveGFData.length);
    });
    /* Get Initial dropdowns */
    var projectHtml = $('#project').get(0).innerHTML;
    var countryHtml = $('#country').get(0).innerHTML;
    var pmHtml = $('#pro_manager').get(0).innerHTML;
    var ssmHtml = $('#ssm_device').get(0).innerHTML;
    /* Changing dropdowns on select */
    var selected_project;
    var selected_pm;
    var selected_ssm;
    $(document).on('change', 'select', function() {
        //arr = {'user_id':user_id, 'country':'','project':'','pro_manager':'','ssm':''};
        // if ($(this).attr("id") == 'country') {
        //     arr.country = $(this).val();
        // } else if ($(this).attr("id") == 'project') {
        //     arr.project = $(this).val();
        //     selected_project = $(this).find("option:selected").text();
        // } else if ($(this).attr("id") == 'pro_manager') {
        //     arr.pro_manager = $(this).val();
        //     selected_pm = $(this).find("option:selected").text();
        // } else if ($(this).attr("id") == 'ssm_device') {
        //     arr.ssm = $(this).val();
        //     selected_ssm = $(this).find("option:selected").text();
        // }
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
        //console.log(arr);
        var selectData = {
            type: $(this).attr("id"),
            value: $(this).val()
        };
        $.ajax({
            type: "POST",
            url: "assets/api/ssm_data_for_map.php",
            data: JSON.stringify(arr),
            success: function(result) {
                liveGfTable.destroy();
                //var data = jQuery.parseJSON(result);
                //console.log(result);
                liveGFData= [];
                if(result.res.length>0) {
                    $("#smb_count").text(result.res.length);
                    $("#ssm_count").text(result.res.length);
                    map = new GMaps({
                        div: '#gmaps-markers'
                    });
                    let infowindow = new google.maps.InfoWindow();
                    var bounds = new google.maps.LatLngBounds();
                    jQuery.each(result.res, function(index, item) {
                        if(item.device_status==0) {
                            liveGFData.push(item);
                        } 
                        //console.log(item.gnss_location_details[0].latitude)
                        //if(item.gnss_location_details.length>0) {
                        if(item.gnss_location_details!=null) {
                            map.addMarker({
                                lat: item.gnss_location_details[0].latitude,
                                lng: item.gnss_location_details[0].longitude,
                                details: {
                                    database_id: 42,
                                    author: 'HPNeo'
                                },
                                icon: iconCustom,
                                click: function(e) {

                                },
                                mouseover: function() {
                                    infowindow.open(map, this);
                                    infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                        "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                        "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                        "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                                },
                                mouseout: function() {
                                    infowindow.close();
                                }
                            });
                            bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                        }
                    });
                    map.fitBounds(bounds);
                    
                } else {
                    $("#smb_count").text('0');
                    $("#ssm_count").text('0');
                    $("#errMsg").text('Sorry no device found.').show().delay(5000).hide("slow");
                }
                
                liveGfLoad(liveGFData);
                $("#sos_count").text(liveGFData.length);
                
                liveSSMData = result.res;
                liveDeviceTable.destroy();
                liveDevicesLoad(liveSSMData);
                if (result.status == 1) {
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
                    $('#country').find('option').not(':first').remove();
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
        //$("input[type=date]").val("");
        //var arr = {'user_id': user_id, 'country': '', 'project': Number('0'), 'pro_manager': Number('0'), 'ssm': '', 'from_date': '', 'to_date': ''};
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
        $.ajax({
            type: "POST",
            url: "assets/api/ssm_data_for_map.php",
            data: JSON.stringify(arr)
        }).done(function(result) {
            liveGFData= [];
            //console.log(result);
            if(result.res.length>0) {
                $("#smb_count").text(result.res.length);
                $("#ssm_count").text(result.res.length);
                liveSSMData = result.res;
                // console.log(liveSSMData)
                liveDeviceTable.destroy();
                liveGfTable.destroy();
                liveDevicesLoad(liveSSMData);
                map = new GMaps({
                    div: '#gmaps-markers'
                });
                let infowindow = new google.maps.InfoWindow();
                var bounds = new google.maps.LatLngBounds();
                jQuery.each(result.res, function(index, item) {
                    if(item.device_status==0) {
                        liveGFData.push(item);
                    } 
                // console.log(JSON.parse(item.device_responsible))
                    //console.log(item.gnss_location_details.length);
                    //if(item.gnss_location_details.length > 0) {
                    if(item.gnss_location_details!=null) {
                        map.addMarker({
                            lat: item.gnss_location_details[0].latitude,
                            lng: item.gnss_location_details[0].longitude,
                            details: {
                                database_id: 42,
                                author: 'HPNeo'
                            },
                            icon: iconCustom,
                            click: function(e) {

                            },
                            mouseover: function() {
                                infowindow.open(map, this);
                                infowindow.setContent("<h4>" + item.gnss_location_details[0].latitude +
                                    "</h4><p><b>Latitude:</b> " + item.gnss_location_details[0].latitude + "</p><p><b>Longitude:</b> " + item.gnss_location_details[0].longitude +
                                    "</p><p><b>Team:</b> " + item.team_name + "</p><p><b>SMB Ref. No-:</b> " + item.ssm_id +
                                    "</p><p><b>Last Seen:</b> " + item.last_seen_time + "</p>")
                            },
                            mouseout: function() {
                                infowindow.close();
                            }
                        });
                        bounds.extend(new google.maps.LatLng(item.gnss_location_details[0].latitude, item.gnss_location_details[0].longitude));
                        }
                    });
                map.fitBounds(bounds);
            } else {
                $("#smb_count").text('0');
                $("#ssm_count").text('0');
                $("#errMsg").text('Sorry no device found.').show().delay(5000).hide("slow");
            }
            liveGfLoad(liveGFData);
            $("#sos_count").text(liveGFData.length);
            if (result.status == 1) {
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
            }
        });
    });
    /* Selectboxes in the table */
    $("#checkall").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        $('.del-btn').css('display', 'inline-block');
        $('.checkItem').each(function() {
            $(this).css('visibility', 'visible');
        });
    });

    $("input[type=checkbox]").click(function() {
        if (!$(this).prop("checked")) {
            $("#checkall").prop("checked", false);
            $('.del-btn').css('display', 'none');
            $('.checkItem').each(function() {
                $(this).css('visibility', 'hidden');
            });
        }
    });
    $('.checkItem').each(function() {
        if (!$(this).prop("checked")) {
            $(this).css('visibility', 'hidden');
        } else if ($(this).prop("checked")) {
            $(this).css('visibility', 'visible');
        }
    });

    /* Maps page on hover change */
    $(".sos-status").mouseover(function() {
        $('.img-sos').attr('src', $('.img-sos').data("hover"));
    }).mouseout(function() {
        $('.img-sos').attr('src', $('.img-sos').data("src"));
    });
    $(".gf-status").mouseover(function() {
        $('.img-gf').attr('src', $('.img-gf').data("hover"));
    }).mouseout(function() {
        $('.img-gf').attr('src', $('.img-gf').data("src"));
    });
    $(".live-status").mouseover(function() {
        $('.img-live').attr('src', $('.img-live').data("hover"));
    }).mouseout(function() {
        $('.img-live').attr('src', $('.img-live').data("src"));
    });
    $(".report-status").mouseover(function() {
        $('.img-report').attr('src', $('.img-report').data("hover"));
    }).mouseout(function() {
        $('.img-report').attr('src', $('.img-report').data("src"));
    });
    $(document).on('click', '.sos-status', function() {
        $('#sosModal').modal('show');
        //console.log(liveGFData);
    });

    $(document).on('click', '.live-status', function() {
        $('#liveModal').modal('show');
        if (liveSSMData.length > 0) {
            // liveDevicesLoad("")
        }
    });

    function liveDevicesLoad(data) { 
        liveDeviceTable = $('#datatable_liveSSM').DataTable({
            // scrollY: '150px',
            // scrollCollapse: true,
            "lengthMenu": [5, 10, 15, 20, 25],
            data: data,
            columns: [{
                    render: function(data, type, row, meta) {

                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'ssm_id'
                },
                {

                    render: function(data, type, row, meta) {
                        var temp = '';
                        let dump = row.device_responsible
                        if (dump != null) {
                            for (i = 0; i < dump.length; i++) {
                                temp += dump[i]
                            }
                        }
                        return temp;
                    }
                },
                {
                    data: 'team_name'
                }
            ],
        });

    }
    function liveGfLoad(data) {
        
          
        liveGfTable = $('#datatable_gf').DataTable({
            // scrollY: '150px',
            // scrollCollapse: true,
            "lengthMenu": [5, 10, 15, 20, 25],
            data: data,
            columns: [/*{
                    render: function(data, type, row, meta) {

                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },*/
                {
                    data: 'ssm_id'
                },
                {

                    render: function(data, type, row, meta) {
                        var temp = '';
                        let dump = row.device_responsible
                        if (dump != null) {
                            for (i = 0; i < dump.length; i++) {
                                temp += dump[i]
                            }
                        }
                        return temp;
                    }
                },
                {
                    data: 'team_name'
                }
            ],
        });
        

    }
});