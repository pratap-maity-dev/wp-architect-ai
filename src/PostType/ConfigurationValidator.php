<?php
/**
 * Custom post type configuration validation.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\PostType;

defined( 'ABSPATH' ) || exit;

/**
 * Validates sanitized custom post type configuration.
 */
final class ConfigurationValidator {

	/**
	 * WordPress core post type keys that cannot be re-registered.
	 *
	 * @var array<string>
	 */
	private const RESERVED_KEYS = array(
		'post',
		'page',
		'attachment',
		'revision',
		'nav_menu_item',
		'custom_css',
		'customize_changeset',
		'oembed_cache',
		'user_request',
		'wp_block',
		'wp_template',
		'wp_template_part',
		'wp_global_styles',
		'wp_navigation',
		'wp_font_family',
		'wp_font_face',
	);

	/**
	 * Validates a configuration.
	 *
	 * @param Configuration $configuration Configuration to validate.
	 * @return array<string> Validation errors.
	 */
	public function validate( Configuration $configuration ): array {
		$errors = array();

		if ( '' === $configuration->post_type_key ) {
			$errors[] = __( 'The post type key is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( 1 !== preg_match( '/^[a-z0-9_-]+$/', $configuration->post_type_key ) ) {
			$errors[] = __( 'The post type key may contain only lowercase letters, numbers, underscores, or hyphens.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( 20 < strlen( $configuration->post_type_key ) ) {
			$errors[] = __( 'The post type key must not exceed 20 characters.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( in_array( $configuration->post_type_key, self::RESERVED_KEYS, true ) ) {
			$errors[] = __( 'The post type key is reserved by WordPress.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( '' === $configuration->singular_label ) {
			$errors[] = __( 'The singular label is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( '' === $configuration->plural_label ) {
			$errors[] = __( 'The plural label is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( '' !== $configuration->menu_position && false === filter_var( $configuration->menu_position, FILTER_VALIDATE_INT ) ) {
			$errors[] = __( 'The menu position must be a whole number.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		return $errors;
	}
}
