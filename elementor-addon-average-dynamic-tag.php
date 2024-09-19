<?php
/**
 * Plugin Name: Elementor ACF Dynamic Tags
 * Description: Add dynamic tag that returns an ACF field.
 * Plugin URI:  https://joshuahealey.com/elementor-acf-dynamic-tags
 * Version:     1.0.0
 * Author:      Joshua Healey (@liberalterian)
 * Author URI:  https://joshuahealey.com/
 * Text Domain: elementor-acf-dynamic-tags
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.24.0
 * Elementor Pro tested up to: 3.24.0
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
		'site',
		[
			'title' => esc_html__( 'Site', 'elementor-acf-dynamic-tags' )
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
function register_acf_dynamic_text_tag( $dynamic_tags_manager ) {

	require_once( __DIR__ . '/dynamic-tags/acf-dynamic-text-tag.php' );

	$dynamic_tags_manager->register( new \ACF_Dynamic_Text_Tag );

}
add_action( 'elementor/dynamic_tags/register', 'register_acf_dynamic_text_tag' );