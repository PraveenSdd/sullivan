<?php ?> 
<div class="modal fade modal-default" id="uploadPermitDocumentModel" role="dialog">
        <div class="modal-dialog modal-lg">
             Modal content
            <div class="modal-content">
                <div class="modal-header">
              
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title formTitle">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-default clearfix">
                        <form name="" enctype="multipart/form-data" method="get" id="uploadPermit" action="javascript:void(0);">
                            <div class="row">
                                <div class="col-sm-4 col-xs-6">
                                    <label>Upload</label>
                                    <div class="input-group" style="width:100%;">
                                        <label class="input-group-btn igb-file">
                                            <span class="btn btn-primary">
                                            Browse&hellip; 
                                            <input  name="form_documet"  id="form_documet" type="file" style="display: none;" multiple>
                                            </span>
                                        </label>
                                        <input  type="text" class="form-control igb-file-txt" readonly>
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
                                
                                <?php 
                                   
                                    echo $this->Form->hidden('form_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'form_id'
                                    ));
                                    echo $this->Form->hidden('form_documents_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'form_documents_id'
                                    ));
                                    echo $this->Form->hidden('permit_documents_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'permit_documents_id'
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