 <?php if(!empty($form['form_agencies'])){ 
$number = 1;foreach($form['form_agencies'] as $agency){
if(!empty($agency['category']['name'])){ ?>
<div class="permit-agency-list">
<div class="row">
<div class="col-sm-5"><?=$number.'- '.$agency['category']['name']; ?></div>
<div class="col-sm-1">
<a  class="permitAgency" data-title="Edit Agency" title="Delete" href="javasript:void();" data-formId="<?php echo $form['id'];?>" data-categotyId="<?php echo $agency['category']['id'] ?>" data-formAgencyId="<?php echo $agency['id'];?>" data-toggle="modal" data-target="#permitAddAgencyModel"> <i class="fa fa-edit"></i>
</a>

   </div>
</div>

</div>
<?php }
$number++; ?>
<?php }
}else{ ?>
<div class="permit-agency-list hide"></div>
<?php } ?>