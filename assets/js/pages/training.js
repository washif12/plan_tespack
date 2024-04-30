$(document).ready(function() {
    /* Ajax Loader */
    $(document).ajaxSend(function() {
        $("#overlay-loader").fadeIn(300);
    });
    $(document).ajaxStop(function() {
        $("#overlay-loader").fadeOut(300);
    });
    var user_id = $("#data-id").val();
    var user_role = $("#data-role").val();
    //console.log(user_role);
    loadNotification(user_id);
    function insertModalReset() {
        window.location.reload();
    }
    /* Adding Tutorials */
    $(document).on('click', '#addTut', function() {
        var formData = {
            title: $("#title").val(),
            link: $("#link").val(),
            desc: $("#desc").val()
        };

        $.ajax({
            type: "POST",
            url: "backend/trainings/create.php",
            data: formData,
        }).done(function(result) {
            var data = jQuery.parseJSON(result);
            //console.log(data);
            if (data.success == 0) {
                $("#errMsg").text(data.message).show().delay(4000).hide("slow");
            } else if (data.success == 1) {

                //start Activity
                var formData = {
                    user_id: $("#data-id").val(),
                    section: 'Tutorial',
                    command: 'Added',
                    user_trc_details: document.getElementById("user_trc_details").value,
                    description: `${$("#data-name").val()} Added a new Tutorial.<br>Title: ${$("#title").val()} `
                };
                $.ajax({
                    type: "POST",
                    url: "/assets/api/activity_log.php",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(result) {
                        // console.log(result)
                    },

                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                })

                //end Activity log//

                $("#msgSuccess").text('You have successfully added a new Tutorial!').show().delay(4000).hide("slow", insertModalReset);
            }
        });
    });
    /* Editing Tutorials */
    let editLoadData = "";
    $(document).on('click', '.edit_modal', function() {
        var editId = $(this).attr("id").split("_")[1];
        //console.log(editId);
        $.ajax({
            type: "POST",
            url: "backend/trainings/modal.php",
            data: {
                id: editId
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                editLoadData = data;
                $("#editTitle").val(data.fields[0]);
                $("#editLink").val(data.fields[1]);
                $("#editDesc").val(data.fields[2]);
                $("#editHead").text(data.fields[3]);
            },
            error: function(err) {
                console.log(err);
            }
        });
        $("#editModal").modal("show");

        $(".edit_btn").click(function() {
            var editFormData = {
                title: $("#editTitle").val(),
                link: $("#editLink").val(),
                desc: $("#editDesc").val(),
                id: editId
            };
            $.ajax({
                type: "POST",
                url: "backend/trainings/update.php",
                data: editFormData,
            }).done(function(result) {
                var data = jQuery.parseJSON(result);
                //console.log(data);
                if (data.success == 0) {
                    $("#errMsgEdit").text(data.message).show().delay(3000).hide("slow");
                } else if (data.success == 1) {
                    //start activity log//
                    let checkEditData = '';
                    let limit = 0;
                    if (editLoadData.fields[0].trim() != editFormData.title.trim()) {
                        checkEditData += `<br>Title : ${editLoadData.fields[0]} to ${editFormData.title} |`;
                        limit += 1;
                    }
                    if (editLoadData.fields[1].trim() != editFormData.link.trim()) {
                        checkEditData += `<br>Link : ${editLoadData.fields[1]} to ${editFormData.link} |`
                        limit += 1;
                    }
                    if (editLoadData.fields[2].trim() != editFormData.desc.trim()) {
                        checkEditData += `<br>Description : ${editLoadData.fields[2]} to ${editFormData.desc} |`
                        limit += 1;
                    }

                    checkEditData = checkEditData.replaceAll(" |", ", ");
                    checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'Tutorial',
                        command: 'Edited',
                        user_trc_details: document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Edited ${editLoadData.fields[0]}'s details ${checkEditData} `
                    };
                    $.ajax({
                        type: "POST",
                        url: "/assets/api/activity_log.php",

                        data: JSON.stringify(formData),
                        contentType: "application/json",
                        success: function(result) {
                            // console.log(success)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error: ' + textStatus + ' - ' + errorThrown);
                        }

                    })

                    //end activity log//
                    $("#msgSuccessEdit").text('You have successfully edited this record!').show().delay(4000).hide("slow", insertModalReset);
                }
            });
        });
    });
    $(document).on('click', '.del_modal', function() {
        $("#delModal").modal("show");
        var delId = $(this).attr("id").split("_")[1];
        var dataName = $(this).attr("name");
        $(".del_btn").click(function() {
            $.ajax({
                type: "POST",
                url: "backend/trainings/delete.php",
                data: {
                    id: delId
                },
                success: function(data) {
                    //start Activity
                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'Country',
                        command: 'Deleted',
                        user_trc_details: document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Deleted ${dataName} From Tutorial List `
                    };
                    $.ajax({
                        type: "POST",
                        url: "/assets/api/activity_log.php",
                        data: JSON.stringify(formData),
                        contentType: "application/json",
                        success: function(result) {
                            // console.log(result)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error: ' + textStatus + ' - ' + errorThrown);
                        }
                    })

                    //end Activity log//

                    location.reload();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
});