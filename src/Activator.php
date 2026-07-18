<?php
/**
 * Plugin activation handling.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI;

/**
 * Handles plugin activation.
 */
final class Activator {

	/**
	 * Verifies that the server meets the plugin requirements.
	 *
	 * @return void
	 */
	public static function activate(): void {
		global $wp_version;

		if ( version_compare( PHP_VERSION, WP_ARCHITECT_AI_MINIMUM_PHP_VERSION, '<' ) ) {
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: Minimum required PHP version. */
						__( 'WP Architect AI requires PHP %s or later.', 'wp-architect-ai' ),
						WP_ARCHITECT_AI_MINIMUM_PHP_VERSION
					)
				),
				esc_html__( 'Plugin activation failed', 'wp-architect-ai' ),
				array( 'back_link' => true )
			);
		}

		if ( version_compare( (string) $wp_version, WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION, '<' ) ) {
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: Minimum required WordPress version. */
						__( 'WP Architect AI requires WordPress %s or later.', 'wp-architect-ai' ),
						WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION
					)
				),
				esc_html__( 'Plugin activation failed', 'wp-architect-ai' ),
				array( 'back_link' => true )
			);
		}
	}
}
