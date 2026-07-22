<?php
/**
 * Taxonomy configuration.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG\Taxonomy;

defined( 'ABSPATH' ) || exit;

/**
 * Immutable sanitized taxonomy configuration.
 */
final class Configuration {
	/**
	 * Whether the taxonomy is public.
	 *
	 * @var bool
	 */
	public readonly bool $public;

	/**
	 * Constructor.
	 *
	 * @param string        $taxonomy_key Taxonomy key.
	 * @param string        $singular_label Singular label.
	 * @param string        $plural_label Plural label.
	 * @param array<string> $post_types Associated post type keys.
	 * @param string        $custom_post_types Manually entered post type keys.
	 * @param string        $description Description.
	 * @param bool          $is_public Whether the taxonomy is public.
	 * @param bool          $publicly_queryable Whether front-end queries are allowed.
	 * @param bool          $show_ui Whether to show an admin UI.
	 * @param bool          $show_admin_column Whether to show an admin column.
	 * @param bool          $show_in_rest Whether to expose the taxonomy through REST.
	 * @param bool          $hierarchical Whether the taxonomy is hierarchical.
	 * @param bool          $show_tagcloud Whether to show the tag cloud widget.
	 * @param bool          $show_in_quick_edit Whether to show the taxonomy in quick edit.
	 * @param string        $rewrite_slug Rewrite slug.
	 * @param bool          $rewrite_hierarchical Whether rewrite URLs are hierarchical.
	 * @param bool          $query_var Whether to enable the query variable.
	 */
	public function __construct(
		public readonly string $taxonomy_key,
		public readonly string $singular_label,
		public readonly string $plural_label,
		public readonly array $post_types,
		public readonly string $custom_post_types,
		public readonly string $description,
		bool $is_public,
		public readonly bool $publicly_queryable,
		public readonly bool $show_ui,
		public readonly bool $show_admin_column,
		public readonly bool $show_in_rest,
		public readonly bool $hierarchical,
		public readonly bool $show_tagcloud,
		public readonly bool $show_in_quick_edit,
		public readonly string $rewrite_slug,
		public readonly bool $rewrite_hierarchical,
		public readonly bool $query_var
	) {
		$this->public = $is_public;
	}
}
