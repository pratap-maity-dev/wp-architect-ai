<?php
/**
 * Plugin activation handling.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG;

defined( 'ABSPATH' ) || exit;

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

		if ( version_compare( PHP_VERSION, PMORIX_PTRG_MINIMUM_PHP_VERSION, '<' ) ) {
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: Minimum required PHP version. */
						__( 'PMorix Post Type, Taxonomy & REST Generator requires PHP %s or later.', 'pmorix-post-type-taxonomy-rest-generator' ),
						PMORIX_PTRG_MINIMUM_PHP_VERSION
					)
				),
				esc_html__( 'Plugin activation failed', 'pmorix-post-type-taxonomy-rest-generator' ),
				array( 'back_link' => true )
			);
		}

		if ( version_compare( (string) $wp_version, PMORIX_PTRG_MINIMUM_WORDPRESS_VERSION, '<' ) ) {
			wp_die(
				esc_html(
					sprintf(
						/* translators: %s: Minimum required WordPress version. */
						__( 'PMorix Post Type, Taxonomy & REST Generator requires WordPress %s or later.', 'pmorix-post-type-taxonomy-rest-generator' ),
						PMORIX_PTRG_MINIMUM_WORDPRESS_VERSION
					)
				),
				esc_html__( 'Plugin activation failed', 'pmorix-post-type-taxonomy-rest-generator' ),
				array( 'back_link' => true )
			);
		}
	}
}
