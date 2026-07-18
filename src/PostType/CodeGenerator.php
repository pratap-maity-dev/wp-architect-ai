<?php
/**
 * Custom post type PHP generation.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\PostType;

/**
 * Generates a standalone custom post type registration snippet.
 */
final class CodeGenerator {

	/**
	 * Generates formatted PHP without executing it.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function generate( Configuration $configuration ): string {
		$function_name = 'wp_architect_ai_register_' . str_replace( '-', '_', $configuration->post_type_key ) . '_post_type';
		$supports      = implode( ', ', array_map( array( $this, 'export' ), $configuration->supports ) );
		$rewrite       = '' === $configuration->rewrite_slug
			? 'false'
			: "array( 'slug' => " . $this->export( $configuration->rewrite_slug ) . ' )';

		$lines = array(
			'<?php',
			'/**',
			' * Registers the custom post type.',
			' */',
			"function {$function_name}(): void {",
			"\t\$labels = array(",
			"\t\t'name'          => _x( " . $this->export( $configuration->plural_label ) . ", 'Post type general name', 'your-text-domain' ),",
			"\t\t'singular_name' => _x( " . $this->export( $configuration->singular_label ) . ", 'Post type singular name', 'your-text-domain' ),",
			"\t\t'menu_name'     => __( " . $this->export( $configuration->plural_label ) . ", 'your-text-domain' ),",
			"\t\t'add_new_item'  => sprintf( __( 'Add New %s', 'your-text-domain' ), " . $this->export( $configuration->singular_label ) . ' ),',
			"\t\t'edit_item'     => sprintf( __( 'Edit %s', 'your-text-domain' ), " . $this->export( $configuration->singular_label ) . ' ),',
			"\t);",
			'',
			"\t\$args = array(",
			"\t\t'labels'        => \$labels,",
			"\t\t'description'   => " . $this->export( $configuration->description ) . ',',
			"\t\t'public'        => " . $this->export( $configuration->public ) . ',',
			"\t\t'hierarchical'  => " . $this->export( $configuration->hierarchical ) . ',',
			"\t\t'show_ui'       => " . $this->export( $configuration->show_ui ) . ',',
			"\t\t'show_in_rest'  => " . $this->export( $configuration->show_in_rest ) . ',',
			"\t\t'has_archive'   => " . $this->export( $configuration->has_archive ) . ',',
			"\t\t'rewrite'       => {$rewrite},",
			"\t\t'menu_icon'     => " . $this->export( $configuration->menu_icon ) . ',',
			"\t\t'supports'      => array( {$supports} ),",
			"\t);",
			'',
			"\t" . 'register_post_type( ' . $this->export( $configuration->post_type_key ) . ', $args );',
			'}',
			"add_action( 'init', '{$function_name}' );",
			'',
		);

		return implode( "\n", $lines );
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
