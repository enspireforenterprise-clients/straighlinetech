<?php if (! defined('ABSPATH')) die('No direct access allowed');

	global $post;

	$defaults = [
		'tabs'         => [],
		'display_mode' => 'tabs'
	];

	$module         = array_merge( $defaults, $module );
	$section_links  = [];
	$section_panels = [];
	$display_mode   = $module['display_mode'];
	$heading        = $module['heading'];
	$classes        = SCM()->get_module_classes( $module );

	if( 'accordion' == $display_mode ) {

		$classes[] = 'scm-accordion';

	}

	if( empty( $heading ) ) {

		$heading = 'h3';

	}

	if( is_array( $module['tabs'] ) ) {

		$active        = 'no';
		$aria_selected = 'true';
		$index         = 1;

		foreach( $module['tabs'] as $tab ) {

			$name     = trim( $tab['tab_label'] );
			$tab_id   = sanitize_title( $name ) . '-tab';
			$panel_id = sanitize_title( $name ) . '-panel';
			$content  = apply_filters( 'the_content', trim( $tab['tab_content'] ) );

			if( empty( $name ) || empty( $content ) ) {

				continue;

			}

			$section_labels[] = sprintf('
				<button
					class="section-label"
					role="tab"
					id="%2$s"
					aria-selected="%6$s"
					data-active="%1$s"
					data-section="%3$s"
					data-index="%5$s"
					aria-controls="%3$s">
					%4$s
				</button>',
				$active,
				$tab_id,
				$panel_id,
				$name,
				$index,
				$aria_selected
			);

			$section_panels[] = sprintf('
			  <%7$s class="button-wrap"><button
					class="section-label" 
					data-active="%1$s" 
					data-section="%3$s" 
					data-index="%5$s"
					aria-expanded="false"
					id="%2$s-2"
					aria-controls="%3$s">
					%4$s
					<span class="icon" aria-hidden="true"></span>
				</button></%7$s>
				<div
					aria-labelledby="%2$s"
					class="section-panel"
					id="%3$s"
					data-active="%1$s" 
					data-section="%3$s" 
					data-index="%5$s">
					%6$s
				</div>',
				$active,
				$tab_id,
				$panel_id,
				$name,
				$index,
				$content,
				$heading
			);

			$active        = 'no';
			$aria_selected = 'false';
			$index++;

		}
	}

