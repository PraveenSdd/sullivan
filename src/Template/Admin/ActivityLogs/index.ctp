<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('message', 'Message'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('activity', 'Activity'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('module_name', 'Module Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('created', 'Activity Date'); ?></th>
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
                  <?php echo $this->element('layout/backend/default/pagination'); ?>


            </div>
        </div>
    </div>
</div>
