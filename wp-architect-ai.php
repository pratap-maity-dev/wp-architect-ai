<?php
/**
 * Plugin Name:       WP Architect AI
 * Plugin URI:        https://wordpress.org/plugins/wp-architect-ai/
 * Description:       A foundation for generating secure, standards-compliant WordPress code from structured configuration.
 * Version:           0.1.0
 * Requires at least: 6.5
 * Requires PHP:      8.1
 * Author:            Pratap Maity
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-architect-ai
 * Domain Path:       /languages
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WP_ARCHITECT_AI_VERSION', '0.1.0' );
define( 'WP_ARCHITECT_AI_FILE', __FILE__ );
define( 'WP_ARCHITECT_AI_MINIMUM_PHP_VERSION', '8.1' );
define( 'WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION', '6.5' );

/**
 * Displays an admin notice when the plugin cannot start.
 *
 * @param string $message Notice message.
 * @return void
 */
function wp_architect_ai_render_requirement_notice( string $message ): void {
	?>
	<div class="notice notice-error">
		<p><?php echo esc_html( $message ); ?></p>
	</div>
	<?php
}

if ( version_compare( PHP_VERSION, WP_ARCHITECT_AI_MINIMUM_PHP_VERSION, '<' ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			wp_architect_ai_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required PHP version. */
					__( 'WP Architect AI requires PHP %s or later.', 'wp-architect-ai' ),
					WP_ARCHITECT_AI_MINIMUM_PHP_VERSION
				)
			);
		}
	);
	return;
}

global $wp_version;

if ( version_compare( (string) $wp_version, WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION, '<' ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			wp_architect_ai_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required WordPress version. */
					__( 'WP Architect AI requires WordPress %s or later.', 'wp-architect-ai' ),
					WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION
				)
			);
		}
	);
	return;
}

$wp_architect_ai_autoloader = __DIR__ . '/vendor/autoload.php';

if ( ! is_readable( $wp_architect_ai_autoloader ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			wp_architect_ai_render_requirement_notice(
				__( 'WP Architect AI could not start because its Composer dependencies are missing.', 'wp-architect-ai' )
			);
		}
	);
	return;
}

require_once $wp_architect_ai_autoloader;

register_activation_hook( __FILE__, array( PratapMaity\WPArchitectAI\Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( PratapMaity\WPArchitectAI\Deactivator::class, 'deactivate' ) );

PratapMaity\WPArchitectAI\Plugin::create()->run();
