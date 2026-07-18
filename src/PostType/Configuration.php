<?php
/**
 * Custom post type configuration.
 *
 * @package PratapMaity\WPArchitectAI
 */

namespace PratapMaity\WPArchitectAI\PostType;

/**
 * Immutable sanitized custom post type configuration.
 */
final class Configuration {
	/**
	 * Whether the post type is public.
	 *
	 * @var bool
	 */
	public readonly bool $public;

	/**
	 * Constructor.
	 *
	 * @param string        $post_type_key Post type key.
	 * @param string        $singular_label Singular label.
	 * @param string        $plural_label Plural label.
	 * @param string        $description Description.
	 * @param bool          $is_public Whether the post type is public.
	 * @param bool          $publicly_queryable Whether front-end queries are allowed.
	 * @param bool          $show_ui Whether to show an admin UI.
	 * @param bool          $show_in_menu Whether to show the post type in the admin menu.
	 * @param bool          $show_in_rest Whether to expose the post type through REST.
	 * @param bool          $hierarchical Whether the post type is hierarchical.
	 * @param bool          $has_archive Whether the post type has an archive.
	 * @param bool          $exclude_from_search Whether to exclude the post type from search.
	 * @param string        $rewrite_slug Rewrite slug.
	 * @param string        $menu_icon Dashicon class or icon URL.
	 * @param string        $menu_position Menu position input.
	 * @param array<string> $supports Supported editor features.
	 */
	public function __construct(
		public readonly string $post_type_key,
		public readonly string $singular_label,
		public readonly string $plural_label,
		public readonly string $description,
		bool $is_public,
		public readonly bool $publicly_queryable,
		public readonly bool $show_ui,
		public readonly bool $show_in_menu,
		public readonly bool $show_in_rest,
		public readonly bool $hierarchical,
		public readonly bool $has_archive,
		public readonly bool $exclude_from_search,
		public readonly string $rewrite_slug,
		public readonly string $menu_icon,
		public readonly string $menu_position,
		public readonly array $supports
	) {
		$this->public = $is_public;
	}
}
