<?php ?>
 <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <!-- <th scope="col">User</th> -->
                            <th scope="col"><?php echo $this->Paginator->sort('created_at', 'Created'); ?></th>
                            <th scope="col">Module name</th>
                            <th scope="col">Activity</th>
                            <th scope="col">Message</th>
                            
                            
                            <!-- <th scope="col">Url</th>  -->      

                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($logs->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($logs as $logs){
                        $a = parse_url($logs->url);
                     ?>
                        <tr scope="row">
                            <!-- <td ><?php //echo $logs->user_id; ?></td> -->
                            <td><?php echo $this->Custom->HumanReadable($logs->created_at);?></td>
                            <td><?php echo htmlentities($logs->module_name); ?></td>
                            <td><?php echo htmlentities($logs->sub_module_name); ?></td>
                            <td><?php echo htmlentities($logs->message).'......'; ?><a style="cursor: pointer;" href="javascript:void(0);" title="view">View Detail</a></td>
                            
                            
                         </tr>
                <?php } } ?>
                    </tbody> 
                </table>
                  <?php echo $this->element('layout/frontend/default/pagination'); ?>


            </div>