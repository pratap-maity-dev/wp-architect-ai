<?php
/**
 * Custom post type request sanitization.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\PostType;

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes custom post type configuration input.
 */
final class ConfigurationSanitizer {

	/**
	 * Supported editor features.
	 *
	 * @var array<string>
	 */
	public const ALLOWED_SUPPORTS = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'trackbacks',
		'custom-fields',
		'comments',
		'revisions',
		'page-attributes',
		'post-formats',
	);

	/**
	 * Sanitizes request data and returns a configuration.
	 *
	 * @param array<string, mixed> $input Untrusted request data.
	 * @return Configuration
	 */
	public function sanitize( array $input ): Configuration {
		$supports = array();

		if ( isset( $input['supports'] ) && is_array( $input['supports'] ) ) {
			$unslashed_supports = wp_unslash( $input['supports'] );
			$scalar_supports    = array_filter( $unslashed_supports, 'is_scalar' );
			$sanitized_supports = array_map( 'sanitize_key', array_map( 'strval', $scalar_supports ) );
			$supports           = array_values( array_intersect( self::ALLOWED_SUPPORTS, $sanitized_supports ) );
		}

		return new Configuration(
			$this->sanitize_text_field( $input, 'post_type_key' ),
			$this->sanitize_text_field( $input, 'singular_label' ),
			$this->sanitize_text_field( $input, 'plural_label' ),
			$this->sanitize_textarea_field( $input, 'description' ),
			$this->sanitize_boolean_field( $input, 'public' ),
			$this->sanitize_boolean_field( $input, 'publicly_queryable' ),
			$this->sanitize_boolean_field( $input, 'show_ui' ),
			$this->sanitize_boolean_field( $input, 'show_in_menu' ),
			$this->sanitize_boolean_field( $input, 'show_in_rest' ),
			$this->sanitize_boolean_field( $input, 'hierarchical' ),
			$this->sanitize_boolean_field( $input, 'has_archive' ),
			$this->sanitize_boolean_field( $input, 'exclude_from_search' ),
			$this->sanitize_slug_field( $input, 'rewrite_slug' ),
			$this->sanitize_text_field( $input, 'menu_icon' ),
			$this->sanitize_text_field( $input, 'menu_position' ),
			$supports
		);
	}

	/**
	 * Sanitizes a text field.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return string
	 */
	private function sanitize_text_field( array $input, string $key ): string {
		return sanitize_text_field( $this->unslash_scalar( $input, $key ) );
	}

	/**
	 * Sanitizes a textarea field.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return string
	 */
	private function sanitize_textarea_field( array $input, string $key ): string {
		return sanitize_textarea_field( $this->unslash_scalar( $input, $key ) );
	}

	/**
	 * Sanitizes a slug field.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return string
	 */
	private function sanitize_slug_field( array $input, string $key ): string {
		return sanitize_title( $this->unslash_scalar( $input, $key ) );
	}

	/**
	 * Normalizes a checkbox value.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return bool
	 */
	private function sanitize_boolean_field( array $input, string $key ): bool {
		return isset( $input[ $key ] ) && '1' === sanitize_text_field( $this->unslash_scalar( $input, $key ) );
	}

	/**
	 * Returns an unslashed scalar field value.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return string
	 */
	private function unslash_scalar( array $input, string $key ): string {
		if ( ! isset( $input[ $key ] ) || ! is_scalar( $input[ $key ] ) ) {
			return '';
		}

		return (string) wp_unslash( $input[ $key ] );
	}
}
