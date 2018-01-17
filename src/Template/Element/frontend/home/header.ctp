<?php ?>
<!-- header index start here -->
<header class="header-index">
    <nav class="navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav main-nav">
                    <li class="active">
                        <a href="/how-to-works">How it works</a></li>
                    <li><a href="#about">Plan</a></li>
                    <li><a href="#contact">About Us</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right user-link-rgt-side">
                    <li><a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">Sign In</a></li>
                    <li> <?php echo $this->Html->link('Sign Up',['controller'=>'users','action'=>'signup'],array('title'=>'Sign Uo','escape' => false)); ?></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header><!-- /header index end -->
