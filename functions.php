<?php

add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts' );
function generatepress_child_enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


add_filter( 'get_the_archive_title', 'genereratepress_child_the_archive_title', 20 );
function genereratepress_child_the_archive_title( $title ) {
	if ( is_author() ) {
		the_post();
		$author = get_multiple_authors( 0, true, true );
		rewind_posts();

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

add_action('init', 'generatepress_child_remove_action', 100);

function generatepress_child_remove_action() {
    remove_action('generate_after_archive_title', 'generate_do_archive_description');
}

add_action( 'generate_after_archive_title', 'generatepress_child_do_archive_description' );
function generatepress_child_do_archive_description() {
	if ( ! is_author() ) {
		return;
	}

	the_post();
	$author = get_multiple_authors( 0, true, true );
	rewind_posts();

    $author = $author[0];

	if ( ! empty( $author->description ) ) {
		echo '<div class="author-info">' . $author->description . '</div>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * generate_after_archive_description hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_archive_description' );
}
