<?php ?>
<style>
    /*Right*/
    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 50%;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
        height: 90%;
    }	
    .modal.right.fade .modal-dialog {
        right: -50%;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #EEEEEE;
        background-color: #FAFAFA;
    }

</style>
<a href="javascript:void(0);" class="btn btn-default btn-attachment-viewer-load hidden" data-toggle="modal" data-target="#attachmentViewModal" style="display: none;">attachment Viewer</a>
<div class="modal right fade modal-default" id="attachmentViewModal" role="dialog">
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

                <iframe class="image-attachment-viewer attachment-viewer-url hidden" width="100%" height="100%" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning green_btn btnAttachmentDownload" data-id="" data-download-url="">Download</button>
                <button type="button" class="btn btn-warning green_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /modal default end -->

<script>
    $(document).on('click', '.btn-attachment-viewer', function () {
        //function defined in custom.js
        if (checkSecurity($(this).data('security-type-id'))) {
            var attachmentId = $(this).data('attachment-id');
            var dataattachmentable = $(this).data('attachment-table');
            var dataattachmentsrc = $(this).data('download-pdf-path');
            var documentname = $(this).data('file-name');
            $('.btnAttachmentDownload').data('attachment-id', attachmentId);
            $('.btnAttachmentDownload').data('data-attachment-table', dataattachmentable);
            $('.btnAttachmentDownload').data('data-download-pdf-path', dataattachmentsrc);
            $('.btnAttachmentDownload').data('data-file-name', documentname);

            var attachmentName = $(this).data('attachment-name');
            $('.attachment-viewer-name').html(attachmentName);
            var attachmentSrc = $(this).data('attachment-src');
            $('.btnAttachmentDownload').data('download-url', attachmentSrc);
            var fileParts = attachmentSrc.split('.');
            var fileType = fileParts[fileParts.length - 1];
            console.log('attachmentSrc==>' + attachmentSrc);
            $('.attachment-viewer-url').addClass('hidden');
            if (fileType == 'pdf') {
                $('.google-attachment-viewer').removeClass('hidden');
                var googleAttachmentViewerUrl = 'http://docs.google.com/gview?url=' + attachmentSrc + '&embedded=true';
                $('.google-attachment-viewer').attr('src', googleAttachmentViewerUrl);
                $('.btn-attachment-viewer-load').trigger('click');
            } else if (fileType == 'jpg' || fileType == 'jpeg') {
                $('.image-attachment-viewer').removeClass('hidden');
                var imageAttachmentViewerUrl = attachmentSrc;
                $('.image-attachment-viewer').attr('src', imageAttachmentViewerUrl);
                $('.btn-attachment-viewer-load').trigger('click');
            } else {
                $('.office-attachment-viewer').removeClass('hidden');
                var officeAttachmentViewerUrl = 'http://view.officeapps.live.com/op/embed.aspx?src=' + attachmentSrc + '&embedded=true';
                $('.office-attachment-viewer').attr('src', officeAttachmentViewerUrl);
                $('.btn-attachment-viewer-load').trigger('click');
            }
        }

    });

    $(".btnAttachmentDownload").click(function () {
        var attachmentId = $(this).data('attachment-id');
        var attachmentTable = $(this).data('data-attachment-table');
        var downloadpath = $(this).data('data-download-pdf-path');
        var documentname = $(this).data('data-file-name');
        window.open('/customs/download?attachmentId=' + attachmentId + '&attachmentTable=' + attachmentTable + '&path=' + downloadpath + '&documentname=' + documentname);
    });
</script>