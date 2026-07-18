<?php
/**
 * REST API generator form and preview.
 *
 * @var PratapMaity\WPArchitectAI\RestApi\Configuration $configuration Sanitized configuration.
 * @var array<string>                                     $errors Validation errors.
 * @var string                                            $generated_code Generated PHP.
 * @var string                                            $success_message Success message.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_architect_ai_methods         = array( 'GET', 'POST', 'PUT', 'PATCH', 'DELETE' );
$wp_architect_ai_data_sources    = array(
	'posts'            => __( 'WordPress posts', 'wp-architect-ai' ),
	'custom_post_type' => __( 'Custom post type', 'wp-architect-ai' ),
	'single_post'      => __( 'Single post by ID', 'wp-architect-ai' ),
	'taxonomy_terms'   => __( 'Taxonomy terms', 'wp-architect-ai' ),
	'current_user'     => __( 'Current authenticated user', 'wp-architect-ai' ),
	'custom_callback'  => __( 'Custom callback placeholder', 'wp-architect-ai' ),
);
$wp_architect_ai_orderby         = array( 'date', 'modified', 'title', 'ID', 'author', 'name', 'rand', 'menu_order' );
$wp_architect_ai_authentication  = array(
	'public'        => __( 'Public endpoint', 'wp-architect-ai' ),
	'logged_in'     => __( 'Logged-in users', 'wp-architect-ai' ),
	'capability'    => __( 'Required capability', 'wp-architect-ai' ),
	'administrator' => __( 'Administrators only', 'wp-architect-ai' ),
);
$wp_architect_ai_response_fields = array(
	'id'        => __( 'ID', 'wp-architect-ai' ),
	'title'     => __( 'Title', 'wp-architect-ai' ),
	'content'   => __( 'Content', 'wp-architect-ai' ),
	'excerpt'   => __( 'Excerpt', 'wp-architect-ai' ),
	'slug'      => __( 'Slug', 'wp-architect-ai' ),
	'status'    => __( 'Status', 'wp-architect-ai' ),
	'date'      => __( 'Date', 'wp-architect-ai' ),
	'modified'  => __( 'Modified date', 'wp-architect-ai' ),
	'permalink' => __( 'Permalink', 'wp-architect-ai' ),
);
$wp_architect_ai_option_fields   = array(
	'search_enabled'          => __( 'Search parameter support', 'wp-architect-ai' ),
	'pagination_enabled'      => __( 'Pagination support', 'wp-architect-ai' ),
	'taxonomy_filter_enabled' => __( 'Taxonomy filter support', 'wp-architect-ai' ),
	'meta_filter_enabled'     => __( 'Meta filter support', 'wp-architect-ai' ),
	'include_featured_image'  => __( 'Include featured image URL', 'wp-architect-ai' ),
	'include_author'          => __( 'Include author information', 'wp-architect-ai' ),
	'include_taxonomies'      => __( 'Include taxonomy terms', 'wp-architect-ai' ),
	'include_custom_fields'   => __( 'Include custom fields', 'wp-architect-ai' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'REST API Generator', 'wp-architect-ai' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a secure WordPress REST API endpoint and generate a reviewable PHP controller.', 'wp-architect-ai' ); ?></p>
	<p><strong><?php echo esc_html__( 'The generated endpoint code is not executed or installed automatically. Review, test, and customize it before using it in production.', 'wp-architect-ai' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>
	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert"><p><strong><?php echo esc_html__( 'Please correct the following errors:', 'wp-architect-ai' ); ?></strong></p><ul>
			<?php
			foreach ( $errors as $wp_architect_ai_error ) :
				?>
				<li><?php echo esc_html( $wp_architect_ai_error ); ?></li><?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'wp_architect_ai_generate_rest_api' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_rest_api">
		<table class="form-table" role="presentation">
			<tr><th scope="row"><label for="api_namespace"><?php echo esc_html__( 'API namespace', 'wp-architect-ai' ); ?></label></th><td><input class="regular-text" id="api_namespace" name="api_namespace" required value="<?php echo esc_attr( $configuration->api_namespace ); ?>" aria-describedby="api-namespace-description"><p class="description" id="api-namespace-description"><?php echo esc_html__( 'Example: wp-architect-ai/v1. Do not include leading or trailing slashes.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="route"><?php echo esc_html__( 'Route path', 'wp-architect-ai' ); ?></label></th><td><input class="regular-text code" id="route" name="route" required value="<?php echo esc_attr( $configuration->route ); ?>" aria-describedby="route-description"><p class="description" id="route-description"><?php echo esc_html__( 'Example: projects or projects/(?P<id>\d+). A leading slash is optional.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="method"><?php echo esc_html__( 'HTTP method', 'wp-architect-ai' ); ?></label></th><td><select id="method" name="method">
			<?php
			foreach ( $wp_architect_ai_methods as $wp_architect_ai_method ) :
				?>
				<option value="<?php echo esc_attr( $wp_architect_ai_method ); ?>" <?php selected( $configuration->method, $wp_architect_ai_method ); ?>><?php echo esc_html( $wp_architect_ai_method ); ?></option><?php endforeach; ?></select><p class="description"><?php echo esc_html__( 'Write methods generate authenticated, non-mutating boilerplate that requires developer implementation.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="data_source"><?php echo esc_html__( 'Data source', 'wp-architect-ai' ); ?></label></th><td><select id="data_source" name="data_source">
			<?php
			foreach ( $wp_architect_ai_data_sources as $wp_architect_ai_value => $wp_architect_ai_label ) :
				?>
				<option value="<?php echo esc_attr( $wp_architect_ai_value ); ?>" <?php selected( $configuration->data_source, $wp_architect_ai_value ); ?>><?php echo esc_html( $wp_architect_ai_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="endpoint_post_type"><?php echo esc_html__( 'Post type', 'wp-architect-ai' ); ?></label></th><td><input class="regular-text" id="endpoint_post_type" name="endpoint_post_type" value="<?php echo esc_attr( $configuration->post_type ); ?>"><p class="description"><?php echo esc_html__( 'Use post, page, product, or a valid custom post type key.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="result_limit"><?php echo esc_html__( 'Number of results', 'wp-architect-ai' ); ?></label></th><td><input class="small-text" type="number" min="1" max="100" id="result_limit" name="result_limit" value="<?php echo esc_attr( $configuration->result_limit ); ?>"></td></tr>
			<tr><th scope="row"><label for="order"><?php echo esc_html__( 'Order', 'wp-architect-ai' ); ?></label></th><td><select id="order" name="order"><option value="DESC" <?php selected( $configuration->order, 'DESC' ); ?>>DESC</option><option value="ASC" <?php selected( $configuration->order, 'ASC' ); ?>>ASC</option></select></td></tr>
			<tr><th scope="row"><label for="orderby"><?php echo esc_html__( 'Order by', 'wp-architect-ai' ); ?></label></th><td><select id="orderby" name="orderby">
			<?php
			foreach ( $wp_architect_ai_orderby as $wp_architect_ai_value ) :
				?>
				<option value="<?php echo esc_attr( $wp_architect_ai_value ); ?>" <?php selected( $configuration->orderby, $wp_architect_ai_value ); ?>><?php echo esc_html( $wp_architect_ai_value ); ?></option><?php endforeach; ?></select></td></tr>
			<?php foreach ( $wp_architect_ai_option_fields as $wp_architect_ai_field => $wp_architect_ai_label ) : ?>
				<tr><th scope="row"><?php echo esc_html( $wp_architect_ai_label ); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr( $wp_architect_ai_field ); ?>" value="1" <?php checked( $configuration->{$wp_architect_ai_field} ); ?>> <?php echo esc_html__( 'Enabled', 'wp-architect-ai' ); ?></label></td></tr>
			<?php endforeach; ?>
			<tr><th scope="row"><label for="authentication"><?php echo esc_html__( 'Authentication requirement', 'wp-architect-ai' ); ?></label></th><td><select id="authentication" name="authentication">
			<?php
			foreach ( $wp_architect_ai_authentication as $wp_architect_ai_value => $wp_architect_ai_label ) :
				?>
				<option value="<?php echo esc_attr( $wp_architect_ai_value ); ?>" <?php selected( $configuration->authentication, $wp_architect_ai_value ); ?>><?php echo esc_html( $wp_architect_ai_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="required_capability"><?php echo esc_html__( 'Required capability', 'wp-architect-ai' ); ?></label></th><td><input class="regular-text" id="required_capability" name="required_capability" value="<?php echo esc_attr( $configuration->required_capability ); ?>"><p class="description"><?php echo esc_html__( 'Required only when capability-based authentication is selected.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><?php echo esc_html__( 'Response fields', 'wp-architect-ai' ); ?></th><td><fieldset><legend class="screen-reader-text"><?php echo esc_html__( 'Selected response fields', 'wp-architect-ai' ); ?></legend>
			<?php
			foreach ( $wp_architect_ai_response_fields as $wp_architect_ai_field => $wp_architect_ai_label ) :
				?>
				<label><input type="checkbox" name="response_fields[]" value="<?php echo esc_attr( $wp_architect_ai_field ); ?>" <?php checked( in_array( $wp_architect_ai_field, $configuration->response_fields, true ) ); ?>> <?php echo esc_html( $wp_architect_ai_label ); ?></label><br><?php endforeach; ?></fieldset></td></tr>
			<tr><th scope="row"><label for="custom_meta_keys"><?php echo esc_html__( 'Custom field keys', 'wp-architect-ai' ); ?></label></th><td><input class="regular-text" id="custom_meta_keys" name="custom_meta_keys" value="<?php echo esc_attr( $configuration->custom_meta_keys_input ); ?>"><p class="description"><?php echo esc_html__( 'Comma- or space-separated public meta keys. Protected keys beginning with an underscore are rejected.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="cache_duration"><?php echo esc_html__( 'Cache duration', 'wp-architect-ai' ); ?></label></th><td><input class="small-text" type="number" min="0" max="86400" id="cache_duration" name="cache_duration" value="<?php echo esc_attr( $configuration->cache_duration ); ?>"> <?php echo esc_html__( 'seconds', 'wp-architect-ai' ); ?><p class="description"><?php echo esc_html__( 'Caching is generated only for public GET collection endpoints.', 'wp-architect-ai' ); ?></p></td></tr>
			<tr><th scope="row"><label for="description"><?php echo esc_html__( 'Endpoint description', 'wp-architect-ai' ); ?></label></th><td><textarea class="large-text" id="description" name="description" rows="3"><?php echo esc_textarea( $configuration->description ); ?></textarea></td></tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'wp-architect-ai' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=wp-architect-ai-rest-api-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'wp-architect-ai' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<div class="notice notice-info inline"><p><strong><?php echo esc_html__( 'Endpoint preview:', 'wp-architect-ai' ); ?></strong> <code><?php echo esc_html( '/wp-json/' . $configuration->api_namespace . $configuration->route ); ?></code><br><strong><?php echo esc_html__( 'Authentication:', 'wp-architect-ai' ); ?></strong> <?php echo esc_html( $wp_architect_ai_authentication[ $configuration->authentication ] ); ?><br><strong><?php echo esc_html__( 'Response fields:', 'wp-architect-ai' ); ?></strong> <?php echo esc_html( implode( ', ', $configuration->response_fields ) ); ?></p></div>
		<h2><?php echo esc_html__( 'Generated code preview', 'wp-architect-ai' ); ?></h2>
		<textarea id="wp-architect-ai-generated-rest-code" class="large-text code" rows="36" readonly aria-label="<?php echo esc_attr__( 'Generated REST endpoint PHP code', 'wp-architect-ai' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p><button type="button" class="button" data-wp-architect-ai-copy data-target="wp-architect-ai-generated-rest-code" data-status="wp-architect-ai-copy-rest-status"><?php echo esc_html__( 'Copy to clipboard', 'wp-architect-ai' ); ?></button> <span id="wp-architect-ai-copy-rest-status" role="status" aria-live="polite"></span></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_rest_api' ); ?><input type="hidden" name="action" value="wp_architect_ai_download_rest_api">
			<?php foreach ( get_object_vars( $configuration ) as $wp_architect_ai_field => $wp_architect_ai_value ) : ?>
				<?php
				$wp_architect_ai_input_field = 'post_type' === $wp_architect_ai_field ? 'endpoint_post_type' : $wp_architect_ai_field;
				if ( is_array( $wp_architect_ai_value ) ) :
					foreach ( $wp_architect_ai_value as $wp_architect_ai_item ) :
						?>
					<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_input_field ); ?>[]" value="<?php echo esc_attr( $wp_architect_ai_item ); ?>">
						<?php
endforeach; elseif ( is_bool( $wp_architect_ai_value ) ) :
	?>
	<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_input_field ); ?>" value="<?php echo $wp_architect_ai_value ? '1' : '0'; ?>">
	<?php
else :
	?>
	<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_input_field ); ?>" value="<?php echo esc_attr( $wp_architect_ai_value ); ?>"><?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'wp-architect-ai' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
