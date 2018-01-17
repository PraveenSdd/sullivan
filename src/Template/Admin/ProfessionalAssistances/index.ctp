<?php ?>
 <div class="row">
    <div class="col-xs-12">
        <div class="box">
             <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                        
                    <!-- filters starts-->
                    <div class="UserAdminIndexForm">
                        <div class="box-body">	
                            <div class="row">
			     <form action="/admin/professionalAssistances" novalidate="novalidate" id="CategoryIndexForm" method="get" accept-charset="utf-8">
                                 <div style="display:none;">
                                     <input type="hidden" name="_method" value="Get"/></div>
                                <div class='col-xs-3 col-md-2'>
                                    <input name="name" placeholder="Name" class="form-control btm-search" type="text" id="CategoryCategoryName"/>
                                </div>								
                                 <div class='col-xs-3 col-md-2'>
                                     <select name="status" class="form-control btm-search" id="CategoryIsActive">
<option value="">--All Status--</option>
<option value="1">Active</option>
<option value="0">Inactive</option>
</select></div>
                                <div class='col-xs-12 col-md-3'>
                                    <div class="col-xs-4"><input type="submit" class="btm-search btn bg-olive" value="Search">	</div>
                                     <div class="col-xs-4">
                                        <a href="/admin/professionalAssistances/index/clear" class="btm-search btn btn-warning">Clear</a> </div>
                                </div>	

			    </form>                            </div>
                        </div>	

                    </div>
               
                <div style="clear:both;"></div>
            </div>
                 <div class=" padding_btm_20" style="padding-top:10px">
			
			<div class="col-xs-12 margin-top-20">
                            <span class="pull-right">
                             <?php echo $this->Html->link('Add',['controller'=>'faqs','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?>
                                </span>
                        </div>
		    </div>
             
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('comapny_name', 'Comapny Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('phone', 'Phone'); ?></th>
                             <th scope="col"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($professionalAssistances->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($professionalAssistances as $professionalAssistance){
                        $id = $this->Encryption->encode($professionalAssistance->id);
                     ?>
                        <tr scope="row">
                            <td><?=@$professionalAssistance->comapny_name; ?></td>
                            <td><?=@$professionalAssistance->name; ?></td>
                            <td><?=@$professionalAssistance->email; ?></td>
                            <td><?=@$professionalAssistance->phone; ?></td>
                          
                            <td><?php echo $this->Custom->DateTime($professionalAssistance->created);?></td>
                            
                            
                            <td><?php if($professionalAssistance->is_active==1) { ?> 
                                
                                <a  class="myalert-active " data-title="Faq" title="Active" data-status="1" data-newstatus="0" href="javasript:void();" data-id="<?php echo $professionalAssistance->id?>" data-modelname="ProfessionalAssistances">  <?php echo $this->Html->image('icons/active.png');?>  </a>
                                
                            <?php }if($professionalAssistance->is_active==0){?> 
                                 <a  class="myalert-active " data-title="Faq" title="Inactive" data-status="0" data-newstatus="1" href="javasript:void();" data-id="<?php echo $professionalAssistance->id?>" data-modelname="ProfessionalAssistances">  <?php echo $this->Html->image('icons/inactive.png');?>  </a>
                            <?php } ?>
                            </td>
                            <td class="center">
                               
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'ProfessionalAssistances','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp;

                             
 <a  class="myalert-delete " data-title="Faq" title="Delete" href="javasript:void();" data-id="<?php echo $professionalAssistance->id?>" data-modelname="ProfessionalAssistances"> <?php echo $this->Html->image("icons/delete.png"); ?> </a>
 
                            </td>
                        </tr>
                <?php } } ?>
                    </tbody> 
                    </table>
                  <?php echo $this->element('pagination'); ?>
                

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

