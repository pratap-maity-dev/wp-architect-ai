<?php
/**
 * Taxonomy PHP generation.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\Taxonomy;

defined( 'ABSPATH' ) || exit;

/**
 * Generates a standalone taxonomy registration file.
 */
final class CodeGenerator {

	/**
	 * Generates formatted PHP without executing it.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function generate( Configuration $configuration ): string {
		$key_hash      = substr( hash( 'sha256', $configuration->taxonomy_key ), 0, 8 );
		$function_name = 'wp_architect_ai_register_' . str_replace( '-', '_', $configuration->taxonomy_key ) . '_' . $key_hash . '_taxonomy';
		$post_types    = implode( ', ', array_map( array( $this, 'export' ), $configuration->post_types ) );
		$rewrite       = '' === $configuration->rewrite_slug
			? 'false'
			: "array( 'slug' => " . $this->export( $configuration->rewrite_slug ) . ", 'hierarchical' => " . $this->export( $configuration->rewrite_hierarchical ) . ' )';
		$labels        = $this->labels( $configuration );
		$lines         = array(
			'<?php',
			'/**',
			' * Registers the custom taxonomy.',
			' */',
			'',
			"if ( ! defined( 'ABSPATH' ) ) {",
			"\texit;",
			'}',
			'',
			"function {$function_name}(): void {",
			"\t\$labels = array(",
		);

		foreach ( $labels as $key => $label ) {
			$lines[] = "\t\t" . $this->export( $key ) . ' => __( ' . $this->export( $label ) . ", 'pmorix-post-type-taxonomy-rest-generator' ),";
		}

		$lines = array_merge(
			$lines,
			array(
				"\t);",
				'',
				"\t\$args = array(",
				"\t\t'labels'             => \$labels,",
				"\t\t'description'        => " . $this->export( $configuration->description ) . ',',
				"\t\t'public'             => " . $this->export( $configuration->public ) . ',',
				"\t\t'publicly_queryable'  => " . $this->export( $configuration->publicly_queryable ) . ',',
				"\t\t'show_ui'            => " . $this->export( $configuration->show_ui ) . ',',
				"\t\t'show_admin_column'  => " . $this->export( $configuration->show_admin_column ) . ',',
				"\t\t'show_in_rest'       => " . $this->export( $configuration->show_in_rest ) . ',',
				"\t\t'hierarchical'       => " . $this->export( $configuration->hierarchical ) . ',',
				"\t\t'show_tagcloud'      => " . $this->export( $configuration->show_tagcloud ) . ',',
				"\t\t'show_in_quick_edit' => " . $this->export( $configuration->show_in_quick_edit ) . ',',
				"\t\t'rewrite'            => {$rewrite},",
				"\t\t'query_var'          => " . $this->export( $configuration->query_var ) . ',',
				"\t);",
				'',
				"\t" . 'register_taxonomy( ' . $this->export( $configuration->taxonomy_key ) . ", array( {$post_types} ), \$args );",
				'}',
				"add_action( 'init', '{$function_name}' );",
				'',
			)
		);

		return implode( "\n", $lines );
	}

	/**
	 * Returns a safe generated download filename.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function filename( Configuration $configuration ): string {
		$key = preg_replace( '/[^a-z0-9_-]/', '', strtolower( $configuration->taxonomy_key ) );

		return 'register-' . substr( (string) $key, 0, 32 ) . '-taxonomy.php';
	}

	/**
	 * Builds complete taxonomy labels.
	 *
	 * @param Configuration $configuration Configuration values.
	 * @return array<string, string>
	 */
	private function labels( Configuration $configuration ): array {
		$singular = $configuration->singular_label;
		$plural   = $configuration->plural_label;

		return array(
			'name'                       => $plural,
			'singular_name'              => $singular,
			'search_items'               => 'Search ' . $plural,
			'popular_items'              => 'Popular ' . $plural,
			'all_items'                  => 'All ' . $plural,
			'parent_item'                => 'Parent ' . $singular,
			'parent_item_colon'          => 'Parent ' . $singular . ':',
			'edit_item'                  => 'Edit ' . $singular,
			'view_item'                  => 'View ' . $singular,
			'update_item'                => 'Update ' . $singular,
			'add_new_item'               => 'Add New ' . $singular,
			'new_item_name'              => 'New ' . $singular . ' Name',
			'separate_items_with_commas' => 'Separate ' . strtolower( $plural ) . ' with commas',
			'add_or_remove_items'        => 'Add or remove ' . strtolower( $plural ),
			'choose_from_most_used'      => 'Choose from the most used ' . strtolower( $plural ),
			'not_found'                  => 'No ' . strtolower( $plural ) . ' found.',
			'no_terms'                   => 'No ' . strtolower( $plural ),
			'items_list_navigation'      => $plural . ' list navigation',
			'items_list'                 => $plural . ' list',
			'back_to_items'              => 'Back to ' . strtolower( $plural ),
			'name_field_description'     => 'The name is how it appears on your site.',
			'parent_field_description'   => 'Assign a parent term to create a hierarchy.',
			'slug_field_description'     => 'The slug is the URL-friendly version of the name.',
			'desc_field_description'     => 'The description is not prominent by default.',
		);
	}

	/**
	 * Exports a scalar as valid PHP.
	 *
	 * @param string|bool $value Value to export.
	 * @return string
	 */
	private function export( string|bool $value ): string {
		if ( is_bool( $value ) ) {
			return $value ? 'true' : 'false';
		}

		return "'" . str_replace( array( '\\', "'" ), array( '\\\\', "\\'" ), $value ) . "'";
	}
}
