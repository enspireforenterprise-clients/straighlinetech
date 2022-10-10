<?php

function footer_wp_activate() {

  $activation_content = '<div class="sc-module sc-module-text">' . ob_get_clean() . '</div>';

  get_header();

  sc_render_page( 'Activation', $activation_content );

  get_footer();

}

footer_wp_activate();

?>