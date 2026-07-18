<?php
/**
 * Main plugin orchestration.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI;

use PratapMaity\WPArchitectAI\Admin\DashboardPage;
use PratapMaity\WPArchitectAI\Admin\PostTypeGeneratorPage;
use PratapMaity\WPArchitectAI\PostType\CodeGenerator;
use PratapMaity\WPArchitectAI\PostType\ConfigurationSanitizer;
use PratapMaity\WPArchitectAI\PostType\ConfigurationValidator;

/**
 * Registers the plugin's runtime hooks.
 */
final class Plugin {

	/**
	 * Admin dashboard page.
	 *
	 * @var DashboardPage
	 */
	private DashboardPage $dashboard_page;

	/**
	 * Custom post type generator page.
	 *
	 * @var PostTypeGeneratorPage
	 */
	private PostTypeGeneratorPage $post_type_generator_page;

	/**
	 * Creates the plugin with its dependencies.
	 *
	 * @return self
	 */
	public static function create(): self {
		$validator = new ConfigurationValidator();

		return new self(
			new DashboardPage(),
			new PostTypeGeneratorPage(
				new ConfigurationSanitizer(),
				$validator,
				new CodeGenerator()
			)
		);
	}

	/**
	 * Constructor.
	 *
	 * @param DashboardPage         $dashboard_page           Admin dashboard page.
	 * @param PostTypeGeneratorPage $post_type_generator_page Post type generator page.
	 */
	public function __construct( DashboardPage $dashboard_page, PostTypeGeneratorPage $post_type_generator_page ) {
		$this->dashboard_page           = $dashboard_page;
		$this->post_type_generator_page = $post_type_generator_page;
	}

	/**
	 * Registers plugin hooks.
	 *
	 * @return void
	 */
	public function run(): void {
		if ( is_admin() ) {
			$this->dashboard_page->register_hooks();
			$this->post_type_generator_page->register_hooks();
		}
	}
}
