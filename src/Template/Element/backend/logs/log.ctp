<?php ?>
<section class="content-header">
<div class="row">
    <div class="col-lg-12">
        <?php echo $this->Html->link('View All',['controller'=>'activityLogs','action'=>'index'],['escape'=>false,'class'=>'btn btn-info pull-right']);?>
    </div>
</div>
    </section>
<div class="box-body table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Created</th>
                <th scope="col">Module name</th>
                <th scope="col">Activity</th>
                <th scope="col">Message</th>
            </tr>
        </thead>
        <tbody>
                 <?php  if($logs->count() <= 0 ){  ?>
            <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($logs as $logs){
                     ?>
            <tr scope="row">
                <!-- <td ><?php //echo $logs->user_id; ?></td> -->
                <td><?php echo $this->Custom->HumanReadable($logs->created);?></td>
                <td><?php echo htmlentities($logs->module_name); ?></td>
                <td><?php echo htmlentities($logs->activity); ?></td>
                <td><?php echo htmlentities($logs->message); ?></td>
            </tr>
                <?php } } ?>
        </tbody> 
    </table>
</div>