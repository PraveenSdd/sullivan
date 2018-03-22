<?php ?>
  <!-- main content start here -->
    <div class="main-content clearfix">
        <h2 class="pull-left"><?php echo @$pageHedding;?></h2>
        <div class="clearfix"></div>
        <div class="form-default clearfix">
              <h5><?= $this->Flash->render() ?></h5>
            <?php  echo $this->Form->create('ProfessionalAssistances', array('url' => array('controller' => 'ProfessionalAssistances', 'action' => 'index'),'id'=>'professional_assistance','method'=>'post','class'=>'form-horizontal')); ?>
            	<div class="row">
                    <div class="col-sm-6 col-xs-6">
                    	<label>Subject</label>
                         <?php echo $this->Form->input('subject', array(
                                                  'placeholder'=>'Subject',
                                                  'class'=>'form-control',
                                                  'label' => false,
                                                 ));  
                                              ?>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                    	<label>Name<span class="text-danger">*</span></label>
                        <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                 ));  
                                              ?>

                    </div>
                    <div class="col-sm-6 col-xs-6">
                    	<label>Email<span class="text-danger">*</span></label>
                            <?php echo $this->Form->input('email', array(
                                                  'placeholder'=>'Email',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                 ));  
                                              ?>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                    	<label>Phone<span class="text-danger">*</span></label>
                        <?php echo $this->Form->input('phone', array(
                                                  'placeholder'=>'Phone',
                                                  'class'=>'form-control inp-phone',
                                                  'label' => false,
                                                 ));  
                                              ?>
                    </div>
                    <div class="col-sm-12 col-xs-6">
                    	<label>Query<span class="text-danger">*</span></label>
                        <?php echo $this->Form->textarea(
                                        'query',
                                        array(
                                            'placeholder'=>'Query',
                                            'class'=>'form-control',
                                            'label' => 'false',
                                              'rows'=>"5",
                                           ));  
                                        ?>
                    </div>
                    
                    <div class="col-sm-12 col-xs-12 clearfix">
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                    </div>
                </div>
              <?php echo $this->Form->end();?>
        </div>
    </div>
<?= $this->Html->script(['ProfessionalAssistances']);?>

