=== WP Architect AI ===
Contributors: pratapmaity
Tags: developer tools, code generator, development
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.1
Stable tag: 0.3.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A foundation for generating secure, standards-compliant WordPress code from structured configuration.

== Description ==

WP Architect AI is a WordPress developer productivity plugin. It includes secure Custom Post Type and Taxonomy Generators that produce reviewable and downloadable PHP registration files.

External AI service integrations are not included. Generated code is displayed or downloaded only; the plugin does not execute it or modify theme or plugin files.

== Installation ==

1. Upload the `wp-architect-ai` directory to `/wp-content/plugins/`.
2. Run `composer install --no-dev --optimize-autoloader` inside the plugin directory before packaging or deployment.
3. Activate WP Architect AI through the Plugins screen in WordPress.
4. Open WP Architect AI in the WordPress administration menu.

== Frequently Asked Questions ==

= Does this release connect to an AI service? =

No. AI API integration is not part of this foundation release.

= Does this release execute or install generated PHP code? =

No. It generates a text preview and downloadable file, but never executes the code or writes it into a theme or plugin.

== Screenshots ==

1. The WP Architect AI administration dashboard.

== Changelog ==

= 0.3.0 =

* Added the secure Taxonomy Generator with common and custom post type associations.
* Added taxonomy sanitization, validation and complete registration code generation.
* Added secure taxonomy preview, clipboard copying and streamed PHP downloads.
* Added shared generated-file download and clipboard infrastructure.
* Added automated taxonomy validation, sanitization and code-generation tests.

= 0.2.0 =

* Expanded the Custom Post Type Generator with complete registration options and supports.
* Added strict sanitization, validation, capability and nonce protections.
* Added secure PHP preview, clipboard copying and streamed downloads.
* Added complete translation-ready labels and collision-safe callback names.
* Expanded automated validation, sanitization and code-generation tests.

= 0.1.0 =

* Added the initial plugin bootstrap and Composer autoloading.
* Added activation and deactivation handlers.
* Added the WP Architect AI administration dashboard.
* Added the Custom Post Type Generator with preview and secure download.
