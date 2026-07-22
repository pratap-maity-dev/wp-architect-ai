<?php
/**
 * Plugin deactivation handling.
 *
 * @package PratapMaity\PMorixPTRG
 */

namespace PratapMaity\PMorixPTRG;

defined( 'ABSPATH' ) || exit;

/**
 * Handles plugin deactivation.
 */
final class Deactivator {

	/**
	 * Performs deactivation tasks.
	 *
	 * No persistent data or scheduled events exist in this foundation release.
	 *
	 * @return void
	 */
	public static function deactivate(): void {
		// Intentionally empty until the plugin owns resources that need cleanup.
	}
}
