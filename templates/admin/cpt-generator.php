<?php
/**
 * Custom post type generator form and preview.
 *
 * @var PratapMaity\WPArchitectAI\PostType\Configuration $configuration Sanitized form configuration.
 * @var array<string>                                      $errors Validation errors.
 * @var string                                             $generated_code Generated PHP preview.
 * @var string                                             $success_message Success notice message.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_architect_ai_boolean_fields = array(
	'public'              => __( 'Public', 'wp-architect-ai' ),
	'publicly_queryable'  => __( 'Publicly queryable', 'wp-architect-ai' ),
	'show_ui'             => __( 'Show UI', 'wp-architect-ai' ),
	'show_in_menu'        => __( 'Show in menu', 'wp-architect-ai' ),
	'show_in_rest'        => __( 'Show in REST', 'wp-architect-ai' ),
	'hierarchical'        => __( 'Hierarchical', 'wp-architect-ai' ),
	'has_archive'         => __( 'Has archive', 'wp-architect-ai' ),
	'exclude_from_search' => __( 'Exclude from search', 'wp-architect-ai' ),
);
$wp_architect_ai_support_fields = array(
	'title'           => __( 'Title', 'wp-architect-ai' ),
	'editor'          => __( 'Editor', 'wp-architect-ai' ),
	'author'          => __( 'Author', 'wp-architect-ai' ),
	'thumbnail'       => __( 'Thumbnail', 'wp-architect-ai' ),
	'excerpt'         => __( 'Excerpt', 'wp-architect-ai' ),
	'trackbacks'      => __( 'Trackbacks', 'wp-architect-ai' ),
	'custom-fields'   => __( 'Custom fields', 'wp-architect-ai' ),
	'comments'        => __( 'Comments', 'wp-architect-ai' ),
	'revisions'       => __( 'Revisions', 'wp-architect-ai' ),
	'page-attributes' => __( 'Page attributes', 'wp-architect-ai' ),
	'post-formats'    => __( 'Post formats', 'wp-architect-ai' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Custom Post Type Generator', 'wp-architect-ai' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a post type and generate a PHP registration file for review.', 'wp-architect-ai' ); ?></p>
	<p><strong><?php echo esc_html__( 'Generated code is never executed or installed automatically. Review it before using it in your own project.', 'wp-architect-ai' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>

	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert">
			<p><strong><?php echo esc_html__( 'Please correct the following errors:', 'wp-architect-ai' ); ?></strong></p>
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
				<td><input class="regular-text" id="post_type_key" name="post_type_key" type="text" maxlength="20" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->post_type_key ); ?>" aria-describedby="post-type-key-description"><p class="description" id="post-type-key-description"><?php echo esc_html__( 'Required. One to 20 lowercase letters, numbers, underscores, or hyphens.', 'wp-architect-ai' ); ?></p></td>
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
				<td><input class="regular-text" id="rewrite_slug" name="rewrite_slug" type="text" value="<?php echo esc_attr( $configuration->rewrite_slug ); ?>"><p class="description"><?php echo esc_html__( 'Optional URL slug. It will be normalized with WordPress slug rules.', 'wp-architect-ai' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_icon"><?php echo esc_html__( 'Menu icon', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="menu_icon" name="menu_icon" type="text" value="<?php echo esc_attr( $configuration->menu_icon ); ?>"><p class="description"><?php echo esc_html__( 'Enter a Dashicons class such as dashicons-admin-post.', 'wp-architect-ai' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_position"><?php echo esc_html__( 'Menu position', 'wp-architect-ai' ); ?></label></th>
				<td><input class="small-text" id="menu_position" name="menu_position" type="number" min="0" step="1" value="<?php echo esc_attr( $configuration->menu_position ); ?>"><p class="description"><?php echo esc_html__( 'Optional whole-number position in the WordPress admin menu.', 'wp-architect-ai' ); ?></p></td>
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
		<?php submit_button( __( 'Generate PHP', 'wp-architect-ai' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=wp-architect-ai-cpt-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'wp-architect-ai' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'wp-architect-ai' ); ?></h2>
		<textarea id="wp-architect-ai-generated-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated PHP code', 'wp-architect-ai' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
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
