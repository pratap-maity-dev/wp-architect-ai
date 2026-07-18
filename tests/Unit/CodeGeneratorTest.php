<?php
/**
 * Code generator tests.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PratapMaity\WPArchitectAI\PostType\CodeGenerator;
use PratapMaity\WPArchitectAI\PostType\Configuration;

/**
 * Tests deterministic PHP code generation.
 */
final class CodeGeneratorTest extends TestCase {

	/**
	 * Generates the expected registration arguments and safely quotes values.
	 *
	 * @return void
	 */
	public function test_generates_registration_code(): void {
		$configuration = new Configuration(
			'book_review',
			"Book's Review",
			'Book Reviews',
			'A curated review.',
			true,
			false,
			true,
			true,
			true,
			'book-reviews',
			'dashicons-book',
			array( 'title', 'editor', 'thumbnail' )
		);
		$code          = ( new CodeGenerator() )->generate( $configuration );

		self::assertStringStartsWith( '<?php', $code );
		self::assertStringContainsString( "register_post_type( 'book_review', \$args );", $code );
		self::assertStringNotContainsString( '\\tregister_post_type', $code );
		self::assertStringContainsString( "'show_in_rest'  => true", $code );
		self::assertStringContainsString( "'rewrite'       => array( 'slug' => 'book-reviews' )", $code );
		self::assertStringContainsString( "array( 'title', 'editor', 'thumbnail' )", $code );
		self::assertStringContainsString( "'Book\\'s Review'", $code );
	}

	/**
	 * Disables rewriting when no rewrite slug is supplied.
	 *
	 * @return void
	 */
	public function test_generates_false_rewrite_without_slug(): void {
		$configuration = new Configuration( 'book', 'Book', 'Books', '', false, false, true, false, false, '', '', array() );
		$code          = ( new CodeGenerator() )->generate( $configuration );

		self::assertStringContainsString( "'rewrite'       => false", $code );
	}
}
