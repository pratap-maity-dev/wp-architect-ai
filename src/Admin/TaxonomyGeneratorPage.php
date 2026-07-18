<?php
/**
 * Taxonomy generator admin page.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Admin;

use PratapMaity\WPArchitectAI\Taxonomy\CodeGenerator;
use PratapMaity\WPArchitectAI\Taxonomy\Configuration;
use PratapMaity\WPArchitectAI\Taxonomy\ConfigurationSanitizer;
use PratapMaity\WPArchitectAI\Taxonomy\ConfigurationValidator;

/**
 * Handles the taxonomy generator interface and download.
 */
final class TaxonomyGeneratorPage {

	private const CAPABILITY      = 'manage_options';
	private const MENU_SLUG       = 'wp-architect-ai-taxonomy-generator';
	private const GENERATE_ACTION = 'wp_architect_ai_generate_taxonomy';
	private const DOWNLOAD_ACTION = 'wp_architect_ai_download_taxonomy';

	/**
	 * Constructor.
	 *
	 * @param ConfigurationSanitizer $sanitizer Request sanitizer.
	 * @param ConfigurationValidator $validator Configuration validator.
	 * @param CodeGenerator          $generator PHP code generator.
	 * @param GeneratedFileDownload  $download Generated file response.
	 */
	public function __construct(
		private ConfigurationSanitizer $sanitizer,
		private ConfigurationValidator $validator,
		private CodeGenerator $generator,
		private GeneratedFileDownload $download
	) {
	}

	/**
	 * Registers WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks(): void {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_post_' . self::DOWNLOAD_ACTION, array( $this, 'download' ) );
	}

	/**
	 * Registers the generator submenu.
	 *
	 * @return void
	 */
	public function register_menu(): void {
		add_submenu_page(
			'wp-architect-ai',
			esc_html__( 'Taxonomy Generator', 'wp-architect-ai' ),
			esc_html__( 'Taxonomy Generator', 'wp-architect-ai' ),
			self::CAPABILITY,
			self::MENU_SLUG,
			array( $this, 'render' )
		);
	}

	/**
	 * Loads clipboard behavior only on this page.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 * @return void
	 */
	public function enqueue_assets( string $hook_suffix ): void {
		if ( 'wp-architect-ai_page_' . self::MENU_SLUG !== $hook_suffix ) {
			return;
		}

		wp_enqueue_script(
			'wp-architect-ai-generator',
			plugins_url( 'assets/js/generator.js', WP_ARCHITECT_AI_FILE ),
			array(),
			WP_ARCHITECT_AI_VERSION,
			true
		);
		wp_localize_script(
			'wp-architect-ai-generator',
			'wpArchitectAiGenerator',
			array(
				'copied' => __( 'Code copied to the clipboard.', 'wp-architect-ai' ),
				'failed' => __( 'Unable to copy automatically. Select the code and copy it manually.', 'wp-architect-ai' ),
			)
		);
	}

	/**
	 * Renders the generator form and preview.
	 *
	 * @return void
	 */
	public function render(): void {
		$this->assert_capability();

		$configuration   = $this->empty_configuration();
		$errors          = array();
		$generated_code  = '';
		$success_message = '';

		if ( $this->is_post_request() ) {
			check_admin_referer( self::GENERATE_ACTION );
			$request_action = isset( $_POST['wp_architect_ai_action'] ) && is_scalar( $_POST['wp_architect_ai_action'] )
				? sanitize_key( wp_unslash( $_POST['wp_architect_ai_action'] ) )
				: '';

			if ( self::GENERATE_ACTION === $request_action ) {
				$configuration = $this->sanitizer->sanitize( $_POST ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized immediately by the dedicated sanitizer.
				$errors        = $this->validator->validate( $configuration );

				if ( array() === $errors ) {
					$generated_code  = $this->generator->generate( $configuration );
					$success_message = __( 'Taxonomy code generated successfully.', 'wp-architect-ai' );
				}
			}
		}

		$template = dirname( __DIR__, 2 ) . '/templates/admin/taxonomy-generator.php';
		include $template;
	}

	/**
	 * Sends validated generated code as a PHP attachment.
	 *
	 * @return never
	 */
	public function download(): never {
		$this->assert_capability();
		check_admin_referer( self::DOWNLOAD_ACTION );

		$configuration = $this->sanitizer->sanitize( $_POST ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized immediately by the dedicated sanitizer.
		$errors        = $this->validator->validate( $configuration );

		if ( array() !== $errors ) {
			wp_die(
				esc_html__( 'The download configuration is invalid.', 'wp-architect-ai' ),
				esc_html__( 'Download failed', 'wp-architect-ai' ),
				array( 'response' => 400 )
			);
		}

		$this->download->send( $this->generator->filename( $configuration ), $this->generator->generate( $configuration ) );
	}

	/**
	 * Checks whether the current request uses POST.
	 *
	 * @return bool
	 */
	private function is_post_request(): bool {
		$request_method = isset( $_SERVER['REQUEST_METHOD'] )
			? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) )
			: '';

		return 'POST' === $request_method;
	}

	/**
	 * Enforces the required administrative capability.
	 *
	 * @return void
	 */
	private function assert_capability(): void {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die(
				esc_html__( 'You do not have permission to access this page.', 'wp-architect-ai' ),
				esc_html__( 'Access denied', 'wp-architect-ai' ),
				array( 'response' => 403 )
			);
		}
	}

	/**
	 * Creates the initial form state.
	 *
	 * @return Configuration
	 */
	private function empty_configuration(): Configuration {
		return new Configuration( '', '', '', array( 'post' ), '', '', true, true, true, false, true, false, true, true, '', false, true );
	}
}
