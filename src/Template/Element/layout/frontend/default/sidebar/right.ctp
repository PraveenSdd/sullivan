<?php ?>
<!-- right sidebar start here -->
<div class="right-sidebar clearfix">
    <a href="javascript:void();" class="rgt-sidebar-control"><i class="fa fa-bars"></i></a>
    <div class="rs-content-box clearfix">
        <h3>Upcoming Alerts</h3>
        <ul class="alert-box clearfix">
            <?php if(!empty($headerUpcomingAlerts)){
            foreach($headerUpcomingAlerts as $upcomingAlerts){
                if($upcomingAlerts['is_admin'] == 1){
                                 $color = 'alert-green';
                             }elseif($upcomingAlerts['added_by'] == $LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                ?>
            <li>
                <a href="/alerts/view/<?php echo $this->Encryption->encode($upcomingAlerts['id']);?>">
                    <span class="<?php echo $color;?>"><?php echo $upcomingAlerts['date'];?></span>
                    <p><i class="fa fa-calendar-check-o"></i> <?php echo $upcomingAlerts['title']; ?></p>
                </a>
            </li>
            <?php }?>
            <li><a href="/alerts/index">View all..</a></li>
            <?php }else{?>
            <li><a href="javascript:void(0);">You have 0 notifications.</a></li>
            <?php }?>
        </ul>
    </div>
    <div class="rs-content-box clearfix">
        <h3>Upcoming Deadlines</h3>
        <ul class="alert-box clearfix">
            <?php if(!empty($upcomingDeadlines)){
            foreach($upcomingDeadlines as $upcomingDeadline){
                if($upcomingDeadline['is_admin'] == 1){
                                 $color = 'alert-green';
                             }elseif($upcomingDeadline['added_by'] ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                ?>
            <li>
                <a href="javascript:void(0);">
                    <span class="<?php echo $color;?>">
                        <?php echo $upcomingDeadline['date'];
                        if($upcomingDeadline['is_renewable']==0){
                            echo ' '.$upcomingDeadline['time'];}?></span>
                    <p><i class="fa fa-calendar-check-o"></i> <?php echo $upcomingDeadline['permit']['name']; ?> <strong><?php if($upcomingDeadline['is_renewable']){ echo " (Renewable)";}?></strong></p>
                </a>
            </li>
            <?php }?>
            <li><a href="/deadlines/index">View all..</a></li>
            <?php }else{?>
            <li><a href="javascript:void(0);">You have 0 notifications.</a></li>
            <?php }?>
        </ul>
    </div>
    <div class="rs-content-box clearfix">
        <h3>Last Modification</h3>
        <ul class="notification-box clearfix">
            <?php if(!empty($headerActivityLogs)){
                    foreach($headerActivityLogs as $activityLog){ ?>
            <li>
                <a href="javascript:void(0);">
                    <span><?php echo $activityLog['activity'];?></span>
                    <p><i class="fa fa-file"></i> <?php echo $activityLog['message'];?></p>
                    <small><?php echo $this->Custom->dateTime($activityLog['created'])?></small>
                </a>
            </li>
                    <?php }?>
            <li><a href="/activityLogs/index">View all..</a></li>
                    <?php }else{?>
            <li><a href="javascript:void(0);">You have 0 log.</a></li>
            <?php }?>
        </ul>
    </div>
</div><!-- right sidebar start here -->

