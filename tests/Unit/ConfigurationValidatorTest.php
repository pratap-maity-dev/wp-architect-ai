<?php
/**
 * Configuration validator tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\PMorixPTRG\PostType\Configuration;
use PratapMaity\PMorixPTRG\PostType\ConfigurationValidator;

/**
 * Tests custom post type validation.
 */
final class ConfigurationValidatorTest extends TestCase {

	/**
	 * Accepts a valid post type configuration.
	 *
	 * @return void
	 */
	public function test_accepts_valid_configuration(): void {
		self::assertSame( array(), ( new ConfigurationValidator() )->validate( $this->configuration( 'book_review' ) ) );
	}

	/**
	 * Requires a post type key.
	 *
	 * @return void
	 */
	public function test_rejects_missing_post_type_key(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( '' ) );

		self::assertContains( 'The post type key is required.', $errors );
	}

	/**
	 * Rejects invalid key characters.
	 *
	 * @return void
	 */
	public function test_rejects_invalid_key_characters(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'Book reviews!' ) );

		self::assertContains( 'The post type key may contain only lowercase letters, numbers, underscores, or hyphens.', $errors );
	}

	/**
	 * Rejects keys longer than the WordPress limit.
	 *
	 * @return void
	 */
	public function test_rejects_key_longer_than_twenty_characters(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'twenty_one_characters' ) );

		self::assertContains( 'The post type key must not exceed 20 characters.', $errors );
	}

	/**
	 * Rejects a non-integer menu position.
	 *
	 * @return void
	 */
	public function test_rejects_invalid_menu_position(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'book', '5.5' ) );

		self::assertContains( 'The menu position must be a whole number.', $errors );
	}

	/**
	 * Creates a valid configuration around supplied values.
	 *
	 * @param string $key Post type key.
	 * @param string $menu_position Menu position.
	 * @return Configuration
	 */
	private function configuration( string $key, string $menu_position = '5' ): Configuration {
		return new Configuration( $key, 'Book', 'Books', '', true, true, true, true, true, false, true, false, 'books', 'dashicons-book', $menu_position, array( 'title' ) );
	}
}
