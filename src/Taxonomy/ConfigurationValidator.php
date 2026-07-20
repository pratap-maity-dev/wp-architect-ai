<?php
/**
 * Taxonomy configuration validation.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Taxonomy;

defined( 'ABSPATH' ) || exit;

/**
 * Validates sanitized taxonomy configuration.
 */
final class ConfigurationValidator {

	/**
	 * WordPress core taxonomy keys that cannot be re-registered.
	 *
	 * @var array<string>
	 */
	private const RESERVED_KEYS = array( 'category', 'post_tag', 'nav_menu', 'link_category', 'post_format', 'wp_theme', 'wp_template_part_area', 'wp_pattern_category' );

	/**
	 * Validates a configuration.
	 *
	 * @param Configuration $configuration Configuration to validate.
	 * @return array<string> Validation errors.
	 */
	public function validate( Configuration $configuration ): array {
		$errors = array();

		if ( '' === $configuration->taxonomy_key ) {
			$errors[] = __( 'The taxonomy key is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( 1 !== preg_match( '/^[a-z0-9_-]+$/', $configuration->taxonomy_key ) ) {
			$errors[] = __( 'The taxonomy key may contain only lowercase letters, numbers, underscores, or hyphens.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( 32 < strlen( $configuration->taxonomy_key ) ) {
			$errors[] = __( 'The taxonomy key must not exceed 32 characters.', 'pmorix-post-type-taxonomy-rest-generator' );
		} elseif ( in_array( $configuration->taxonomy_key, self::RESERVED_KEYS, true ) ) {
			$errors[] = __( 'The taxonomy key is reserved by WordPress.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( '' === $configuration->singular_label ) {
			$errors[] = __( 'The singular label is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( '' === $configuration->plural_label ) {
			$errors[] = __( 'The plural label is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		}

		if ( array() === $configuration->post_types ) {
			$errors[] = __( 'At least one associated post type is required.', 'pmorix-post-type-taxonomy-rest-generator' );
		} else {
			foreach ( $configuration->post_types as $post_type ) {
				if ( '' === $post_type || 1 !== preg_match( '/^[a-z0-9_-]{1,20}$/', $post_type ) ) {
					$errors[] = __( 'Associated post type keys must contain no more than 20 lowercase letters, numbers, underscores, or hyphens.', 'pmorix-post-type-taxonomy-rest-generator' );
					break;
				}
			}
		}

		return $errors;
	}
}
