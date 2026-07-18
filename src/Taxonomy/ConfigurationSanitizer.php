<?php
/**
 * Taxonomy request sanitization.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Taxonomy;

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes taxonomy configuration input.
 */
final class ConfigurationSanitizer {

	/**
	 * Sanitizes request data and returns a configuration.
	 *
	 * @param array<string, mixed> $input Untrusted request data.
	 * @return Configuration
	 */
	public function sanitize( array $input ): Configuration {
		$selected_post_types = $this->sanitize_post_type_array( $input );
		$custom_post_types   = $this->sanitize_text_field( $input, 'custom_post_types' );
		$manual_post_types   = preg_split( '/[\s,]+/', $custom_post_types, -1, PREG_SPLIT_NO_EMPTY );
		$manual_post_types   = false === $manual_post_types ? array() : array_map( 'sanitize_text_field', $manual_post_types );
		$post_types          = array_values( array_unique( array_merge( $selected_post_types, $manual_post_types ) ) );

		return new Configuration(
			$this->sanitize_text_field( $input, 'taxonomy_key' ),
			$this->sanitize_text_field( $input, 'singular_label' ),
			$this->sanitize_text_field( $input, 'plural_label' ),
			$post_types,
			$custom_post_types,
			$this->sanitize_textarea_field( $input, 'description' ),
			$this->sanitize_boolean_field( $input, 'public' ),
			$this->sanitize_boolean_field( $input, 'publicly_queryable' ),
			$this->sanitize_boolean_field( $input, 'show_ui' ),
			$this->sanitize_boolean_field( $input, 'show_admin_column' ),
			$this->sanitize_boolean_field( $input, 'show_in_rest' ),
			$this->sanitize_boolean_field( $input, 'hierarchical' ),
			$this->sanitize_boolean_field( $input, 'show_tagcloud' ),
			$this->sanitize_boolean_field( $input, 'show_in_quick_edit' ),
			sanitize_title( $this->unslash_scalar( $input, 'rewrite_slug' ) ),
			$this->sanitize_boolean_field( $input, 'rewrite_hierarchical' ),
			$this->sanitize_boolean_field( $input, 'query_var' )
		);
	}

	/**
	 * Sanitizes selected post types.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @return array<string>
	 */
	private function sanitize_post_type_array( array $input ): array {
		if ( ! isset( $input['post_types'] ) || ! is_array( $input['post_types'] ) ) {
			return array();
		}

		$values  = wp_unslash( $input['post_types'] );
		$scalars = array_filter( $values, 'is_scalar' );

		return array_map( 'sanitize_text_field', array_map( 'strval', $scalars ) );
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
