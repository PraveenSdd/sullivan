<?php ?>
    <div class="main-content clearfix">
        <h2 class="pull-left">Ongoing Projects (<?=count($accessPermits);?>)</h2>
        <div class="clearfix"></div>
     
        <div class="table-responsive clearfix">
        		<table class="table-striped">
            	  <thead>
                    <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Location'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Industry'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
              </thead>
              <tbody>
               <?php  if($accessPermits->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($accessPermits as $permitdata){ 
                             $id = $this->Encryption->encode($permitdata->form->id);
                             ?>
                        <tr>
                            <td>
                                    <?php echo $this->Html->link($permitdata->form->title,['controller'=>'forms','action'=>'view',$id],array('title'=>'View','escape' => false)); ?>
                                
                            </td>
                           
                            <td> <?php echo $permitdata->user_location->title; ?> 
                            </td>
                            
                             <td><?php if(!empty($permitdata->industry->name)) echo $permitdata->industry->name; ?> 
                             </td>
                             <td><?php  $formStatus =  $this->Custom->getFormStatus($permitdata->permit_status_id);
                                echo $formStatus->title; ?> 
                             </td>
                             <td><?php echo  $this->Custom->dateTime($permitdata->modified);?> 
                             </td>
                            
                        </tr>    
                    <?php } }?>
                    </tbody>
                </table>
        </div>
    </div>