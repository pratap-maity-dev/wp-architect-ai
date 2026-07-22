<?php
/**
 * Custom post type PHP generation.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\PostType;

defined( 'ABSPATH' ) || exit;

/**
 * Generates a standalone custom post type registration file.
 */
final class CodeGenerator {

	/**
	 * Generates formatted PHP without executing it.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function generate( Configuration $configuration ): string {
		$key_hash      = substr( hash( 'sha256', $configuration->post_type_key ), 0, 8 );
		$function_name = 'pmorix_ptrg_register_' . str_replace( '-', '_', $configuration->post_type_key ) . '_' . $key_hash . '_post_type';
		$supports      = implode( ', ', array_map( array( $this, 'export' ), $configuration->supports ) );
		$rewrite       = '' === $configuration->rewrite_slug
			? 'false'
			: "array( 'slug' => " . $this->export( $configuration->rewrite_slug ) . ' )';
		$menu_position = '' === $configuration->menu_position ? 'null' : (string) (int) $configuration->menu_position;
		$labels        = $this->labels( $configuration );
		$lines         = array(
			'<?php',
			'/**',
			' * Registers the custom post type.',
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
				"\t\t'labels'              => \$labels,",
				"\t\t'description'         => " . $this->export( $configuration->description ) . ',',
				"\t\t'public'              => " . $this->export( $configuration->public ) . ',',
				"\t\t'publicly_queryable'   => " . $this->export( $configuration->publicly_queryable ) . ',',
				"\t\t'show_ui'             => " . $this->export( $configuration->show_ui ) . ',',
				"\t\t'show_in_menu'        => " . $this->export( $configuration->show_in_menu ) . ',',
				"\t\t'show_in_rest'        => " . $this->export( $configuration->show_in_rest ) . ',',
				"\t\t'hierarchical'        => " . $this->export( $configuration->hierarchical ) . ',',
				"\t\t'has_archive'         => " . $this->export( $configuration->has_archive ) . ',',
				"\t\t'exclude_from_search' => " . $this->export( $configuration->exclude_from_search ) . ',',
				"\t\t'rewrite'             => {$rewrite},",
				"\t\t'menu_icon'           => " . $this->export( $configuration->menu_icon ) . ',',
				"\t\t'menu_position'       => {$menu_position},",
				"\t\t'supports'            => array( {$supports} ),",
				"\t);",
				'',
				"\t" . 'register_post_type( ' . $this->export( $configuration->post_type_key ) . ', $args );',
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
		$key = preg_replace( '/[^a-z0-9_-]/', '', strtolower( $configuration->post_type_key ) );

		return 'register-' . substr( (string) $key, 0, 20 ) . '-post-type.php';
	}

	/**
	 * Builds complete post type labels.
	 *
	 * @param Configuration $configuration Configuration values.
	 * @return array<string, string>
	 */
	private function labels( Configuration $configuration ): array {
		$singular = $configuration->singular_label;
		$plural   = $configuration->plural_label;

		return array(
			'name'                  => $plural,
			'singular_name'         => $singular,
			'menu_name'             => $plural,
			'name_admin_bar'        => $singular,
			'add_new'               => 'Add New',
			'add_new_item'          => 'Add New ' . $singular,
			'new_item'              => 'New ' . $singular,
			'edit_item'             => 'Edit ' . $singular,
			'view_item'             => 'View ' . $singular,
			'all_items'             => 'All ' . $plural,
			'search_items'          => 'Search ' . $plural,
			'parent_item_colon'     => 'Parent ' . $singular . ':',
			'not_found'             => 'No ' . strtolower( $plural ) . ' found.',
			'not_found_in_trash'    => 'No ' . strtolower( $plural ) . ' found in Trash.',
			'archives'              => $singular . ' Archives',
			'attributes'            => $singular . ' Attributes',
			'insert_into_item'      => 'Insert into ' . strtolower( $singular ),
			'uploaded_to_this_item' => 'Uploaded to this ' . strtolower( $singular ),
			'featured_image'        => 'Featured image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'filter_items_list'     => 'Filter ' . strtolower( $plural ) . ' list',
			'items_list_navigation' => $plural . ' list navigation',
			'items_list'            => $plural . ' list',
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
