<?php ?>

<div class="main-content clearfix">
    <h2 class="pull-left">FAQ</h2>
    <div class="clearfix"></div>
    <div class="main-content-bx clearfix">
        <div id="accordion" class="faq-wrap" role="tablist">
                     <?php foreach($faqs as $faq){ ?>
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1"><?php echo $faq['question']?></a>
                    </h5>
                </div>
                <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <p><?php echo $faq['answer']?></p>
                    </div>
                </div>
            </div>
                     <?php }?>
        </div>
    </div>
</div>

