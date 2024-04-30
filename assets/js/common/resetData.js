const gfChange = (user_id, deviceId, method) => {
    var gf_status = [];
    $.ajax({
        type: "POST",
        url: "assets/api/geofencing_data_by_user_pg.php",
        data: JSON.stringify({
            'user_id': user_id
        }),
        success: function (result) {
            //console.log(result);
            if (result.status == '0') {
                //$("#errMsg").text('There is an error, please check your inputs').show().delay(4000);
            } else if (result.status == '1') {
                var gf_circle_details;
                var gf_devices;
                var in_device = [];
                var out_device = [];
                var jsonObj = {};
                var geofence_key;
                jQuery.each(result.res, function (index, item) {

                    in_device = [];
                    out_device = [];
                    geofence_key = item.id;
                    gf_circle_details = JSON.parse(item.shape_details);
                    gf_devices = item.device;
                    jQuery.each(gf_devices, function (indexDev, itemDev) {
                        jsonObj = {};
                        var deviceLatLng = new google.maps.LatLng(itemDev.latitude, itemDev.longitude);
                        var circleCenterLatLng = new google.maps.LatLng(gf_circle_details.center.lat, gf_circle_details.center.lng);
                        var distance = google.maps.geometry.spherical.computeDistanceBetween(deviceLatLng, circleCenterLatLng);
                        jsonObj['gf_id'] = geofence_key;
                        //jsonObj['foreign_id'] = itemDev.geofence_device_id;
                        jsonObj['foreign_id'] = geofence_key;
                        jsonObj['ssm_id'] = itemDev.ssm_id;
                        jsonObj['des2'] = itemDev.ssm_id;
                        jsonObj['for'] = method;
                        jsonObj['user_id'] = user_id;
                        let date = new Date();
                        jsonObj['user_date'] = date;
                        jsonObj['foreign_st'] = 'geofencing';
                        if (distance <= gf_circle_details.radius) {
                            //in_device.push(itemDev.ssm_id);
                            jsonObj['pos'] = 'inside';
                            jsonObj['title'] = `<strong>${itemDev.ssm_id}</strong> is inside of the geofence`;
                            jsonObj['content'] = `<strong>${itemDev.ssm_id}</strong> is inside of the geofence`;
                            jsonObj['des1'] = 'inside';
                        } else {
                            //out_device.push(itemDev.ssm_id);
                            jsonObj['title'] = `<strong>${itemDev.ssm_id}</strong> is outside of the geofence`;
                            jsonObj['content'] = `<strong>${itemDev.ssm_id}</strong> is outside of the geofence`;
                            jsonObj['pos'] = 'outside';
                            jsonObj['des1'] = 'outside';
                        }
                        //jsonObj['outside'] = out_device;
                        gf_status.push(jsonObj);
                    });
                    //gf_status.push(jsonObj);
                });
                if (deviceId != '') {
                    gf_status = gf_status.filter(item => (item.ssm_id == deviceId));
                } else {
                    gf_status = gf_status;
                }
                //console.log(gf_status);
                // if (method == 0) {
                    try {
                        fetch('/assets/api/ssm_compare_and_notification_insert.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                info: gf_status,
                                user_id: parseInt(user_id)
                            }),
                        }).then((response) => response.json())
                            .then((responseJson) => {
                                if (responseJson.status) {
                                    //console.log(responseJson.success);
                                    
                                }
                            })
                    }
                    catch (error) {
                        console.log(error)
                    }
                    loadNotification(user_id);
                // } 
              
                
                // else {
                //     gf_status && gf_status.map(async (item) => {
                //         if (method == 1) {
                //             let res = await saveNotification(item);
                //             await pushNotification({
                //                 ...item,
                //                 ...res
                //             });
                           
                //         } else {
                //             let response = await notification('', item);
                //             if (response.res[0] && method == 2) {
                //                 if (response.res[0].des1 != item.des1) {
                //                     let res = await saveNotification(item);
                //                     await pushNotification({
                //                         ...item,
                //                         ...res
                //                     });
                        
                //                 }
                //             }
                //         }
                //     })
                //      loadNotification(user_id);
                // }
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}