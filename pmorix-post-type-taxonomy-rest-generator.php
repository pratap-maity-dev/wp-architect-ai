<?php
/**
 * Plugin Name:       PMorix Post Type, Taxonomy & REST Generator
 * Plugin URI:        https://github.com/pratap-maity-dev/wp-architect-ai
 * Description:       Generate reviewable WordPress code for post types, taxonomies, and REST API endpoints without executing it.
 * Version:           0.5.0
 * Requires at least: 6.5
 * Requires PHP:      8.1
 * Author:            Pratap Maity
 * Author URI:        https://github.com/pratap-maity-dev
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pmorix-post-type-taxonomy-rest-generator
 *
 * @package PratapMaity\PMorixPTRG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PMORIX_PTRG_VERSION', '0.5.0' );
define( 'PMORIX_PTRG_FILE', __FILE__ );
define( 'PMORIX_PTRG_MINIMUM_PHP_VERSION', '8.1' );
define( 'PMORIX_PTRG_MINIMUM_WORDPRESS_VERSION', '6.5' );

/**
 * Displays an admin notice when the plugin cannot start.
 *
 * @param string $message Notice message.
 * @return void
 */
function pmorix_ptrg_render_requirement_notice( string $message ): void {
	?>
	<div class="notice notice-error">
		<p><?php echo esc_html( $message ); ?></p>
	</div>
	<?php
}

if ( version_compare( PHP_VERSION, PMORIX_PTRG_MINIMUM_PHP_VERSION, '<' ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			pmorix_ptrg_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required PHP version. */
					__( 'PMorix Post Type, Taxonomy & REST Generator requires PHP %s or later.', 'pmorix-post-type-taxonomy-rest-generator' ),
					PMORIX_PTRG_MINIMUM_PHP_VERSION
				)
			);
		}
	);
	return;
}

global $wp_version;

if ( version_compare( (string) $wp_version, PMORIX_PTRG_MINIMUM_WORDPRESS_VERSION, '<' ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			pmorix_ptrg_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required WordPress version. */
					__( 'PMorix Post Type, Taxonomy & REST Generator requires WordPress %s or later.', 'pmorix-post-type-taxonomy-rest-generator' ),
					PMORIX_PTRG_MINIMUM_WORDPRESS_VERSION
				)
			);
		}
	);
	return;
}

$pmorix_ptrg_autoloader = __DIR__ . '/vendor/autoload.php';

if ( ! is_readable( $pmorix_ptrg_autoloader ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			pmorix_ptrg_render_requirement_notice(
				__( 'PMorix Post Type, Taxonomy & REST Generator could not start because its Composer dependencies are missing.', 'pmorix-post-type-taxonomy-rest-generator' )
			);
		}
	);
	return;
}

require_once $pmorix_ptrg_autoloader;

register_activation_hook( __FILE__, array( PratapMaity\PMorixPTRG\Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( PratapMaity\PMorixPTRG\Deactivator::class, 'deactivate' ) );

PratapMaity\PMorixPTRG\Plugin::create()->run();
