<?php //if( $this->Paginator->param('count') <= PAGINATION_LIMIT){ ?> 
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <li><?php echo $this->Paginator->prev('Previous', array('class' => "disabled1"));?> </li>
                                <li><?php echo $this->Paginator->numbers(array('separator' => '&nbsp;|&nbsp;')); ?></li>
                                <li><?php  echo $this->Paginator->next('Next', array('class' => "disabled1")); ?></li>
                            </ul>
                        </div>
                <?php //}?>