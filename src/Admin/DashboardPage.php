<?php
/**
 * Admin dashboard page.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Admin;

/**
 * Registers and renders the plugin dashboard.
 */
final class DashboardPage {

	/**
	 * Capability required to access the dashboard.
	 */
	private const CAPABILITY = 'manage_options';

	/**
	 * Registers WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks(): void {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * Registers the top-level admin menu.
	 *
	 * @return void
	 */
	public function register_menu(): void {
		add_menu_page(
			esc_html__( 'WP Architect AI', 'wp-architect-ai' ),
			esc_html__( 'WP Architect AI', 'wp-architect-ai' ),
			self::CAPABILITY,
			'wp-architect-ai',
			array( $this, 'render' ),
			'dashicons-editor-code',
			58
		);
	}

	/**
	 * Renders the dashboard page.
	 *
	 * @return void
	 */
	public function render(): void {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die(
				esc_html__( 'You do not have permission to access this page.', 'wp-architect-ai' ),
				esc_html__( 'Access denied', 'wp-architect-ai' ),
				array( 'response' => 403 )
			);
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'WP Architect AI', 'wp-architect-ai' ); ?></h1>
			<p>
				<?php
				echo esc_html__(
					'Use the CPT and Taxonomy Generators to create reviewable WordPress registration files.',
					'wp-architect-ai'
				);
				?>
			</p>
		</div>
		<?php
	}
}
