<?php ?>
<div class="main-content clearfix">
    <!--Permit Preparation phase on-->
    <div class="clearfix"></div>
    <h4 class="pull-left"> 
            <?php echo 'On Going'; ?>      
    </h4>
    <div class="clearfix"></div>
    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Name'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Location'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Agencies'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Status'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Deadline'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
               <?php  if($accessPermits->count() <= 0 ){  ?>
                <tr><td colspan="6" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($accessPermits as $permitdata){ 
                            $locationId[] = $permitdata->user_location->id;
                            $agencyId[] =$permitdata['category']['id'];
                             $id = $this->Encryption->encode($permitdata->form->id);
                             ?>
                <tr>
                    <td>
                                  <?php echo $this->Html->link($permitdata->form->title,['controller'=>'forms','action'=>'view',$id],array('title'=>'View','escape' => false)); ?>

                    </td>

                    <td> <?php echo $permitdata->user_location->title; ?> 
                    </td>

                    <td>  <?php echo $permitdata['category']['name']; ?> 
                    </td>

                    <td><?php  $formStatus =  $this->Custom->getFormStatus($permitdata->permit_status_id);
                                echo $formStatus->title; ?> 
                    </td>
                    <td>
                                 <?php $deadline =  $this->Custom->getPermitDeadline($permitdata->form->id);
                            if(!empty($deadline)){
                                echo $this->Custom->dateTime($deadline->date).', '.$deadline->time;
                            }?>  
                    </td>
                    <td><?php echo  $this->Custom->dateTime($permitdata->modified);?> 
                    </td>

                    <td class="center">
                                <?php if($permitdata->permit_status_id == 1){ $newStatus = 2; } 
                                        if($permitdata->permit_status_id == 2){ $newStatus = 3; }
                                    ?>
                              <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'forms','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 

                    </td>
                </tr>    
                    <?php } }?>

            </tbody>
        </table>

    </div>

    <div class="clearfix"></div>
    <h4 class="pull-left " style="padding-top:70px"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>

    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Name'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Location'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Agencies'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Status'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Deadline'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
               <?php  if($locationIndustries->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($locationIndustries as $formdata){ 
                                $permits =  $this->Custom->getPermitListByIndustry($formdata->industry_id,$userId);
                                $location =  $this->Custom->getLocation($formdata->user_location_id);

                                if($permits != null){ 
                                    foreach($permits as $permit ){
                                       if(empty($locationId)) $locationId =[];
                                       if(in_array($location->id, $locationId)){
                                        }else{ ?>
                                            <tr>
                                                <td>
                                                         <?php echo $permit['form']['title']; ?> 
                                                </td>

                                                <td> <?php  echo $location->title; ?> 
                                                </td>

                                                <td>
                                                    <?php echo $permit['category']['name']; ?> 
                                                </td>
                                                <td><?php $formStatus =  $this->Custom->getFormStatus(1);
                                                            echo $formStatus->title; ?> 
                                                </td>
                                                <td>
                                                <?php $deadline =  $this->Custom->getPermitDeadline( $permit['form']['id']);
                                                    if(!empty($deadline)){
                                                        echo $this->Custom->dateTime($deadline->date).', '.$deadline->time;
                                                    }?>  
                                                </td>
                                                <td><?php echo $this->Custom->dateTime($permit['form']['created']);?> 
                                                </td>
                                                <td class="center">
                               <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Change Status','data-oldStatus'=>'1',' data-locationId'=>$formdata->user_location_id,'data-industryId'=>'$formdata->industry_id','data-title'=>$permit['form']['title'],'data-agencyId'=>$permit['category']['id'],'data-modelname'=>$permit['form']['title'],'data-newStatus'=>'2','data-userId'=>$Authuser['id'],'data-modelname'=>'Alerts','data-id'=> $permit['form']['id'],'class'=>"changeFormStatus")); ?> 
                                                </td>
                                            </tr>   
                                        <?php }
                                    }
                                }
                            }
                            }?>
            </tbody>
        </table>
    </div>
<?php echo $this->element('frontend/modal/download_view_form'); ?>
<?= $this->Html->script(['forms']);?>