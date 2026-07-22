<?php
/**
 * REST admin controller security tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Guards the controller's nonce and capability checks.
 */
final class RestAdminSecurityTest extends TestCase {

	/** Download handler retains nonce and capability validation. @return void */
	public function test_download_has_nonce_and_capability_checks(): void {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reads a local test fixture.
		$source = file_get_contents( dirname( __DIR__, 2 ) . '/src/Admin/RestApiGeneratorPage.php' );

		self::assertIsString( $source );
		self::assertStringContainsString( 'check_admin_referer( self::DOWNLOAD_ACTION, self::NONCE_FIELD )', $source );
		self::assertStringContainsString( 'current_user_can( self::CAPABILITY )', $source );
		self::assertStringContainsString( '$this->assert_capability();', $source );
	}

	/** Generated code is streamed and never stored by the admin controller. @return void */
	public function test_admin_controller_does_not_write_or_execute_generated_php(): void {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reads a local test fixture.
		$source = file_get_contents( dirname( __DIR__, 2 ) . '/src/Admin/RestApiGeneratorPage.php' );

		self::assertIsString( $source );
		self::assertDoesNotMatchRegularExpression( '/\beval\s*\(/i', $source );
		self::assertStringNotContainsString( 'file_put_contents', $source );
		self::assertStringNotContainsString( 'fopen(', $source );
	}
}
