/* @Function:ecoConfirm()
 * @Description: Open confirm alert popup
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Dec. 2017
 */
function ecoConfirm(msg, returnStatus) {
    var confirmBox = $("#confirm-modal");
    confirmBox.find("#confirmMessage").text(msg);
    confirmBox.find("[data-returnvalue]").unbind().click(function ()
    {
        confirmBox.modal({show: false});

    });
    confirmBox.find("[data-returnvalue]").click(function () {
        var setStatus = $(this).data('returnvalue');
        returnStatus(setStatus);
    });
    confirmBox.modal({show: true, keyboard: false, });
    ;
}
/*  @@Function: 
 * @Description: On click for change status ajax
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Oct. 2017
 */
$(document).on('click', '.myalert-active', function (event) {
    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var status = $(this).data('status');
    var newStatus = $(this).data('newstatus');
    var title = $(this).data('title');
    event.preventDefault();
    var urllink = $(this).attr('href');
    ecoConfirm("Are you sure you want to change the status?", function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: "/Customs/changeStatus",
                type: "POST",
                data: {id: id,
                    model: model,
                    status: status,
                    newStatus: newStatus,
                    title: title
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        } else {
            console.log('false');
        }
    });
});
/*  @@Function: 
 * @Description: js for open search form on index page
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Oct. 2017
 */

$(document).on('click', '.myalert-delete', function (event) {

    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var title = $(this).data('title');
    event.preventDefault();
    var urllink = $(this).attr('href');
    var redirect = $(this).data('url');
    if (title == 'Verify') {
        var msg = "Are you sure you want to verify staff?";
    } else {
        var msg = "Are you sure you want to delete this " + title + "?";
    }
    ecoConfirm(msg, function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: "/Customs/deleteStatus",
                type: "POST",
                data: {id: id,
                    model: model,
                    title: title
                },
                success: function (data) {
                    if (redirect) {
                        window.location = redirect;
                    } else {
                        window.location.reload();
                    }
                }
            });
        } else {
            console.log('false');
        }
    });
});

    