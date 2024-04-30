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
    
    function insertModalReset() {
        window.location.reload();
    }
    $("#inviteBtn").click(function(event) {
        event.preventDefault()
        var formData = {
            name: $("#name").val(),
            email: $("#email").val(),
            role: $("#role").val(),
            sender: $("#data-name").val()
        };

        $.ajax({
            type: "POST",
            url: "assets/api/emailInvite/emailInvite.php",
            //url: "email/emailInvite.php",
            data: formData
        }).done(function(result) {
            var data = jQuery.parseJSON(result);
            //$("#overlay-loader").fadeOut(300);
            //console.log(data);
            /*setTimeout(function(){
                $("#overlay-loader").fadeOut(300);
            },500);*/
            if (data.success == 0) {

                $("#errMsg").html('<i class="fa fa-times-circle"></i>' + data.message).show().delay(5000).hide("slow");
            } else if (data.success == 1) {

                var formData = {
                    name: $("#name").val(),
                    email: $("#email").val(),
                    role: $("#role").val(),
                    user_id: $("#data-id").val(),
                    section: 'User',
                    command: 'Invited',
                    user_trc_details : document.getElementById("user_trc_details").value,
                    description: `${$("#data-name").val()} invited ${$("#name").val()} as a ${$("#role").val()}`
                };
                $.ajax({
                    type: "POST",
                    url: "/assets/api/activity_log.php",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function(result) {
                        //console.log(success)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }

                })
                $("#name").val('');
                $("#email").val('');
                $("#role").val('');
                $("#msgSuccess").html('<i class="fa fa-check-circle"></i>' + data.message).show().delay(5000).hide("slow");
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
                url: "backend/users/delete.php",
                data: {
                    id: delId
                },
                success: function(data) {

                    /* Start acivity Log */
                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'User',
                        command: 'Deleted',
                        user_trc_details : document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Deleted ${dataName} From UserList`
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
        var roleId;
        $.ajax({
            type: "POST",
            url: "backend/users/modal.php",
            data: {
                id: editId
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                editLoadData = data;
                console.log(data);
                $("#userFName").val(data.fields[0]);
                $("#userEmail").val(data.fields[1]);
                $("#userPhone").val(data.fields[2]);
                $("#userCountry").val(data.fields[3]);
                $("#userAddress").val(data.fields[4]);
                $("#userLName").val(data.fields[5]);
                $("#userRole").val(data.fields[7]);
                if(data.fields[8]==1){
                    $("#userRole").prop("disabled", true);
                    $("#msgRoleEdit").text("This user is assigned to a Project. You can't change his role while assigned");
                }
                else {
                    $("#userRole").prop("disabled", false);
                    $("#msgRoleEdit").text('');
                }
                roleId = data.fields[7];
            },
            error: function(err) {
                console.log(err);
            }
        });

        $(".edit_btn").click(function() {
            var editFormData = {
                fname: $("#userFName").val(),
                lname: $("#userLName").val(),
                email: $("#userEmail").val(),
                phone: $("#userPhone").val(),
                country: $("#userCountry").val(),
                address: $("#userAddress").val(),
                newRole: $("#userRole").val(),
                id: editId,
                role: roleId
            };

            $.ajax({
                type: "POST",
                url: "backend/users/update.php",
                data: editFormData,
            }).done(function(result) {
                var data = jQuery.parseJSON(result);
                console.log(data);
                if (data.success == 0) {

                    $("#errMsgEdit").html('<i class="fa fa-times-circle"></i>' + data.message).show().delay(3000).hide("slow");
                } else if (data.success == 1) {

                    //start activity log//

                    let checkEditData = '';
                    let limit = 0;
                    if (editLoadData.fields[0].trim() != editFormData.fname) {
                        checkEditData += `First Name : ${editLoadData.fields[0]} to ${editFormData.fname} |`;
                        limit += 1;
                    }
                    if (editLoadData.fields[1].trim() != editFormData.email.trim()) {
                        checkEditData += `Email : ${editLoadData.fields[1]} to ${editFormData.email} |`
                        limit += 1;
                    }
                    if (editLoadData.fields[2].trim() != editFormData.phone.trim()) {
                        checkEditData += `Phone : ${editLoadData.fields[2]} to ${editFormData.phone} |`;
                        limit += 1;
                    }
                    if (editLoadData.fields[3].trim() != editFormData.country.trim()) {
                        checkEditData += `Country : ${editLoadData.fields[3]} to ${editFormData.country} |`;
                        limit += 1;
                    }
                    if (editLoadData.fields[4].trim() != editFormData.address.trim()) {
                        checkEditData += `Address : ${editLoadData.fields[4]} to <br>${editFormData.address} |`
                        limit += 1;
                    }
                    if (editLoadData.fields[5].trim() != editFormData.lname.trim()) {
                        checkEditData += `Last Name : ${editLoadData.fields[5]} to ${editFormData.lname} |`
                        limit += 1;
                    }
                    if (editLoadData.fields[7] != editFormData.newRole) {
                        let temp = editFormData.newRole == 1 ? "Global Admin" : editFormData.newRole == 2 ? "Project Admin" : editFormData.newRole == 3 ? "Country Admin" : editFormData.newRole == 4 ? "Team Member" : " ";

                        checkEditData += `Role : ${$("#userRole option").attr('data-id')} to ${temp} |`;

                        limit += 1;
                    }

                    checkEditData = checkEditData.replaceAll(" |", ", ");
                    checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                    var formData = {
                        user_id: $("#data-id").val(),
                        section: 'User',
                        command: 'Edited',
                        user_trc_details : document.getElementById("user_trc_details").value,
                        description: `${$("#data-name").val()} Edited ${`${editFormData.fname} ${editFormData.lname}`}'s ${checkEditData} `
                    };
                    $.ajax({
                        type: "POST",
                        url: "/assets/api/activity_log.php",
                        //url: "email/emailInvite.php",
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

                    $("#msgSuccessEdit").html('<i class="fa fa-check-circle"></i>You have successfully edited this record!').show().delay(2000).hide("slow", insertModalReset);
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