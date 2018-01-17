<?php ?><div class="modal fade modal-default" id="permitAddAgencyModel" role="dialog">
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
                    <form name="" method="get" id="permitAddAgency" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Agency <span class="text-danger">*</span></label>
                                     <?php 
                                    echo $this->Form->input('agency_id', array(
                                       'type' => 'select',
                                       'options' => $categotylist,
                                        'label' => false,
                                        'class'=> 'form-control select2 agencyId',
                                        'id'=>'agencyId',
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Conatct Person</label>
                                     <?php 
                                    echo $this->Form->input('agency_conatct_id', array(
                                       'type' => 'select',
                                       'options' => @$conatcPersonlist,
                                        //'multiple'=>"multiple",
                                        'label' => false,
                                        'class'=> 'form-control select2 contactPerson',
                                        'id'=>'contactPerson',
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 text-right">
                               <?php echo $this->Html->link('Add Contact','javascript:void(0);',array('data-categoryId'=>'','escape' => false, 'data-title'=>"Contact",'data-flag'=>'1', 'class'=>"addConatctPerson  addicons ")); ?> 
                            </div>


                                <?php 
                                    echo $this->Form->hidden('permit_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addFormsformId',
                                    'id'=>'addAgencyPermitId'
                                    ));
                                   
                                ?>
                                <?php 
                                    echo $this->Form->hidden('permit_agency_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'permitAgencyid'
                                    ));
                                   
                                ?>

                            <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>