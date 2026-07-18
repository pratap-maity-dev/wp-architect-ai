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
	 * @param bool          $hierarchical Whether the post type is hierarchical.
	 * @param bool          $show_ui Whether to show an admin UI.
	 * @param bool          $show_in_rest Whether to expose the post type through REST.
	 * @param bool          $has_archive Whether the post type has an archive.
	 * @param string        $rewrite_slug Rewrite slug.
	 * @param string        $menu_icon Dashicon class or icon URL.
	 * @param array<string> $supports Supported editor features.
	 */
	public function __construct(
		public readonly string $post_type_key,
		public readonly string $singular_label,
		public readonly string $plural_label,
		public readonly string $description,
		bool $is_public,
		public readonly bool $hierarchical,
		public readonly bool $show_ui,
		public readonly bool $show_in_rest,
		public readonly bool $has_archive,
		public readonly string $rewrite_slug,
		public readonly string $menu_icon,
		public readonly array $supports
	) {
		$this->public = $is_public;
	}
}
