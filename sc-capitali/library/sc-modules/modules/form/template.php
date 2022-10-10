<?php if (! defined('ABSPATH')) die('No direct access allowed'); ?>

<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
  <div class="row">
    <div class="col-12">
      <?php

        $form_plugin  = $module['form_plugin'];
        $ninja_form   = $module['ninja_form'];
        $gravity_form = $module['gravity_form'];
        $form_embed   = $module['embed_code'];

        switch( $form_plugin ) {

          case 'Gravity Forms':

            if( class_exists( 'RGFormsModel' ) && is_array( $gravity_form ) ) {

              $display_title       = false;
              $display_description = false;
              $display_inactive    = false;
              $field_values        = array();
              $ajax                = true;

              gravity_form_enqueue_scripts( $gravity_form['id'], true );
              gravity_form( 
                $gravity_form['id'], 
                $display_title,     
                $display_description,
                $display_inactive,
                $field_values,
                $ajax
              );

            }

            break;

          case 'Ninja Forms':

            if( class_exists( 'Ninja_Forms' ) && is_array( $ninja_form ) ) { 
              
              Ninja_Forms()->display( $ninja_form['id'] );

            }

            break;

          case 'JavaScript Embed':

            if( ! empty( $form_embed ) ) {

              echo '<div class="scm-form__embed">'. $form_embed . '</div>';
              
            }

            break;
  
        }

      ?>
    </div>
  </div>
</section>
