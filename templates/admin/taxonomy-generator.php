<?php
/**
 * Taxonomy generator form and preview.
 *
 * @var PratapMaity\WPArchitectAI\Taxonomy\Configuration $configuration Sanitized form configuration.
 * @var array<string>                                      $errors Validation errors.
 * @var string                                             $generated_code Generated PHP preview.
 * @var string                                             $success_message Success notice message.
 *
 * @package PratapMaity\WPArchitectAI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$architect_ai_code_generator_boolean_fields    = array(
	'public'               => __( 'Public', 'architect-ai-code-generator' ),
	'publicly_queryable'   => __( 'Publicly queryable', 'architect-ai-code-generator' ),
	'show_ui'              => __( 'Show UI', 'architect-ai-code-generator' ),
	'show_admin_column'    => __( 'Show admin column', 'architect-ai-code-generator' ),
	'show_in_rest'         => __( 'Show in REST', 'architect-ai-code-generator' ),
	'hierarchical'         => __( 'Hierarchical', 'architect-ai-code-generator' ),
	'show_tagcloud'        => __( 'Show tag cloud', 'architect-ai-code-generator' ),
	'show_in_quick_edit'   => __( 'Show in quick edit', 'architect-ai-code-generator' ),
	'rewrite_hierarchical' => __( 'Rewrite hierarchical', 'architect-ai-code-generator' ),
	'query_var'            => __( 'Query variable', 'architect-ai-code-generator' ),
);
$architect_ai_code_generator_common_post_types = array(
	'post'      => __( 'Posts', 'architect-ai-code-generator' ),
	'page'      => __( 'Pages', 'architect-ai-code-generator' ),
	'product'   => __( 'Products', 'architect-ai-code-generator' ),
	'portfolio' => __( 'Portfolio', 'architect-ai-code-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Taxonomy Generator', 'architect-ai-code-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a taxonomy and generate a PHP registration file for review.', 'architect-ai-code-generator' ); ?></p>
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
		<?php wp_nonce_field( 'wp_architect_ai_generate_taxonomy' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_taxonomy">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="taxonomy_key"><?php echo esc_html__( 'Taxonomy key', 'architect-ai-code-generator' ); ?></label></th>
				<td><input class="regular-text" id="taxonomy_key" name="taxonomy_key" type="text" maxlength="32" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->taxonomy_key ); ?>" aria-describedby="taxonomy-key-description"><p class="description" id="taxonomy-key-description"><?php echo esc_html__( 'Required. One to 32 lowercase letters, numbers, underscores, or hyphens.', 'architect-ai-code-generator' ); ?></p></td>
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
				<th scope="row"><?php echo esc_html__( 'Associated post types', 'architect-ai-code-generator' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Common associated post types', 'architect-ai-code-generator' ); ?></legend>
						<?php foreach ( $architect_ai_code_generator_common_post_types as $architect_ai_code_generator_post_type => $architect_ai_code_generator_post_type_label ) : ?>
							<label><input name="post_types[]" type="checkbox" value="<?php echo esc_attr( $architect_ai_code_generator_post_type ); ?>" <?php checked( in_array( $architect_ai_code_generator_post_type, $configuration->post_types, true ) ); ?>> <?php echo esc_html( $architect_ai_code_generator_post_type_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
					<label for="custom_post_types"><strong><?php echo esc_html__( 'Custom post type keys', 'architect-ai-code-generator' ); ?></strong></label><br>
					<input class="regular-text" id="custom_post_types" name="custom_post_types" type="text" value="<?php echo esc_attr( $configuration->custom_post_types ); ?>" aria-describedby="custom-post-types-description">
					<p class="description" id="custom-post-types-description"><?php echo esc_html__( 'Optional comma- or space-separated keys. At least one common or custom post type is required.', 'architect-ai-code-generator' ); ?></p>
				</td>
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
		</table>
		<?php submit_button( __( 'Generate PHP', 'architect-ai-code-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=architect-ai-code-generator-taxonomy-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'architect-ai-code-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'architect-ai-code-generator' ); ?></h2>
		<textarea id="architect-ai-code-generator-generated-taxonomy-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated taxonomy PHP code', 'architect-ai-code-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="architect-ai-code-generator-copy-taxonomy-code" data-architect-ai-code-generator-copy data-target="architect-ai-code-generator-generated-taxonomy-code" data-status="architect-ai-code-generator-copy-taxonomy-status"><?php echo esc_html__( 'Copy to clipboard', 'architect-ai-code-generator' ); ?></button>
			<span id="architect-ai-code-generator-copy-taxonomy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_taxonomy' ); ?>
			<input type="hidden" name="action" value="wp_architect_ai_download_taxonomy">
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
