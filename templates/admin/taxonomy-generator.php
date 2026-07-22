<?php
/**
 * Taxonomy generator form and preview.
 *
 * @var PratapMaity\PMorixPTRG\Taxonomy\Configuration $configuration Sanitized form configuration.
 * @var array<string>                                      $errors Validation errors.
 * @var string                                             $generated_code Generated PHP preview.
 * @var string                                             $success_message Success notice message.
 *
 * @package PratapMaity\PMorixPTRG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pmorix_ptrg_boolean_fields    = array(
	'public'               => __( 'Public', 'pmorix-post-type-taxonomy-rest-generator' ),
	'publicly_queryable'   => __( 'Publicly queryable', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_ui'              => __( 'Show UI', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_admin_column'    => __( 'Show admin column', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_in_rest'         => __( 'Show in REST', 'pmorix-post-type-taxonomy-rest-generator' ),
	'hierarchical'         => __( 'Hierarchical', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_tagcloud'        => __( 'Show tag cloud', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_in_quick_edit'   => __( 'Show in quick edit', 'pmorix-post-type-taxonomy-rest-generator' ),
	'rewrite_hierarchical' => __( 'Rewrite hierarchical', 'pmorix-post-type-taxonomy-rest-generator' ),
	'query_var'            => __( 'Query variable', 'pmorix-post-type-taxonomy-rest-generator' ),
);
$pmorix_ptrg_common_post_types = array(
	'post'      => __( 'Posts', 'pmorix-post-type-taxonomy-rest-generator' ),
	'page'      => __( 'Pages', 'pmorix-post-type-taxonomy-rest-generator' ),
	'product'   => __( 'Products', 'pmorix-post-type-taxonomy-rest-generator' ),
	'portfolio' => __( 'Portfolio', 'pmorix-post-type-taxonomy-rest-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Taxonomy Generator', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a taxonomy and generate a PHP registration file for review.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p>
	<p><strong><?php echo esc_html__( 'Generated code is never executed or installed automatically. Review it before using it in your own project.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong></p>

	<?php if ( '' !== $success_message ) : ?>
		<div class="notice notice-success is-dismissible" role="status"><p><?php echo esc_html( $success_message ); ?></p></div>
	<?php endif; ?>

	<?php if ( array() !== $errors ) : ?>
		<div class="notice notice-error" role="alert">
			<p><strong><?php echo esc_html__( 'Please correct the following errors:', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong></p>
			<ul>
				<?php foreach ( $errors as $pmorix_ptrg_error ) : ?>
					<li><?php echo esc_html( $pmorix_ptrg_error ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form method="post">
		<?php wp_nonce_field( 'pmorix_ptrg_generate_taxonomy', 'pmorix_ptrg_taxonomy_nonce' ); ?>
		<input type="hidden" name="pmorix_ptrg_action" value="pmorix_ptrg_generate_taxonomy">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="taxonomy_key"><?php echo esc_html__( 'Taxonomy key', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="taxonomy_key" name="taxonomy_key" type="text" maxlength="32" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->taxonomy_key ); ?>" aria-describedby="taxonomy-key-description"><p class="description" id="taxonomy-key-description"><?php echo esc_html__( 'Required. One to 32 lowercase letters, numbers, underscores, or hyphens.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="singular_label"><?php echo esc_html__( 'Singular label', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="singular_label" name="singular_label" type="text" required value="<?php echo esc_attr( $configuration->singular_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="plural_label"><?php echo esc_html__( 'Plural label', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="plural_label" name="plural_label" type="text" required value="<?php echo esc_attr( $configuration->plural_label ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><?php echo esc_html__( 'Associated post types', 'pmorix-post-type-taxonomy-rest-generator' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Common associated post types', 'pmorix-post-type-taxonomy-rest-generator' ); ?></legend>
						<?php foreach ( $pmorix_ptrg_common_post_types as $pmorix_ptrg_post_type => $pmorix_ptrg_post_type_label ) : ?>
							<label><input name="post_types[]" type="checkbox" value="<?php echo esc_attr( $pmorix_ptrg_post_type ); ?>" <?php checked( in_array( $pmorix_ptrg_post_type, $configuration->post_types, true ) ); ?>> <?php echo esc_html( $pmorix_ptrg_post_type_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
					<label for="custom_post_types"><strong><?php echo esc_html__( 'Custom post type keys', 'pmorix-post-type-taxonomy-rest-generator' ); ?></strong></label><br>
					<input class="regular-text" id="custom_post_types" name="custom_post_types" type="text" value="<?php echo esc_attr( $configuration->custom_post_types ); ?>" aria-describedby="custom-post-types-description">
					<p class="description" id="custom-post-types-description"><?php echo esc_html__( 'Optional comma- or space-separated keys. At least one common or custom post type is required.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="description"><?php echo esc_html__( 'Description', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><textarea class="large-text" id="description" name="description" rows="4"><?php echo esc_textarea( $configuration->description ); ?></textarea></td>
			</tr>
			<?php foreach ( $pmorix_ptrg_boolean_fields as $pmorix_ptrg_field => $pmorix_ptrg_label ) : ?>
				<tr>
					<th scope="row"><?php echo esc_html( $pmorix_ptrg_label ); ?></th>
					<td><label><input name="<?php echo esc_attr( $pmorix_ptrg_field ); ?>" type="checkbox" value="1" <?php checked( $configuration->{$pmorix_ptrg_field} ); ?>> <?php echo esc_html__( 'Enabled', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<th scope="row"><label for="rewrite_slug"><?php echo esc_html__( 'Rewrite slug', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="rewrite_slug" name="rewrite_slug" type="text" value="<?php echo esc_attr( $configuration->rewrite_slug ); ?>"><p class="description"><?php echo esc_html__( 'Optional URL slug. It will be normalized with WordPress slug rules.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td>
			</tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'pmorix-post-type-taxonomy-rest-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=pmorix_ptrg_taxonomy_generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'pmorix-post-type-taxonomy-rest-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h2>
		<textarea id="pmorix-post-type-taxonomy-rest-generator-generated-taxonomy-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated taxonomy PHP code', 'pmorix-post-type-taxonomy-rest-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="pmorix-post-type-taxonomy-rest-generator-copy-taxonomy-code" data-pmorix-ptrg-copy data-target="pmorix-post-type-taxonomy-rest-generator-generated-taxonomy-code" data-status="pmorix-post-type-taxonomy-rest-generator-copy-taxonomy-status"><?php echo esc_html__( 'Copy to clipboard', 'pmorix-post-type-taxonomy-rest-generator' ); ?></button>
			<span id="pmorix-post-type-taxonomy-rest-generator-copy-taxonomy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'pmorix_ptrg_download_taxonomy', 'pmorix_ptrg_taxonomy_nonce' ); ?>
			<input type="hidden" name="action" value="pmorix_ptrg_download_taxonomy">
			<?php foreach ( get_object_vars( $configuration ) as $pmorix_ptrg_field => $pmorix_ptrg_value ) : ?>
				<?php if ( is_array( $pmorix_ptrg_value ) ) : ?>
					<?php foreach ( $pmorix_ptrg_value as $pmorix_ptrg_item ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_field ); ?>[]" value="<?php echo esc_attr( $pmorix_ptrg_item ); ?>">
					<?php endforeach; ?>
				<?php elseif ( is_bool( $pmorix_ptrg_value ) ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_field ); ?>" value="<?php echo $pmorix_ptrg_value ? '1' : '0'; ?>">
				<?php else : ?>
					<input type="hidden" name="<?php echo esc_attr( $pmorix_ptrg_field ); ?>" value="<?php echo esc_attr( $pmorix_ptrg_value ); ?>">
				<?php endif; ?>
			<?php endforeach; ?>
			<?php submit_button( __( 'Download PHP file', 'pmorix-post-type-taxonomy-rest-generator' ), 'secondary', 'submit', false ); ?>
		</form>
	<?php endif; ?>
</div>
