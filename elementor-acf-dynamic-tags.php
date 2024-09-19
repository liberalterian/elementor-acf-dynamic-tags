<?php
/**
 * Plugin Name: EACF - Dynamic Tags
 * Description: Adds dynamic tags that allow users to add ACF fields to Elementor templates.
 * Plugin URI:  https://joshuahealey.com/elementor-acf-dynamic-tags
 * Version:     1.0.0
 * Author:      Joshua Healey (@liberalterian)
 * Author URI:  https://joshuahealey.com/
 * Text Domain: elementor-acf-dynamic-tags
 *
 * Requires Plugins: elementor, advanced custom fields
 * Elementor tested up to: 3.24.0
 * Elementor Pro tested up to: 3.24.0
 * Advanced Custom Fields test up to: 6.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register New Dynamic Tag Group.
 *
 * Register new site group for site-related tags.
 *
 * @since 1.0.0
 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
 * @return void
 */
function register_site_dynamic_tag_group( $dynamic_tags_manager ) {

	$dynamic_tags_manager->register_group(
		'acf-fields',
		[
			'title' => esc_html__( 'ACF Fields', 'eacfdt' )
		]
	);

}
add_action( 'elementor/dynamic_tags/register', 'register_site_dynamic_tag_group' );

/**
 * Register ACF Average Dynamic Tag.
 *
 * Include dynamic tag file and register tag class.
 *
 * @since 1.0.0
 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
 * @return void
 */
function register_acf_dynamic_tags( $dynamic_tags_manager ) {

	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-text-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-textarea-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-number-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-url-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-email-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-wysiwyg-tag.php' );
	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-image-tag.php' );

	$dynamic_tags_manager->register( new \ACF_Dynamic_Text_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_Text_Area_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_Number_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_URL_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_Email_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_WYSIWYG_Tag );
	$dynamic_tags_manager->register( new \ACF_Dynamic_Image_Tag );

}
add_action( 'elementor/dynamic_tags/register', 'register_acf_dynamic_tags' );