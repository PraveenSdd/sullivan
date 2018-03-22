<?php  ?>
<div data-backdrop="static" id="confirmAlertModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content model-border confirm-alert-modal-content">
            <div class="modal-header modal-header-common confirm-alert-modal-header" style="background:#286090!important; color:#fff">
                <button data-return-flag="false" title="Close" data-dismiss="modal" class="close" type="button">
                    <span style="color:#fff">×</span></button>
                <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body confirm-alert-modal-body" style="font-size:16px">
                <div class="confirm-alert-modal-body-content" id="confirmMessage" class="mtb20 text-center"></div>
            </div>
            <br>
            <div class="text-center padding-bottom-20" >
                <a data-dismiss="modal" data-return-flag="true" data-max-width="80" class="btn btn-primary confirm-alert-modal-yes" type="">Yes</a>
                <a data-dismiss="modal" data-return-flag="false" data-max-width="80" class="btn btn-default confirm-alert-modal-no" type="">No</a>
                <br>
            </div>
        </div>
    </div>
</div>