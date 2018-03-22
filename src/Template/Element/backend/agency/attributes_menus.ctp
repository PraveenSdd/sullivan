<?php ?>
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12 bg-primary clearfix text-center">
            <h5 class="permitTitle">Contact Person Details</h5>
            <p class="description"></p>
        </div> 
    </div>
    <div class="box-body view-permit-outer text-center">                    
        <!-- Agency related Contact person Block - START -->
        <div class="row ">
            <div class="form-group">
                <div class="col-sm-9">
                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-agency-contact" aria-expanded="true" aria-controls=collapse-agency-contact" >Related Contact Person</a>
                    <div id="collapse-agency-contact" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body agency-contact-person-block">
                            <?php echo $this->element('backend/agency/contact_person_list',array('agencyContacts'=>@$agency['agency_contacts'])); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php
                        echo $this->Html->link('Add Contact Person', 'javascript:void(0);', array('escape' => false, 'data-title' => "Add Contact Person",'data-agency-contact-id'=>'', 'data-agency-contact-name'=>'', 'data-agency-contact-position'=>'', 'data-agency-contact-email'=>'','data-agency-contact-phone'=>'', 'data-agency-contact-phone-extension'=>'','data-agency-contact-address'=>0, 'class' => "btnAgencyContactPersonModal  addicons "));
                    ?> 
                </div>
            </div>
        </div>
    </div>
    <div class="box-body view-permit-outer text-center">    
        <!-- Agency related Permit Block - START -->
        <div class="row ">
            <div class="form-group">
                <div class="col-sm-9">
                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-agency-permit" aria-expanded="true" aria-controls="collapse-agency-permit" >Related Permit</a>
                    <div id="collapse-agency-permit" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body agency-permit-block">
<?php echo $this->element('backend/agency/permit_list', array('permitAgencies' => @$agency['permit_agencies'])); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php
                        echo $this->Html->link('Add Permit', 'javascript:void(0);', array('data-categoryId' => 0, 'escape' => false, 'data-title' => "Add Permit", 'data-permit-id' => '', 'data-agency-contact-id' => '', 'data-permit-agency-id' => '', 'data-modal-type' => 'add', 'class' => "btnAgencyPermitModal  addicons "));
                        ?> 

                </div>
            </div>
        </div>
        <!-- Agency related Permit Block - END -->

    </div>
</div>
<!-- modal add contact person form --> 
<?php echo $this->element('backend/agency/contact_person_modal'); ?>
<!-- modal add permit person form -->
<?php echo $this->element('backend/agency/permit_modal'); ?>
<?php echo $this->element('backend/agency/view_contact_person_modal'); ?>
