<?php
/**
 * Admin dashboard page.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Admin;

defined( 'ABSPATH' ) || exit;

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
			esc_html__( 'PMorix Post Type, Taxonomy & REST Generator', 'pmorix-post-type-taxonomy-rest-generator' ),
			esc_html__( 'PMorix Post Type, Taxonomy & REST Generator', 'pmorix-post-type-taxonomy-rest-generator' ),
			self::CAPABILITY,
			'pmorix_ptrg_dashboard',
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
				esc_html__( 'You do not have permission to access this page.', 'pmorix-post-type-taxonomy-rest-generator' ),
				esc_html__( 'Access denied', 'pmorix-post-type-taxonomy-rest-generator' ),
				array( 'response' => 403 )
			);
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'PMorix Post Type, Taxonomy & REST Generator', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h1>
			<p>
				<?php
				echo esc_html__(
					'Use the CPT, Taxonomy, and REST API Generators to create reviewable WordPress code.',
					'pmorix-post-type-taxonomy-rest-generator'
				);
				?>
			</p>
		</div>
		<?php
	}
}
