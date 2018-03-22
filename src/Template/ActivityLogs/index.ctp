<?php ?>
<div class="row">
    <div class="col-xs-12">
        <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
        </h4>
        <div class="clearfix"></div>
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">Message</th>
                            <th scope="col"><?php echo $this->Paginator->sort('activity', 'Activity'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('module_name', 'Module'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('created', 'Modified Date'); ?></th>
                            <!--th scope="col"><?php echo $this->Paginator->sort('added_by', 'Modified By'); ?></th-->
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($activityLogs->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($activityLogs as $activityLog){
                        $id = $this->Encryption->encode($activityLog->id);
                     ?>
                        <tr scope="row">
                            <td>
                                <?php echo htmlentities($activityLog->message); ?> 
                            </td>
                            <td><?php echo $activityLog->activity; ?></td>
                            <td><?php echo $activityLog->module_name; ?></td>
                            <td><?php echo $this->Custom->HumanReadable($activityLog->created);?></td>
                        </tr>
                <?php } } ?>
                    </tbody> 
                </table>
                  <?php echo $this->element('layout/frontend/default/pagination');?>
            </div>
        </div>
    </div>
</div>
