<?php
/**
 * REST API endpoint PHP generation.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\RestApi;

defined( 'ABSPATH' ) || exit;

/**
 * Generates a standalone object-oriented REST endpoint file.
 */
final class CodeGenerator {

	/**
	 * Generates formatted PHP without executing it.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function generate( Configuration $configuration ): string {
		$class_name = $this->class_name( $configuration );
		$lines      = $this->header( $configuration, $class_name );
		$lines      = array_merge( $lines, $this->register_methods( $configuration ) );
		$lines      = array_merge( $lines, $this->permission_method( $configuration ) );
		$lines      = array_merge( $lines, $this->parameter_methods( $configuration ) );
		$lines      = array_merge( $lines, $this->request_methods( $configuration ) );
		$lines      = array_merge( $lines, $this->prepare_item_method( $configuration ) );
		$lines[]    = '}';
		$lines[]    = '';
		$lines[]    = "( new {$class_name}() )->register();";
		$lines[]    = '';
		$lines      = str_replace( '\\t', "\t", $lines );

		return implode( "\n", $lines );
	}

	/**
	 * Returns a safe generated filename.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function filename( Configuration $configuration ): string {
		$route = preg_replace( '/[^a-z0-9_-]/', '-', strtolower( trim( $configuration->route, '/' ) ) );
		$route = trim( preg_replace( '/-+/', '-', (string) $route ), '-' );

		return ( '' === $route ? 'custom' : substr( $route, 0, 48 ) ) . '-rest-endpoint.php';
	}

	/**
	 * Returns the collision-resistant generated class name.
	 *
	 * @param Configuration $configuration Validated configuration.
	 * @return string
	 */
	public function class_name( Configuration $configuration ): string {
		$base = preg_replace( '/[^A-Za-z0-9]+/', '_', $configuration->api_namespace . '_' . trim( $configuration->route, '/' ) );
		$base = trim( (string) $base, '_' );
		$base = '' !== $base && ctype_digit( $base[0] ) ? 'Endpoint_' . $base : $base;
		$hash = substr( hash( 'sha256', $configuration->api_namespace . '|' . $configuration->route ), 0, 8 );

		return ( '' === $base ? 'Custom' : $base ) . '_' . $hash . '_REST_Controller';
	}

	/**
	 * Builds the generated file header.
	 *
	 * @param Configuration $configuration Configuration.
	 * @param string        $class_name Generated class name.
	 * @return array<string>
	 */
	private function header( Configuration $configuration, string $class_name ): array {
		$description = '' === $configuration->description ? 'Generated REST API endpoint.' : $configuration->description;
		$description = str_replace( array( "\r", "\n", '*/' ), array( ' ', ' ', '* /' ), $description );

		return array(
			'<?php',
			'/**',
			' * ' . $description,
			' */',
			'',
			'namespace WPArchitectGenerated;',
			'',
			"defined( 'ABSPATH' ) || exit;",
			'',
			"final class {$class_name} {",
			'\tprivate const NAMESPACE = ' . $this->export( $configuration->api_namespace ) . ';',
			'\tprivate const ROUTE = ' . $this->export( $configuration->route ) . ';',
			'\tprivate const POST_TYPE = ' . $this->export( $configuration->post_type ) . ';',
			'\tprivate const MAX_RESULTS = ' . (string) (int) $configuration->result_limit . ';',
			'\tprivate const CACHE_DURATION = ' . (string) (int) $configuration->cache_duration . ';',
			'\tprivate const META_KEYS = array( ' . implode( ', ', array_map( array( $this, 'export' ), $configuration->custom_meta_keys ) ) . ' );',
			'',
		);
	}

