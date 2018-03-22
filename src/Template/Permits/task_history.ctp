<?php

$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
   <?= $this->Flash->render() ?>
    <div class="form-default clearfix">
        <div class="col-sm-12 bg-primary clearfix ">
            <h3 class="text-center"><?php if(!empty($permitDetails)) echo ($permitDetails->name);?></h3>
            <p> <?php if(!empty($permitDetails)) echo $permitDetails->description;?></p>
        </div>
        <?php echo $this->Form->hidden('Permit.name', array('data-id'=>$permitDetails->id,'data-id-ecrypt'=>$permitId,'value'=>$permitDetails->name,'class'=>'form-control inp-permit-name')) ?>
        <?php echo $this->Form->hidden('Operation.name', array('data-id'=>$this->Encryption->decode($operationId),'data-id-ecrypt'=>$operationId,'value'=>'','class'=>'form-control inp-operation-name')) ?>
        <?php echo $this->Form->hidden('Location.name', array('data-id'=>$this->Encryption->decode($locationId),'data-id-ecrypt'=>$locationId,'value'=>'','class'=>'form-control inp-location-name')) ?>
        <?php echo $this->Form->hidden('UserPermit.id', array('data-id'=>$accessPermits->id,'data-id-ecrypt'=>$this->Encryption->decode($accessPermits->id),'value'=>'','class'=>'form-control inp-user-permit-id')) ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div id="accordion" class="faq-wrap" role="tablist">
                    <!-- accordion Card - Permit-Agency -- START   -->
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-permit-agency" aria-expanded="true" aria-controls="collapse-permit-agency">Status Logs</a>
                            </h5>
                        </div>
                        <div id="collapse-permit-agency" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="table-responsive permit-agency-block">
                                    <table class="table-striped">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th>Modified By</th>
                                                <th>Last Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($userPermitStatusLogList) && !$userPermitStatusLogList->isEmpty()){ 
                                            foreach($userPermitStatusLogList as $userPermitLog){  ?>
                                            <tr>
                                                <td class="text-left"><?php echo $userPermitLog['permit_status']['title'];?></td>
                                                <td class="text-left"> <?php echo $userPermitLog['notes'];?></td>
                                                <td class="text-left"> <?php echo $userPermitLog['user']['first_name'].' '.$userPermitLog['user']['last_name'];?></td>
                                                <td class="text-left"><?php echo $this->Custom->dateTime($userPermitLog['modified'])?></td>

                                            </tr>
                                        <?php }

                                        }else{ ?>
                                            <tr>
                                                <td colspan="4"> Record not found </td></tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- accordion Card - Permit-Deadline -- START   -->
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse-permit-deadline" aria-expanded="true" aria-controls="collapse-permit-deadline">Deadline</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-permit-deadline" class="collapse in" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="table-responsive permit-deadline-block">
                    <?php echo $this->element('/frontend/permit/deadline_list',array('permitDeadlines'=>$permitDetails->deadlines,'userPermitDeadlines'=>$userPermitDeadlines)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- accordion Card - Permit-Deadline -- END   -->
                </div>
            </div>
        </div>
    </div>
</div>