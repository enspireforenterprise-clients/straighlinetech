<div id="mobile-menu" class="sc-column-menu" role="dialog">
	<header class="sc-column-menu__header">
		<div class="sc-column-menu__logo">
			<a href="<?php bloginfo('url'); ?>" class="logo">
				<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?> Homepage</span>
				<span class="logo__media" aria-hidden="true">
					<?php echo sc_get_logo( 'sc_header_logo' ); ?>
				</span>
			</a>
		</div>
		
		<button class="sc-column-menu__close">
			<span>Close <span class="sr-only">Main Menu</span></span>
		</button>

		
		<div class="row scm-mobile-header d-xl-none" id="mobile-header-menu-bar">
						<div class="col-sm-12">
						<?php
							$portal_text = get_theme_mod( 'sc_portal_text' ); 
							$portal_url  = get_theme_mod( 'sc_portal_url' ); 
						?>
					<?php if( ! empty($portal_text) && ! empty( $portal_url ) ): ?>
					<div class="header__portal_link">
						
						<a href="<?php echo esc_url( $portal_url ); ?>" class="button button--secondary"><?php echo esc_html( $portal_text); ?></a>
					</div>
					<?php endif; ?>
					</div>
					</div>
	</header>
	<section class="container">
		<div class="row">
			<div class="col-12">
				<nav class="sc-column-menu__navigation">
					<?php
						wp_nav_menu([
							'theme_location' => 'header_menu_main',
							'container'      => '',
							'depth'          => '3',
							'items_wrap'		 => '<ul id="%1$s" class="%2$s" role="menubar" aria-label="Main Navigation">%3$s</ul>',
							'walker'         => new SC_Accessible_Mobile_Menu_Walker()
						]);
					?>
				</nav>
			</div>
		</div>
	</section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-12">
					
				</div>
			</div>
		</div>
	</footer>
</div>