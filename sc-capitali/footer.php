<?php if (! defined('ABSPATH')) die('No direct access allowed'); ?>
			<footer id="footer">
								
				<div class="container">
					<div class="row footer-top">
					
						<div class="col-sm-9 col-xs-12 col-lg-9">
							<div class="footer-navigation">
								<?php
									wp_nav_menu(array(
										'theme_location' => 'footer_menu_main',
										'container'      => 'nav',
										'depth'          => '2',
									));
								?>
							</div>
						</div>

						<div class="col-sm-3 col-xs-12 col-lg-3">
							<div class="branding">
								<a href="<?php bloginfo( 'url' ); ?>" class="logo">
									<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?> Homepage</span>
									<span class="logo__media" aria-hidden="true">
										<?php echo sc_get_logo( 'sc_footer_logo' ); ?>
									</span>
								</a>
							</div>

							<div class="footer-col footer-col-right">
								<?php echo sc_get_social_icons( [ 'class' => 'sc-social-icons' ] ); ?>
								
							</div>
						</div>
						
					</div><!-- /.row -->
					
					<div class="row">
						<?php if( get_theme_mod( 'sc_disclaimer' ) ) : ?>
						<div class="col-12 col-lg-6">
							
							<div class="footer-col footer-col-left">
								<p class="disclaimer">
									<?php echo esc_html( get_theme_mod( 'sc_disclaimer' ) ); ?>
								</p>
							</div>
						</div>	
						<?php endif; ?>
						<div class="col-12 col-lg-6">
							<div class="footer-col footer-col-right">
								<div class="footer-notices">
									<p class="copyright">
										<?php echo esc_html( sc_dynamic_year( get_theme_mod( 'sc_copyright' ) ) ); ?>
									</p>
								</div>
							</div>
						</div>


						


					</div><!-- /.row -->
				</div><!-- /.container -->
			</footer><!-- /#footer -->
			
		</div><!-- /#wrapper -->
		<?php wp_footer(); ?>
		<?php 
			
			echo get_theme_mod( 'sc_footer_tracking_scripts' );
		
			if( get_field( 'sc_footer_tracking_scripts' ) ) {

				echo get_field( 'sc_footer_tracking_scripts' );

			}

		?>
	</body>


<script>
( function( $ ) {

  'use strict';

  var $window       = $( window );
  var lastScrollTop = 0;
  var $header       = $( '#header' );
  var headerBottom  = $header.position().top + $header.outerHeight( true );

  $window.scroll( function() {
          var windowTop  = $window.scrollTop();

          // Add custom sticky class 
          if ( windowTop >= headerBottom ) {
              $header.addClass( 'myprefix-maybe-sticky' );
          } else {
              $header.removeClass( 'myprefix-maybe-sticky' );
              $header.removeClass( 'myprefix-show' );
          }

          // Show/hide
          if ( $header.hasClass( 'myprefix-maybe-sticky' ) ) {
              if ( windowTop <= headerBottom || windowTop < lastScrollTop ) {
                  $header.addClass( 'myprefix-show' );
              } else {
                  $header.removeClass( 'myprefix-show' );
              }
          }
          lastScrollTop = windowTop;
  } );
} ( jQuery ) );
</script>

<script>
jQuery(function() {
    jQuery('a[href^="#"]').click(function() {
        if (
                window.location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
            &&  window.location.hostname == this.hostname
        ) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
				jQuery('html,body').animate({
                    scrollTop: target.offset().top - 550
                }, 1000);
                return false;
            }
        }
    });
});


</script>	

</html>