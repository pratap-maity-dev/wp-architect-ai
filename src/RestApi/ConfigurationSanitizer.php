<?php
/**
 * REST API request sanitization.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\RestApi;

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes REST endpoint configuration input.
 */
final class ConfigurationSanitizer {

	/** Allowed HTTP methods. @var array<string> */
	public const METHODS = array( 'GET', 'POST', 'PUT', 'PATCH', 'DELETE' );

	/** Allowed data sources. @var array<string> */
	public const DATA_SOURCES = array( 'posts', 'custom_post_type', 'single_post', 'taxonomy_terms', 'current_user', 'custom_callback' );

	/** Allowed sort directions. @var array<string> */
	public const ORDERS = array( 'ASC', 'DESC' );

	/** Allowed sort fields. @var array<string> */
	public const ORDERBY_VALUES = array( 'date', 'modified', 'title', 'ID', 'author', 'name', 'rand', 'menu_order' );

	/** Allowed authentication modes. @var array<string> */
	public const AUTHENTICATION_VALUES = array( 'public', 'logged_in', 'capability', 'administrator' );

	/** Allowed response fields. @var array<string> */
	public const RESPONSE_FIELDS = array( 'id', 'title', 'content', 'excerpt', 'slug', 'status', 'date', 'modified', 'permalink', 'featured_image', 'author', 'taxonomies', 'custom_fields' );

	/**
	 * Sanitizes request data.
	 *
	 * @param array<string, mixed> $input Untrusted request data.
	 * @return Configuration
	 */
	public function sanitize( array $input ): Configuration {
		$raw_namespace = $this->unslash_scalar( $input, 'api_namespace' );
		$api_namespace = sanitize_text_field( $raw_namespace );
		$raw_route     = $this->unslash_scalar( $input, 'route' );
		// Preserve valid named-regex syntax such as (?P<id>\d+); the validator applies a strict route grammar.
		$sanitized_route    = trim( $raw_route );
		$route              = '/' . ltrim( $sanitized_route, '/' );
		$response_fields    = $this->sanitize_allowlist_array( $input, 'response_fields', self::RESPONSE_FIELDS );
		$include_featured   = $this->sanitize_boolean_field( $input, 'include_featured_image' );
		$include_author     = $this->sanitize_boolean_field( $input, 'include_author' );
		$include_taxonomies = $this->sanitize_boolean_field( $input, 'include_taxonomies' );
		$include_custom     = $this->sanitize_boolean_field( $input, 'include_custom_fields' );

		foreach ( array(
			'featured_image' => $include_featured,
			'author'         => $include_author,
			'taxonomies'     => $include_taxonomies,
			'custom_fields'  => $include_custom,
		) as $field => $enabled ) {
			if ( $enabled && ! in_array( $field, $response_fields, true ) ) {
				$response_fields[] = $field;
			}
		}

		$custom_meta_input = $this->sanitize_text_field( $input, 'custom_meta_keys' );
		if ( isset( $input['custom_meta_keys'] ) && is_array( $input['custom_meta_keys'] ) ) {
			$meta_values       = array_filter( wp_unslash( $input['custom_meta_keys'] ), 'is_scalar' );
			$custom_meta_keys  = array_values( array_unique( array_map( 'sanitize_key', array_map( 'strval', $meta_values ) ) ) );
			$custom_meta_input = $this->sanitize_text_field( $input, 'custom_meta_keys_input' );
		} else {
			$custom_meta_keys = preg_split( '/[\s,]+/', $custom_meta_input, -1, PREG_SPLIT_NO_EMPTY );
			$custom_meta_keys = false === $custom_meta_keys ? array() : array_values( array_unique( array_map( 'sanitize_key', $custom_meta_keys ) ) );
		}

		return new Configuration(
			$api_namespace,
			trim( $raw_namespace ) !== $api_namespace,
			$route,
			$raw_route !== $sanitized_route || str_contains( $raw_route, "\0" ) || 1 === preg_match( '/[\x00-\x1F\x7F]/', $raw_route ),
			strtoupper( $this->sanitize_text_field( $input, 'method' ) ),
			$this->sanitize_key_field( $input, 'data_source' ),
			$this->sanitize_text_field( $input, 'endpoint_post_type' ),
			$this->sanitize_text_field( $input, 'result_limit' ),
			strtoupper( $this->sanitize_text_field( $input, 'order' ) ),
			$this->sanitize_text_field( $input, 'orderby' ),
			$this->sanitize_boolean_field( $input, 'search_enabled' ),
			$this->sanitize_boolean_field( $input, 'pagination_enabled' ),
			$this->sanitize_boolean_field( $input, 'taxonomy_filter_enabled' ),
			$this->sanitize_boolean_field( $input, 'meta_filter_enabled' ),
			$this->sanitize_key_field( $input, 'authentication' ),
			$this->sanitize_key_field( $input, 'required_capability' ),
			$response_fields,
			$include_featured,
			$include_author,
			$include_taxonomies,
			$include_custom,
			$custom_meta_keys,
			$custom_meta_input,
			$this->sanitize_text_field( $input, 'cache_duration' ),
			$this->sanitize_textarea_field( $input, 'description' )
		);
	}

	/**
	 * Sanitizes an allowlisted array.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @param array<string>        $allowlist Allowed values.
	 * @return array<string>
	 */
	private function sanitize_allowlist_array( array $input, string $key, array $allowlist ): array {
		if ( ! isset( $input[ $key ] ) || ! is_array( $input[ $key ] ) ) {
			return array();
		}

		$values = array_filter( wp_unslash( $input[ $key ] ), 'is_scalar' );
		$values = array_map( 'sanitize_key', array_map( 'strval', $values ) );

		return array_values( array_intersect( $allowlist, $values ) );
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
	 * Sanitizes a key field.
	 *
	 * @param array<string, mixed> $input Input data.
	 * @param string               $key Field key.
	 * @return string
	 */
	private function sanitize_key_field( array $input, string $key ): string {
		return sanitize_key( $this->unslash_scalar( $input, $key ) );
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
	 * Returns an unslashed scalar value.
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
