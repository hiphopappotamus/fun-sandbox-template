<?php
/**
 * One Sandbox functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package One_Sandbox
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function one_sandbox_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'one_sandbox_content_width', 640 );
}
add_action( 'after_setup_theme', 'one_sandbox_content_width', 0 );

/**
 * consolidate inc
 */
$one_sandbox_directory = '/inc';
$includes = array(
	'/custom-header.php',
	'/theme-setup.php',
	'/template-tags.php',
	'/customizer.php',
	'/template-functions.php',
	'/enqueue.php',
	'/admin-functions.php',
	'/bootstrap-navwalker.php',
	'/custom-functions.php',
	'/editor.php',
	'/extras.php',
	'/hooks.php',
	'/theme-settings.php'
);

foreach ($includes as $file) {
	require_once get_template_directory() . $one_sandbox_directory . $file;
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

