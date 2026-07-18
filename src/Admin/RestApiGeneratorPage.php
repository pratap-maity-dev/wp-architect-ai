<?php
/**
 * REST API generator admin page.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Admin;

defined( 'ABSPATH' ) || exit;

use PratapMaity\WPArchitectAI\RestApi\CodeGenerator;
use PratapMaity\WPArchitectAI\RestApi\Configuration;
use PratapMaity\WPArchitectAI\RestApi\ConfigurationSanitizer;
use PratapMaity\WPArchitectAI\RestApi\ConfigurationValidator;

/**
 * Handles the REST API generator interface and download.
 */
final class RestApiGeneratorPage {

	private const CAPABILITY      = 'manage_options';
	private const MENU_SLUG       = 'architect-ai-code-generator-rest-api-generator';
	private const GENERATE_ACTION = 'wp_architect_ai_generate_rest_api';
	private const DOWNLOAD_ACTION = 'wp_architect_ai_download_rest_api';

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

	/** Registers WordPress hooks. @return void */
	public function register_hooks(): void {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_post_' . self::DOWNLOAD_ACTION, array( $this, 'download' ) );
	}

	/** Registers the generator submenu. @return void */
	public function register_menu(): void {
		add_submenu_page(
			'architect-ai-code-generator',
			esc_html__( 'REST API Generator', 'architect-ai-code-generator' ),
			esc_html__( 'REST API Generator', 'architect-ai-code-generator' ),
			self::CAPABILITY,
			self::MENU_SLUG,
			array( $this, 'render' )
		);
	}

	/**
	 * Loads clipboard behavior on this page.
	 *
	 * @param string $hook_suffix Current page hook.
	 * @return void
	 */
	public function enqueue_assets( string $hook_suffix ): void {
		if ( 'architect-ai-code-generator_page_' . self::MENU_SLUG !== $hook_suffix ) {
			return;
		}

		wp_enqueue_script( 'architect-ai-code-generator-generator', plugins_url( 'assets/js/generator.js', WP_ARCHITECT_AI_FILE ), array(), WP_ARCHITECT_AI_VERSION, true );
		wp_localize_script(
			'architect-ai-code-generator-generator',
			'architectAiCodeGenerator',
			array(
				'copied' => __( 'Code copied to the clipboard.', 'architect-ai-code-generator' ),
				'failed' => __( 'Unable to copy automatically. Select the code and copy it manually.', 'architect-ai-code-generator' ),
			)
		);
	}

	/** Renders the generator form and preview. @return void */
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
					$success_message = __( 'REST API endpoint code generated successfully.', 'architect-ai-code-generator' );
				}
			}
		}

		$template = dirname( __DIR__, 2 ) . '/templates/admin/rest-api-generator.php';
		include $template;
	}

	/** Sends validated generated code as an attachment. @return never */
	public function download(): never {
		$this->assert_capability();
		check_admin_referer( self::DOWNLOAD_ACTION );

		$configuration = $this->sanitizer->sanitize( $_POST ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized immediately by the dedicated sanitizer.
		$errors        = $this->validator->validate( $configuration );

		if ( array() !== $errors ) {
			wp_die( esc_html__( 'The download configuration is invalid.', 'architect-ai-code-generator' ), esc_html__( 'Download failed', 'architect-ai-code-generator' ), array( 'response' => 400 ) );
		}

		$this->download->send( $this->generator->filename( $configuration ), $this->generator->generate( $configuration ) );
	}

	/** Checks whether the request uses POST. @return bool */
	private function is_post_request(): bool {
		$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';

		return 'POST' === $request_method;
	}

	/** Enforces administrative access. @return void */
	private function assert_capability(): void {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'architect-ai-code-generator' ), esc_html__( 'Access denied', 'architect-ai-code-generator' ), array( 'response' => 403 ) );
		}
	}

	/** Returns the initial form state. @return Configuration */
	private function empty_configuration(): Configuration {
		return new Configuration(
			'architect-ai-code-generator/v1',
			false,
			'/projects',
			false,
			'GET',
			'posts',
			'post',
			'10',
			'DESC',
			'date',
			false,
			true,
			false,
			false,
			'public',
			'',
			array( 'id', 'title', 'excerpt', 'slug', 'date', 'permalink' ),
			false,
			false,
			false,
			false,
			array(),
			'',
			'0',
			''
		);
	}
}
