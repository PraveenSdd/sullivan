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
			     <form action="/admin/faqs" novalidate="novalidate" id="CategoryIndexForm" method="get" accept-charset="utf-8">
                                 <div style="display:none;">
                                     <input type="hidden" name="_method" value="Get"/></div>
                                <div class='col-xs-3 col-md-2'>
                                    <input name="title" placeholder="Question" class="form-control btm-search" type="text" id="CategoryCategoryName"/>
                                </div>								
                                
                                <div class='col-xs-12 col-md-3'>
                                    <div class="col-xs-4"><input type="submit" class="btm-search btn bg-olive" value="Search">	</div>
                                     <div class="col-xs-4">
                                        <a href="/admin/faqs/index/clear" class="btm-search btn btn-warning">Clear</a> </div>
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
                            <th scope="col"><?php echo $this->Paginator->sort('question', 'Question'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($faqs->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($faqs as $faq){
                        $id = $this->Encryption->encode($faq->id);
                     ?>
                        <tr scope="row">
                            <td>
                                <?php echo $this->Html->link($faq->question,['controller'=>'faqs','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> </td>
                          
                            <td><?php echo $this->Custom->DateTime($faq->modified);?></td>
                            
                            
                            
                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'faqs','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'faqs','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp;

                             
 
 
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