<?php
if(module_exists('block_class')) { ?>
    <div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?> <?php print block_class($block); ?>">
		<?php if (!empty($block->subject)): ?>
		   <h2><?php print $block->subject ?></h2>
		<?php endif;?>
	    <div class="content"><?php print $block->content ?></div>
    </div>
<?php } else { ?>
	<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
		<?php if (!empty($block->subject)): ?>
		   <h2><?php print $block->subject ?></h2>
		<?php endif;?>
        <div class="content">
            <div class="helper">
                <?php print $block->content ?> 
            </div>
            <div class="block-bottom"></div>
        </div>
    </div>
<?php } ?>