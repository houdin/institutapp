// Loaded after CoreUI app.js

//Message Notification
setInterval(() => {
    axios
        .get(messageNotificationRoute)
        .then((response) => {
            console.log("DATA/////");
            console.log(response.data);
            if (response.data.unreadMessageCount > 0) {
                $(".unreadMessages").empty();
                $(".mob-notification").removeClass("d-none").html("!");
                $(".unreadMessageCounter")
                    .removeClass("d-none")
                    .html(response.data.unreadMessageCount);
                let html = "";
                let host =
                    $(location).attr("protocol") +
                    "//" +
                    $(location).attr("hostname") +
                    "/user/messages/?thread=";
                $(response.data.threads).each((key, value) => {
                    html +=
                        '<a class="dropdown-item" href="' +
                        host +
                        value.thread_id +
                        '"> ' +
                        '<p class="font-weight-bold mb-0">' +
                        value.title +
                        ' <span class="badge bg-success">' +
                        value.unreadMessagesCount +
                        "</span></p>" +
                        '<p class="mb-0">' +
                        value.message +
                        "</p>" +
                        "</a>";
                });
                $(".unreadMessages").html(html);
            } else {
                $(".unreadMessageCounter").addClass("d-none");
                $(".mob-notification").addClass("d-none");
            }
        })
        .catch((error) => {
            $(".unreadMessageCounter").addClass("d-none");
            $(".mob-notification").addClass("d-none");
            console.log(error);
        });
}, 5000);
