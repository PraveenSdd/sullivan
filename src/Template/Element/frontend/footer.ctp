<?php ?>

<div data-backdrop="static" id="confirm-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content model-border">
            <div class="modal-header modal-header-common" style="background:#286090!important; color:#fff">
                <button data-returnvalue="false" title="Close" data-dismiss="modal" class="close" type="button">
                    <span style="color:#fff">×</span></button>
                <h4 class="modal-title">Confirma</h4>
            </div>
            <div class="modal-body" style="font-size:16px">
                <div id="confirmMessage" class="mtb20 text-center"></div>
            </div>
            <br>
            <div class="text-center padding-bottom-20" >
                <a data-dismiss="modal" data-returnvalue="true" data-max-width="80" class="btn btn-primary" type="">Yes</a>
                <a data-dismiss="modal" data-returnvalue="false" data-max-width="80" class="btn btn-default" type="">No</a>
                <br>
            </div>
        </div>
    </div>
</div>

