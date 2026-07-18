<?php
/**
 * REST configuration test factory.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests;

use PratapMaity\WPArchitectAI\RestApi\Configuration;

/**
 * Creates valid REST configuration fixtures.
 */
trait RestConfigurationFactory {

	/**
	 * Creates a configuration with optional overrides.
	 *
	 * @param array<string, mixed> $overrides Property overrides.
	 * @return Configuration
	 */
	private function rest_configuration( array $overrides = array() ): Configuration {
		$values = array_merge(
			array(
				'api_namespace'           => 'portfolio/v1',
				'namespace_modified'      => false,
				'route'                   => '/projects',
				'route_modified'          => false,
				'method'                  => 'GET',
				'data_source'             => 'custom_post_type',
				'post_type'               => 'portfolio',
				'result_limit'            => '10',
				'order'                   => 'DESC',
				'orderby'                 => 'date',
				'search_enabled'          => true,
				'pagination_enabled'      => true,
				'taxonomy_filter_enabled' => true,
				'meta_filter_enabled'     => false,
				'authentication'          => 'public',
				'required_capability'     => '',
				'response_fields'         => array( 'id', 'title', 'excerpt', 'slug', 'date', 'permalink', 'featured_image', 'author', 'taxonomies' ),
				'include_featured_image'  => true,
				'include_author'          => true,
				'include_taxonomies'      => true,
				'include_custom_fields'   => false,
				'custom_meta_keys'        => array(),
				'custom_meta_keys_input'  => '',
				'cache_duration'          => '0',
				'description'             => 'Portfolio projects endpoint.',
			),
			$overrides
		);

		return new Configuration( ...array_values( $values ) );
	}
}
