# Playground: Lead API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-lead-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-lead-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-lead-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-level%2010-brightgreen)](.github/workflows/ci.yml#L128)

Playground: Lead API

This package provides an API without UI for interacting with the [Playground: Lead](https://github.com/gammamatrix/playground-lead), a model package for Laravel.

If you need a JSON API with a UI, then have a look at [Playground: Lead Resource.](https://github.com/gammamatrix/playground-lead-resource)

## Documentation

Read more on using [Playground: Lead API at Read the Docs: Playground Documentation](https://gammamatrix-playground.readthedocs.io/en/develop/built-components/lead.html)

### Postman

A postman collection is provided in the repository: [postman-playground-lead-api.json.](postman-playground-lead-api.json)
- This same collection is viewable on the [.]()

### OpenAPI

This application provides OpenAPI documentation: [openapi.yaml](openapi.yaml).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the Playground: Lead API API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.yaml](openapi.yaml) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-lead-api/develop/openapi.yaml)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-lead-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-lead-api.png" alt="screenshot of artisan about command with Playground: Lead API."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Lead\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via environment variable or the configuration.

See the contents of the published config file: [config/playground-lead-api.php](config/playground-lead-api.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Lead\Api\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-lead-api`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-lead-api.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-lead-api/wiki/Environment-Variables)

## Migrations

This package requires the migrations in [playground-lead](https://github.com/gammamatrix/playground-lead) a Laravel package.

## Cloc

```sh
composer cloc
```

```
➜  playground-lead-api git:(develop) ✗ composer cloc
     800 text files.
     784 unique files.
      17 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.21 s (3773.3 files/s, 365856.9 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
YAML                           114              5              0          31277
JSON                           335              0              0          21046
PHP                            321           3006           3957          15434
XML                             10              0              7           1087
Markdown                         3             55              1            127
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           784           3069           3965          68983
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

Run unit tests:
```sh
composer test
```

Run unit and feature tests:
```sh
composer test-dev
```

Run unit and feature tests in parallel:
```sh
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
