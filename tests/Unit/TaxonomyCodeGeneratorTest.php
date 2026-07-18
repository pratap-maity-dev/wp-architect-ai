<?php
/**
 * Taxonomy code generator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\Taxonomy\CodeGenerator;
use PratapMaity\WPArchitectAI\Taxonomy\Configuration;

/**
 * Tests deterministic taxonomy PHP generation.
 */
final class TaxonomyCodeGeneratorTest extends TestCase {

	/**
	 * Generates a complete taxonomy registration file.
	 *
	 * @return void
	 */
	public function test_generates_register_taxonomy_output(): void {
		$code = ( new CodeGenerator() )->generate( $this->configuration() );

		self::assertStringStartsWith( '<?php', $code );
		self::assertStringContainsString( "if ( ! defined( 'ABSPATH' ) )", $code );
		self::assertStringContainsString( "add_action( 'init', 'wp_architect_ai_register_book_genre_", $code );
		self::assertStringContainsString( "register_taxonomy( 'book_genre', array( 'post', 'portfolio' ), \$args );", $code );
		self::assertStringContainsString( "'show_in_rest'       => true", $code );
		self::assertStringContainsString( "'hierarchical'       => true", $code );
		self::assertStringContainsString( "'query_var'          => true", $code );
		self::assertStringContainsString( "array( 'slug' => 'book-genres', 'hierarchical' => true )", $code );
		self::assertStringContainsString( "'wp-architect-ai'", $code );
	}

	/**
	 * Never emits eval calls.
	 *
	 * @return void
	 */
	public function test_generated_code_contains_no_eval(): void {
		self::assertDoesNotMatchRegularExpression( '/\beval\s*\(/i', ( new CodeGenerator() )->generate( $this->configuration() ) );
	}

	/**
	 * Produces a safe filename from the taxonomy key.
	 *
	 * @return void
	 */
	public function test_generates_safe_filename(): void {
		self::assertSame( 'register-book_genre-taxonomy.php', ( new CodeGenerator() )->filename( $this->configuration() ) );
	}

	/**
	 * Creates a complete valid configuration.
	 *
	 * @return Configuration
	 */
	private function configuration(): Configuration {
		return new Configuration( 'book_genre', 'Genre', 'Genres', array( 'post', 'portfolio' ), 'portfolio', 'Book genres.', true, true, true, true, true, true, true, true, 'book-genres', true, true );
	}
}
