<?php
/**
 * Main plugin orchestration.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI;

use PratapMaity\WPArchitectAI\Admin\DashboardPage;
use PratapMaity\WPArchitectAI\Admin\GeneratedFileDownload;
use PratapMaity\WPArchitectAI\Admin\PostTypeGeneratorPage;
use PratapMaity\WPArchitectAI\Admin\TaxonomyGeneratorPage;
use PratapMaity\WPArchitectAI\PostType\CodeGenerator as PostTypeCodeGenerator;
use PratapMaity\WPArchitectAI\PostType\ConfigurationSanitizer as PostTypeConfigurationSanitizer;
use PratapMaity\WPArchitectAI\PostType\ConfigurationValidator as PostTypeConfigurationValidator;
use PratapMaity\WPArchitectAI\Taxonomy\CodeGenerator as TaxonomyCodeGenerator;
use PratapMaity\WPArchitectAI\Taxonomy\ConfigurationSanitizer as TaxonomyConfigurationSanitizer;
use PratapMaity\WPArchitectAI\Taxonomy\ConfigurationValidator as TaxonomyConfigurationValidator;

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
	 * Taxonomy generator page.
	 *
	 * @var TaxonomyGeneratorPage
	 */
	private TaxonomyGeneratorPage $taxonomy_generator_page;

	/**
	 * Creates the plugin with its dependencies.
	 *
	 * @return self
	 */
	public static function create(): self {
		$download = new GeneratedFileDownload();

		return new self(
			new DashboardPage(),
			new PostTypeGeneratorPage(
				new PostTypeConfigurationSanitizer(),
				new PostTypeConfigurationValidator(),
				new PostTypeCodeGenerator(),
				$download
			),
			new TaxonomyGeneratorPage(
				new TaxonomyConfigurationSanitizer(),
				new TaxonomyConfigurationValidator(),
				new TaxonomyCodeGenerator(),
				$download
			)
		);
	}

	/**
	 * Constructor.
	 *
	 * @param DashboardPage         $dashboard_page           Admin dashboard page.
	 * @param PostTypeGeneratorPage $post_type_generator_page Post type generator page.
	 * @param TaxonomyGeneratorPage $taxonomy_generator_page  Taxonomy generator page.
	 */
	public function __construct( DashboardPage $dashboard_page, PostTypeGeneratorPage $post_type_generator_page, TaxonomyGeneratorPage $taxonomy_generator_page ) {
		$this->dashboard_page           = $dashboard_page;
		$this->post_type_generator_page = $post_type_generator_page;
		$this->taxonomy_generator_page  = $taxonomy_generator_page;
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
			$this->taxonomy_generator_page->register_hooks();
		}
	}
}
