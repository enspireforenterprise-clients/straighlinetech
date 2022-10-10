<?php 

$notification_title = get_theme_mod( 'sc_notification_title' );
$notification_text  = get_theme_mod( 'sc_notification_text' );
$notification_url   = get_theme_mod( 'sc_notification_url' );

if( ! empty( $notification_title ) && ! empty( $notification_text ) ): ?>
<div id="site-notices" class="site-notices">
	<script type="text/template">
		<dialog class="site-notice" data-notice-id="announcement">
			<div class="site-notice__content">
				<svg class="site-notice__content-notice" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 76.27 78.75" aria-hidden="true">
					<path d="M1105.62,514.94a37.64,37.64,0,1,0,37.64,37.63A37.67,37.67,0,0,0,1105.62,514.94Zm0,72.88a35.25,35.25,0,1,1,35.25-35.25A35.29,35.29,0,0,1,1105.62,587.82Z" transform="translate(-1067.49 -514.44)" style="fill:#231f20;stroke:#231f20;stroke-miterlimit:10"/>
					<text transform="translate(29.61 60.82) scale(0.88 1)" style="font-size:67.41088104248047px;fill:#231f20;font-family:Montserrat-Bold, Montserrat;font-weight:700">!</text>
				</svg>
				<strong><?php echo esc_html( $notification_title ); ?>:</strong>	
				<span class="site-notice__text"><?php echo esc_html( $notification_text ); ?></span>
				<?php if( ! empty( $notification_url ) ): ?>
				<a class="site-notice__link" href="<?php echo esc_url($notification_url); ?>">
					<span>Learn More</span>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.52 19.3"><path d="M144.14,231.74l-7.44-9.47a.8.8,0,0,0-.56-.12h0a.81.81,0,0,0-.51.33.8.8,0,0,0,0,.93l5.32,7.42H116.22a.59.59,0,0,0-.6.59V232a.6.6,0,0,0,.6.6h24.91l-5.51,7.59a.86.86,0,0,0-.14.6.8.8,0,0,0,.32.52.84.84,0,0,0,.9,0Z" transform="translate(-115.62 -222.14)" style="fill:#231f20"/></svg>
				</a>				
				<?php endif; ?>
			</div>
			<button class="site-notice__dismiss" data-notice-action="dismiss">
				<span class="sr-only">Close Notice</span>
			</button>
		</dialog>
	</script>
</div>
<?php endif; ?>