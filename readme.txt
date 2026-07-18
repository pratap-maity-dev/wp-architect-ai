=== Architect AI Code Generator ===
Contributors: pratapmaity
Tags: code generator, custom post types, taxonomy, rest api, developer tools
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 0.5.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Generate reviewable WordPress code for post types, taxonomies, and REST API endpoints without executing it.

== Description ==

Architect AI Code Generator is a WordPress developer productivity plugin. It includes Custom Post Type, Taxonomy, and REST API Endpoint Generators that produce reviewable and downloadable PHP files.

Configure an admin form, validate the settings, preview the generated PHP, copy it to the clipboard, or download it for review. Generated code is never executed or installed by the plugin and no theme or plugin files are modified.

= Included generators =

* Custom Post Type registration.
* Custom Taxonomy registration with associated post types.
* WordPress REST API endpoints with permissions, validated arguments, and safe response fields.

= Privacy =

Architect AI Code Generator does not collect personal data, contact external services, or use tracking. Form values and generated code are not stored by the plugin.

== Installation ==

1. Upload the Architect AI Code Generator ZIP through Plugins > Add New > Upload Plugin, or copy the `architect-ai-code-generator` directory into `/wp-content/plugins/`.
2. Activate Architect AI Code Generator through the Plugins screen in WordPress.
3. Open Architect AI Code Generator in the WordPress administration menu.

== Frequently Asked Questions ==

= Does this release connect to an AI service? =

No. AI API integration is not part of this foundation release.

= Where should I place generated code? =

Review and test the generated PHP in a staging environment, then add it to a custom plugin or another appropriate development project. Architect AI Code Generator does not install it for you.

= Does this release execute or install generated PHP code? =

No. It generates a text preview and downloadable file, but never executes the code or writes it into a theme or plugin.

== Changelog ==

= 0.5.0 =

* Renamed the plugin to Architect AI Code Generator for WordPress.org directory compatibility.
* Added a complete production Composer autoloader to the distributable plugin.
* Updated directory metadata, privacy information, installation guidance, and release packaging.
* Added direct-file access protection throughout runtime PHP files.

= 0.4.0 =

* Added the secure REST API Endpoint Generator with object-oriented controller output.
* Added strict namespace, route, method, authentication, query and response-field validation.
* Added pagination, search, taxonomy filtering, restricted meta filtering and optional caching output.
* Added secure preview, clipboard copying and streamed PHP downloads.
* Added REST generator security, sanitization, validation and code-generation tests.

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
* Added the original WP Architect AI administration dashboard.
* Added the Custom Post Type Generator with preview and secure download.
