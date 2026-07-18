<?php
/**
 * Generated file response handling.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Streams generated PHP without writing it to disk.
 */
final class GeneratedFileDownload {

	/**
	 * Sends a generated PHP attachment and ends the request.
	 *
	 * @param string $filename Pre-sanitized filename.
	 * @param string $code Generated PHP code.
	 * @return never
	 */
	public function send( string $filename, string $code ): never {
		if ( 1 !== preg_match( '/^[a-z0-9_-]+\.php$/', $filename ) ) {
			wp_die(
				esc_html__( 'The generated filename is invalid.', 'architect-ai-code-generator' ),
				esc_html__( 'Download failed', 'architect-ai-code-generator' ),
				array( 'response' => 500 )
			);
		}

		nocache_headers();
		header( 'Content-Type: application/x-httpd-php; charset=UTF-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'X-Content-Type-Options: nosniff' );
		echo $code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Raw generated PHP is the intended attachment body.
		exit;
	}
}
