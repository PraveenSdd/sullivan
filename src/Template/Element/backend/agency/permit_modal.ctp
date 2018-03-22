<?php ?><div class="modal fade modal-default" id="agencyPermitModal" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <!--<span class="col-sm-12 col-xs-12" id="statusmsgAttachment" ></span>-->
                <div class="form-default clearfix">
                    <form name="" method="get" id="frmAgencyPermit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Permit <span class="text-danger">*</span></label>
                                    <?php 
                                    echo $this->Form->hidden('permit_agency_id', array(
                                       'class'=> 'form-control  inp-permit-agency-id',
                                        'id'=>'inpPermitAgencyId',
                                        ));
                                    echo $this->Form->input('PermitAgency.permit_id', array(
                                       'type' => 'select',
                                       'options' => [],
                                        'empty'=>'Select Permit',
                                        'label' => false,
                                        'class'=> 'form-control select2 sel-agency-permit',
                                        'id'=>'selAgencyPermit',
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 custom-pop-select2 padding-top-20">
                                <label>Contact Person</label>
                                     <?php 
                                    echo $this->Form->input('PermitAgencyContact.agency_contact_id', array(
                                       'type' => 'select',
                                       'options' => [],
                                        'multiple'=>true,
                                       'empty'=>'Select Contact Person',
                                        'label' => false,
                                        'class'=> 'form-control select2 sel-agency-permit-contact',
                                        'id'=>'selAgencyPermitContact',
                                        'maxlength'=>3,
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 clearfix padding-top-20">
                         <?php echo $this->Form->button('Submit', array('type'=>'button','class'=>'btn btn-default subAgencyPermit')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>