<?php
/**
 * Code generator tests.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\PMorixPTRG\PostType\CodeGenerator;
use PratapMaity\PMorixPTRG\PostType\Configuration;

/**
 * Tests deterministic PHP code generation.
 */
final class CodeGeneratorTest extends TestCase {

	/**
	 * Generates a complete registration file.
	 *
	 * @return void
	 */
	public function test_generates_register_post_type_output(): void {
		$code = ( new CodeGenerator() )->generate( $this->configuration() );

		self::assertStringStartsWith( '<?php', $code );
		self::assertStringContainsString( "if ( ! defined( 'ABSPATH' ) )", $code );
		self::assertStringContainsString( "add_action( 'init', 'pmorix_ptrg_register_book_review_", $code );
		self::assertStringContainsString( "register_post_type( 'book_review', \$args );", $code );
		self::assertStringContainsString( "'show_in_rest'        => true", $code );
		self::assertStringContainsString( "'publicly_queryable'   => true", $code );
		self::assertStringContainsString( "'rewrite'             => array( 'slug' => 'book-reviews' )", $code );
		self::assertStringContainsString( "array( 'title', 'editor', 'author', 'post-formats' )", $code );
		self::assertStringContainsString( "'pmorix-post-type-taxonomy-rest-generator'", $code );
	}

	/**
	 * Never emits eval calls.
	 *
	 * @return void
	 */
	public function test_generated_code_contains_no_eval(): void {
		$code = ( new CodeGenerator() )->generate( $this->configuration() );

		self::assertDoesNotMatchRegularExpression( '/\beval\s*\(/i', $code );
	}

	/**
	 * Produces a safe filename from the validated post type key.
	 *
	 * @return void
	 */
	public function test_generates_safe_filename(): void {
		$generator = new CodeGenerator();

		self::assertSame( 'register-book_review-post-type.php', $generator->filename( $this->configuration() ) );
	}

	/**
	 * Keeps callbacks unique for keys that normalize to the same PHP identifier.
	 *
	 * @return void
	 */
	public function test_generates_unique_callbacks_for_hyphen_and_underscore_keys(): void {
		$generator            = new CodeGenerator();
		$underscore_code      = $generator->generate( $this->configuration() );
		$hyphen_configuration = new Configuration( 'book-review', 'Book', 'Books', '', true, true, true, true, true, false, true, false, '', '', '', array( 'title' ) );
		$hyphen_code          = $generator->generate( $hyphen_configuration );
		$callback_pattern     = "/add_action\\( 'init', '([^']+)' \\);/";

		self::assertSame( 1, preg_match( $callback_pattern, $underscore_code, $underscore_match ) );
		self::assertSame( 1, preg_match( $callback_pattern, $hyphen_code, $hyphen_match ) );
		self::assertNotSame( $underscore_match[1], $hyphen_match[1] );
	}

	/**
	 * Creates a complete valid configuration.
	 *
	 * @return Configuration
	 */
	private function configuration(): Configuration {
		return new Configuration(
			'book_review',
			"Book's Review",
			'Book Reviews',
			'A curated review.',
			true,
			true,
			true,
			true,
			true,
			false,
			true,
			false,
			'book-reviews',
			'dashicons-book',
			'5',
			array( 'title', 'editor', 'author', 'post-formats' )
		);
	}
}
