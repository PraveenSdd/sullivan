<?php ?>
    <div class="modal fade modal-default" id="uploadPermitAttachmentModel" role="dialog">
        <div class="modal-dialog modal-lg">
             Modal content
            <div class="modal-content">
                <div class="modal-header">
              
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title formAttachmentTitle">Modal Header11</h4>
                </div>
                <div class="modal-body">
                    <div class="form-default clearfix">
                        <form name="" enctype="multipart/form-data" method="get" id="uploadPermitAttachment" action="javascript:void(0);">
                            <div class="row">
                                <div class="col-sm-4 col-xs-6">
                                    <label>Upload</label>
                                    <div class="input-group" style="width:100%;">
                                        <label class="input-group-btn igb-file">
                                            <span class="btn btn-primary">
                                            Browse&hellip; 
                                             <?php echo $this->Form->file('form_attechment', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time alertTime',
                                                  'label' => false,
                                                 'id'=>'form_attechment',
                                                 'style'=>'display: none;',
                                                 'multiple'=>'multiple'
                                                 ));  
                                              ?>
                                            
                                            </span>
                                        </label>
                                         
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label>Notes</label>
                                    <?php 
                                      echo $this->Form->textarea('notes', array(
                                          'placeholder'=>'Notes',
                                          'label' => false,
                                          'class'=> 'form-control',
                                          'id'=>'notes'

                                          ));
                                       ?>
                                </div>
                                 <div class="col-sm-4 col-xs-6">
                                    <label>Privacy</label>
                                     <?php  $arrPrivacy = ['0'=>'Public','1'=>'Private'];
                                      echo $this->Form->input('privacy', array(
                                         'type' => 'select',
                                         'options' => $arrPrivacy,
                                          'empty'=>'Please select Privacy',
                                          'label' => false,
                                          'class'=> 'form-control select2',
                                          'id'=>'attachment',
                                          ));
                                       ?>
                                </div>
                                
                                <?php 
                                   
                                    echo $this->Form->hidden('form_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'form_attachment_id'
                                    ));
                                    echo $this->Form->hidden('form_documents_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'form_attachment_documents_id'
                                    ));
                                    echo $this->Form->hidden('form_attachment_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'form_attachment_document_id',
                                    ));
                                    echo $this->Form->hidden('permit_attachment_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'permit_attachment_id',
                                    ));
                                    
                                ?>
                                <div class="col-sm-12 col-xs-12 clearfix">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>