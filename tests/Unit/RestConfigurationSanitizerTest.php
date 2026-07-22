<?php
/**
 * REST configuration sanitizer tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\PMorixPTRG\RestApi\ConfigurationSanitizer;

/**
 * Tests REST form sanitization.
 */
final class RestConfigurationSanitizerTest extends TestCase {

	/** Normalizes a valid route to one leading slash. @return void */
	public function test_normalizes_route(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize( array( 'route' => 'projects/(?P<id>\\\\d+)' ) );

		self::assertSame( '/projects/(?P<id>\d+)', $configuration->route );
		self::assertFalse( $configuration->route_modified );
	}

	/** Detects unsafe route markup and control characters. @return void */
	public function test_marks_unsafe_route_as_modified(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize( array( 'route' => "projects<script>alert(1)</script>\n" ) );

		self::assertTrue( $configuration->route_modified );
	}

	/** Sanitizes a capability string. @return void */
	public function test_sanitizes_capability(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize( array( 'required_capability' => 'Edit Posts!' ) );

		self::assertSame( 'editposts', $configuration->required_capability );
	}

	/** Uses a non-reserved request field for the configured post type. @return void */
	public function test_sanitizes_endpoint_post_type_without_admin_routing_collision(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'endpoint_post_type' => 'portfolio',
				'post_type'          => 'reserved-admin-value',
			)
		);

		self::assertSame( 'portfolio', $configuration->post_type );
	}

	/** Filters response fields through the allowlist. @return void */
	public function test_filters_response_fields(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize( array( 'response_fields' => array( 'id', 'title', 'password_hash', 'email' ) ) );

		self::assertSame( array( 'id', 'title' ), $configuration->response_fields );
	}

	/** Removes duplicate custom keys and preserves protected keys for rejection. @return void */
	public function test_filters_custom_meta_keys(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize( array( 'custom_meta_keys' => 'color, color _secret' ) );

		self::assertSame( array( 'color', '_secret' ), $configuration->custom_meta_keys );
	}
}
