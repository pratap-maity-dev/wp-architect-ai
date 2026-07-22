<?php
/**
 * Configuration sanitizer tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\PMorixPTRG\PostType\ConfigurationSanitizer;

/**
 * Tests submitted configuration sanitization.
 */
final class ConfigurationSanitizerTest extends TestCase {

	/**
	 * Sanitizes labels and rewrite slug.
	 *
	 * @return void
	 */
	public function test_sanitizes_labels_and_rewrite_slug(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'singular_label' => '<b>Book</b>',
				'plural_label'   => '<script>Books</script>',
				'rewrite_slug'   => 'Book Reviews & News',
			)
		);

		self::assertSame( 'Book', $configuration->singular_label );
		self::assertSame( 'Books', $configuration->plural_label );
		self::assertSame( 'book-reviews-news', $configuration->rewrite_slug );
	}

	/**
	 * Restricts supports to the allowlist.
	 *
	 * @return void
	 */
	public function test_filters_supports_through_allowlist(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array( 'supports' => array( 'title', 'author', 'arbitrary-php', 'post-formats' ) )
		);

		self::assertSame( array( 'title', 'author', 'post-formats' ), $configuration->supports );
	}

	/**
	 * Converts only the explicit checkbox value to true.
	 *
	 * @return void
	 */
	public function test_converts_boolean_fields(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'public'             => '1',
				'show_ui'            => '0',
				'show_in_rest'       => 'yes',
				'publicly_queryable' => '1',
			)
		);

		self::assertTrue( $configuration->public );
		self::assertTrue( $configuration->publicly_queryable );
		self::assertFalse( $configuration->show_ui );
		self::assertFalse( $configuration->show_in_rest );
	}
}
