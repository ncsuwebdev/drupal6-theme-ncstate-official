/* 
 * Change base font size, based on the selection made on the theme settings page 
 * [yoursite]/admin/appearance/settings/ncstate_official
*/

body {
  font-size: <?php echo theme_get_setting('base_font_size'); ?>;
}