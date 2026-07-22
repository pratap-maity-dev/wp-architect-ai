<?php
/**
 * REST API endpoint configuration.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\RestApi;

defined( 'ABSPATH' ) || exit;

/**
 * Immutable sanitized REST endpoint configuration.
 */
final class Configuration {

	/**
	 * Constructor.
	 *
	 * @param string        $api_namespace API namespace.
	 * @param bool          $namespace_modified Whether unsafe namespace input was removed.
	 * @param string        $route Route beginning with a slash.
	 * @param bool          $route_modified Whether unsafe route input was removed.
	 * @param string        $method HTTP method.
	 * @param string        $data_source Data source.
	 * @param string        $post_type Post type key.
	 * @param string        $result_limit Result limit input.
	 * @param string        $order Sort direction.
	 * @param string        $orderby Sort field.
	 * @param bool          $search_enabled Whether search is enabled.
	 * @param bool          $pagination_enabled Whether pagination is enabled.
	 * @param bool          $taxonomy_filter_enabled Whether taxonomy filtering is enabled.
	 * @param bool          $meta_filter_enabled Whether meta filtering is enabled.
	 * @param string        $authentication Authentication mode.
	 * @param string        $required_capability Required capability.
	 * @param array<string> $response_fields Response fields.
	 * @param bool          $include_featured_image Whether to include featured images.
	 * @param bool          $include_author Whether to include author details.
	 * @param bool          $include_taxonomies Whether to include taxonomy terms.
	 * @param bool          $include_custom_fields Whether to include custom fields.
	 * @param array<string> $custom_meta_keys Explicit custom meta keys.
	 * @param string        $custom_meta_keys_input Preserved custom meta input.
	 * @param string        $cache_duration Cache duration input.
	 * @param string        $description Endpoint description.
	 */
	public function __construct(
		public readonly string $api_namespace,
		public readonly bool $namespace_modified,
		public readonly string $route,
		public readonly bool $route_modified,
		public readonly string $method,
		public readonly string $data_source,
		public readonly string $post_type,
		public readonly string $result_limit,
		public readonly string $order,
		public readonly string $orderby,
		public readonly bool $search_enabled,
		public readonly bool $pagination_enabled,
		public readonly bool $taxonomy_filter_enabled,
		public readonly bool $meta_filter_enabled,
		public readonly string $authentication,
		public readonly string $required_capability,
		public readonly array $response_fields,
		public readonly bool $include_featured_image,
		public readonly bool $include_author,
		public readonly bool $include_taxonomies,
		public readonly bool $include_custom_fields,
		public readonly array $custom_meta_keys,
		public readonly string $custom_meta_keys_input,
		public readonly string $cache_duration,
		public readonly string $description
	) {
	}
}
