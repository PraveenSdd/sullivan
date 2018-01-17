<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<script>
    alert(<?php echo $message; ?>);
</script>
<div class="" onclick="this.classList.add('hidden')" style="margin-bottom:0px">
    <button data-dismiss="alert" class="close">
        ×
    </button>
    <i class="fa-fw fa fa-check"></i>
    <strong>Success</strong> <?= $message ?>
</div>