	/**
	 * Builds route registration methods.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function register_methods( Configuration $configuration ): array {
		$method_constant = match ( $configuration->method ) {
			'GET' => '\\WP_REST_Server::READABLE',
			'POST' => '\\WP_REST_Server::CREATABLE',
			'DELETE' => '\\WP_REST_Server::DELETABLE',
			default => '\\WP_REST_Server::EDITABLE',
		};
		$permission_callback = 'public' === $configuration->authentication && 'GET' === $configuration->method
			? $this->export( '__return_true' )
			: "array( \$this, 'permissions_check' )";

		return array(
			'\t/** Registers WordPress hooks. @return void */',
			'\tpublic function register(): void {',
			"\t\tadd_action( 'rest_api_init', array( \$this, 'register_routes' ) );",
			'\t}',
			'',
			'\t/** Registers the REST route. @return void */',
			'\tpublic function register_routes(): void {',
			'\t\tregister_rest_route(',
			'\t\t\tself::NAMESPACE,',
			'\t\t\tself::ROUTE,',
			'\t\t\tarray(',
			"\t\t\t\t'methods'             => {$method_constant},",
			"\t\t\t\t'callback'            => array( \$this, 'handle_request' ),",
			"\t\t\t\t'permission_callback' => {$permission_callback},",
			"\t\t\t\t'args'                => \$this->get_endpoint_params(),",
			'\t\t\t)',
			'\t\t);',
			'\t}',
			'',
		);
	}

	/**
	 * Builds the permission callback.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function permission_method( Configuration $configuration ): array {
		$permission = match ( $configuration->authentication ) {
			'public' => 'return true;',
			'logged_in' => 'return is_user_logged_in();',
			'administrator' => "return current_user_can( 'manage_options' );",
			default => 'return current_user_can( ' . $this->export( $configuration->required_capability ) . ' );',
		};

		return array(
			'\t/** Checks endpoint permissions. @param \WP_REST_Request $request Request object. @return bool */',
			'\tpublic function permissions_check( \WP_REST_Request $request ): bool {',
			'\t\tunset( $request );',
			"\t\t{$permission}",
			'\t}',
			'',
		);
	}

	/**
	 * Builds endpoint parameter definitions.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function parameter_methods( Configuration $configuration ): array {
		$params = array();

		if ( 'single_post' === $configuration->data_source ) {
			$params['id'] = array(
				'description' => 'Post ID.',
				'type'        => 'integer',
				'required'    => true,
				'sanitize'    => 'absint',
				'validate'    => 'validate_positive_integer',
			);
		}
		if ( $configuration->pagination_enabled ) {
			$params['page']     = array(
				'description' => 'Current result page.',
				'type'        => 'integer',
				'required'    => false,
				'default'     => 1,
				'sanitize'    => 'absint',
				'validate'    => 'validate_positive_integer',
			);
			$params['per_page'] = array(
				'description' => 'Results per page, capped by the endpoint maximum.',
				'type'        => 'integer',
				'required'    => false,
				'default'     => (int) $configuration->result_limit,
				'sanitize'    => 'absint',
				'validate'    => 'validate_per_page',
			);
		}
		if ( $configuration->search_enabled ) {
			$params['search'] = array(
				'description' => 'Search phrase.',
				'type'        => 'string',
				'required'    => false,
				'default'     => '',
				'sanitize'    => 'sanitize_text_field',
			);
		}
		if ( in_array( $configuration->data_source, array( 'posts', 'custom_post_type' ), true ) ) {
			$params['order']   = array(
				'description' => 'Sort direction.',
				'type'        => 'string',
				'required'    => false,
				'default'     => $configuration->order,
				'sanitize'    => 'sanitize_text_field',
				'validate'    => 'validate_order',
			);
			$params['orderby'] = array(
				'description' => 'Sort field.',
				'type'        => 'string',
				'required'    => false,
				'default'     => $configuration->orderby,
				'sanitize'    => 'sanitize_text_field',
				'validate'    => 'validate_orderby',
			);
		}
		if ( $configuration->taxonomy_filter_enabled || 'taxonomy_terms' === $configuration->data_source ) {
			$params['taxonomy'] = array(
				'description' => 'Registered taxonomy key.',
				'type'        => 'string',
				'required'    => 'taxonomy_terms' === $configuration->data_source,
				'default'     => '',
				'sanitize'    => 'sanitize_key',
				'validate'    => 'validate_taxonomy',
			);
		}
		if ( $configuration->taxonomy_filter_enabled ) {
			$params['term'] = array(
				'description' => 'Term slug used with a safe IN comparison.',
				'type'        => 'string',
				'required'    => false,
				'default'     => '',
				'sanitize'    => 'sanitize_title',
			);
		}
		if ( $configuration->meta_filter_enabled ) {
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Generates an explicitly allowlisted REST parameter.
			$params['meta_key'] = array(
				'description' => 'Explicitly allowed public meta key.',
				'type'        => 'string',
				'required'    => false,
				'default'     => '',
				'sanitize'    => 'sanitize_key',
				'validate'    => 'validate_meta_key',
			);
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- Generates a sanitized value for a fixed equality comparison.
			$params['meta_value'] = array(
				'description' => 'Meta value compared using equals.',
				'type'        => 'string',
				'required'    => false,
				'default'     => '',
				'sanitize'    => 'sanitize_text_field',
			);
		}
		if ( 'GET' !== $configuration->method ) {
			$params['content'] = array(
				'description' => 'Example validated input. Replace with business-specific fields.',
				'type'        => 'string',
				'required'    => true,
				'sanitize'    => 'sanitize_textarea_field',
				'validate'    => 'validate_nonempty_string',
			);
		}

		$lines = array( '\t/** Returns route arguments. @return array<string, array<string, mixed>> */', '\tpublic function get_endpoint_params(): array {', '\t\treturn array(' );
		foreach ( $params as $name => $param ) {
			$lines[] = '\t\t\t' . $this->export( $name ) . ' => array(';
			$lines[] = "\t\t\t\t'description'       => " . $this->export( (string) $param['description'] ) . ',';
			$lines[] = "\t\t\t\t'type'              => " . $this->export( (string) $param['type'] ) . ',';
			$lines[] = "\t\t\t\t'required'          => " . $this->export( (bool) $param['required'] ) . ',';
			if ( array_key_exists( 'default', $param ) ) {
				$lines[] = "\t\t\t\t'default'           => " . $this->export_mixed( $param['default'] ) . ',';
			}
			$lines[] = "\t\t\t\t'sanitize_callback' => " . $this->export( (string) $param['sanitize'] ) . ',';
			if ( isset( $param['validate'] ) ) {
				$lines[] = "\t\t\t\t'validate_callback' => array( \$this, '" . $param['validate'] . "' ),";
			}
			$lines[] = '\t\t\t),';
		}
		$lines[] = '\t\t);';
		$lines[] = '\t}';
		$lines[] = '';
		$lines   = array_merge( $lines, $this->validation_methods() );

		return $lines;
	}

	/**
	 * Builds reusable request validators.
	 *
	 * @return array<string>
	 */
	private function validation_methods(): array {
		return array(
			'\t/** Validates a positive integer. @param mixed $value Value. @return bool */',
			'\tpublic function validate_positive_integer( mixed $value ): bool { return is_numeric( $value ) && 1 <= (int) $value; }',
			'\t/** Validates the per-page limit. @param mixed $value Value. @return bool */',
			'\tpublic function validate_per_page( mixed $value ): bool { return is_numeric( $value ) && 1 <= (int) $value && self::MAX_RESULTS >= (int) $value; }',
			'\t/** Validates sort direction. @param mixed $value Value. @return bool */',
			"\tpublic function validate_order( mixed \$value ): bool { return in_array( strtoupper( (string) \$value ), array( 'ASC', 'DESC' ), true ); }",
			'\t/** Validates the sort field. @param mixed $value Value. @return bool */',
			"\tpublic function validate_orderby( mixed \$value ): bool { return in_array( (string) \$value, array( 'date', 'modified', 'title', 'ID', 'author', 'name', 'rand', 'menu_order' ), true ); }",
			'\t/** Validates a runtime taxonomy. @param mixed $value Value. @return bool */',
			'\tpublic function validate_taxonomy( mixed $value ): bool { return is_string( $value ) && taxonomy_exists( $value ); }',
			'\t/** Validates an explicit, non-protected meta key. @param mixed $value Value. @return bool */',
			'\tpublic function validate_meta_key( mixed $value ): bool { return is_string( $value ) && ! str_starts_with( $value, \'_\' ) && in_array( $value, self::META_KEYS, true ); }',
			'\t/** Validates example write input. @param mixed $value Value. @return bool */',
			'\tpublic function validate_nonempty_string( mixed $value ): bool { return is_string( $value ) && \'\' !== trim( $value ); }',
			'',
		);
	}

	/**
	 * Builds the request callback.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function request_methods( Configuration $configuration ): array {
		$lines = array(
			'\t/** Handles the endpoint request. @param \WP_REST_Request $request Request object. @return \WP_REST_Response|\WP_Error */',
			'\tpublic function handle_request( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error {',
		);
		if ( 'GET' !== $configuration->method ) {
			$lines[] = '\t\t// TODO: Add business-specific validation and mutation logic. No data is modified by this boilerplate.';
			$lines[] = "\t\treturn new \\WP_Error( 'not_implemented', __( 'Implement and test this authenticated write endpoint before use.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 501 ) );";
			$lines[] = '\t}';
			$lines[] = '';

			return $lines;
		}

		if ( 'current_user' === $configuration->data_source ) {
			$lines[] = '\t\t$user = wp_get_current_user();';
			$lines[] = "\t\tif ( 0 === \$user->ID ) { return new \\WP_Error( 'not_authenticated', __( 'Authentication is required.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 401 ) ); }";
			$lines[] = "\t\treturn new \\WP_REST_Response( array( 'ID' => \$user->ID, 'display_name' => \$user->display_name, 'archive_url' => get_author_posts_url( \$user->ID ) ), 200 );";
		} elseif ( 'custom_callback' === $configuration->data_source ) {
			$lines[] = "\t\treturn new \\WP_Error( 'not_implemented', __( 'Replace this placeholder with a reviewed custom callback.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 501 ) );";
		} elseif ( 'taxonomy_terms' === $configuration->data_source ) {
			$lines = array_merge( $lines, $this->taxonomy_term_request_lines() );
		} elseif ( 'single_post' === $configuration->data_source ) {
			$lines = array_merge( $lines, $this->single_post_request_lines() );
		} else {
			$lines = array_merge( $lines, $this->post_query_request_lines( $configuration ) );
		}
		$lines[] = '\t}';
		$lines[] = '';

		return $lines;
	}

	/**
	 * Builds taxonomy-term request handling.
	 *
	 * @return array<string>
	 */
	private function taxonomy_term_request_lines(): array {
		return array(
			"\t\t\$taxonomy = sanitize_key( (string) \$request->get_param( 'taxonomy' ) );",
			"\t\tif ( ! taxonomy_exists( \$taxonomy ) ) { return new \\WP_Error( 'invalid_taxonomy', __( 'The taxonomy does not exist.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 400 ) ); }",
			"\t\t\$terms = get_terms( array( 'taxonomy' => \$taxonomy, 'hide_empty' => false ) );",
			"\t\tif ( is_wp_error( \$terms ) ) { return \$terms; }",
			"\t\t\$items = array_map( static fn( \\WP_Term \$term ): array => array( 'ID' => \$term->term_id, 'name' => \$term->name, 'slug' => \$term->slug, 'taxonomy' => \$term->taxonomy ), \$terms );",
			"\t\treturn new \\WP_REST_Response( array( 'data' => \$items ), 200 );",
		);
	}

	/**
	 * Builds single-post request handling.
	 *
	 * @return array<string>
	 */
	private function single_post_request_lines(): array {
		return array(
			"\t\tif ( ! post_type_exists( self::POST_TYPE ) ) { return new \\WP_Error( 'invalid_post_type', __( 'The configured post type does not exist.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 500 ) ); }",
			"\t\t\$post = get_post( absint( \$request->get_param( 'id' ) ) );",
			"\t\tif ( ! \$post instanceof \\WP_Post || self::POST_TYPE !== \$post->post_type || 'publish' !== \$post->post_status || '' !== \$post->post_password ) { return new \\WP_Error( 'not_found', __( 'The requested item was not found.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 404 ) ); }",
			"\t\t\$item = \$this->prepare_item( \$post );",
			"\t\tif ( is_wp_error( \$item ) ) { return \$item; }",
			"\t\treturn new \\WP_REST_Response( \$item, 200 );",
		);
	}

	/**
	 * Builds WP_Query request handling.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function post_query_request_lines( Configuration $configuration ): array {
		$lines = array(
			"\t\tif ( ! post_type_exists( self::POST_TYPE ) ) { return new \\WP_Error( 'invalid_post_type', __( 'The configured post type does not exist.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 500 ) ); }",
			"\t\t\$page = " . ( $configuration->pagination_enabled ? "max( 1, absint( \$request->get_param( 'page' ) ) )" : '1' ) . ';',
			"\t\t\$per_page = " . ( $configuration->pagination_enabled ? "min( self::MAX_RESULTS, max( 1, absint( \$request->get_param( 'per_page' ) ) ) )" : 'self::MAX_RESULTS' ) . ';',
			"\t\t\$query_args = array( 'post_type' => self::POST_TYPE, 'post_status' => 'publish', 'has_password' => false, 'posts_per_page' => \$per_page, 'paged' => \$page, 'order' => strtoupper( (string) \$request->get_param( 'order' ) ), 'orderby' => (string) \$request->get_param( 'orderby' ) );",
		);
		if ( $configuration->search_enabled ) {
			$lines[] = "\t\t\$query_args['s'] = sanitize_text_field( (string) \$request->get_param( 'search' ) );";
		}
		if ( $configuration->taxonomy_filter_enabled ) {
			$lines[] = "\t\t\$taxonomy = sanitize_key( (string) \$request->get_param( 'taxonomy' ) );";
			$lines[] = "\t\t\$term = sanitize_title( (string) \$request->get_param( 'term' ) );";
			$lines[] = "\t\tif ( '' !== \$taxonomy || '' !== \$term ) { if ( '' === \$taxonomy || '' === \$term || ! taxonomy_exists( \$taxonomy ) ) { return new \\WP_Error( 'invalid_taxonomy_filter', __( 'A valid taxonomy and term are required.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 400 ) ); } \$query_args['tax_query'] = array( array( 'taxonomy' => \$taxonomy, 'field' => 'slug', 'terms' => array( \$term ), 'operator' => 'IN' ) ); }";
		}
		if ( $configuration->meta_filter_enabled ) {
			$lines[] = '\t\t// Security: unrestricted meta queries may reveal sensitive data; only configured public keys are accepted.';
			$lines[] = "\t\t\$meta_key = sanitize_key( (string) \$request->get_param( 'meta_key' ) );";
			$lines[] = "\t\tif ( '' !== \$meta_key ) { if ( str_starts_with( \$meta_key, '_' ) || ! in_array( \$meta_key, self::META_KEYS, true ) ) { return new \\WP_Error( 'invalid_meta_key', __( 'The meta key is not allowed.', 'pmorix-post-type-taxonomy-rest-generator' ), array( 'status' => 400 ) ); } \$query_args['meta_query'] = array( array( 'key' => \$meta_key, 'value' => sanitize_text_field( (string) \$request->get_param( 'meta_value' ) ), 'compare' => '=' ) ); }";
		}
		if ( 'public' === $configuration->authentication && 0 < (int) $configuration->cache_duration ) {
			$lines[] = '\t\t// Invalidate this transient when relevant posts or terms change.';
			$lines[] = "\t\t\$cache_key = 'pmorix_ptrg_rest_' . md5( self::NAMESPACE . self::ROUTE . wp_json_encode( \$request->get_params() ) );";
			$lines[] = "\t\t\$cached = get_transient( \$cache_key );";
			$lines[] = "\t\tif ( false !== \$cached ) { return new \\WP_REST_Response( \$cached, 200 ); }";
		}
		$lines[] = "\t\t\$query = new \\WP_Query( \$query_args );";
		$lines[] = '\t\t$items = array();';
		$lines[] = "\t\tforeach ( \$query->posts as \$post ) { \$item = \$this->prepare_item( \$post ); if ( is_wp_error( \$item ) ) { wp_reset_postdata(); return \$item; } \$items[] = \$item; }";
		$lines[] = '\t\twp_reset_postdata();';
		if ( $configuration->pagination_enabled ) {
			$lines[] = "\t\t\$response_data = array( 'data' => \$items, 'pagination' => array( 'current_page' => \$page, 'per_page' => \$per_page, 'total_items' => (int) \$query->found_posts, 'total_pages' => (int) \$query->max_num_pages ) );";
		} else {
			$lines[] = "\t\t\$response_data = array( 'data' => \$items );";
		}
		if ( 'public' === $configuration->authentication && 0 < (int) $configuration->cache_duration ) {
			$lines[] = '\t\tset_transient( $cache_key, $response_data, self::CACHE_DURATION );';
		}
		$lines[] = '\t\treturn new \WP_REST_Response( $response_data, 200 );';

		return $lines;
	}

	/**
	 * Builds safe post response mapping.
	 *
	 * @param Configuration $configuration Configuration.
	 * @return array<string>
	 */
	private function prepare_item_method( Configuration $configuration ): array {
		$lines       = array(
			'\t/** Prepares a safe response item. @param \WP_Post $post Post object. @return array<string, mixed>|\WP_Error */',
			'\tprivate function prepare_item( \WP_Post $post ): array|\WP_Error {',
			'\t\t$item = array();',
		);
		$field_lines = array(
			'id'             => "\t\t\$item['ID'] = \$post->ID;",
			'title'          => "\t\t\$item['title'] = get_the_title( \$post );",
			'content'        => "\t\t\$item['content'] = get_post_field( 'post_content', \$post->ID );",
			'excerpt'        => "\t\t\$item['excerpt'] = get_the_excerpt( \$post );",
			'slug'           => "\t\t\$item['slug'] = get_post_field( 'post_name', \$post->ID );",
			'status'         => "\t\t\$item['status'] = get_post_field( 'post_status', \$post->ID );",
			'date'           => "\t\t\$item['date'] = get_post_field( 'post_date_gmt', \$post->ID );",
			'modified'       => "\t\t\$item['modified'] = get_post_field( 'post_modified_gmt', \$post->ID );",
			'permalink'      => "\t\t\$item['permalink'] = get_permalink( \$post );",
			'featured_image' => "\t\t\$image = get_the_post_thumbnail_url( \$post, 'full' ); \$item['featured_image'] = false === \$image ? null : \$image;",
			'author'         => "\t\t\$item['author'] = array( 'ID' => (int) \$post->post_author, 'display_name' => get_the_author_meta( 'display_name', \$post->post_author ), 'archive_url' => get_author_posts_url( \$post->post_author ) );",
		);
		foreach ( $configuration->response_fields as $field ) {
			if ( isset( $field_lines[ $field ] ) ) {
				$lines[] = $field_lines[ $field ];
			}
		}
		if ( in_array( 'taxonomies', $configuration->response_fields, true ) ) {
			$lines[] = '\t\t$item[\'taxonomies\'] = array();';
			$lines[] = "\t\tforeach ( get_object_taxonomies( \$post->post_type ) as \$taxonomy ) { \$terms = wp_get_post_terms( \$post->ID, \$taxonomy ); if ( is_wp_error( \$terms ) ) { return \$terms; } \$item['taxonomies'][ \$taxonomy ] = array_map( static fn( \\WP_Term \$term ): array => array( 'ID' => \$term->term_id, 'name' => \$term->name, 'slug' => \$term->slug, 'taxonomy' => \$term->taxonomy ), \$terms ); }";
		}
		if ( in_array( 'custom_fields', $configuration->response_fields, true ) ) {
			$lines[] = '\t\t$item[\'custom_fields\'] = array();';
			$lines[] = "\t\tforeach ( self::META_KEYS as \$meta_key ) { if ( ! str_starts_with( \$meta_key, '_' ) ) { \$item['custom_fields'][ \$meta_key ] = get_post_meta( \$post->ID, \$meta_key, true ); } }";
		}
		$lines[] = '\t\treturn $item;';
		$lines[] = '\t}';
		$lines[] = '';

		return $lines;
	}

	/**
	 * Exports a generated scalar literal.
	 *
	 * @param string|bool $value Value.
	 * @return string
	 */
	private function export( string|bool $value ): string {
		if ( is_bool( $value ) ) {
			return $value ? 'true' : 'false';
		}

		return "'" . str_replace( array( '\\', "'" ), array( '\\\\', "\\'" ), $value ) . "'";
	}

	/**
	 * Exports a mixed generated literal.
	 *
	 * @param mixed $value Value.
	 * @return string
	 */
	private function export_mixed( mixed $value ): string {
		return is_int( $value ) ? (string) $value : $this->export( is_bool( $value ) ? $value : (string) $value );
	}
}
