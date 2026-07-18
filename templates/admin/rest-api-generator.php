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

$architect_ai_code_generator_methods         = array( 'GET', 'POST', 'PUT', 'PATCH', 'DELETE' );
$architect_ai_code_generator_data_sources    = array(
	'posts'            => __( 'WordPress posts', 'architect-ai-code-generator' ),
	'custom_post_type' => __( 'Custom post type', 'architect-ai-code-generator' ),
	'single_post'      => __( 'Single post by ID', 'architect-ai-code-generator' ),
	'taxonomy_terms'   => __( 'Taxonomy terms', 'architect-ai-code-generator' ),
	'current_user'     => __( 'Current authenticated user', 'architect-ai-code-generator' ),
	'custom_callback'  => __( 'Custom callback placeholder', 'architect-ai-code-generator' ),
);
$architect_ai_code_generator_orderby         = array( 'date', 'modified', 'title', 'ID', 'author', 'name', 'rand', 'menu_order' );
$architect_ai_code_generator_authentication  = array(
	'public'        => __( 'Public endpoint', 'architect-ai-code-generator' ),
	'logged_in'     => __( 'Logged-in users', 'architect-ai-code-generator' ),
	'capability'    => __( 'Required capability', 'architect-ai-code-generator' ),
	'administrator' => __( 'Administrators only', 'architect-ai-code-generator' ),
);
$architect_ai_code_generator_response_fields = array(
	'id'        => __( 'ID', 'architect-ai-code-generator' ),
	'title'     => __( 'Title', 'architect-ai-code-generator' ),
	'content'   => __( 'Content', 'architect-ai-code-generator' ),
	'excerpt'   => __( 'Excerpt', 'architect-ai-code-generator' ),
	'slug'      => __( 'Slug', 'architect-ai-code-generator' ),
	'status'    => __( 'Status', 'architect-ai-code-generator' ),
	'date'      => __( 'Date', 'architect-ai-code-generator' ),
	'modified'  => __( 'Modified date', 'architect-ai-code-generator' ),
	'permalink' => __( 'Permalink', 'architect-ai-code-generator' ),
);
$architect_ai_code_generator_option_fields   = array(
	'search_enabled'          => __( 'Search parameter support', 'architect-ai-code-generator' ),
	'pagination_enabled'      => __( 'Pagination support', 'architect-ai-code-generator' ),
	'taxonomy_filter_enabled' => __( 'Taxonomy filter support', 'architect-ai-code-generator' ),
	'meta_filter_enabled'     => __( 'Meta filter support', 'architect-ai-code-generator' ),
	'include_featured_image'  => __( 'Include featured image URL', 'architect-ai-code-generator' ),
	'include_author'          => __( 'Include author information', 'architect-ai-code-generator' ),
	'include_taxonomies'      => __( 'Include taxonomy terms', 'architect-ai-code-generator' ),
	'include_custom_fields'   => __( 'Include custom fields', 'architect-ai-code-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'REST API Generator', 'architect-ai-code-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a secure WordPress REST API endpoint and generate a reviewable PHP controller.', 'architect-ai-code-generator' ); ?></p>
	<p><strong><?php echo esc_html__( 'The generated endpoint code is not executed or installed automatically. Review, test, and customize it before using it in production.', 'architect-ai-code-generator' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>
	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert"><p><strong><?php echo esc_html__( 'Please correct the following errors:', 'architect-ai-code-generator' ); ?></strong></p><ul>
			<?php
			foreach ( $errors as $architect_ai_code_generator_error ) :
				?>
				<li><?php echo esc_html( $architect_ai_code_generator_error ); ?></li><?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'wp_architect_ai_generate_rest_api' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_rest_api">
		<table class="form-table" role="presentation">
			<tr><th scope="row"><label for="api_namespace"><?php echo esc_html__( 'API namespace', 'architect-ai-code-generator' ); ?></label></th><td><input class="regular-text" id="api_namespace" name="api_namespace" required value="<?php echo esc_attr( $configuration->api_namespace ); ?>" aria-describedby="api-namespace-description"><p class="description" id="api-namespace-description"><?php echo esc_html__( 'Example: architect-ai-code-generator/v1. Do not include leading or trailing slashes.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="route"><?php echo esc_html__( 'Route path', 'architect-ai-code-generator' ); ?></label></th><td><input class="regular-text code" id="route" name="route" required value="<?php echo esc_attr( $configuration->route ); ?>" aria-describedby="route-description"><p class="description" id="route-description"><?php echo esc_html__( 'Example: projects or projects/(?P<id>\d+). A leading slash is optional.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="method"><?php echo esc_html__( 'HTTP method', 'architect-ai-code-generator' ); ?></label></th><td><select id="method" name="method">
			<?php
			foreach ( $architect_ai_code_generator_methods as $architect_ai_code_generator_method ) :
				?>
				<option value="<?php echo esc_attr( $architect_ai_code_generator_method ); ?>" <?php selected( $configuration->method, $architect_ai_code_generator_method ); ?>><?php echo esc_html( $architect_ai_code_generator_method ); ?></option><?php endforeach; ?></select><p class="description"><?php echo esc_html__( 'Write methods generate authenticated, non-mutating boilerplate that requires developer implementation.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="data_source"><?php echo esc_html__( 'Data source', 'architect-ai-code-generator' ); ?></label></th><td><select id="data_source" name="data_source">
			<?php
			foreach ( $architect_ai_code_generator_data_sources as $architect_ai_code_generator_value => $architect_ai_code_generator_label ) :
				?>
				<option value="<?php echo esc_attr( $architect_ai_code_generator_value ); ?>" <?php selected( $configuration->data_source, $architect_ai_code_generator_value ); ?>><?php echo esc_html( $architect_ai_code_generator_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="endpoint_post_type"><?php echo esc_html__( 'Post type', 'architect-ai-code-generator' ); ?></label></th><td><input class="regular-text" id="endpoint_post_type" name="endpoint_post_type" value="<?php echo esc_attr( $configuration->post_type ); ?>"><p class="description"><?php echo esc_html__( 'Use post, page, product, or a valid custom post type key.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="result_limit"><?php echo esc_html__( 'Number of results', 'architect-ai-code-generator' ); ?></label></th><td><input class="small-text" type="number" min="1" max="100" id="result_limit" name="result_limit" value="<?php echo esc_attr( $configuration->result_limit ); ?>"></td></tr>
			<tr><th scope="row"><label for="order"><?php echo esc_html__( 'Order', 'architect-ai-code-generator' ); ?></label></th><td><select id="order" name="order"><option value="DESC" <?php selected( $configuration->order, 'DESC' ); ?>>DESC</option><option value="ASC" <?php selected( $configuration->order, 'ASC' ); ?>>ASC</option></select></td></tr>
			<tr><th scope="row"><label for="orderby"><?php echo esc_html__( 'Order by', 'architect-ai-code-generator' ); ?></label></th><td><select id="orderby" name="orderby">
			<?php
			foreach ( $architect_ai_code_generator_orderby as $architect_ai_code_generator_value ) :
				?>
				<option value="<?php echo esc_attr( $architect_ai_code_generator_value ); ?>" <?php selected( $configuration->orderby, $architect_ai_code_generator_value ); ?>><?php echo esc_html( $architect_ai_code_generator_value ); ?></option><?php endforeach; ?></select></td></tr>
			<?php foreach ( $architect_ai_code_generator_option_fields as $architect_ai_code_generator_field => $architect_ai_code_generator_label ) : ?>
				<tr><th scope="row"><?php echo esc_html( $architect_ai_code_generator_label ); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>" value="1" <?php checked( $configuration->{$architect_ai_code_generator_field} ); ?>> <?php echo esc_html__( 'Enabled', 'architect-ai-code-generator' ); ?></label></td></tr>
			<?php endforeach; ?>
			<tr><th scope="row"><label for="authentication"><?php echo esc_html__( 'Authentication requirement', 'architect-ai-code-generator' ); ?></label></th><td><select id="authentication" name="authentication">
			<?php
			foreach ( $architect_ai_code_generator_authentication as $architect_ai_code_generator_value => $architect_ai_code_generator_label ) :
				?>
				<option value="<?php echo esc_attr( $architect_ai_code_generator_value ); ?>" <?php selected( $configuration->authentication, $architect_ai_code_generator_value ); ?>><?php echo esc_html( $architect_ai_code_generator_label ); ?></option><?php endforeach; ?></select></td></tr>
			<tr><th scope="row"><label for="required_capability"><?php echo esc_html__( 'Required capability', 'architect-ai-code-generator' ); ?></label></th><td><input class="regular-text" id="required_capability" name="required_capability" value="<?php echo esc_attr( $configuration->required_capability ); ?>"><p class="description"><?php echo esc_html__( 'Required only when capability-based authentication is selected.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><?php echo esc_html__( 'Response fields', 'architect-ai-code-generator' ); ?></th><td><fieldset><legend class="screen-reader-text"><?php echo esc_html__( 'Selected response fields', 'architect-ai-code-generator' ); ?></legend>
			<?php
			foreach ( $architect_ai_code_generator_response_fields as $architect_ai_code_generator_field => $architect_ai_code_generator_label ) :
				?>
				<label><input type="checkbox" name="response_fields[]" value="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>" <?php checked( in_array( $architect_ai_code_generator_field, $configuration->response_fields, true ) ); ?>> <?php echo esc_html( $architect_ai_code_generator_label ); ?></label><br><?php endforeach; ?></fieldset></td></tr>
			<tr><th scope="row"><label for="custom_meta_keys"><?php echo esc_html__( 'Custom field keys', 'architect-ai-code-generator' ); ?></label></th><td><input class="regular-text" id="custom_meta_keys" name="custom_meta_keys" value="<?php echo esc_attr( $configuration->custom_meta_keys_input ); ?>"><p class="description"><?php echo esc_html__( 'Comma- or space-separated public meta keys. Protected keys beginning with an underscore are rejected.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="cache_duration"><?php echo esc_html__( 'Cache duration', 'architect-ai-code-generator' ); ?></label></th><td><input class="small-text" type="number" min="0" max="86400" id="cache_duration" name="cache_duration" value="<?php echo esc_attr( $configuration->cache_duration ); ?>"> <?php echo esc_html__( 'seconds', 'architect-ai-code-generator' ); ?><p class="description"><?php echo esc_html__( 'Caching is generated only for public GET collection endpoints.', 'architect-ai-code-generator' ); ?></p></td></tr>
			<tr><th scope="row"><label for="description"><?php echo esc_html__( 'Endpoint description', 'architect-ai-code-generator' ); ?></label></th><td><textarea class="large-text" id="description" name="description" rows="3"><?php echo esc_textarea( $configuration->description ); ?></textarea></td></tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'architect-ai-code-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=architect-ai-code-generator-rest-api-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'architect-ai-code-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<div class="notice notice-info inline"><p><strong><?php echo esc_html__( 'Endpoint preview:', 'architect-ai-code-generator' ); ?></strong> <code><?php echo esc_html( '/wp-json/' . $configuration->api_namespace . $configuration->route ); ?></code><br><strong><?php echo esc_html__( 'Authentication:', 'architect-ai-code-generator' ); ?></strong> <?php echo esc_html( $architect_ai_code_generator_authentication[ $configuration->authentication ] ); ?><br><strong><?php echo esc_html__( 'Response fields:', 'architect-ai-code-generator' ); ?></strong> <?php echo esc_html( implode( ', ', $configuration->response_fields ) ); ?></p></div>
		<h2><?php echo esc_html__( 'Generated code preview', 'architect-ai-code-generator' ); ?></h2>
		<textarea id="architect-ai-code-generator-generated-rest-code" class="large-text code" rows="36" readonly aria-label="<?php echo esc_attr__( 'Generated REST endpoint PHP code', 'architect-ai-code-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p><button type="button" class="button" data-architect-ai-code-generator-copy data-target="architect-ai-code-generator-generated-rest-code" data-status="architect-ai-code-generator-copy-rest-status"><?php echo esc_html__( 'Copy to clipboard', 'architect-ai-code-generator' ); ?></button> <span id="architect-ai-code-generator-copy-rest-status" role="status" aria-live="polite"></span></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_rest_api' ); ?><input type="hidden" name="action" value="wp_architect_ai_download_rest_api">
			<?php foreach ( get_object_vars( $configuration ) as $architect_ai_code_generator_field => $architect_ai_code_generator_value ) : ?>
				<?php
				$architect_ai_code_generator_input_field = 'post_type' === $architect_ai_code_generator_field ? 'endpoint_post_type' : $architect_ai_code_generator_field;
				if ( is_array( $architect_ai_code_generator_value ) ) :
					foreach ( $architect_ai_code_generator_value as $architect_ai_code_generator_item ) :
						?>
					<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_input_field ); ?>[]" value="<?php echo esc_attr( $architect_ai_code_generator_item ); ?>">
						<?php
endforeach; elseif ( is_bool( $architect_ai_code_generator_value ) ) :
	?>
	<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_input_field ); ?>" value="<?php echo $architect_ai_code_generator_value ? '1' : '0'; ?>">
	<?php
else :
	?>
	<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_input_field ); ?>" value="<?php echo esc_attr( $architect_ai_code_generator_value ); ?>"><?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'architect-ai-code-generator' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
