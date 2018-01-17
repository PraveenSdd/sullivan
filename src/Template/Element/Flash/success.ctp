<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-success fade in" onclick="this.classList.add('hidden')" style="margin-bottom:5px">
    <button data-dismiss="alert" class="close">
        ×
    </button>
    <i class="fa-fw fa fa-check"></i>
    <strong>Success</strong> <?= $message ?>
</div>