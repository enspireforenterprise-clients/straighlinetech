<?php if ( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );?><!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/sc-capitali/assets/favicon/fav-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/sc-capitali/assets/favicon/fav-icon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/sc-capitali/assets/favicon/fav-icon-16x16.png">
		<link rel="mask-icon" href="/wp-content/themes/sc-capitali/assets/favicon/fav-icon.png" color="#019cc9">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		
		<?php wp_head(); ?>
		<?php 
			
			echo get_theme_mod( 'sc_header_tracking_scripts' ); 
			
			if( get_field( 'sc_header_tracking_scripts' ) ) {

				echo get_field( 'sc_header_tracking_scripts' );

			}

		?>
		
	</head>
	<body <?php body_class((! is_front_page() ? array('interior') : array('home'))); ?>>
		<?php 
		
			echo get_theme_mod( 'sc_after_body_open_tracking_scripts' ); 
		
			if( get_field( 'sc_after_body_open_tracking_scripts' ) ) {

				echo get_field( 'sc_after_body_open_tracking_scripts' );

			}

		?>
		
		<a href="#skip-to-content-anchor" id="skip-to-content-link">Skip to Content</a>
		<div id="wrapper">
			<?php get_template_part( 'off-canvas-menus' ); ?>
			<header id="header" class="header">
				<div class="branding d-none d-xl-flex">
					<a href="<?php bloginfo('url'); ?>" class="logo">
						<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?> Homepage</span>
						<span class="logo__media" aria-hidden="true">
							<?php echo sc_get_logo( 'sc_header_logo' ); ?>
						</span>
					</a>
				</div>
				<div class="header__content d-none d-xl-flex">
					
					
					
					<div class="row scm-menu-btn">
					
					<div class="header__menu d-none d-lg-flex">
					<div class="col-sm-8">
						<nav class="header__navigation">
							<?php
								wp_nav_menu([
									'theme_location' => 'header_menu_main',
									'container'      => '',
									'depth'          => '3',
									'items_wrap'		 => '<ul id="%1$s" class="%2$s" role="menubar" aria-label="Main Navigation">%3$s</ul>',
									'walker'         => new SC_Accessible_Menu_Walker()
								]);
							?>
						</nav>

						</div>
						<div class="col-sm-4">

						<?php
							$portal_text = get_theme_mod( 'sc_portal_text' ); 
							$portal_url  = get_theme_mod( 'sc_portal_url' ); 
						?>
					<?php if( ! empty($portal_text) && ! empty( $portal_url ) ): ?>
					<div class="header__portal">
						
						<a href="<?php echo esc_url( $portal_url ); ?>" class="button button-primary"><?php echo esc_html( $portal_text); ?></a>
					</div>
					<?php endif; ?>
					</div>
					</div>

					</div>
				</div>
				<div class="header__content__mobile d-flex d-xl-none">
					<div class="branding">
						<a href="<?php bloginfo('url'); ?>" class="logo">
							<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?> Homepage</span>
							<span class="logo__media" aria-hidden="true">
								<?php echo sc_get_logo( 'sc_header_logo' ); ?>
							</span>
						</a>
					</div>
					
					<button class="mobile-menu-button d-block" id="mobile-menu-button" aria-expanded="false">
						<span class="mobile-menu-button__hamburger">
							<span></span>
							<span></span>
							<span></span>
						</span>
						<span class="mobile-menu-button__text"><span class="sr-only">Open Main </span> Menu</span>
					</button>

					
					
				</div>
  
				<div class="row scm-mobile-header d-xl-none">
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
				
				
      </header><!-- /#header -->
	
	  <?php get_template_part( 'site-notices' ); ?>
      <div id="header-padding"></div>
			<a name="skip-to-content-anchor"></a>