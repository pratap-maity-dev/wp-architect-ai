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

$wp_architect_ai_boolean_fields    = array(
	'public'               => __( 'Public', 'wp-architect-ai' ),
	'publicly_queryable'   => __( 'Publicly queryable', 'wp-architect-ai' ),
	'show_ui'              => __( 'Show UI', 'wp-architect-ai' ),
	'show_admin_column'    => __( 'Show admin column', 'wp-architect-ai' ),
	'show_in_rest'         => __( 'Show in REST', 'wp-architect-ai' ),
	'hierarchical'         => __( 'Hierarchical', 'wp-architect-ai' ),
	'show_tagcloud'        => __( 'Show tag cloud', 'wp-architect-ai' ),
	'show_in_quick_edit'   => __( 'Show in quick edit', 'wp-architect-ai' ),
	'rewrite_hierarchical' => __( 'Rewrite hierarchical', 'wp-architect-ai' ),
	'query_var'            => __( 'Query variable', 'wp-architect-ai' ),
);
$wp_architect_ai_common_post_types = array(
	'post'      => __( 'Posts', 'wp-architect-ai' ),
	'page'      => __( 'Pages', 'wp-architect-ai' ),
	'product'   => __( 'Products', 'wp-architect-ai' ),
	'portfolio' => __( 'Portfolio', 'wp-architect-ai' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Taxonomy Generator', 'wp-architect-ai' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a taxonomy and generate a PHP registration file for review.', 'wp-architect-ai' ); ?></p>
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
		<?php wp_nonce_field( 'wp_architect_ai_generate_taxonomy' ); ?>
		<input type="hidden" name="wp_architect_ai_action" value="wp_architect_ai_generate_taxonomy">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="taxonomy_key"><?php echo esc_html__( 'Taxonomy key', 'wp-architect-ai' ); ?></label></th>
				<td><input class="regular-text" id="taxonomy_key" name="taxonomy_key" type="text" maxlength="32" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->taxonomy_key ); ?>" aria-describedby="taxonomy-key-description"><p class="description" id="taxonomy-key-description"><?php echo esc_html__( 'Required. One to 32 lowercase letters, numbers, underscores, or hyphens.', 'wp-architect-ai' ); ?></p></td>
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
				<th scope="row"><?php echo esc_html__( 'Associated post types', 'wp-architect-ai' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Common associated post types', 'wp-architect-ai' ); ?></legend>
						<?php foreach ( $wp_architect_ai_common_post_types as $wp_architect_ai_post_type => $wp_architect_ai_post_type_label ) : ?>
							<label><input name="post_types[]" type="checkbox" value="<?php echo esc_attr( $wp_architect_ai_post_type ); ?>" <?php checked( in_array( $wp_architect_ai_post_type, $configuration->post_types, true ) ); ?>> <?php echo esc_html( $wp_architect_ai_post_type_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
					<label for="custom_post_types"><strong><?php echo esc_html__( 'Custom post type keys', 'wp-architect-ai' ); ?></strong></label><br>
					<input class="regular-text" id="custom_post_types" name="custom_post_types" type="text" value="<?php echo esc_attr( $configuration->custom_post_types ); ?>" aria-describedby="custom-post-types-description">
					<p class="description" id="custom-post-types-description"><?php echo esc_html__( 'Optional comma- or space-separated keys. At least one common or custom post type is required.', 'wp-architect-ai' ); ?></p>
				</td>
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
		</table>
		<?php submit_button( __( 'Generate PHP', 'wp-architect-ai' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=wp-architect-ai-taxonomy-generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'wp-architect-ai' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'wp-architect-ai' ); ?></h2>
		<textarea id="wp-architect-ai-generated-taxonomy-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated taxonomy PHP code', 'wp-architect-ai' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="wp-architect-ai-copy-taxonomy-code" data-wp-architect-ai-copy data-target="wp-architect-ai-generated-taxonomy-code" data-status="wp-architect-ai-copy-taxonomy-status"><?php echo esc_html__( 'Copy to clipboard', 'wp-architect-ai' ); ?></button>
			<span id="wp-architect-ai-copy-taxonomy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'wp_architect_ai_download_taxonomy' ); ?>
			<input type="hidden" name="action" value="wp_architect_ai_download_taxonomy">
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
