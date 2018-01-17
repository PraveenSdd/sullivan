    <?php
    if(isset($breadcrumb)){
        foreach ($breadcrumb as $row){
            if(isset($row['link']))
                echo '<a href="/'.$row['link'].'"> '.ucwords($row['label']).'</a>&nbsp;&nbsp;>&nbsp;&nbsp;';
            else
                echo ucwords($row['label']).'';
        }
    }
    
    ?>
