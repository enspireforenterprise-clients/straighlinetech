<?php if (! defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="post-content post-excerpt" data-mh="">
	<?php 
	
	$post_id = get_the_ID(); 

	$modules = false;

	if( class_exists('SC_Modules') ) {

		if( is_array( SC_Modules::singleton()->get_modules() ) ) {

			$modules = true;

		}

	}

	if( $modules ) {

		$search = new SC_Search( $post_id );

		$my_excerpt = get_the_excerpt();
			if($my_excerpt !='') {
				the_excerpt();
			} 
			else{
		echo '<p>' . sc_trim_words( $search->get_plain_text_content(), 150 ) . '...</p>';

			}
		

		echo '<a href="' . esc_url( get_permalink() ) . '" class="button button--archive" aria-labelledby="article-number-'.$post_id.'">Read More</a>';

	} else {

		the_excerpt();
	
	}
	
	?>
</div>