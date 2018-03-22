<?php ?><div class="modal fade modal-default" id="permitAgencyModal" role="dialog">
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
                    <form name="" method="post" id="frmPermitAgency" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Permit <span class="text-danger">*</span></label>
                                    <?php 
                                    echo $this->Form->hidden('permit_agency_id', array(
                                       'class'=> 'form-control  inp-permit-agency-id',
                                        'id'=>'inpPermitAgencyId',
                                        ));
                                    echo $this->Form->input('PermitAgency.agency_id', array(
                                       'type' => 'select',                                       
                                        'empty'=>'Select Agency',
                                        'options'=>$agencyList,
                                        'label' => false,
                                        'class'=> 'form-control select2 sel-permit-agency',
                                        'id'=>'selPermitAgency',
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
                                        'class'=> 'form-control select2 sel-permit-agency-contact',
                                        'id'=>'selPermitAgencyContact',
                                        'maxlength'=>3,
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 clearfix padding-top-20">
                         <?php echo $this->Form->button('Submit', array('type'=>'button','class'=>'btn btn-default subPermitAgency')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>