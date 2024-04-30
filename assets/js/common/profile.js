/* Dropzone handle */
Dropzone.autoDiscover = false;
var replaceVal;
var proId;
var roleId;
let editLoadData = '';

var myDropzonePro = new Dropzone(".profile-img-update", {
    autoProcessQueue: false,
    acceptedFiles: ".png,.jpg,.jpeg",
    maxFiles: 1,
    init: function () {
        this.on("maxfilesexceeded", function (file) {
            this.removeAllFiles();
            this.addFile(file);
        });
        this.on("error", function (file, message, xhr) {
            if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
        });
        this.on('sending', function (file, xhr, formData) {
            /*$("#eventInfo").find("input").each(function(){
                formData.append($(this).attr("name"), $(this).val());
            });*/
            formData.append('fname', $("#proFName").val());
            formData.append('lname', $("#proLName").val());
            formData.append('email', $("#proEmail").val());
            formData.append('phone', $("#proPhone").val());
            formData.append('country', $("#proCountry").val());
            formData.append('address', $("#proAddress").val());
            formData.append('id', proId);
            formData.append('role', roleId);
            //console.log(formData);
           
        });
        
        this.on("success", function (file, responseText) {
            var result = JSON.parse(responseText);
            console.log(result);
            if (result.success == 0) {
                $("#errMsgPro").html('<i class="fa fa-times-circle"></i>' + result.message).show().delay(3000).hide("slow");
            } else if (result.success == 1) {
                let editFormData = "";
                myDropzonePro.removeFile(file);
               
                $.ajax({
                    type: "POST",
                    url: "backend/users/modal.php",
                    data: { id: proId },
                    success: function (result) {
                        $("#msgSuccessPro").html('<i class="fa fa-check-circle"></i>You have successfully edited this record!').show().delay(2000).hide("slow");
                        var data = jQuery.parseJSON(result);
                        editFormData = data;
                        //console.log(data);
                        $(".modal-title").text(data.fields[0] + ' ' + data.fields[5]);
                        $("#pro-head").text(data.fields[0] + ' ' + data.fields[5]);
                        $("#viewName").text(data.fields[0] + ' ' + data.fields[5]);
                        $("#viewEmail").text(data.fields[1]);
                        $("#viewPhone").text(data.fields[2]);
                        $("#viewCountry").text(data.fields[3]);
                        $("#viewAddress").text(data.fields[4]);
                        //$('.pro-form').toggle();
                        $('.pro-form').css('display', 'none');
                        $('.profile-img-update').css('display', 'none');
                        $('.pro-footer').css('display', 'none');
                        $('.pro-view').css('display', 'block');
                        $('.pro-img').css('display', '');
                        $(".pro-img").attr("src", data.fields[9]);
                        $('.pro-edit').css('display', 'inline-block');

                          
                //start activity log//
                let checkEditData = '';
                let limit = 0;
               
                checkEditData += `<br> Profie Picture |`;

                if (editLoadData.fields[0] != editFormData.fields[0]) {
                    checkEditData += `<br>First Name : ${editLoadData.fields[0]} to ${editFormData.fields[0]} |`;
                    limit += 1;
                }
                if (editLoadData.fields[1] != editFormData.fields[1]) {
                    checkEditData += `<br>Email : ${editLoadData.fields[1]} to ${editFormData.fields[1]} |`;
                }
                if (editLoadData.fields[2] != editFormData.fields[2]) {
                    checkEditData += `<br>Phone : ${editLoadData.fields[2]} to ${editFormData.fields[2]} |`;
                }
                if (editLoadData.fields[3] != editFormData.fields[3]) {
                    checkEditData += `<br>Country : ${editLoadData.fields[3]} to ${editFormData.fields[3]} |`;
                }
                if (editLoadData.fields[4] != editFormData.fields[4]) {
                    checkEditData += `<br>Address : ${editLoadData.fields[4]} to ${editFormData.fields[4]} |`;
                }
                if (editLoadData.fields[5] != editFormData.fields[5]) {
                    checkEditData += `<br>Last Name : ${editLoadData.fields[5]} to ${editFormData.fields[5]} |`
                    limit += 1;
                }

                checkEditData = checkEditData.replaceAll(" |", ", ");
                checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                var formData = {
                    user_id: $("#data-id").val(),
                    section: 'User Profile',
                    command: 'Edited',
                    user_trc_details: document.getElementById("user_trc_details").value,
                    description: `${$("#data-name").val()} Edited his profile details ${checkEditData} `
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
                    },
                    error: function (err) {
                        //console.log(err);
                    }
                });
              
            }
        });
        this.on("complete", function (file) {
            this.removeAllFiles(true);
        })
    }
});

$(document).on('click', '.pro_modal', function () {
    $("#proModal").modal("show");
    proId = $(this).attr("id");

    $.ajax({
        type: "POST",
        url: "backend/users/modal.php",
        data: { id: proId },
        success: function (result) {
            var data = jQuery.parseJSON(result);
            //console.log(data);
            if (data.fields[7] == '1') {
                var roleUser = 'Global Admin';
            } else if (data.fields[7] == '2'){
                var roleUser = 'Project Admin';
            } else if (data.fields[7] == '3'){
                var roleUser = 'Country Admin';
            } else if (data.fields[7] == '4'){
                var roleUser = 'Team Member';
            } else if (data.fields[7] == '0'){
                var roleUser = 'Tespack Admin';
            }
            $(".modal-title").text(data.fields[0] + ' ' + data.fields[5]+ '- '+ roleUser);
            $("#pro-head").text(data.fields[0] + ' ' + data.fields[5]);
            $("#viewName").text(data.fields[0] + ' ' + data.fields[5]);
            $("#viewEmail").text(data.fields[1]);
            $("#viewPhone").text(data.fields[2]);
            $("#viewCountry").text(data.fields[3]);
            $("#viewAddress").text(data.fields[4]);
            if (data.fields[9] == null) {
                $(".pro-img").attr("src", "assets/uploads/propic.png");
            } else {
                $(".pro-img").attr("src", data.fields[9]);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
  
    $('.pro-edit').click(function () {
        //$('.pro-form').toggle();
        $('.pro-form').css('display', 'block');
        $('.profile-img-update').css('display', 'block');
        $('.pro-footer').css('display', 'flex');
        $('.pro-view').css('display', 'none');
        $('.pro-img').css('display', 'none');
        $(this).css('display', 'none');
        $.ajax({
            type: "POST",
            url: "backend/users/modal.php",
            data: { id: proId },
            success: function (result) {
                var data = jQuery.parseJSON(result);
                editLoadData = data;
                //console.log(data);
                $("#proFName").val(data.fields[0]);
                $("#proEmail").val(data.fields[1]);
                $("#proPhone").val(data.fields[2]);
                $("#proCountry").val(data.fields[3]);
                $("#proAddress").val(data.fields[4]);
                $("#proLName").val(data.fields[5]);
                $(".dropzone-img").attr('src', data.fields[9]);
                roleId = data.fields[7];
            },
            error: function (err) {
                console.log(err);
            }
        });
        $(".pro_btn").click(function (e) {
            if (myDropzonePro.getQueuedFiles().length > 0) {
                e.preventDefault();
                myDropzonePro.processQueue();
            } else {
                var proFormData = {
                    fname: $("#proFName").val(),
                    lname: $("#proLName").val(),
                    email: $("#proEmail").val(),
                    phone: $("#proPhone").val(),
                    country: $("#proCountry").val(),
                    address: $("#proAddress").val(),
                    id: proId,
                    role: roleId
                };
                let editFormData = proFormData;

                //console.log(proFormData);
                $.ajax({
                    type: "POST",
                    url: "backend/others/profileUpdate.php",
                    data: proFormData,
                }).done(function (result) {
                    var data = jQuery.parseJSON(result);
                    //console.log(data);
                    if (data.success == 0) {
                        $("#errMsgPro").html('<i class="fa fa-times-circle"></i>' + data.message).show().delay(3000).hide("slow");
                    }
                    else if (data.success == 1) {

                        //start activity log//
                        let checkEditData = '';
                        let limit = 0;
                        if (editLoadData.fields[0] != editFormData.fname) {
                            checkEditData += `<br>First Name : ${editLoadData.fields[0]} to ${editFormData.fname} |`;
                            limit += 1;
                        }
                        if (editLoadData.fields[1] != editFormData.email) {
                            checkEditData += `<br>Email : ${editLoadData.fields[1]} to ${editFormData.email} |`;
                        }
                        if (editLoadData.fields[2] != editFormData.phone) {
                            checkEditData += `<br>Phone : ${editLoadData.fields[2]} to ${editFormData.phone} |`;
                        }
                        if (editLoadData.fields[3] != editFormData.country) {
                            checkEditData += `<br>Country : ${editLoadData.fields[3]} to ${editFormData.country} |`;
                        }
                        if (editLoadData.fields[4] != editFormData.address) {
                            checkEditData += `<br>Address : ${editLoadData.fields[4]} to ${editFormData.address} |`;
                        }
                        if (editLoadData.fields[5] != editFormData.lname) {
                            checkEditData += `<br>Last Name : ${editLoadData.fields[5]} to ${editFormData.lname} |`
                            limit += 1;
                        }

                        checkEditData = checkEditData.replaceAll(" |", ", ");
                        checkEditData = checkEditData.slice(0, checkEditData.length - 2);

                        var formData = {
                            user_id: $("#data-id").val(),
                            section: 'User Profile',
                            command: 'Edited',
                            user_trc_details: document.getElementById("user_trc_details").value,
                            description: `${$("#data-name").val()} Edited his profile details ${checkEditData} `
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

                        $("#msgSuccessPro").html('<i class="fa fa-check-circle"></i>You have successfully edited this record!').show().delay(2000).hide("slow");

                        $.ajax({
                            type: "POST",
                            url: "backend/users/modal.php",
                            data: { id: proId },
                            success: function (result) {
                                var data = jQuery.parseJSON(result);
                                //console.log(data);
                                $(".modal-title").text(data.fields[0] + ' ' + data.fields[5]);
                                $("#pro-head").text(data.fields[0] + ' ' + data.fields[5]);
                                $("#viewName").text(data.fields[0] + ' ' + data.fields[5]);
                                $("#viewEmail").text(data.fields[1]);
                                $("#viewPhone").text(data.fields[2]);
                                $("#viewCountry").text(data.fields[3]);
                                $("#viewAddress").text(data.fields[4]);
                                //$('.pro-form').toggle();
                                $('.pro-form').css('display', 'none');
                                $('.profile-img-update').css('display', 'none');
                                $('.pro-footer').css('display', 'none');
                                $('.pro-view').css('display', 'block');
                                $('.pro-img').css('display', '');
                                $('.pro-edit').css('display', 'inline-block');
                            },
                            error: function (err) {
                                //console.log(err);
                            }
                        });
                    }
                });
            }
        });
    });
});
$('.pro-cancel').click(function () {
    //$('.pro-form').toggle();
    $('.pro-footer').css('display', 'none');
    $('.pro-view').css('display', 'block');
    $('.pro-img').css('display', '');
    $('.pro-edit').css('display', 'inline-block');
    $('.pro-form').css('display', 'none');
    $('.profile-img-update').css('display', 'none');
    $(".dropzone-img").attr('src', '');
});
$('#proModal').on('hidden.bs.modal', function (e) {
    myDropzonePro.removeAllFiles();
    $(".dropzone-img").attr('src', '');
    $('.pro-footer').css('display', 'none');
    $('.pro-view').css('display', 'block');
    $('.pro-img').css('display', '');
    $('.pro-edit').css('display', 'inline-block');
    if ($('.pro-form').css('display') == 'block') {
        $('.pro-form').css('display', 'none');
    }
    if ($('.profile-img-update').css('display') == 'block') {
        $('.profile-img-update').css('display', 'none');
    }
});