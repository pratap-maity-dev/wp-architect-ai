<?php
/**
 * REST endpoint configuration validation.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\RestApi;

/**
 * Validates sanitized REST endpoint configuration.
 */
final class ConfigurationValidator {

	/**
	 * Validates a configuration.
	 *
	 * @param Configuration $configuration Configuration to validate.
	 * @return array<string> Validation errors.
	 */
	public function validate( Configuration $configuration ): array {
		$errors = array();

		if ( '' === $configuration->api_namespace ) {
			$errors[] = __( 'The API namespace is required.', 'wp-architect-ai' );
		} elseif ( $configuration->namespace_modified || 1 !== preg_match( '#^[a-z0-9_-]+(?:/[a-z0-9_-]+)*$#', $configuration->api_namespace ) ) {
			$errors[] = __( 'The API namespace may contain lowercase letters, numbers, hyphens, underscores, and single internal forward slashes only.', 'wp-architect-ai' );
		}

		if ( '/' === $configuration->route || '' === $configuration->route ) {
			$errors[] = __( 'The route path is required.', 'wp-architect-ai' );
		} elseif ( $configuration->route_modified || 1 !== preg_match( '#^/[A-Za-z0-9_./?()<>\\\\+*^$|=:\[\]-]+$#', $configuration->route ) ) {
			$errors[] = __( 'The route contains unsafe characters or markup.', 'wp-architect-ai' );
		}

		if ( ! in_array( $configuration->method, ConfigurationSanitizer::METHODS, true ) ) {
			$errors[] = __( 'Select a supported HTTP method.', 'wp-architect-ai' );
		}

		if ( ! in_array( $configuration->data_source, ConfigurationSanitizer::DATA_SOURCES, true ) ) {
			$errors[] = __( 'Select a supported data source.', 'wp-architect-ai' );
		}

		if ( in_array( $configuration->data_source, array( 'posts', 'custom_post_type', 'single_post' ), true ) && 1 !== preg_match( '/^[a-z0-9_-]{1,20}$/', $configuration->post_type ) ) {
			$errors[] = __( 'The post type must contain no more than 20 lowercase letters, numbers, underscores, or hyphens.', 'wp-architect-ai' );
		}

		if ( false === filter_var( $configuration->result_limit, FILTER_VALIDATE_INT ) || 1 > (int) $configuration->result_limit || 100 < (int) $configuration->result_limit ) {
			$errors[] = __( 'The number of results must be an integer from 1 to 100.', 'wp-architect-ai' );
		}

		if ( ! in_array( $configuration->order, ConfigurationSanitizer::ORDERS, true ) ) {
			$errors[] = __( 'Select a supported order.', 'wp-architect-ai' );
		}

		if ( ! in_array( $configuration->orderby, ConfigurationSanitizer::ORDERBY_VALUES, true ) ) {
			$errors[] = __( 'Select a supported order-by value.', 'wp-architect-ai' );
		}

		if ( ! in_array( $configuration->authentication, ConfigurationSanitizer::AUTHENTICATION_VALUES, true ) ) {
			$errors[] = __( 'Select a supported authentication requirement.', 'wp-architect-ai' );
		} elseif ( 'GET' !== $configuration->method && 'public' === $configuration->authentication ) {
			$errors[] = __( 'Write methods cannot use public authentication.', 'wp-architect-ai' );
		} elseif ( 'capability' === $configuration->authentication && '' === $configuration->required_capability ) {
			$errors[] = __( 'A valid capability is required for capability-based authentication.', 'wp-architect-ai' );
		}

		if ( array() === $configuration->response_fields ) {
			$errors[] = __( 'Select at least one response field.', 'wp-architect-ai' );
		}

		if ( false === filter_var( $configuration->cache_duration, FILTER_VALIDATE_INT ) || 0 > (int) $configuration->cache_duration || 86400 < (int) $configuration->cache_duration ) {
			$errors[] = __( 'Cache duration must be an integer from 0 to 86400 seconds.', 'wp-architect-ai' );
		}

		if ( ( $configuration->include_custom_fields || $configuration->meta_filter_enabled ) && array() === $configuration->custom_meta_keys ) {
			$errors[] = __( 'Enter at least one custom meta key when meta filtering or custom fields are enabled.', 'wp-architect-ai' );
		}

		foreach ( $configuration->custom_meta_keys as $meta_key ) {
			if ( '' === $meta_key || str_starts_with( $meta_key, '_' ) ) {
				$errors[] = __( 'Custom meta keys cannot be empty or begin with an underscore.', 'wp-architect-ai' );
				break;
			}
		}

		if ( 'current_user' === $configuration->data_source && 'public' === $configuration->authentication ) {
			$errors[] = __( 'Current-user endpoints must require authentication.', 'wp-architect-ai' );
		}

		return $errors;
	}
}
