<?php
/**
 * PHPUnit bootstrap.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! function_exists( '__' ) ) {
	/**
	 * Returns an untranslated test string.
	 *
	 * @param string $text Source string.
	 * @return string
	 */
	function __( string $text ): string {
		return $text;
	}
}

require_once dirname( __DIR__ ) . '/src/PostType/Configuration.php';
require_once dirname( __DIR__ ) . '/src/PostType/ConfigurationValidator.php';
require_once dirname( __DIR__ ) . '/src/PostType/CodeGenerator.php';
