<?php
/**
 * Taxonomy configuration validator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\Taxonomy\Configuration;
use PratapMaity\WPArchitectAI\Taxonomy\ConfigurationValidator;

/**
 * Tests taxonomy validation.
 */
final class TaxonomyConfigurationValidatorTest extends TestCase {

	/**
	 * Accepts a valid taxonomy configuration.
	 *
	 * @return void
	 */
	public function test_accepts_valid_configuration(): void {
		self::assertSame( array(), ( new ConfigurationValidator() )->validate( $this->configuration( 'book_genre' ) ) );
	}

	/**
	 * Requires a taxonomy key.
	 *
	 * @return void
	 */
	public function test_rejects_missing_taxonomy_key(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( '' ) );

		self::assertContains( 'The taxonomy key is required.', $errors );
	}

	/**
	 * Rejects invalid taxonomy key characters.
	 *
	 * @return void
	 */
	public function test_rejects_invalid_key_characters(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'Book genres!' ) );

		self::assertContains( 'The taxonomy key may contain only lowercase letters, numbers, underscores, or hyphens.', $errors );
	}

	/**
	 * Rejects taxonomy keys longer than 32 characters.
	 *
	 * @return void
	 */
	public function test_rejects_key_longer_than_thirty_two_characters(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'taxonomy_key_longer_than_32_chars' ) );

		self::assertContains( 'The taxonomy key must not exceed 32 characters.', $errors );
	}

	/**
	 * Requires an associated post type.
	 *
	 * @return void
	 */
	public function test_rejects_missing_associated_post_types(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'genre', array() ) );

		self::assertContains( 'At least one associated post type is required.', $errors );
	}

	/**
	 * Rejects invalid associated post type keys.
	 *
	 * @return void
	 */
	public function test_rejects_invalid_associated_post_type(): void {
		$errors = ( new ConfigurationValidator() )->validate( $this->configuration( 'genre', array( 'post', 'Bad Type!' ) ) );

		self::assertContains( 'Associated post type keys must contain no more than 20 lowercase letters, numbers, underscores, or hyphens.', $errors );
	}

	/**
	 * Creates a valid configuration around supplied values.
	 *
	 * @param string        $key Taxonomy key.
	 * @param array<string> $post_types Associated post types.
	 * @return Configuration
	 */
	private function configuration( string $key, array $post_types = array( 'post' ) ): Configuration {
		return new Configuration( $key, 'Genre', 'Genres', $post_types, '', '', true, true, true, true, true, true, true, true, 'genres', true, true );
	}
}
