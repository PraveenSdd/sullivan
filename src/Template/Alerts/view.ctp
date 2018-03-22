<?php ?>
<h4 class="pull-left"> 
    <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
</h4>
<div class="clearfix"></div>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="row box-header with-border padding-top-5">
                <div class="col-md-12">
                    <div class="row margin-bottom-20">
                        <div class="col-sm-12 bg-primary clearfix ">
                            <h3 class="text-center"><?php echo $alerts->title; ?></h3>
                            <p> <?php echo $alerts->notes; ?> </p>
                        </div>
                    </div>

                    <div class="row margin-bottom-20">
                        <div class="col-sm-6">
                            <label for="" class="col-sm-3 control-label">Alert Type</label>
                            <div class="col-sm-9">
                                <?php echo $alerts->alert_type->name; ?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <?php if($alerts->alert_type_id == 5) { ?>
                            <label for="" class="col-sm-3 control-label">Staff</label>
                            <div class="col-sm-9">
                                    <?php if (!empty($alerts->alert_staffs)) {
                                        $staffs = [];
                                        foreach ($alerts->alert_staffs as $alertStaff) {
                                            $staffs[] = @$alertStaff->user->first_name . ' ' . @$alertStaff->user->last_name;
                                        }
                                        echo implode(', &nbsp;', @$staffs);
                                    }
                                    ?>
                            </div>
                            <?php } ?>       
                        </div>
                    </div>

                    <div class="row margin-bottom-20">
                        <div class="col-sm-6">
                            <label for="" class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-9">
                                <?php echo $alerts->date; ?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="" class="col-sm-3 control-label">Time</label>
                            <div class="col-sm-9">
                                <?php  echo $alerts->time; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row margin-bottom-20">
                        <div class="col-sm-6">
                            <label for="" class="col-sm-3 control-label">Notes</label>
                            <div class="col-sm-9">
                                <?php echo $alerts->notes; ?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="" class="col-sm-3 control-label">Repetition</label>
                            <div class="col-sm-9">
                                <?php if($alerts->is_repeated) { 
                                    echo 'Yes - '.$alerts->interval_value.'/'.$alerts->interval_type;
                                } else {
                                    echo 'No';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($alertNotificationId)){?>
                        <?php if(!empty($isSubscribed['is_unsubscribed'])){?>
                            <div class="row margin-bottom-20">
                                <div class="col-sm-6">
                                    <label for="" class="col-sm-3 control-label">Un-Subscribe</label>
                                    <div class="col-sm-2">
                                        <input <?php echo (!empty($isSubscribed['is_unsubscribed']))?'checked="checked"':'';?> type="checkbox" data-alert-notification-id=<?php echo $this->Encryption->encode($alertNotificationId);?> name="is_subscribed" value="1" class="inp-alert-repeat">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="box-footer button-form-sub">
                            <?php echo $this->Html->link('Back', ['controller' => 'alerts', 'action' => 'notification'], array('class' => 'btn btn-warning', 'escape' => false));?>
                        </div>
                    <?php } else{?>
                    <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Cancel', ['controller' => 'alerts', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?>
                    </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.inp-alert-repeat', function () {
        var alertNotificationId = $(this).data('alert-notification-id');
        var status = 0;
        if ($(this).is(':checked')) {
            var status = 1;
        }
        if (alertNotificationId) {
            $.ajax({
                url: "/alerts/subscribeUnsubscribeAlert",
                type: "Post",
                dataType: 'JSON',
                data: {alertNotificationId: alertNotificationId, status: status},
                success: function (response) {
                    if (response.flag) {
                        pNotifySuccess('Notifications', response.msg);
                    }else{
                        pNotifyError('Notifications', response.msg);
                    }
                }
            });
        }
    });
</script>



