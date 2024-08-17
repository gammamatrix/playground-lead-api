# Playground: Lead API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-lead-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-lead-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-lead-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground: Lead API package.

## Documentation

### Swagger

This application provides Swagger documentation: [swagger.json](swagger.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

Swagger API Documentation is built with npm.
- npm is only needed to generate documentation and is not needed to operate the Lead API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [swagger.json](swagger.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [swagger.json on the Swagger Editor UI.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-lead-api/develop/swagger.json)
- Preview [swagger.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-lead-api/develop/swagger.json)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-lead-api
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/playground-lead-api.php](config/playground-lead-api.php)

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Playground\Lead\Api\ServiceProvider" --tag="playground-config"
```

## Cloc

```sh
composer cloc
```

```
➜  playground-lead-api git:(feature/GH-1) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
     618 text files.
     446 unique files.
     173 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.61 s (725.4 files/s, 117450.6 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                             5              0              0          35543
PHP                            322           2433           3998          16335
YAML                           112              5              0          13544
XML                              3              0              7            215
Markdown                         3             37              0             85
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           446           2478           4005          65734
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 9 on:
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

```sh
composer test --parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