?>
<?php if( count( $section_labels ) ): ?>
	<section 
		class="<?php echo implode( ' ', $classes ); ?>" 
		id="<?php echo esc_attr( $module['module_id'] ); ?>" 
		data-display-mode="<?php echo esc_attr( $module['display_mode'] ); ?>">
			<div
				class="section-labels"
				role="tablist"
				aria-label="<?php echo esc_attr( $module['tabs_section_title'] ); ?>">
				<?php echo implode( '', $section_labels ); ?>
			</div>
			<?php echo implode( '', $section_panels ); ?>
	</section>
	<script type="text/javascript">

		(function($) {

			var module      = $( '#<?php echo $module['module_id']; ?>' );
			var displayMode = module.data( 'display-mode' )

			$(document).ready(function() {

				onResize();

			});

			function onResize() {

				const mq = window.matchMedia('(max-width: 992px)');

				mq.addListener(updateDisplayMode)

				updateDisplayMode( mq )

			}
			
			function updateDisplayMode( e ) {

				var displayMode  = module.data('display-mode');

				if ( e.matches ) {
					displayMode = 'accordion';
				} else {
					displayMode = module.data('display-mode');
				}

				module.find('.section-label').unbind('click');
				module.find('.section-label').click(function(event) {

					if ( ! event.target.matches('.section-label') )

					event.preventDefault();

					selectTab( $(this).data('index'), displayMode );

				});

				var currentLabelTop, 
						lastLabelTop;
				
				switch(displayMode) {
			
					case 'tabs':

						selectTab(1, displayMode);

						module.removeClass('scm-accordion');
						module.find('.section-panel').attr('role', 'tabpanel')
						module.find('.section-labels').css('display', 'block');
						module.find('.section-label').not('.section-labels .section-label').css('display', 'none');
						module.find('.button-wrap').css('display', 'none');
						break;
						
					case 'accordion':
							
						module.addClass('scm-accordion');
						module.find('.section-labels').css('display', 'none');
						module.find('.section-label').not('.section-labels .section-label').removeAttr('aria-selected');
						module.find('.section-label').not('.section-labels .section-label').css('display', 'block');
						module.find('.section-label').not('.button-wrap').css('display', 'block');
						module.find('.button-wrap').css('display', 'block');
						break;

				}

				if('tabs' == displayMode) {

					module.find('.section-labels .section-label').each(function(index, sectionLabel) {

						currentLabelTop = $(sectionLabel).position().top;

						if(undefined === lastLabelTop) {

							lastLabelTop = currentLabelTop;

						}

						if(lastLabelTop != currentLabelTop) {

							displayMode = 'accordion';

						}

						lastLabelTop = currentLabelTop;

					});

					a11yTabsInit();

				} else {

					a11yAccordionsInit();

				}

			}

			/*----------  Accordions Event Listener Fns  ----------*/

			function a11yAccordionsInit() {

				
				Array.prototype.slice.call(document.querySelectorAll('.scm-accordion')).forEach(function (accordion) {
					
					var alreadyExpanded = accordion.querySelector('.section-label:first-of-type');
					
					// Allow for multiple accordion sections to be expanded at the same time
					var allowMultiple = accordion.hasAttribute('data-allow-multiple');
					
					// Allow for each toggle to both open and close individually
					var allowToggle = (allowMultiple) ? allowMultiple : accordion.hasAttribute('data-allow-toggle');

					// Create the array of toggle elements for the accordion group
					var triggers = Array.prototype.slice.call(accordion.querySelectorAll('div:not(.section-labels) .section-label'));
					var panels = Array.prototype.slice.call(accordion.querySelectorAll('.section-panel'));


					accordion.addEventListener('click', function (event) {
						var target = event.target;

						if (target.classList.contains('section-label')) {
							// Check if the current toggle is expanded.
							var isExpanded = target.getAttribute('aria-expanded') == 'true';
							var active = accordion.querySelector('[aria-expanded="true"]');

							// without allowMultiple, close the open accordion
							if (!allowMultiple && active && active !== target) {
								// Set the expanded state on the triggering element
								active.setAttribute('aria-expanded', 'false');
								// Hide the accordion sections, using aria-controls to specify the desired section
								//document.getElementById(active.getAttribute('aria-controls')).setAttribute('hidden', '');

								// When toggling is not allowed, clean up disabled state
								if (!allowToggle) {
									active.removeAttribute('aria-disabled');
								}
							}

							if (!isExpanded) {
								// Set the expanded state on the triggering element
								target.setAttribute('aria-expanded', 'true');
								// Hide the accordion sections, using aria-controls to specify the desired section
								document.getElementById(target.getAttribute('aria-controls')).removeAttribute('hidden');

								// If toggling is not allowed, set disabled state on trigger
								if (!allowToggle) {
									target.setAttribute('aria-disabled', 'true');
								}
							}
							else if (allowToggle && isExpanded) {
								// Set the expanded state on the triggering element
								target.setAttribute('aria-expanded', 'false');
								// Hide the accordion sections, using aria-controls to specify the desired section
								//document.getElementById(target.getAttribute('aria-controls')).setAttribute('hidden', '');
							}

							event.preventDefault();
						}
					});

					// Bind keyboard behaviors on the main accordion container
					accordion.addEventListener('keydown', function (event) {
						var target = event.target;
						var key = event.which.toString();

						var isExpanded = target.getAttribute('aria-expanded') == 'true';
						var allowToggle = (allowMultiple) ? allowMultiple : accordion.hasAttribute('data-allow-toggle');

						// 33 = Page Up, 34 = Page Down
						var ctrlModifier = (event.ctrlKey && key.match(/33|34/));

						// Is this coming from an accordion header?
						if (target.classList.contains('section-label')) {
							// Up/ Down arrow and Control + Page Up/ Page Down keyboard operations
							// 38 = Up, 40 = Down

							if (key.match(/38|40/) || ctrlModifier) {
								var index     = triggers.indexOf(target);
								var direction = (key.match(/34|40/)) ? 1 : -1;
								var length    = triggers.length;
								var newIndex  = (index + length + direction) % length;

								triggers[newIndex].focus();

								event.preventDefault();
							}
							else if (key.match(/35|36/)) {
								// 35 = End, 36 = Home keyboard operations
								switch (key) {
									// Go to first accordion
									case '36':
										triggers[0].focus();
										triggers[0].click();
										break;
										// Go to last accordion
									case '35':
										triggers[triggers.length - 1].focus();
										triggers[triggers.length - 1].click();
										break;
								}
								event.preventDefault();

							}

						}
					});

					// These are used to style the accordion when one of the buttons has focus
					Array.prototype.slice.call(accordion.querySelectorAll('.section-label')).forEach(function (trigger) {

						trigger.addEventListener('focus', function (event) {
							accordion.classList.add('focus');
						});

						trigger.addEventListener('blur', function (event) {
							accordion.classList.remove('focus');
						});

					});

					// Minor setup: will set disabled state, via aria-disabled, to an
					// expanded/ active accordion which is not allowed to be toggled close
					if (!allowToggle) {
						// Get the first expanded/ active accordion
						var expanded = accordion.querySelector('[aria-expanded="true"]');

						// If an expanded/ active accordion is found, disable
						if (expanded) {
							expanded.setAttribute('aria-disabled', 'true');
						}
					}

				});
			}

			function bindAccordionListeners(index, keys, direction, accordions, labels, regions ) {

				$(accordions[index]).keydown(function(event) {

					accordionKeyDownListener.call(this, event, keys, direction, accordions, labels, regions )

				});

			}

			function accordionKeyDownListener(event, keys, direction, accordions, labels, regions) {

				
				const key   = event.keyCode;
				const index = $(event.target).index();

			}

			/*----------  Tab A11y Functions and Event Listeners  ----------*/
			
			function a11yTabsInit(displayMode) {

				const tablist = module.find('[role="tablist"]');
				const tabs    = module.find('[role="tab"]');
				const panels  = module.find('[role="tabpanel"]');

				// For simpler keycode reference
				var keys = {

					end: 35,
					home: 36,
					left: 37,
					up: 38,
					right: 39,
					down: 40,
					delete: 46

				};

				// Add or subtract depending on key pressed
				var direction = {

					37: -1,
					38: -1,
					39: 1,
					40: 1

				};

				for ( i = 0; i < tabs.length; i++ ) {

					bindTabListeners(i, keys, direction, tablist, tabs, panels);

				}

			}

			function bindTabListeners(index, keys, direction, tablist, tabs, panels) {

				$(tabs[index]).keyup(function( event ) {

					tabKeyUpListener.call( this, event, tabs, keys, direction );
					
				});

				$(tabs[index]).keydown(function( event ) {

					tabKeyDownListener.call( this, event, tabs, keys, direction );

				});
				
			}	

			function tabKeyDownListener( event, tabs, keys, direction ) {

				event.stopPropagation();
			
				var key     = event.keyCode;
				var index   = $(event.target).index();
				
				switch ( key ) {
					
					// Activate last tab
					case keys.end:
						event.preventDefault();
						tabs[tabs.length - 1].focus();
						tabs[tabs.length - 1].click();
						break;

					//Activate first tab
					case keys.home:
						event.preventDefault();
						tabs[0].focus();
						tabs[0].click();
						break;

					case keys.up:
					case keys.down:
						event.preventDefault();
						break;

				}

			}

			function tabKeyUpListener( event, tabs, keys, direction ) {
				
				switchTabOnArrowPress.call(this, event, tabs, direction, keys);

			}

			function switchTabOnArrowPress( event, tabs, direction, keys ) {

				var pressed = event.keyCode;

				if ( direction[pressed] ) {

					var tab = event.target;
					var index = $(event.target).index();

					if ( index !== undefined ) {

						if ( tabs[index + direction[pressed]] ) {

						tabs[index + direction[pressed]].focus();
						tabs[index + direction[pressed]].click();

						} else if ( pressed === keys.left || pressed === keys.up ) {
							
							focusLastTab(tabs);

						} else if ( pressed === keys.right || pressed === keys.down ) {
							
							focusFirstTab(tabs);

						}

					}

				}

			}

			function focusFirstTab(tabs) {
				tabs[0].focus();
				tabs[0].click();
			}

			function focusLastTab(tabs) {
				tabs[tabs.length - 1].focus();
				tabs[tabs.length - 1].click();
			}

			function selectTab(index, displayMode) {

				if ( 'tabs' == displayMode ) {

					module.find('.section-label').attr('data-active', 'no');
					module.find('.section-label').attr('aria-selected', 'false');
					module.find('.section-label[data-index="' + index + '"]').attr('aria-selected', 'true');
					module.find('.section-panel').css('display', 'none');
					module.find('.section-panel[data-index="' + index + '"]').css('display', 'block');

				} else {

					module.find('.section-panel').attr('data-active', 'no');
					module.find('.section-label').attr('data-active', 'no');						
					module.find('.section-label').attr('aria-expanded', 'false');
					module.find('.section-label').attr('aria-expanded', 'false');
					module.find('.section-label[data-index="' + index + '"]').attr('aria-expanded', 'true');

				}

				module.find('.section-label[data-index="' + index + '"]').attr('data-active', 'yes');
				module.find('.section-panel[data-index="' + index + '"]').attr('data-active', 'yes');

			}

		})(jQuery);

	</script>
<?php endif; ?>