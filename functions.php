<?php

add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts' );
function generatepress_child_enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


add_filter( 'get_the_archive_title', 'genereratepress_child_the_archive_title', 20 );
function genereratepress_child_the_archive_title( $title ) {
	if ( is_author() ) {
		$author = get_multiple_authors( 0, true, true );

		if ( empty( $author ) ) {
			return $title;
		}

		$author = $author[0];

		$title = sprintf(
			'%1$s<span class="vcard">%2$s</span>',
			$author->get_avatar( 50 ),
			$author->display_name
		);
	}

	return $title;
}
