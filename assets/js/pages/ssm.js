$(document).ready(function() {
    /* Ajax Loader */
    $(document).ajaxSend(function() {
        $("#overlay-loader").fadeIn(300);
    });
    $(document).ajaxStop(function() {
        $("#overlay-loader").fadeOut(300);
    });
    /*Add SMB */
    var user_id = $("#data-id").val();
    loadNotification(user_id);
    function insertModalReset() {
        window.location.reload();
    }
    $("#addSmb").click(function(event) {
        var formData = {
            model: $("#model").val(),
            date: $("#date").val(),
            contact: $("#contact").val(),
            country: $("#country").val(),
            ref_no: $("#ref_no").val(),
            note: $("#note").val()
        };

        $.ajax({
            type: "POST",
            url: "backend/smb/insert.php",
            data: formData,
            encode: true,
        }).done(function(result) {
            var data = jQuery.parseJSON(result);
            //console.log(data);
            if (data.success == 0) {
                $("#errMsg").text(data.message).show().delay(3000).hide("slow");
            } else if (data.success == 1) {

                //start Activity ADD
                var formData = {
                    user_id: $("#data-id").val(),
                    section: 'SSM',
                    command: 'Added',
                    user_trc_details : document.getElementById("user_trc_details").value,
                    description: `${$("#data-name").val()} Added ${$("#ref_no").val()} in the SSM List<br>Model : ${$("#model").val()}<br>Country : ${$("#country").val()}`
                };
                $.ajax({
                    type: "POST",
                    url: "/assets/api/activity_log.php",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(result) {
                        // console.log(result)
                    },

                    error: function(err) {
                        console.log(err);
                    }
                })

                //end Activity log//

                $("#msgSuccess").text('You have successfully added a new SMB!').show().delay(6000).hide("slow", insertModalReset);
            }
        });
    });
    $(document).on('click', '.del_modal', function() {
        $("#delModal").modal("show");
        var delId = $(this).attr("id").split("_")[1];
        var dataName = $(this).attr("name");

        $(".del_btn").click(function() {
            $.ajax({
                type: "POST",
                url: "backend/smb/delete.php",
                data: {
                    id: delId
                },
                success: function(data) {
                    //start Activity
                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'Country',
                        command: 'Added',
                        user_trc_details : document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Deleted ${dataName} From SSM List`
                    };
                    $.ajax({
                        type: "POST",
                        url: "/assets/api/activity_log.php",
                        data: JSON.stringify(formData),
                        contentType: "application/json",
                        success: function(result) {
                            // console.log(result)
                        },

                        error: function(err) {
                            console.log(err);
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
    let editLoadData = '';
    $(document).on('click', '.edit_modal', function() {
        $("#editModal").modal("show");
        var editId = $(this).attr("id").split("_")[1];
        $.ajax({
            type: "POST",
            url: "backend/smb/modal.php",
            data: {
                id: editId
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                editLoadData = data;
                //console.log(data);
                $("#refEdit").val(data.ref);
                $("#modelEdit").val(data.model);
                $("#contactEdit").val(data.contact);
                $("#dateEdit").val(data.deliver_date);
                $("#countryEdit").val(data.country);
                //$("#countryEdit").text(data.fields[4]);
                $("#editDesc").val(data.note);
            },
            error: function(err) {
                console.log(err);
            }
        });

        $(".edit_btn").click(function() {
            var editFormData = {
                country: $("#countryEdit").val(),
                ref: $("#refEdit").val(),
                note: $("#editDesc").val(),
                model: $("#modelEdit").val(),
                contact: $("#contactEdit").val(),
                date: $("#dateEdit").val(),
                id: editId
            };
            $.ajax({
                type: "POST",
                url: "backend/smb/update.php",
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
                    if (editLoadData.ref.trim() != editFormData.ref.trim()) {
                        checkEditData += `Reference ID : ${editLoadData.ref} to ${editFormData.ref} |`;
                        limit += 1;
                    }
                    if (editLoadData.model.trim() != editFormData.model.trim()) {
                        checkEditData += `Model : ${editLoadData.model} to ${editFormData.model} |`
                        limit += 1;
                    }
                    if (editLoadData.contact.trim() != editFormData.contact.trim()) {
                        checkEditData += `Contact : ${editLoadData.contact} to ${editFormData.contact} |`
                        limit += 1;
                    }
                    if (editLoadData.deliver_date.trim() != editFormData.date.trim()) {
                        checkEditData += `Date : ${editLoadData.deliver_date} to ${editFormData.date} |`
                        limit += 1;
                    }
                    if (editLoadData.country.trim() != editFormData.country.trim()) {
                        checkEditData += `Country : ${editLoadData.country} to ${editFormData.country} |`
                        limit += 1;
                    }
                    if (editLoadData.note.trim() != editFormData.note.trim()) {
                        checkEditData += `Description : ${editLoadData.note} to <br>${editFormData.note} |`
                        limit += 1;
                    }
                 

                    checkEditData = checkEditData.replaceAll(" |", ", ");
                    checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'SSM',
                        command: 'Edited',
                        user_trc_details : document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Edited ${editLoadData.ref}'s details <br>${checkEditData} `
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

                    $("#msgSuccessEdit").text('You have successfully edited this record!').show().delay(6000).hide("slow", insertModalReset);
                }
            });
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
});