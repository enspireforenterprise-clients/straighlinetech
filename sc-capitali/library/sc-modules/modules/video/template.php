<?php if (! defined('ABSPATH')) die('No direct access allowed'); 

SCM_Video::set_data( $module );

?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
	<div class="sc-card sc-card--video">
		<div class="sc-card__media">
			<div class="scm-video__container">
				<button class="scm-video__button">
					<span class="scm-video__button__text">Play Video</span>
					<span class="scm-video__button__icon"></span>
				</button>
				<div class="scm-video__cover scm-video__cover--lazy-load" data-image="<?php echo SCM_Video::get_cover_image(); ?>" aria-hidden="true"></div>
				<div class="scm-video__player">
					<script class="scm-video__player__template" type="text/template">
						<?php echo SCM_Video::get_video_player(); ?>
					</script>
				</div>
			</div>
		</div>
	</div>
</section>
