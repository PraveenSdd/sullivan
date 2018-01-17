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
			     <?php  echo $this->Form->create('Categories', array('url' => array('controller' => 'categories', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                                 
                                <div class='col-xs-3 col-md-3'>
                                    <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Agency Name',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                    'maxlength'=>120,
                                                 ));  
                                              ?>
                                </div>	
                                <div class='col-xs-12 col-md-3'>
                                    <div class="col-xs-4"><input type="submit" class="btm-search btn bg-olive" value="Search">	</div>
                                     <div class="col-xs-4">
                                        <a href="/admin/categories/index/clear" class="btm-search btn btn-warning">Clear</a> </div>
                                </div>	

			    <?php echo $this->Form->end();?>
                            </div>
                        </div>	

                    </div>
               
                <div style="clear:both;"></div>
            </div>
                 <div class=" padding_btm_20" style="padding-top:10px">
			
			<div class="col-xs-12 margin-top-20">
                            <span class="pull-right">
                             <?php echo $this->Html->link('Add Agencies',['controller'=>'categories','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?>
                                </span>
                        </div>
		    </div>
             
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Agency Name'); ?></th>
                             <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($categories->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($categories as $category){
                        $id = $this->Encryption->encode($category->id);
                     ?>
                        <tr scope="row">
                             <td>
                              <?php echo $this->Html->link($category->name,['controller'=>'categories','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> 
                            
                             </td>
                           
                            <td><?= date("d-m-Y", strtotime($category->modified)); ?></td>
                            
<!--                            <td>
                                <?= $this->Html->link($this->Encryption->subcategory($category->id), ['controller' => 'categories', 'action' => 'subCategory', $id],array('escape' => false)); ?> 
                                </td>-->
                            
                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'categories','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                
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

<script>
$(document).ready(function() {

    $("#register").validate({ 
        rules: {
            //-- rules--
        },
        messages: {
            //-- messages--
        },
        submitHandler: function(form) {
            $.ajax({
                url: 'register.php',
                data:  $(form).serialize(),
                dataType: 'json'
            });
            return false;
        }
    });

});</script>