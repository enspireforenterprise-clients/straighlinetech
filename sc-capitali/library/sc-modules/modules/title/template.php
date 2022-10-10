<?php if (! defined('ABSPATH')) die('No direct access allowed');

$overline  = $module['content']['overline'];
$title     = $module['content']['title'];
$sub_title = $module['content']['sub_title'];
$type      = 'h' . (int) $module['options']['type'];
$size      = $module['options']['text_size'];
$sub_style = $module['options']['subtitle_style'];

?>
<?php if( ! empty( $title ) ): ?>
  <header class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
		<?php

			echo sc_get_heading(
				$title, [
					'overline'  => $overline,
					'sub_title' => $sub_title,
					'element'   => $type,
					'size'      => $size,
					'separator' => 'true',
					'sub_style' => $sub_style
				]
			);

		?>
  </header>
<?php endif; ?>
