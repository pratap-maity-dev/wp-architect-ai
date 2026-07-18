<?php
/**
 * PHPUnit bootstrap.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! function_exists( '__' ) ) {
	/**
	 * Returns an untranslated test string.
	 *
	 * @param string $text Source string.
	 * @return string
	 */
	function __( string $text ): string {
		return $text;
	}
}

if ( ! function_exists( 'wp_unslash' ) ) {
	/**
	 * Recursively removes slashes in tests.
	 *
	 * @param mixed $value Value to unslash.
	 * @return mixed
	 */
	function wp_unslash( mixed $value ): mixed {
		return is_array( $value ) ? array_map( 'wp_unslash', $value ) : stripslashes( (string) $value );
	}
}

if ( ! function_exists( 'wp_strip_all_tags' ) ) {
	/**
	 * Removes HTML tags for unit tests.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	function wp_strip_all_tags( string $value ): string {
		return preg_replace( '/<[^>]*>/', '', $value ) ?? '';
	}
}

if ( ! function_exists( 'sanitize_text_field' ) ) {
	/**
	 * Provides the text behavior needed by unit tests.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	function sanitize_text_field( string $value ): string {
		return trim( wp_strip_all_tags( $value ) );
	}
}

if ( ! function_exists( 'sanitize_textarea_field' ) ) {
	/**
	 * Provides textarea sanitization for tests.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	function sanitize_textarea_field( string $value ): string {
		return sanitize_text_field( $value );
	}
}

if ( ! function_exists( 'sanitize_key' ) ) {
	/**
	 * Provides key sanitization for tests.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	function sanitize_key( string $value ): string {
		return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( $value ) ) ?? '';
	}
}

if ( ! function_exists( 'sanitize_title' ) ) {
	/**
	 * Provides slug sanitization for tests.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	function sanitize_title( string $value ): string {
		$value = strtolower( wp_strip_all_tags( $value ) );
		$value = preg_replace( '/[^a-z0-9]+/', '-', $value ) ?? '';

		return trim( $value, '-' );
	}
}

require_once dirname( __DIR__ ) . '/src/PostType/Configuration.php';
require_once dirname( __DIR__ ) . '/src/PostType/ConfigurationValidator.php';
require_once dirname( __DIR__ ) . '/src/PostType/ConfigurationSanitizer.php';
require_once dirname( __DIR__ ) . '/src/PostType/CodeGenerator.php';
require_once dirname( __DIR__ ) . '/src/Taxonomy/Configuration.php';
require_once dirname( __DIR__ ) . '/src/Taxonomy/ConfigurationValidator.php';
require_once dirname( __DIR__ ) . '/src/Taxonomy/ConfigurationSanitizer.php';
require_once dirname( __DIR__ ) . '/src/Taxonomy/CodeGenerator.php';
