<?php

//prx($permitDetails);
$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
   <?= $this->Flash->render() ?>
    <div class="form-default clearfix">
        <div class="main-action-btn pull-right clearfix">
            <?php echo $this->Html->link('Add Previous Permit',['controller'=>'previousPermits','action'=>'add'],array('escape' => false,'title'=>'edit','class'=>"btnPreviousPermitDocumentModal btn btn-default"));
            ?> 
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="table-responsive previous-permit-list-block">
                <table class="table-striped tbl-previous-permit">
                    <thead class="tbl-previous-permit-thead">
                        <tr class="tbl-previous-permit-tr">
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Operation</th>
                            <th scope="col">Renewable</th>
                            <th scope="col">Last Modification</th>
                            <th scope="col">Modified By</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="tbl-previous-permit-body">
                            <?php if(!empty($previousPermitData)) {
                                foreach ($previousPermitData as $key => $data) {
                                    $permitId = $this->Encryption->encode($data->permit_id);
                                    $operationId = $this->Encryption->encode($data->operation->id);
                                    $location_id = $this->Encryption->encode($data->user_location->id); 
                                    ?>
                        <tr  class="tbl-previous-permit-tr">
                            <td>
                                <?php 
                                if($data->permit_status_id != 0){
                                echo $this->Html->link(htmlentities(strip_tags($data->permit->name)),['controller'=>'permits','action'=>'details',$permitId,$operationId,$location_id,$this->Encryption->encode($data->id)],array('title'=>'View','escape' => false)); 
                                }else{
                                    echo $this->Html->link(htmlentities(strip_tags($data->permit->name)),['controller'=>'previousPermits','action'=>'view',$permitId,$operationId,$location_id],array('title'=>'View','escape' => false)); 
                                }
                                ?>
                            </td>
                            <td>
                                            <?php echo $data->user_location->title;?>
                            </td>
                            <td>
                                            <?php echo $data->operation->name;?>
                            </td>
                            <td>
                                            <?php echo @$data->renewable->date;?>
                            </td>
                            <td>
                                            <?php echo $this->Custom->dateTime($data->modified);?>
                            </td>

                            <td><?= @$data->user->first_name; ?></td>
                            <td>
                                <?php 
                                if($data->permit->is_admin == 0){
                                    echo $this->Html->link($this->Html->image('icons/edit.png'),['controller'=>'previousPermits','action'=>'edit',$this->Encryption->encode($data->id)],array('title'=>'Edit Previous Permit','escape' => false)); 
                                }
                                if($data->permit_status_id != 0){
                                    echo $this->Html->link('<i class="fa fa-download"></i>',['controller'=>'permits','action'=>'downloadAllFiles',$permitId,$this->Encryption->encode($data->id)],array('title'=>'Download','escape' => false)); 
                                }
                                ?>
                            </td>
                        </tr>
                                <?php } ?> 
                            <?php } else { ?>
                        <tr class="tbl-previous-permit-tr">
                            <td colspan="6">Data not available!</td>
                        </tr>
                            <?php } ?>        
                    </tbody>
                </table>
                    <?php echo $this->element('layout/frontend/default/pagination'); ?>
            </div>
        </div>
    </div>
</div>


