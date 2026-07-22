<?php
/**
 * REST API generator form and preview.
 *
 * @var PratapMaity\PMorixPTRG\RestApi\Configuration $configuration Sanitized configuration.
 * @var array<string>                                     $errors Validation errors.
 * @var string                                            $generated_code Generated PHP.
 * @var string                                            $success_message Success message.
 *
 * @package PratapMaity\PMorixPTRG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pmorix_ptrg_methods         = array( 'GET', 'POST', 'PUT', 'PATCH', 'DELETE' );
$pmorix_ptrg_data_sources    = array(
	'posts'            => __( 'WordPress posts', 'pmorix-post-type-taxonomy-rest-generator' ),
	'custom_post_type' => __( 'Custom post type', 'pmorix-post-type-taxonomy-rest-generator' ),
	'single_post'      => __( 'Single post by ID', 'pmorix-post-type-taxonomy-rest-generator' ),
	'taxonomy_terms'   => __( 'Taxonomy terms', 'pmorix-post-type-taxonomy-rest-generator' ),
	'current_user'     => __( 'Current authenticated user', 'pmorix-post-type-taxonomy-rest-generator' ),
	'custom_callback'  => __( 'Custom callback placeholder', 'pmorix-post-type-taxonomy-rest-generator' ),
);
$pmorix_ptrg_orderby         = array( 'date', 'modified', 'title', 'ID', 'author', 'name', 'rand', 'menu_order' );
$pmorix_ptrg_authentication  = array(
	'public'        => __( 'Public endpoint', 'pmorix-post-type-taxonomy-rest-generator' ),
	'logged_in'     => __( 'Logged-in users', 'pmorix-post-type-taxonomy-rest-generator' ),
	'capability'    => __( 'Required capability', 'pmorix-post-type-taxonomy-rest-generator' ),
	'administrator' => __( 'Administrators only', 'pmorix-post-type-taxonomy-rest-generator' ),
);
$pmorix_ptrg_response_fields = array(
	'id'        => __( 'ID', 'pmorix-post-type-taxonomy-rest-generator' ),
	'title'     => __( 'Title', 'pmorix-post-type-taxonomy-rest-generator' ),
	'content'   => __( 'Content', 'pmorix-post-type-taxonomy-rest-generator' ),
	'excerpt'   => __( 'Excerpt', 'pmorix-post-type-taxonomy-rest-generator' ),
	'slug'      => __( 'Slug', 'pmorix-post-type-taxonomy-rest-generator' ),
	'status'    => __( 'Status', 'pmorix-post-type-taxonomy-rest-generator' ),
	'date'      => __( 'Date', 'pmorix-post-type-taxonomy-rest-generator' ),
	'modified'  => __( 'Modified date', 'pmorix-post-type-taxonomy-rest-generator' ),
	'permalink' => __( 'Permalink', 'pmorix-post-type-taxonomy-rest-generator' ),
);
$pmorix_ptrg_option_fields   = array(
	'search_enabled'          => __( 'Search parameter support', 'pmorix-post-type-taxonomy-rest-generator' ),
	'pagination_enabled'      => __( 'Pagination support', 'pmorix-post-type-taxonomy-rest-generator' ),
	'taxonomy_filter_enabled' => __( 'Taxonomy filter support', 'pmorix-post-type-taxonomy-rest-generator' ),
	'meta_filter_enabled'     => __( 'Meta filter support', 'pmorix-post-type-taxonomy-rest-generator' ),
	'include_featured_image'  => __( 'Include featured image URL', 'pmorix-post-type-taxonomy-rest-generator' ),
	'include_author'          => __( 'Include author information', 'pmorix-post-type-taxonomy-rest-generator' ),
	'include_taxonomies'      => __( 'Include taxonomy terms', 'pmorix-post-type-taxonomy-rest-generator' ),
	'include_custom_fields'   => __( 'Include custom fields', 'pmorix-post-type-taxonomy-rest-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'REST API Generator', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a secure WordPress REST API endpoint and generate a reviewable PHP controller.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p>
	<p><strong><?php echo esc_html__( 'The generated endpoint code is not executed or installed automatically. Review, test, and customize it before using it in production.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>
	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert"><p><strong><?php echo esc_html__( 'Please correct the following errors:', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong></p><ul>
			<?php
			foreach ( $errors as $pmorix_ptrg_error ) :
				?>
				<li><?php echo esc_html( $pmorix_ptrg_error ); ?></li><?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'pmorix_ptrg_generate_rest_api', 'pmorix_ptrg_rest_api_nonce' ); ?>
		<input type="hidden" name="pmorix_ptrg_action" value="pmorix_ptrg_generate_rest_api">
		<table class="form-table" role="presentation">
			<tr><th scope="row"><label for="api_namespace"><?php echo esc_html__( 'API namespace', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="regular-text" id="api_namespace" name="api_namespace" required value="<?php echo esc_attr( $configuration->api_namespace ); ?>" aria-describedby="api-namespace-description"><p class="description" id="api-namespace-description"><?php echo esc_html__( 'Example: pmorix-post-type-taxonomy-rest-generator/v1. Do not include leading or trailing slashes.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="route"><?php echo esc_html__( 'Route path', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="regular-text code" id="route" name="route" required value="<?php echo esc_attr( $configuration->route ); ?>" aria-describedby="route-description"><p class="description" id="route-description"><?php echo esc_html__( 'Example: projects or projects/(?P<id>\d+). A leading slash is optional.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="method"><?php echo esc_html__( 'HTTP method', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><select id="method" name="method">
			<?php
			foreach ( $pmorix_ptrg_methods as $pmorix_ptrg_method ) :
				?>
				<option value="<?php echo esc_attr( $pmorix_ptrg_method ); ?>" <?php selected( $configuration->method, $pmorix_ptrg_method ); ?>><?php echo esc_html( $pmorix_ptrg_method ); ?></option><?php endforeach; ?></select><p class="description"><?php echo esc_html__( 'Write methods generate authenticated, non-mutating boilerplate that requires developer implementation.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="data_source"><?php echo esc_html__( 'Data source', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><select id="data_source" name="data_source">
			<?php
			foreach ( $pmorix_ptrg_data_sources as $pmorix_ptrg_value => $pmorix_ptrg_label ) :
				?>
				<option value="<?php echo esc_attr( $pmorix_ptrg_value ); ?>" <?php selected( $configuration->data_source, $pmorix_ptrg_value ); ?>><?php echo esc_html( $pmorix_ptrg_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="endpoint_post_type"><?php echo esc_html__( 'Post type', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="regular-text" id="endpoint_post_type" name="endpoint_post_type" value="<?php echo esc_attr( $configuration->post_type ); ?>"><p class="description"><?php echo esc_html__( 'Use post, page, product, or a valid custom post type key.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="result_limit"><?php echo esc_html__( 'Number of results', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="small-text" type="number" min="1" max="100" id="result_limit" name="result_limit" value="<?php echo esc_attr( $configuration->result_limit ); ?>"></td></tr>
			<tr><th scope="row"><label for="order"><?php echo esc_html__( 'Order', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><select id="order" name="order"><option value="DESC" <?php selected( $configuration->order, 'DESC' ); ?>>DESC</option><option value="ASC" <?php selected( $configuration->order, 'ASC' ); ?>>ASC</option></select></td></tr>
			<tr><th scope="row"><label for="orderby"><?php echo esc_html__( 'Order by', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><select id="orderby" name="orderby">
			<?php
			foreach ( $pmorix_ptrg_orderby as $pmorix_ptrg_value ) :
				?>
				<option value="<?php echo esc_attr( $pmorix_ptrg_value ); ?>" <?php selected( $configuration->orderby, $pmorix_ptrg_value ); ?>><?php echo esc_html( $pmorix_ptrg_value ); ?></option><?php endforeach; ?></select></td></tr>
			<?php foreach ( $pmorix_ptrg_option_fields as $pmorix_ptrg_field => $pmorix_ptrg_label ) : ?>
				<tr><th scope="row"><?php echo esc_html( $pmorix_ptrg_label ); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr( $pmorix_ptrg_field ); ?>" value="1" <?php checked( $configuration->{$pmorix_ptrg_field} ); ?>> <?php echo esc_html__( 'Enabled', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></td></tr>
			<?php endforeach; ?>
			<tr><th scope="row"><label for="authentication"><?php echo esc_html__( 'Authentication requirement', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><select id="authentication" name="authentication">
			<?php
			foreach ( $pmorix_ptrg_authentication as $pmorix_ptrg_value => $pmorix_ptrg_label ) :
				?>
				<option value="<?php echo esc_attr( $pmorix_ptrg_value ); ?>" <?php selected( $configuration->authentication, $pmorix_ptrg_value ); ?>><?php echo esc_html( $pmorix_ptrg_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="required_capability"><?php echo esc_html__( 'Required capability', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="regular-text" id="required_capability" name="required_capability" value="<?php echo esc_attr( $configuration->required_capability ); ?>"><p class="description"><?php echo esc_html__( 'Required only when capability-based authentication is selected.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><?php echo esc_html__( 'Response fields', 'pmorix-post-type-taxonomy-rest-generator' ); ?></th><td><fieldset><legend class="screen-reader-text"><?php echo esc_html__( 'Selected response fields', 'pmorix-post-type-taxonomy-rest-generator' ); ?></legend>
			<?php
			foreach ( $pmorix_ptrg_response_fields as $pmorix_ptrg_field => $pmorix_ptrg_label ) :
				?>
				<label><input type="checkbox" name="response_fields[]" value="<?php echo esc_attr( $pmorix_ptrg_field ); ?>" <?php checked( in_array( $pmorix_ptrg_field, $configuration->response_fields, true ) ); ?>> <?php echo esc_html( $pmorix_ptrg_label ); ?></label><br><?php endforeach; ?></fieldset></td></tr>
			<tr><th scope="row"><label for="custom_meta_keys"><?php echo esc_html__( 'Custom field keys', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="regular-text" id="custom_meta_keys" name="custom_meta_keys" value="<?php echo esc_attr( $configuration->custom_meta_keys_input ); ?>"><p class="description"><?php echo esc_html__( 'Comma- or space-separated public meta keys. Protected keys beginning with an underscore are rejected.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="cache_duration"><?php echo esc_html__( 'Cache duration', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><input class="small-text" type="number" min="0" max="86400" id="cache_duration" name="cache_duration" value="<?php echo esc_attr( $configuration->cache_duration ); ?>"> <?php echo esc_html__( 'seconds', 'pmorix-post-type-taxonomy-rest-generator' ); ?><p class="description"><?php echo esc_html__( 'Caching is generated only for public GET collection endpoints.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="description"><?php echo esc_html__( 'Endpoint description', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th><td><textarea class="large-text" id="description" name="description" rows="3"><?php echo esc_textarea( $configuration->description ); ?></textarea></td></tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'pmorix-post-type-taxonomy-rest-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=pmorix_ptrg_rest_api_generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'pmorix-post-type-taxonomy-rest-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<div class="notice notice-info inline"><p><strong><?php echo esc_html__( 'Endpoint preview:', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong> <code><?php echo esc_html( '/wp-json/' . $configuration->api_namespace . $configuration->route ); ?></code><br><strong><?php echo esc_html__( 'Authentication:', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong> <?php echo esc_html( $pmorix_ptrg_authentication[ $configuration->authentication ] ); ?><br><strong><?php echo esc_html__( 'Response fields:', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong> <?php echo esc_html( implode( ', ', $configuration->response_fields ) ); ?></p></div>
		<h2><?php echo esc_html__( 'Generated code preview', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h2>
		<textarea id="pmorix-post-type-taxonomy-rest-generator-generated-rest-code" class="large-text code" rows="36" readonly aria-label="<?php echo esc_attr__( 'Generated REST endpoint PHP code', 'pmorix-post-type-taxonomy-rest-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p><button type="button" class="button" data-pmorix-ptrg-copy data-target="pmorix-post-type-taxonomy-rest-generator-generated-rest-code" data-status="pmorix-post-type-taxonomy-rest-generator-copy-rest-status"><?php echo esc_html__( 'Copy to clipboard', 'pmorix-post-type-taxonomy-rest-generator' ); ?></button> <span id="pmorix-post-type-taxonomy-rest-generator-copy-rest-status" role="status" aria-live="polite"></span></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'pmorix_ptrg_download_rest_api', 'pmorix_ptrg_rest_api_nonce' ); ?><input type="hidden" name="action" value="pmorix_ptrg_download_rest_api">
			<?php foreach ( get_object_vars( $configuration ) as $pmorix_ptrg_field => $pmorix_ptrg_value ) : ?>
				<?php
				$pmorix_ptrg_input_field = 'post_type' === $pmorix_ptrg_field ? 'endpoint_post_type' : $pmorix_ptrg_field;
				if ( is_array( $pmorix_ptrg_value ) ) :
					foreach ( $pmorix_ptrg_value as $pmorix_ptrg_item ) :
						?>
					<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_input_field ); ?>[]" value="<?php echo esc_attr( $pmorix_ptrg_item ); ?>">
						<?php
endforeach; elseif ( is_bool( $pmorix_ptrg_value ) ) :
	?>
	<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_input_field ); ?>" value="<?php echo $pmorix_ptrg_value ? '1' : '0'; ?>">
	<?php
else :
	?>
	<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_input_field ); ?>" value="<?php echo esc_attr( $pmorix_ptrg_value ); ?>"><?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'pmorix-post-type-taxonomy-rest-generator' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
