# YourMark Coding Standards

One PHPCS ruleset and one PHPStan config, shared by every YourMark PHP project.
Projects pin a version, so tightening a rule never breaks a project that hasn't opted in.

## What's in it

| File | What it is |
|---|---|
| `YourMark/ruleset.xml` | PHPCS standard `YourMark`: WordPress Coding Standards plus the house exceptions below |
| `phpstan/wordpress.neon` | PHPStan defaults: level 7, WordPress stubs, `treatPhpDocTypesAsCertain: false` |

House exceptions to WPCS:

- Short arrays `[]` are **required**; `array()` is an error.
- Non-Yoda conditions (`$a === 'b'`) are **required**.
- PSR-4 PascalCase filenames (`Plugin.php`) are allowed.
- Hook names may use slashes (`vendor/location/name`).
- PHPStan-style generic types in docblocks are allowed.
- Under `tests/`: no function docblocks required, and stubs may group several classes and functions in one file.

Requiring this package also installs PHPCS, WPCS, PHPStan and `szepeviktor/phpstan-wordpress`,
so a project doesn't require those itself.

## Install

The package isn't on Packagist, so add the GitHub repository first:

```json
{
  "repositories": [
    { "type": "vcs", "url": "https://github.com/YourMark/coding-standards" }
  ],
  "require-dev": {
    "yourmark/coding-standards": "^1.0"
  },
  "config": {
    "allow-plugins": {
      "dealerdirect/phpcodesniffer-composer-installer": true,
      "phpstan/extension-installer": true
    }
  }
}
```

Then remove `squizlabs/php_codesniffer`, `wp-coding-standards/wpcs`, `phpstan/phpstan`,
`phpstan/extension-installer` and `szepeviktor/phpstan-wordpress` from the project's own `require-dev`.

## Use

`phpcs.xml.dist` keeps only what belongs to that project:

```xml
<?xml version="1.0"?>
<ruleset name="My Plugin">
	<file>.</file>
	<exclude-pattern>*/assets/build/*</exclude-pattern>

	<rule ref="YourMark"/>

	<!-- Project-specific settings. -->
	<config name="minimum_wp_version" value="6.9"/>
	<rule ref="WordPress.WP.I18n">
		<properties>
			<property name="text_domain" type="array" value="my-plugin"/>
		</properties>
	</rule>
</ruleset>
```

`phpstan.neon` includes the shared defaults and adds paths, bootstraps and ignores:

```neon
includes:
	- vendor/yourmark/coding-standards/phpstan/wordpress.neon

parameters:
	phpVersion: 80100
	paths:
		- src/
	bootstrapFiles:
		- phpstan-bootstrap.php
```

Anything the project sets overrides the shared value, for example `level: 5` while bringing
an older codebase up to standard.

## Versioning

Tags follow semver, judged from the point of view of a project that is passing today:

| Bump | When |
|---|---|
| **Major** | A passing project could now fail: a new sniff, a removed exception, a higher PHPStan level, a new major of PHPCS/WPCS/PHPStan, a higher minimum PHP |
| **Minor** | Rules only get looser, or new opt-in files are added (for example a second ruleset) |
| **Patch** | Docs, CI, or fixes that don't change results |

So `^1.0` never turns a green project red. Upgrading a project to `^2.0` is a deliberate step,
done in its own PR together with the fixes it needs.

To keep an older project on an older line while it is still maintained, branch from its last
tag (`1.x`) and tag fixes there (`1.4.1`).

## Release

1. Update `CHANGELOG.md`.
2. Tag and push: `git tag 1.1.0 && git push origin 1.1.0`.
3. In a project: `composer update yourmark/coding-standards`.

## Develop

```bash
composer install
composer test   # pass.php must be clean, fail.php must fail, PHPStan config must load
```
