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
    /*Add Country */
    function insertModalReset() {
        window.location.reload();
    }
    $("#insertCountry").click(function(event) {
        var formData = {
            country: $("#countrySelection").val(),
            region: $("#add_region").val(),
            note: $("#note").val()
        };

        $.ajax({
            type: "POST",
            url: "backend/country/insert.php",
            data: formData,
            encode: true,
        }).done(function(result) {
            var data = jQuery.parseJSON(result);
            //console.log(data);
            if (data.success == 0) {
                $("#errMsg").text(data.message).show().delay(10000).hide("slow");
            } else if (data.success == 1) {

                //start Activity
                var formData = {
                    user_id: $("#data-id").val(),
                    section: 'Country',
                    command: 'Added',
                    user_trc_details : document.getElementById("user_trc_details").value,
                    description: `${$("#data-name").val()} Added ${$("#countrySelection").val()} as a country and Region ${$("#add_region").val()}`
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

                $("#msgSuccess").text('You have successfully added a new Country!').show().delay(4000).hide("slow", insertModalReset);
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
                url: "backend/country/delete.php",

                data: {
                    id: delId
                },
                success: function(data) {
                    //start Activity
                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'Country',
                        command: 'Deleted',
                        user_trc_details : document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Deleted ${dataName} From Country List`
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
    let editLoadData = '';
    $(document).on('click', '.view_btn', function() {
        $("#viewModal").modal("show");
        var viewId = $(this).attr("id").split("_")[1];
        $.ajax({
            type: "POST",
            url: "backend/country/modal.php",
            data: {
                id: viewId
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                $("#modalCountry").text(data.fields[0]);
                $("#modalRegion").text(data.fields[1]);
                $("#modalNote").text(data.fields[2]);
                $("#viewHead").text(data.fields[3]);
            },
            error: function(err) {
                console.log(err);
                $("#modalCountry").text('');
                $("#modalRegion").text('');
                $("#modalNote").text('');
            }
        });
    });
    $(document).on('click', '.edit_modal', function() {

        var editId = $(this).attr("id").split("_")[1];

        $.ajax({
            type: "POST",
            url: "backend/country/modal.php",
            data: {
                id: editId
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                editLoadData = data;
                //$("#editHead").text(data.fields[3]);
                //$("#countryEdit").val(data.fields[0]);
                //$("select#countryEdit").attr("data-default-value",data.fields[0]);
                //document.getElementById("countryEdit").setAttribute("country-data-default-value",data.fields[0]);
                //$("#gds-cr-one").val(data.fields[1]);
                $('.editAppend').append('<select id="countryEdit" readonly disabled class="form-control crs-country" data-default-value="' + data.fields[0] + '" data-region-id="edit_region"></select>');
                $("#edit_region").attr("data-default-value", data.fields[1]);
                $("#editDesc").val(data.fields[2]);
                window.crs.init();
            },
            error: function(err) {
                console.log(err);
            }
        });
        $("#editModal").modal("show");

        $(".edit_btn").click(function() {
            var editFormData = {
                //country: $("#countryEdit").val(),
                region: $("#edit_region").val(),
                note: $("#editDesc").val(),
                id: editId
            };
            $.ajax({
                type: "POST",
                url: "backend/country/update.php",
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
                    if (editLoadData.fields[1].trim() != editFormData.region.trim()) {
                        checkEditData += `Region : ${editLoadData.fields[1]} to ${editFormData.region} |`;
                        limit += 1;
                    }
                    if (editLoadData.fields[2].trim() != editFormData.note.trim()) {
                        checkEditData += `Note : ${editLoadData.fields[2]} to <br>${editFormData.note} |`
                        limit += 1;
                    }
                 

                    checkEditData = checkEditData.replaceAll(" |", ", ");
                    checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'User',
                        command: 'Edited',
                        user_trc_details : document.getElementById("user_trc_details").value,
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
    $('#editModal').on('hidden.bs.modal', function(e) {
        $(this).find('.editAppend').html('');
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