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

$architect_ai_code_generator_boolean_fields = array(
	'public'              => __( 'Public', 'architect-ai-code-generator' ),
	'publicly_queryable'  => __( 'Publicly queryable', 'architect-ai-code-generator' ),
	'show_ui'             => __( 'Show UI', 'architect-ai-code-generator' ),
	'show_in_menu'        => __( 'Show in menu', 'architect-ai-code-generator' ),
	'show_in_rest'        => __( 'Show in REST', 'architect-ai-code-generator' ),
	'hierarchical'        => __( 'Hierarchical', 'architect-ai-code-generator' ),
	'has_archive'         => __( 'Has archive', 'architect-ai-code-generator' ),
	'exclude_from_search' => __( 'Exclude from search', 'architect-ai-code-generator' ),
);
$architect_ai_code_generator_support_fields = array(
	'title'           => __( 'Title', 'architect-ai-code-generator' ),
	'editor'          => __( 'Editor', 'architect-ai-code-generator' ),
	'author'          => __( 'Author', 'architect-ai-code-generator' ),
	'thumbnail'       => __( 'Thumbnail', 'architect-ai-code-generator' ),
	'excerpt'         => __( 'Excerpt', 'architect-ai-code-generator' ),
	'trackbacks'      => __( 'Trackbacks', 'architect-ai-code-generator' ),
	'custom-fields'   => __( 'Custom fields', 'architect-ai-code-generator' ),
	'comments'        => __( 'Comments', 'architect-ai-code-generator' ),
	'revisions'       => __( 'Revisions', 'architect-ai-code-generator' ),
	'page-attributes' => __( 'Page attributes', 'architect-ai-code-generator' ),
	'post-formats'    => __( 'Post formats', 'architect-ai-code-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Custom Post Type Generator', 'architect-ai-code-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a post type and generate a PHP registration file for review.', 'architect-ai-code-generator' ); ?></p>
	<p><strong><?php echo esc_html__( 'Generated code is never executed or installed automatically. Review it before using it in your own project.', 'architect-ai-code-generator' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>

	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert">
			<p><strong><?php echo esc_html__( 'Please correct the following errors:', 'architect-ai-code-generator' ); ?></strong></p>
			<ul>
				<?php foreach ( $errors as $architect_ai_code_generator_error ) : ?>
					<li><?php echo esc_html( $architect_ai_code_generator_error ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'wp_architect_ai_generate_cpt' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_cpt">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="post_type_key"><?php echo esc_html__( 'Post type key', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="post_type_key" name="post_type_key" type="text" maxlength="20" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->post_type_key ); ?>" aria-describedby="post-type-key-description"><p class="description" id="post-type-key-description"><?php echo esc_html__( 'Required. One to 20 lowercase letters, numbers, underscores, or hyphens.', 'architect-ai-code-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="singular_label"><?php echo esc_html__( 'Singular label', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="singular_label" name="singular_label" type="text" required value="<?php echo esc_attr( $configuration->singular_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="plural_label"><?php echo esc_html__( 'Plural label', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="plural_label" name="plural_label" type="text" required value="<?php echo esc_attr( $configuration->plural_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="description"><?php echo esc_html__( 'Description', 'architect-ai-code-generator' ); ?></label></th>
				<td><textarea class="large-text" id="description" name="description" rows="4"><?php echo esc_textarea( $configuration->description ); ?></textarea></td>
			</tr>
			<?php foreach ( $architect_ai_code_generator_boolean_fields as $architect_ai_code_generator_field => $architect_ai_code_generator_label ) : ?>
				<tr>
					<th scope="row"><?php echo esc_html( $architect_ai_code_generator_label ); ?></th>
					<td><label><input name="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>" type="checkbox" value="1" <?php checked( $configuration->{$architect_ai_code_generator_field} ); ?>> <?php echo esc_html__( 'Enabled', 'architect-ai-code-generator' ); ?></label></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<th scope="row"><label for="rewrite_slug"><?php echo esc_html__( 'Rewrite slug', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="rewrite_slug" name="rewrite_slug" type="text" value="<?php echo esc_attr( $configuration->rewrite_slug ); ?>"><p class="description"><?php echo esc_html__( 'Optional URL slug. It will be normalized with WordPress slug rules.', 'architect-ai-code-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_icon"><?php echo esc_html__( 'Menu icon', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="menu_icon" name="menu_icon" type="text" value="<?php echo esc_attr( $configuration->menu_icon ); ?>"><p class="description"><?php echo esc_html__( 'Enter a Dashicons class such as dashicons-admin-post.', 'architect-ai-code-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_position"><?php echo esc_html__( 'Menu position', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="small-text" id="menu_position" name="menu_position" type="number" min="0" step="1" value="<?php echo esc_attr( $configuration->menu_position ); ?>"><p class="description"><?php echo esc_html__( 'Optional whole-number position in the WordPress admin menu.', 'architect-ai-code-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><?php echo esc_html__( 'Supports', 'architect-ai-code-generator' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Supported editor features', 'architect-ai-code-generator' ); ?></legend>
						<?php foreach ( $architect_ai_code_generator_support_fields as $architect_ai_code_generator_support => $architect_ai_code_generator_support_label ) : ?>
							<label><input name="supports[]" type="checkbox" value="<?php echo esc_attr( $architect_ai_code_generator_support ); ?>" <?php checked( in_array( $architect_ai_code_generator_support, $configuration->supports, true ) ); ?>> <?php echo esc_html( $architect_ai_code_generator_support_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'architect-ai-code-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=architect-ai-code-generator-cpt-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'architect-ai-code-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'architect-ai-code-generator' ); ?></h2>
		<textarea id="architect-ai-code-generator-generated-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated PHP code', 'architect-ai-code-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="architect-ai-code-generator-copy-code" data-architect-ai-code-generator-copy data-target="architect-ai-code-generator-generated-code" data-status="architect-ai-code-generator-copy-status"><?php echo esc_html__( 'Copy to clipboard', 'architect-ai-code-generator' ); ?></button>
			<span id="architect-ai-code-generator-copy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_cpt' ); ?>
			<input type="hidden" name="action" value="wp_architect_ai_download_cpt">
			<?php foreach ( get_object_vars( $configuration ) as $architect_ai_code_generator_field => $architect_ai_code_generator_value ) : ?>
				<?php if ( is_array( $architect_ai_code_generator_value ) ) : ?>
					<?php foreach ( $architect_ai_code_generator_value as $architect_ai_code_generator_item ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>[]" value="<?php echo esc_attr( $architect_ai_code_generator_item ); ?>">
					<?php endforeach; ?>
				<?php elseif ( is_bool( $architect_ai_code_generator_value ) ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>" value="<?php echo $architect_ai_code_generator_value ? '1' : '0'; ?>">
				<?php else : ?>
					<input type="hidden" name="<?php echo esc_attr( $architect_ai_code_generator_field ); ?>" value="<?php echo esc_attr( $architect_ai_code_generator_value ); ?>">
				<?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'architect-ai-code-generator' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
