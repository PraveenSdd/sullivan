<ol class="breadcrumb">
    <li>
        <?php echo $this->Html->link('<i class="fa fa-dashboard"></i> Dashboard',['controller'=>'users','action'=>'dashboard'],array('title'=>'View','escape' => false)); ?> </li>    
    <?php
    if(isset($breadcrumb)){
        foreach ($breadcrumb as $row){
            if(isset($row['link']))
                echo '<li><a href="/admin/'.$row['link'].'">'.ucwords($row['label']).'</a></li>';
            else
                echo '<li>'.ucwords($row['label']).'</li>';
        }
    }
    
    ?>
</ol>