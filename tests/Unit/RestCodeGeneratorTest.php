<?php
/**
 * REST endpoint code generator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\RestApi\CodeGenerator;
use PratapMaity\WPArchitectAI\Tests\RestConfigurationFactory;

/**
 * Tests secure REST controller generation.
 */
final class RestCodeGeneratorTest extends TestCase {
	use RestConfigurationFactory;

	/** Generates the required REST registration structure. @return void */
	public function test_generates_rest_route_and_security_callbacks(): void {
		$code = ( new CodeGenerator() )->generate( $this->rest_configuration() );

		self::assertStringContainsString( "add_action( 'rest_api_init'", $code );
		self::assertStringContainsString( '\\WP_REST_Server::READABLE', $code );
		self::assertStringContainsString( 'register_rest_route(', $code );
		self::assertStringContainsString( "'permission_callback' => '__return_true'", $code );
		self::assertStringContainsString( "'sanitize_callback'", $code );
		self::assertStringContainsString( "'validate_callback'", $code );
		self::assertStringContainsString( 'new \\WP_REST_Response', $code );
		self::assertStringContainsString( 'new \\WP_Error', $code );
		self::assertStringContainsString( 'wp_reset_postdata();', $code );
		self::assertStringNotContainsString( '\\t', $code );
	}

	/** Generates enabled request features without raw SQL. @return void */
	public function test_generates_pagination_search_and_taxonomy_filter(): void {
		$code = ( new CodeGenerator() )->generate( $this->rest_configuration() );

		self::assertStringContainsString( "'pagination' => array(", $code );
		self::assertStringContainsString( "\$query_args['s']", $code );
		self::assertStringContainsString( "\$query_args['tax_query']", $code );
		self::assertStringNotContainsString( 'SELECT ', strtoupper( $code ) );
		self::assertStringNotContainsString( '$wpdb', $code );
	}

	/** Generates restricted meta filtering and explicit custom fields. @return void */
	public function test_generates_restricted_meta_filter(): void {
		$configuration = $this->rest_configuration(
			array(
				'meta_filter_enabled'   => true,
				'include_custom_fields' => true,
				'custom_meta_keys'      => array( 'project_color' ),
				'response_fields'       => array( 'id', 'custom_fields' ),
			)
		);
		$code          = ( new CodeGenerator() )->generate( $configuration );

		self::assertStringContainsString( "'compare' => '='", $code );
		self::assertStringContainsString( 'get_post_meta( $post->ID, $meta_key, true )', $code );
		self::assertStringNotContainsString( 'get_post_meta( $post->ID )', $code );
	}

	/** Generates safe class and filename values. @return void */
	public function test_generates_safe_class_name_and_filename(): void {
		$generator     = new CodeGenerator();
		$configuration = $this->rest_configuration();

		self::assertMatchesRegularExpression( '/^[A-Za-z0-9_]+_REST_Controller$/', $generator->class_name( $configuration ) );
		self::assertSame( 'projects-rest-endpoint.php', $generator->filename( $configuration ) );
		self::assertStringStartsWith( 'Endpoint_', $generator->class_name( $this->rest_configuration( array( 'api_namespace' => '1/v1' ) ) ) );
	}

	/** Keeps endpoint descriptions inside the generated comment. @return void */
	public function test_description_cannot_terminate_generated_comment(): void {
		$configuration = $this->rest_configuration( array( 'description' => "Example */\neval( 'bad' );" ) );
		$code          = ( new CodeGenerator() )->generate( $configuration );

		self::assertStringContainsString( 'Example * / eval', $code );
		self::assertStringNotContainsString( "Example */\neval", $code );
	}

	/** Prevents forbidden execution and sensitive author output. @return void */
	public function test_generated_code_avoids_forbidden_or_sensitive_output(): void {
		$code = ( new CodeGenerator() )->generate( $this->rest_configuration() );

		self::assertDoesNotMatchRegularExpression( '/\beval\s*\(/i', $code );
		self::assertDoesNotMatchRegularExpression( '/\bunserialize\s*\(/i', $code );
		self::assertStringNotContainsString( 'user_email', $code );
		self::assertStringNotContainsString( 'password_hash', $code );
	}

	/** Generates authenticated, non-mutating write boilerplate. @return void */
	public function test_write_method_is_not_public_and_does_not_modify_data(): void {
		$configuration = $this->rest_configuration(
			array(
				'method'         => 'POST',
				'authentication' => 'administrator',
			)
		);
		$code          = ( new CodeGenerator() )->generate( $configuration );

		self::assertStringNotContainsString( "'permission_callback' => '__return_true'", $code );
		self::assertStringContainsString( "'not_implemented'", $code );
		self::assertStringNotContainsString( 'wp_insert_post', $code );
		self::assertStringNotContainsString( 'wp_update_post', $code );
		self::assertStringNotContainsString( 'wp_delete_post', $code );
	}
}
