<?php
/**
 * Configuration validator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\PostType\Configuration;
use PratapMaity\WPArchitectAI\PostType\ConfigurationValidator;

/**
 * Tests custom post type validation.
 */
final class ConfigurationValidatorTest extends TestCase {

	/**
	 * Provides invalid post type keys.
	 *
	 * @return array<string, array<string>>
	 */
	public static function invalid_key_provider(): array {
		return array(
			'empty'     => array( '' ),
			'too long'  => array( 'twenty_one_characters' ),
			'uppercase' => array( 'Book' ),
			'spaces'    => array( 'book reviews' ),
			'reserved'  => array( 'post' ),
		);
	}

	/**
	 * Rejects invalid WordPress post type keys.
	 *
	 * @param string $key Invalid key.
	 * @return void
	 */
	#[DataProvider( 'invalid_key_provider' )]
	public function test_rejects_invalid_post_type_keys( string $key ): void {
		$validator = new ConfigurationValidator();

		self::assertNotSame( array(), $validator->validate( $this->configuration( $key ) ) );
	}

	/**
	 * Accepts a valid key.
	 *
	 * @return void
	 */
	public function test_accepts_valid_post_type_key(): void {
		$validator = new ConfigurationValidator();

		self::assertSame( array(), $validator->validate( $this->configuration( 'book_review' ) ) );
	}

	/**
	 * Creates a valid configuration around a supplied key.
	 *
	 * @param string $key Post type key.
	 * @return Configuration
	 */
	private function configuration( string $key ): Configuration {
		return new Configuration( $key, 'Book', 'Books', '', true, false, true, true, true, 'books', 'dashicons-book', array( 'title' ) );
	}
}
