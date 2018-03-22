<?php
  if(!empty($permitAgencyContact)) {
      if(isset($permitAgencyContact->agency)){
        ?>
      
<style>
    .user-ba-des label { float:left;width:120px;font-weight:600;}
    .user-ba-des p { margin-left:120px;padding-top:3px;}
</style>
<div class="user-ba-des">
      <div class="form-group">
        <label for="email" style="font-size: 16px;">Name:</label>
        <p><?php echo $permitAgencyContact->agency->name  ?></p>
      </div>
      <div class="form-group">
        <label for="pwd">Address:</label>
        <p>
            
                <?php echo $permitAgencyContact->agency->address->address1; ?><br>
                <?php if(!empty($permitAgencyContact->agency->address->address2)){?>
                <?php echo $permitAgencyContact->agency->address->address2; ?><br>
                <?php } ?>
                <?php echo $permitAgencyContact->agency->address->city.' '.$permitAgencyContact->agency->address->state->name .', '.$permitAgencyContact->agency->address->zipcode; ?>
        </p>
      </div>
      <div class="form-group">
        <label>Description</label>
        <p><?php echo $permitAgencyContact->agency->description != '' ? $permitAgencyContact->agency->description : 'N/A' ; ?></p>
      </div>
</div>


        <table class="table-striped tbl-permit-document">
            <thead class="tbl-permit-document-thead">
                <tr class="tbl-permit-document-tr">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Position</th>
                    <th scope="col">Phone No/Extension</th>
                    <th scope="col">Address</th>
                </tr>
            </thead>
            <tbody>
       <?php
       if(!empty($permitAgencyContact->permit_agency_contacts)){ 
        ?> <?php foreach ($permitAgencyContact->permit_agency_contacts as $key => $value) { 
                  if(count($value->agency_contact->addresses) >0 ){

                    foreach ($value->agency_contact->addresses as $ke => $val) { 
                       ?>

                        <tr class="tbl-permit-document-tr">
                        <td><?php echo $value->agency_contact->name ?></td>
                        <td><?php echo $value->agency_contact->email ?></td>
                        <td><?php echo $value->agency_contact->position ?></td>
                        <td><?php echo $value->agency_contact->phone ?>
                        <?php if( ! empty($value->agency_contact->phone_extension) ){
                            echo '/'.$value->agency_contact->phone_extension ?>      
                        <?php } ?>
                        <td>
                            <div>
                                <p><?php echo $val->address1; ?></p>
                                <?php if(!empty($val->address2)){?>
                                <p><?php echo $val->address2; ?></p>
                                <?php } ?>
                                <p><?php echo $val->city.' '.$val->state->name .', '.$val->zipcode; ?></p>
                            </div>
                            </td>
                    </tr>

                    <?php }
                   
                   ?> 
                  <?php }else{
                    ?>
                    <tr class="tbl-permit-document-tr">
                        <td><?php echo $value->agency_contact->name ?></td>
                        <td><?php echo $value->agency_contact->email ?></td>
                        <td><?php echo $value->agency_contact->position ?></td>
                        <td><?php echo $value->agency_contact->phone; 
                            if(!empty($value->agency_contact->phone_extension)){
                                echo "/".$value->agency_contact->phone_extension;
                            } 
                        ?></td>
                        <td><?php echo 'N/A'; ?></td>
                    </tr>
                  <?php } 
                ?>

            <?php }  ?>
        </table>

       <?php }else{
       ?>
       <p>NO contact address found</p>
   <?php } ?>
      
      <?php }
    }else{
        ?>
        <p>No data found!</p>
    <?php    
    }
 ?>