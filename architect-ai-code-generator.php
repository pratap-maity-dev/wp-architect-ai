<?php
/**
 * Plugin Name:       Architect AI Code Generator
 * Plugin URI:        https://github.com/pratap-maity-dev/wp-architect-ai
 * Description:       Generate reviewable WordPress code for post types, taxonomies, and REST API endpoints without executing it.
 * Version:           0.5.0
 * Requires at least: 6.5
 * Requires PHP:      8.1
 * Author:            Pratap Maity
 * Author URI:        https://github.com/pratap-maity-dev
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       architect-ai-code-generator
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WP_ARCHITECT_AI_VERSION', '0.5.0' );
define( 'WP_ARCHITECT_AI_FILE', __FILE__ );
define( 'WP_ARCHITECT_AI_MINIMUM_PHP_VERSION', '8.1' );
define( 'WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION', '6.5' );

/**
 * Displays an admin notice when the plugin cannot start.
 *
 * @param string $message Notice message.
 * @return void
 */
function architect_ai_code_generator_render_requirement_notice( string $message ): void {
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
			architect_ai_code_generator_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required PHP version. */
					__( 'Architect AI Code Generator requires PHP %s or later.', 'architect-ai-code-generator' ),
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
			architect_ai_code_generator_render_requirement_notice(
				sprintf(
					/* translators: %s: Minimum required WordPress version. */
					__( 'Architect AI Code Generator requires WordPress %s or later.', 'architect-ai-code-generator' ),
					WP_ARCHITECT_AI_MINIMUM_WORDPRESS_VERSION
				)
			);
		}
	);
	return;
}

$architect_ai_code_generator_autoloader = __DIR__ . '/vendor/autoload.php';

if ( ! is_readable( $architect_ai_code_generator_autoloader ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			architect_ai_code_generator_render_requirement_notice(
				__( 'Architect AI Code Generator could not start because its Composer dependencies are missing.', 'architect-ai-code-generator' )
			);
		}
	);
	return;
}

require_once $architect_ai_code_generator_autoloader;

register_activation_hook( __FILE__, array( PratapMaity\WPArchitectAI\Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( PratapMaity\WPArchitectAI\Deactivator::class, 'deactivate' ) );

PratapMaity\WPArchitectAI\Plugin::create()->run();
