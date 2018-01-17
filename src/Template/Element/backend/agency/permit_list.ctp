 <?php ?>
<table class="table table-responsive">
    <thead>
    <t>
        <th>Permit Name</th>
        <th>Person</th>
    </t>
</thead>
<tbody>
        <?php if(!empty($category['permits'])){
              if(!empty($category['permits']->toArray())){
            foreach($category['permits'] as $permit){ ?>
    <tr>
        <td class="text-left"><?=$permit['form']['title']?></td>
        <td class="text-left"><?=$permit['agency_contact']['name']?></td>
    </tr>
         <?php }
        }else{ ?>
    <tr>
        <td colspan="6"> Record not found </td></tr>
       <?php } 
        }else{ ?>
    <tr>
        <td colspan="6"> Record not found </td></tr>
       <?php } ?>
</tbody>
</table>