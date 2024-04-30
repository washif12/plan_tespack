$(document).on('click', '.btn_download', function () {
    $("#downloadModal").modal("show");
    var dlId = $(this).attr("id").split("_")[1];
    console.log(dlId);
    $(".download_btn").click(function () {
        if (dlId == 'battery') {
            $(".btn-battery").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded total battery cycle report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
        else if (dlId == 'cycle') {
            $(".btn-cycle").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded battery cycle report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
        else if (dlId == 'carbon') {
            $(".btn-carbon").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded carbon emission report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
        else if (dlId == 'energy') {
            $(".btn-energy").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded energy report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
        else if (dlId == 'parts') {
            $(".btn-parts").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded device's parts replacement report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
        else if (dlId == 'security') {
            $(".btn-security").trigger("click");
            var formData = {
                user_id: $("#data-id").val(),
                section: 'Report',
                command: 'Download',
                user_trc_details: $("#user_trc_details").val(),
                description: `${$("#data-name").val()} dowloaded geofence alert report.`
            };
            $.ajax({
                type: "POST",
                url: "/assets/api/activity_log.php",

                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function (result) {
                    // console.log(success)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }

            })

            //end activity log//
            dlId = '';
        }
    });
});