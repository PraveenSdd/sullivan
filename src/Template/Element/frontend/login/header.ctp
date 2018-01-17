<?php?>
   
     <header class="header-main clearfix">
            <a class="navbar-brand pull-left" href="/">
                <img src="<?php echo $this->Html->webroot;?>/frontend/home/img/logo.png" alt="Sullivan PC"  />
            </a>
            <ul class="nav navbar-nav navbar-right user-link-rgt-side">
                <?php if($this->request->params['action']== 'signup'){ ?>
                    <li>
                        <a href="javascript:void(0);" data-toggle="modal" class="dropdown-toggle" data-target="#loginModal">Sign In</a>
                    </li>
                <?php } else if($this->request->params['action']== 'signin' || $this->request->params['action']== 'login'){ ?>
                    <li>
                        <?php echo $this->Html->link('Sign Up',['controller'=>'users','action'=>'signup'],array('class'=>'dropdown-toggle','escape' => false)); ?>
                    </li>    
                <?php } else { ?>
                      <li>
                          <a href="javascript:void(0);" data-toggle="modal" class="dropdown-toggle" data-target="#loginModal">Sign In</a>
                      </li>
                      <li>
                        <?php echo $this->Html->link('Sign Up',['controller'=>'users','action'=>'signup'],array('class'=>'dropdown-toggle','escape' => false)); ?>
                      </li>    
             <?php  } ?>
            </ul>
               
        </header><!-- /header main end -->
        
