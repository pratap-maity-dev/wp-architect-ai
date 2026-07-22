<?php
/**
 * Taxonomy configuration sanitizer tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\PMorixPTRG\Taxonomy\ConfigurationSanitizer;

/**
 * Tests taxonomy request sanitization.
 */
final class TaxonomyConfigurationSanitizerTest extends TestCase {

	/**
	 * Sanitizes labels and rewrite slug.
	 *
	 * @return void
	 */
	public function test_sanitizes_labels_and_rewrite_slug(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'singular_label' => '<b>Genre</b>',
				'plural_label'   => '<script>Genres</script>',
				'rewrite_slug'   => 'Book Genres & Topics',
			)
		);

		self::assertSame( 'Genre', $configuration->singular_label );
		self::assertSame( 'Genres', $configuration->plural_label );
		self::assertSame( 'book-genres-topics', $configuration->rewrite_slug );
	}

	/**
	 * Sanitizes and removes duplicate associated post types.
	 *
	 * @return void
	 */
	public function test_sanitizes_and_deduplicates_post_types(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'post_types'        => array( 'post', 'page', 'post' ),
				'custom_post_types' => 'portfolio, page product',
			)
		);

		self::assertSame( array( 'post', 'page', 'portfolio', 'product' ), $configuration->post_types );
	}

	/**
	 * Preserves sanitized invalid keys for validator feedback.
	 *
	 * @return void
	 */
	public function test_preserves_invalid_post_type_for_validation(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array( 'custom_post_types' => '<b>Bad Type!</b>' )
		);

		self::assertSame( array( 'Bad', 'Type!' ), $configuration->post_types );
	}

	/**
	 * Converts only explicit checkbox values to true.
	 *
	 * @return void
	 */
	public function test_normalizes_boolean_fields(): void {
		$configuration = ( new ConfigurationSanitizer() )->sanitize(
			array(
				'public'       => '1',
				'show_ui'      => '0',
				'show_in_rest' => 'yes',
				'query_var'    => '1',
			)
		);

		self::assertTrue( $configuration->public );
		self::assertFalse( $configuration->show_ui );
		self::assertFalse( $configuration->show_in_rest );
		self::assertTrue( $configuration->query_var );
	}
}
