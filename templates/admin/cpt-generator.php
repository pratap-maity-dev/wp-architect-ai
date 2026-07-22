<?php
/**
 * Custom post type generator form and preview.
 *
 * @var PratapMaity\PMorixPTRG\PostType\Configuration $configuration Sanitized form configuration.
 * @var array<string>                                      $errors Validation errors.
 * @var string                                             $generated_code Generated PHP preview.
 * @var string                                             $success_message Success notice message.
 *
 * @package PratapMaity\PMorixPTRG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pmorix_ptrg_boolean_fields = array(
	'public'              => __( 'Public', 'pmorix-post-type-taxonomy-rest-generator' ),
	'publicly_queryable'  => __( 'Publicly queryable', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_ui'             => __( 'Show UI', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_in_menu'        => __( 'Show in menu', 'pmorix-post-type-taxonomy-rest-generator' ),
	'show_in_rest'        => __( 'Show in REST', 'pmorix-post-type-taxonomy-rest-generator' ),
	'hierarchical'        => __( 'Hierarchical', 'pmorix-post-type-taxonomy-rest-generator' ),
	'has_archive'         => __( 'Has archive', 'pmorix-post-type-taxonomy-rest-generator' ),
	'exclude_from_search' => __( 'Exclude from search', 'pmorix-post-type-taxonomy-rest-generator' ),
);
$pmorix_ptrg_support_fields = array(
	'title'           => __( 'Title', 'pmorix-post-type-taxonomy-rest-generator' ),
	'editor'          => __( 'Editor', 'pmorix-post-type-taxonomy-rest-generator' ),
	'author'          => __( 'Author', 'pmorix-post-type-taxonomy-rest-generator' ),
	'thumbnail'       => __( 'Thumbnail', 'pmorix-post-type-taxonomy-rest-generator' ),
	'excerpt'         => __( 'Excerpt', 'pmorix-post-type-taxonomy-rest-generator' ),
	'trackbacks'      => __( 'Trackbacks', 'pmorix-post-type-taxonomy-rest-generator' ),
	'custom-fields'   => __( 'Custom fields', 'pmorix-post-type-taxonomy-rest-generator' ),
	'comments'        => __( 'Comments', 'pmorix-post-type-taxonomy-rest-generator' ),
	'revisions'       => __( 'Revisions', 'pmorix-post-type-taxonomy-rest-generator' ),
	'page-attributes' => __( 'Page attributes', 'pmorix-post-type-taxonomy-rest-generator' ),
	'post-formats'    => __( 'Post formats', 'pmorix-post-type-taxonomy-rest-generator' ),
);
?>
<div class="wrap">
	<h1><?php echo esc_html__( 'Custom Post Type Generator', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h1>
	<p><?php echo esc_html__( 'Configure a post type and generate a PHP registration file for review.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p>
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
		<?php wp_nonce_field( 'pmorix_ptrg_generate_cpt', 'pmorix_ptrg_cpt_nonce' ); ?>
		<input type="hidden" name="pmorix_ptrg_action" value="pmorix_ptrg_generate_cpt">
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="post_type_key"><?php echo esc_html__( 'Post type key', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="post_type_key" name="post_type_key" type="text" maxlength="20" pattern="[a-z0-9_-]+" required value="<?php echo esc_attr( $configuration->post_type_key ); ?>" aria-describedby="post-type-key-description"><p class="description" id="post-type-key-description"><?php echo esc_html__( 'Required. One to 20 lowercase letters, numbers, underscores, or hyphens.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td>
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
			<tr>
				<th scope="row"><label for="menu_icon"><?php echo esc_html__( 'Menu icon', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="regular-text" id="menu_icon" name="menu_icon" type="text" value="<?php echo esc_attr( $configuration->menu_icon ); ?>"><p class="description"><?php echo esc_html__( 'Enter a Dashicons class such as dashicons-admin-post.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label for="menu_position"><?php echo esc_html__( 'Menu position', 'pmorix-post-type-taxonomy-rest-generator' ); ?></label></th>
				<td><input class="small-text" id="menu_position" name="menu_position" type="number" min="0" step="1" value="<?php echo esc_attr( $configuration->menu_position ); ?>"><p class="description"><?php echo esc_html__( 'Optional whole-number position in the WordPress admin menu.', 'pmorix-post-type-taxonomy-rest-generator' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><?php echo esc_html__( 'Supports', 'pmorix-post-type-taxonomy-rest-generator' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php echo esc_html__( 'Supported editor features', 'pmorix-post-type-taxonomy-rest-generator' ); ?></legend>
						<?php foreach ( $pmorix_ptrg_support_fields as $pmorix_ptrg_support => $pmorix_ptrg_support_label ) : ?>
							<label><input name="supports[]" type="checkbox" value="<?php echo esc_attr( $pmorix_ptrg_support ); ?>" <?php checked( in_array( $pmorix_ptrg_support, $configuration->supports, true ) ); ?>> <?php echo esc_html( $pmorix_ptrg_support_label ); ?></label><br>
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php submit_button( __( 'Generate PHP', 'pmorix-post-type-taxonomy-rest-generator' ), 'primary', 'submit', false ); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=pmorix_ptrg_cpt_generator' ) ); ?>"><?php echo esc_html__( 'Reset form', 'pmorix-post-type-taxonomy-rest-generator' ); ?></a>
	</form>

	<?php if ( '' !== $generated_code ) : ?>
		<h2><?php echo esc_html__( 'Generated code preview', 'pmorix-post-type-taxonomy-rest-generator' ); ?></h2>
		<textarea id="pmorix-post-type-taxonomy-rest-generator-generated-code" class="large-text code" rows="30" readonly aria-label="<?php echo esc_attr__( 'Generated PHP code', 'pmorix-post-type-taxonomy-rest-generator' ); ?>"><?php echo esc_textarea( $generated_code ); ?></textarea>
		<p>
			<button type="button" class="button" id="pmorix-post-type-taxonomy-rest-generator-copy-code" data-pmorix-ptrg-copy data-target="pmorix-post-type-taxonomy-rest-generator-generated-code" data-status="pmorix-post-type-taxonomy-rest-generator-copy-status"><?php echo esc_html__( 'Copy to clipboard', 'pmorix-post-type-taxonomy-rest-generator' ); ?></button>
			<span id="pmorix-post-type-taxonomy-rest-generator-copy-status" role="status" aria-live="polite"></span>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'pmorix_ptrg_download_cpt', 'pmorix_ptrg_cpt_nonce' ); ?>
			<input type="hidden" name="action" value="pmorix_ptrg_download_cpt">
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
