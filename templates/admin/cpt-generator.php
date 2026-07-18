<?php
/**
 * Custom post type generator form and preview.
 *
 * @var PratapMaity\WPArchitectAI\PostType\Configuration $configuration Sanitized form configuration.
 * @var array<string>                                      $errors Validation errors.
 * @var string                                             $generated_code Generated PHP preview.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_architect_ai_boolean_fields = array(
	'public'       => __( 'Public', 'wp-architect-ai' ),
	'hierarchical' => __( 'Hierarchical', 'wp-architect-ai' ),
	'show_ui'      => __( 'Show UI', 'wp-architect-ai' ),
	'show_in_rest' => __( 'Show in REST', 'wp-architect-ai' ),
	'has_archive'  => __( 'Has archive', 'wp-architect-ai' ),
);
$wp_architect_ai_support_fields = array(
	'title'         => __( 'Title', 'wp-architect-ai' ),
	'editor'        => __( 'Editor', 'wp-architect-ai' ),
	'thumbnail'     => __( 'Thumbnail', 'wp-architect-ai' ),
	'excerpt'       => __( 'Excerpt', 'wp-architect-ai' ),
	'revisions'     => __( 'Revisions', 'wp-architect-ai' ),
	'custom-fields' => __( 'Custom fields', 'wp-architect-ai' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Custom Post Type Generator', 'wp-architect-ai' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a post type and generate a PHP registration snippet for review.', 'wp-architect-ai' ); ?></p>

	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert">
			<ul>
				<?php foreach ( $errors as $wp_architect_ai_error ) : ?>
					<li><?php echo esc_html( $wp_architect_ai_error ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'wp_architect_ai_generate_cpt' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_cpt">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="post_type_key"><?php echo esc_html__( 'Post type key', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="post_type_key" name="post_type_key" type="text" maxlength="20" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->post_type_key ); ?>"><p class="description"><?php echo esc_html__( 'One to 20 lowercase letters, numbers, underscores, or hyphens.', 'wp-architect-ai' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="singular_label"><?php echo esc_html__( 'Singular label', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="singular_label" name="singular_label" type="text" required value="<?php echo esc_attr( $configuration->singular_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="plural_label"><?php echo esc_html__( 'Plural label', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="plural_label" name="plural_label" type="text" required value="<?php echo esc_attr( $configuration->plural_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="description"><?php echo esc_html__( 'Description', 'wp-architect-ai' ); ?></label></th>
				<td><textarea class="large-text" id="description" name="description" rows="4"><?php echo esc_textarea( $configuration->description ); ?></textarea></td>
			</tr>
			<?php foreach ( $wp_architect_ai_boolean_fields as $wp_architect_ai_field => $wp_architect_ai_label ) : ?>
				<tr>
					<th scope="row"><?php echo esc_html( $wp_architect_ai_label ); ?></th>
					<td><label><input name="<?php echo esc_attr( $wp_architect_ai_field ); ?>" type="checkbox" value="1" <?php checked( $configuration->{$wp_architect_ai_field} ); ?>> <?php echo esc_html__( 'Enabled', 'wp-architect-ai' ); ?></label></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<th scope="row"><label for="rewrite_slug"><?php echo esc_html__( 'Rewrite slug', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="rewrite_slug" name="rewrite_slug" type="text" value="<?php echo esc_attr( $configuration->rewrite_slug ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_icon"><?php echo esc_html__( 'Menu icon', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="menu_icon" name="menu_icon" type="text" value="<?php echo esc_attr( $configuration->menu_icon ); ?>"><p class="description"><?php echo esc_html__( 'Enter a Dashicons class such as dashicons-admin-post.', 'wp-architect-ai' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><?php echo esc_html__( 'Supports', 'wp-architect-ai' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Supported editor features', 'wp-architect-ai' ); ?></legend>
						<?php foreach ( $wp_architect_ai_support_fields as $wp_architect_ai_support => $wp_architect_ai_support_label ) : ?>
							<label><input name="supports[]" type="checkbox" value="<?php echo esc_attr( $wp_architect_ai_support ); ?>" <?php checked( in_array( $wp_architect_ai_support, $configuration->supports, true ) ); ?>> <?php echo esc_html( $wp_architect_ai_support_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'wp-architect-ai' ) ); ?>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'wp-architect-ai' ); ?></h2>
		<textarea id="wp-architect-ai-generated-code" class="large-text code" rows="24" readonly aria-label="<?php echo esc_attr__( 'Generated PHP code', 'wp-architect-ai' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="wp-architect-ai-copy-code" data-target="wp-architect-ai-generated-code"><?php echo esc_html__( 'Copy to clipboard', 'wp-architect-ai' ); ?></button>
			<span id="wp-architect-ai-copy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_cpt' ); ?>
			<input type="hidden" name="action" value="wp_architect_ai_download_cpt">
			<?php foreach ( get_object_vars( $configuration ) as $wp_architect_ai_field => $wp_architect_ai_value ) : ?>
				<?php if ( is_array( $wp_architect_ai_value ) ) : ?>
					<?php foreach ( $wp_architect_ai_value as $wp_architect_ai_item ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_field ); ?>[]" value="<?php echo esc_attr( $wp_architect_ai_item ); ?>">
					<?php endforeach; ?>
				<?php elseif ( is_bool( $wp_architect_ai_value ) ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_field ); ?>" value="<?php echo $wp_architect_ai_value ? '1' : '0'; ?>">
				<?php else : ?>
					<input type="hidden" name="<?php echo esc_attr( $wp_architect_ai_field ); ?>" value="<?php echo esc_attr( $wp_architect_ai_value ); ?>">
				<?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'wp-architect-ai' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
