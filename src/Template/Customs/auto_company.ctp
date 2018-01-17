<?php if($companyList): ?>
    <?php foreach ($companyList as $companyId =>$companyName): ?>
        <li class="li-company-list">
            <label class="lbl-company-list" data-company-id="<?php echo $companyId; ?>"  data-company-name="<?php echo $companyName; ?>">
            <?php echo $companyName; ?></label>
        </li>
    <?php endforeach; ?>
<?php endif; ?>