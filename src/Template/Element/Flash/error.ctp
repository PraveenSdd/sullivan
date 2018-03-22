<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = $message;
}
?>
<style>
    div.flash-message-error {
  color: red;
  /* background: none repeat scroll 0 0 white; */
  clear: both;
  font-size: 13px;
  font-weight: bold;
  width: 100%;
  margin: 0 0 1em 6px;
  padding: 5px;
  padding-left: 0.4em;
}
</style>
<!--<div class="alert alert-danger fade in" onload="this.classList.add('hidden');" style="margin-bottom:0px">
    <button data-dismiss="alert" class="close">
        ×
    </button>
    <i class="fa-fw fa fa-times"></i>
    <strong>Error!</strong> <?= $message ?>
</div>-->
<div class="flash-message-error" ><?php echo $message; ?></div>
<script>$(document).ready(function() {
  // fade out flash 'success' messages
  $('.flash-message-error').delay(1000).hide('highlight', {color: 'none'}, 6000);
});</script>