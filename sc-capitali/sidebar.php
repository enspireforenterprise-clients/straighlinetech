<?php if ( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

// Template Name: Sidebar

get_header();

if ( have_posts() ) {

	while ( have_posts() ) {

		the_post();

		sc_render_page_banner();

		?>
		<div id="page-content">
			<div class="container">
				<div class="row">
					<div class="col-12 d-none col-lg-3 d-lg-block">
						<?php

							$sidebar = apply_filters( 'sc_sidebar_id', 'default-sidebar' );

							ob_start();

							dynamic_sidebar( $sidebar );

							$sidebar_widgets = ob_get_clean();

							echo $sidebar_widgets;

						?>
					</div>
					<div class="col-12 col-lg-9">
						<?php

							SC_Modules::singleton()->container_open  = '<div class="row">';
							SC_Modules::singleton()->container_close = '</div>';
							SC_Modules::singleton()->set_modules( sc_get_modules_above_page_break() );
							(new SC_Modules())->display_modules();

						?>
					</div>
				</div>
			</div>
			<?php

			SC_Modules::singleton()->container_open  = '<div class="container sc-module-container"><div class="row">';
			SC_Modules::singleton()->container_close = '</div></div>';
			SC_Modules::singleton()->set_modules( sc_get_modules_below_page_break() );
			(new SC_Modules())->display_modules();

			?>
			<div class="container">
				<div class="row">
					<div class="col-12 d-lg-none">
						<?php echo $sidebar_widgets; ?>
					</div>
				</div>
			</div>
		</div>
		<?php

	}

}

get_footer();