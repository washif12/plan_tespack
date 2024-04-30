
$(document).on('click', '#notifyIcon', async function () {
    $("#notifyModal").modal("show");
    // $('.noti-icon-badge').css('display', 'none');
    await loadNotification($("#data-ud").val());
});
let res_total_notifications = 0;
const loadNotification = async (user_id) => {
    document.getElementById("notify").innerHTML = '';
    let count = 0;
    //console.log(user_id);
    try {
        fetch('/assets/api/notification.php', {
            method: 'PATCH',
            body: JSON.stringify({
                user_id: user_id,
                notify: "notification"
            }),
        }).then((response) => response.json())
            .then((responseJson) => {
                //console.log(responseJson.ret_data)
                let html = '';
                responseJson.ret_data.map(item => {
                    item.seen === 0 && item.remove === 0 ? count += 1 : '';
                    if (item.remove === 0) {
                        html += `
                        <div class="col-12" style="border-bottom: 1px solid #e9ecef;" data-id = "${item.notification_id}" data-sn = ${item.seen}>
                            <div class="row">
                                <div class="col-1" style="margin: auto;">
                                    <img src="/assets/images/product.png" alt="user-image" class="thumb-md rounded-circle" />
                                </div>
                                <div class="col-6">
                                    <h6 style="color: #4d4c4c;font-size : 0.8rem" >${item.title}</h6>    
                                </div>
                                <div class="col-5" style="margin: auto;">
                                    <p style="float:left;">${dateCalculate(item.user_date)}</p>
                                    <button style="float:right;border: none;" type="button" aria-hidden="true" class="remove" data-id = "${item.notification_id}">×</button>
                                </div>
                            </div>
                        </div>`;
                    }
                })
                let temp = 0;
                responseJson.notify_data.map(element =>{
                    if(element.is_outside){
                        temp+=1;
                        $('.noti-icon-badge').css('display', 'block');
                        return;
                    }
                })
                if(temp == 0){
                    $('.noti-icon-badge').css('display', 'none');
                }
                res_total_notifications = responseJson.total_notifications;
                document.getElementById("notify").innerHTML = html
                // $('.noti-icon-badge').text(count)
                blockBadge();
                blockButton();
                removeNotification();
                noNotifyMsg();
            }).catch((err) => {
                console.log(err)
            });
    } catch (error) {
        console.log(error)
    }
}

const pushNotification = (item) => {
    try {
        let html = `
        <div class="col-12" style="border-bottom: 1px solid #e9ecef;" data-id = "${item.notification_id}"  data-sn = ${item.seen}>
            <div class="row">
                <div class="col-1" style="margin: auto;">
                    <img src="/assets/images/product.png" alt="user-image" class="thumb-md rounded-circle" />
                </div>
                <div class="col-6">
                    <h6 style="color: #4d4c4c;font-size : 0.8rem">${item.title}</h6>
                    
                </div>
                <div class="col-5" style="margin: auto;">
                    <p style="float:left;">${dateCalculate(item.user_date)}</p>
                    <button style="float:right;border: none;" type="button" aria-hidden="true" class="remove" data-id = "${item.notification_id}">×</button>
                </div>
            </div>
        </div>`;
        let element = document.getElementById("notify").children.length;
        let ntbadge = $('.noti-icon-badge').text() == '' ? 0 : parseInt($('.noti-icon-badge').text());
        //console.log(ntbadge)
        if (element === 0) {
            ntbadge += 1;
            $('#notify').html(html)
        }
        if (element > 0) {
            ntbadge += 1;
            $('#notify').prepend(html)
        }
        $('.noti-icon-badge').text(ntbadge)
        removeNotification()
        blockBadge()
    } catch (error) {
        console.log(error)
    }
}

