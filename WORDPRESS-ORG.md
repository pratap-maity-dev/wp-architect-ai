# WordPress.org release process

Architect AI Code Generator is submitted as a complete ZIP whose top-level directory is
`architect-ai-code-generator`. The Composer production autoloader is included, so users do
not need Composer after installation.

Before submission:

1. Update `Version` and `WP_ARCHITECT_AI_VERSION` in `architect-ai-code-generator.php`.
2. Set the same version in `readme.txt` under `Stable tag` and add its changelog.
3. Update `Tested up to` after testing with the latest WordPress release.
4. Run PHP syntax checks, PHPCS, PHPUnit, and WordPress Plugin Check.
5. Build the ZIP from a clean commit:

   `git archive --format=zip --prefix=architect-ai-code-generator/ --output=architect-ai-code-generator.zip HEAD`

6. Install the ZIP on a clean WordPress site and test activation, all generator
   pages, validation, clipboard behavior, and generated-file downloads.

After approval, publish releases through the WordPress.org Subversion repository
using `trunk/` and a matching version directory under `tags/`. Directory artwork
belongs in the SVN repository's top-level `assets/` directory, not plugin trunk.
