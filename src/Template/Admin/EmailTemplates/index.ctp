<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <h5><?= $this->Flash->render() ?></h5>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('subject', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($emailTemplates->count() <= 0) { ?>
                            <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                            <?php
                        } else {
                            foreach ($emailTemplates as $template) {
                                $id = $this->Encryption->encode($template->id);
                                ?>
                                <tr scope="row">
                                    <td>
                                        <?php echo $template->subject; ?> 
                                    </td>
                                    <td><?= date("d-m-Y", strtotime($template->modified)); ?></td>
                                    <td><?= @$template->user->first_name; ?></td>
                                    <td class="center">
                                        <?php echo $this->Html->link($this->Html->image("icons/edit.png"), ['controller' => 'emailTemplates', 'action' => 'edit', $id], array('title' => 'Edit', 'escape' => false)); ?>

                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody> 
                </table>
                <?php echo $this->element('layout/backend/default/pagination'); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>