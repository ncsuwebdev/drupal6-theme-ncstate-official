/* dynamic styles set via the theme options page inside the Drupal site by an Administrator */
<?php if(!theme_get_setting('show_belltower')): // move menu div to the left to line up with the edge of the layout ?>
    #region-noBrandBarDefaultTopMenu {
        width: 880px;
        left: 17px;
    }
<?php endif; ?>
<?php if(theme_get_setting('anniversary_header')): ?>
    #noBrandBarDefaultTopMenuNav {
        left: 130px;
    }
<?php endif; ?>