$('#loadMore').click(function () {
    let data_id = $("#notify").children().last().attr('data-id');
    try {
        fetch('/assets/api/notification.php', {
            method: 'PATCH',
            body: JSON.stringify({
                user_id: $('#data-ud').val(),
                notify: "notification",
                offset: data_id

            }),
        }).then((response) => response.json())
            .then((responseJson) => {
                let html = '';
                res_total_notifications = responseJson.total_notifications;
                res_total_notifications <= 1 ? '' : $('#loadMore').css('display', 'none');
                responseJson.ret_data && responseJson.ret_data.map(item => {
                    if (item.remove === 0) {
                        html += `
                        <div class="col-12" style="border-bottom: 1px solid #e9ecef;" data-id = "${item.notification_id}"  data-sn = ${item.seen}>
                            <div class="row">
                                <div class="col-1" style="margin: auto;">
                                    <img src="/assets/images/product.png" alt="user-image" class="thumb-md rounded-circle" />
                                </div>
                                <div class="col-6">
                                    <h6 style="color: #4d4c4c;font-size : 0.8rem" >${item.title}</h6>    
                                </div>
                                <div class="col-5" style="margin: auto;">
                                    <p style="float:left;">${dateCalculate(item.user_date)}</p>
                                    <button style="float:right;border: none;" type="button" aria-hidden="true" class="remove" data-id = "${item.notification_id}">×</button>
                                </div>
                            </div>
                        </div>`;
                    }
                })
              
                if($('#notify').children().last() > 0 ){
                    $(html).insertAfter($("#notify").children().last());
                }else{
                    $('#notify').html(html);
                    // $('.noti-icon-badge').text(responseJson.ret_data.length)
                }
                
                blockButton();
                blockBadge();
                removeNotification();
            })
    } catch (error) {
        console.log(error)
    }
})
const removeNotification = () => {
    $('.remove').click(async function () {
        let id = $(this).attr('data-id');
        let res = await updateNotification({
            user_id: $('#data-ud').val(),
            notification_id: id,
            remove: true
        })
        if (res.status === 1) {
            $(this).parent().parent().parent().remove();
            noNotifyMsg();
            let ntbadge = $('.noti-icon-badge').text() == '' ? 0 : parseInt($('.noti-icon-badge').text());
            // $('.noti-icon-badge').text(ntbadge-1);
            blockBadge();
        }
    })
    
}
const updateNotification = async (data) => {
    return fetch('/assets/api/notification.php', {
        method: 'PUT',
        body: JSON.stringify(data),

    }).then((response) => response.json())
        .then((responseJson) => {
            return responseJson
        });
}

const saveNotification = async (data) => {
    return fetch('/assets/api/notification.php', {
            method: 'post',
            body: JSON.stringify(data),

        }).then((response) => response.json())
        .then((responseJson) => {

            return responseJson;
        });
}
const notification = async (method, data) => {
    return fetch('/assets/api/notification.php', {
            method: 'PATCH',
            body: JSON.stringify(data),

        }).then((response) => response.json())
        .then((responseJson) => {
            return responseJson
        });
}
const dateCalculate = (date) => {
    let currentTimestamp = new Date();
    let mysqlTimestamp = new Date(date);

    let diffInSeconds = (currentTimestamp - mysqlTimestamp) / 1000;

    if (diffInSeconds < 60) {
        return "just now";
    } else if (diffInSeconds < 3600) {
        return Math.floor(diffInSeconds / 60) + " min ago";
    } else if (diffInSeconds < 86400) {
        return Math.floor(diffInSeconds / 3600) + " hr ago";
    } else if (diffInSeconds < 2592000) {
        return Math.floor(diffInSeconds / 86400) + " day ago";
    } else if (diffInSeconds < 31536000) {
        return Math.floor(diffInSeconds / 2592000) + " mon ago";
    } else {
        return Math.floor(diffInSeconds / 31536000) + " yr ago";
    }

}

const blockButton = () => {
    // $('#notify').children().length >= 10 ? $('#loadMore').css('display', 'block') : $('#loadMore').css('display', 'none');
    res_total_notifications > 10 ? $('#loadMore').css('display', 'block') : $('#loadMore').css('display', 'none');
}
blockButton();


const blockBadge = () => {
    // $('.noti-icon-badge').text() == '' || $('.noti-icon-badge').text() == '0' ? $('.noti-icon-badge').css('display', 'none') : $('.noti-icon-badge').css('display', 'block');
}
blockBadge();
const noNotifyMsg = () => {
    // $('#notify').children().length < 1 ? $('#notify').html("<div class='col-12'><h6 class='text-center'>No Notifications found</h6></div>") : '';
    res_total_notifications < 1 ? $('#notify').html("<div class='col-12'><h6 class='text-center'>No Notifications found</h6></div>") : '';
}
noNotifyMsg();
