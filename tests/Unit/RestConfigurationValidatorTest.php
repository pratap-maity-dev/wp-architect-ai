<?php
/**
 * REST configuration validator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\RestApi\ConfigurationValidator;
use PratapMaity\WPArchitectAI\Tests\RestConfigurationFactory;

/**
 * Tests REST endpoint configuration policy.
 */
final class RestConfigurationValidatorTest extends TestCase {
	use RestConfigurationFactory;

	/** Accepts the manual test configuration. @return void */
	public function test_accepts_valid_configuration(): void {
		self::assertSame( array(), ( new ConfigurationValidator() )->validate( $this->rest_configuration() ) );
	}

	/** Validates missing and malformed namespaces. @return void */
	public function test_validates_namespace(): void {
		$validator = new ConfigurationValidator();

		self::assertContains( 'The API namespace is required.', $validator->validate( $this->rest_configuration( array( 'api_namespace' => '' ) ) ) );
		foreach ( array( 'Bad Namespace', '/portfolio/v1', 'portfolio/v1/', 'portfolio//v1' ) as $namespace ) {
			self::assertContains( 'The API namespace may contain lowercase letters, numbers, hyphens, underscores, and single internal forward slashes only.', $validator->validate( $this->rest_configuration( array( 'api_namespace' => $namespace ) ) ) );
		}
	}

	/** Accepts valid regex routes and rejects unsafe routes. @return void */
	public function test_validates_route(): void {
		$validator = new ConfigurationValidator();

		self::assertSame( array(), $validator->validate( $this->rest_configuration( array( 'route' => '/projects/(?P<id>\d+)' ) ) ) );
		self::assertContains( 'The route contains unsafe characters or markup.', $validator->validate( $this->rest_configuration( array( 'route' => '/projects;phpinfo()' ) ) ) );
	}

	/** Enforces method allowlist and rejects public writes. @return void */
	public function test_validates_method_and_public_permission(): void {
		$validator = new ConfigurationValidator();

		self::assertContains( 'Select a supported HTTP method.', $validator->validate( $this->rest_configuration( array( 'method' => 'TRACE' ) ) ) );
		self::assertContains( 'Write methods cannot use public authentication.', $validator->validate( $this->rest_configuration( array( 'method' => 'POST' ) ) ) );
	}

	/** Validates post type, result bounds, order, and orderby allowlists. @return void */
	public function test_validates_query_configuration(): void {
		$validator = new ConfigurationValidator();

		self::assertNotSame( array(), $validator->validate( $this->rest_configuration( array( 'post_type' => 'Bad Type' ) ) ) );
		self::assertNotSame( array(), $validator->validate( $this->rest_configuration( array( 'result_limit' => '0' ) ) ) );
		self::assertNotSame( array(), $validator->validate( $this->rest_configuration( array( 'result_limit' => '101' ) ) ) );
		self::assertNotSame( array(), $validator->validate( $this->rest_configuration( array( 'order' => 'RANDOM' ) ) ) );
		self::assertNotSame( array(), $validator->validate( $this->rest_configuration( array( 'orderby' => 'meta_value' ) ) ) );
	}

	/** Rejects protected meta keys. @return void */
	public function test_rejects_protected_meta_key(): void {
		$errors = ( new ConfigurationValidator() )->validate(
			$this->rest_configuration(
				array(
					'include_custom_fields' => true,
					'custom_meta_keys'      => array( '_secret' ),
				)
			)
		);

		self::assertContains( 'Custom meta keys cannot be empty or begin with an underscore.', $errors );
	}
}
