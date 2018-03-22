<?php ?>
<div class="modal fade modal-default" id="profileImageModel" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle">Profile Photo</h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                 <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'upladProfileImg'),'method'=>'post','class'=>'form-horizontal','enctype'=>"multipart/form-data")); ?>
                            <div class="profile-userpic">
                                <?php if(isset($profile['profile_image'])){
                                    
                                    echo $this->Html->image('/'.$profile['profile_image'],array('class'=>'img img-responsive'));
                                    
                                }else{ echo $this->Html->image('/img/profile/profile.jpg',array('class'=>'img img-responsive'));
                                }?>
                                <label for="fusk" class="btn btn-primary browser-btn-popup">Choose photo</label>
                                <input id="fusk" type="file" name="photo" style="display:none">
                            </div>

                            <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                               <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'profile-button btn btn-primary hide')); ?>
                            </div>
                                  <?php echo $this->Form->end();?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //this code for on change photo view on crrent time in photo blick
    
    $('input').change(function () {
           $('.profile-button').removeClass('hide');
        var files;
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                selectedImage = e.target.result;
                $('.img').attr('src', selectedImage);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

</script>
