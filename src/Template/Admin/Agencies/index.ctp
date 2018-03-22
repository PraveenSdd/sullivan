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
                            <?php echo $this->Form->create('Agencies', array('url' => array('controller' => 'agencies', 'action' => 'index'), 'id' => 'srchFromAgency', 'type' => 'get')); ?>

                            <div class='col-xs-3 col-md-3'>
                                <?php
                                echo $this->Form->input('name', array(
                                    'placeholder' => 'Agency Name',
                                    'class' => 'form-control btm-search',
                                    'label' => false,
                                    'maxlength' => 120,
                                ));
                                ?>
                            </div>	
                            <div class='col-xs-12 col-md-3'>
                                <div class="col-xs-4"><input type="submit" class="btm-search btn bg-olive" value="Search">	</div>
                                <div class="col-xs-4">
                                    <a href="/admin/agencies/index/clear" class="btm-search btn btn-warning">Clear</a> </div>
                            </div>	

<?php echo $this->Form->end(); ?>
                        </div>
                    </div>	

                </div>

                <div style="clear:both;"></div>
            </div>
            <div class="col-xs-12 margin-top-20">
                <span class="pull-right">
    <?php echo $this->Html->link('Add Agency', ['controller' => 'agencies', 'action' => 'add'], array('class' => 'btn btn-primary', 'escape' => false)); ?>
                </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Agency Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($agencies->count() <= 0) { ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                        <?php
                        } else {
                            foreach ($agencies as $agency) {
                                $id = $this->Encryption->encode($agency->id);
                                ?>
                        <tr scope="row">
                            <td>
        <?php echo $this->Html->link(htmlentities($agency->name), ['controller' => 'agencies', 'action' => 'view', $id], array('title' => 'View', 'escape' => false)); ?> 

                            </td>

                            <td><?= $this->Custom->DateTime($agency->modified); ?></td>
                            <td><?= @$agency->user->first_name; ?></td>

        <!--                            <td>
        <?= $this->Html->link($this->Encryption->subagency($agency->id), ['controller' => 'agencies', 'action' => 'subAgency', $id], array('escape' => false)); ?> 
            </td>-->

                            <td class="center">
            <?php echo $this->Html->link($this->Html->image("icons/edit.png"), ['controller' => 'agencies', 'action' => 'edit', $id], array('title' => 'Edit', 'escape' => false)); ?> &nbsp;&nbsp;
                            </td>
                        </tr>
                    <?php }
                } ?>
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
