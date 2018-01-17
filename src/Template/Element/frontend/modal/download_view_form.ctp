<?php  ?>

<a href="javascript:void(0);" class="btn btn-default btn-attachment-viewer-load hidden" data-toggle="modal" data-target="#attachmentViewModal" style="display: none;">attachment Viewer</a>
<div class="modal fade modal-default" id="attachmentViewModal" role="dialog">
    <div class="modal-dialog modal-lg pull-right modal-for-file">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title attachment-viewer-name">Form View</h4>
            </div>

            <div class="modal-body attachment-view-content">        

                <iframe class="google-attachment-viewer attachment-viewer-url hidden" width='100%' height='100%' src=''></iframe>

                <iframe class="office-attachment-viewer attachment-viewer-url hidden" src='' width='100%' height='100%' frameborder='0'></iframe>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning green_btn btnAttachmentDownload" data-formId ="" data-download-url="">Download</button>
                <button type="button" class="btn btn-warning green_btn" data-dismiss="wzmodal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /modal default end -->


<script>
    $('.btn-attachment-viewer').click(function () {
        var attachmentformId = $(this).data('attachment-id');
       
        $('.btnAttachmentDownload').data('formId', attachmentformId);
        
        var attachmentName = $(this).data('attachment-name');
        $('.attachment-viewer-name').html(attachmentName);
        var attachmentSrc = $(this).data('attachment-src');
        $('.btnAttachmentDownload').data('download-url', attachmentSrc);
        var fileParts = attachmentSrc.split('.');
        var fileType = fileParts[fileParts.length - 1];
        console.log(fileType);
        console.log(attachmentSrc);
        if (fileType == 'pdf') {
            $('.office-attachment-viewer').addClass('hidden');
            $('.google-attachment-viewer').removeClass('hidden');
            var googleAttachmentViewerUrl = 'http://docs.google.com/gview?url=' + attachmentSrc + '&embedded=true';
            $('.google-attachment-viewer').attr('src', googleAttachmentViewerUrl);
            console.log(googleAttachmentViewerUrl);
            $('.btn-attachment-viewer-load').trigger('click');
        } else {
            $('.google-attachment-viewer').addClass('hidden');
            $('.office-attachment-viewer').removeClass('hidden');
            
            var officeAttachmentViewerUrl = 'http://view.officeapps.live.com/op/embed.aspx?src=' + attachmentSrc + '&embedded=true';
            console.log(officeAttachmentViewerUrl);
            $('.office-attachment-viewer').attr('src', officeAttachmentViewerUrl);

            $('.btn-attachment-viewer-load').trigger('click');
        }
        
    });

    $(".btnAttachmentDownload").click(function () {
        var formId = $(this).data('formId');
        $.ajax({
                url: "/Forms/downloadForm",
                type: "Post",
                dataType: 'html',
                data: {id: formId},
                success: function (response) {
                    if (response) {
                       
                    }
                }
            });
            var downloadUrl = $(this).data('download-url');
            location.reload();
            window.open(downloadUrl, '_blank');
      
        return false
    });

    $('.btn-change-view-status').click(function () {
        var viewStatus = $(this).data('view-status');
        var isSent = $(this).data('is-sent');
        var roleId = $(this).data('role-id');
        if (isSent == 1 && viewStatus == 0 && roleId == 2) {
            var attachmentId = $(this).data('attachment-id');
            var attachmentId = $(this).data('attachment-id');
            $.ajax({
                url: "/attachments/changeViewStatus/" + attachmentId,
                type: "POST",
                beforeSend: function (xhr) {
                    $('#preloader').css('display', 'none');
                },
                success: function (res) {
                    //
                }
            });
        }
    });

</script>