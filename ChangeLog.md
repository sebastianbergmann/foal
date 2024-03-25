# ChangeLog

All notable changes are documented in this file using the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [0.4.0] - 2024-MM-DD

### Added

* `--paths` option to export execution paths before/after bytecode optimization in DOT format

### Changed

* The PHAR-specific CLI options `--manifest`, `--sbom`, and `--composer-lock` are now included in the help output

### Removed

* `--diff` option to display optimized-away lines as diff

## [0.3.0] - 2024-03-24

### Added

* Support for multiple arguments (directories and/or files)
* `--diff` option to display optimized-away lines as diff

### Changed

* [#3](https://github.com/sebastianbergmann/foal/issues/3): Refactor `Analyser` to operate on list of files

## [0.2.1] - 2024-03-24

* No functional changes

## [0.2.0] - 2024-03-24

### Removed

* This tool now requires PHP 8.3

## [0.1.0] - 2018-12-24

* Initial release

[0.4.0]: https://github.com/sebastianbergmann/foal/compare/0.3.0...main
[0.3.0]: https://github.com/sebastianbergmann/foal/compare/0.2.1...0.3.0
[0.2.1]: https://github.com/sebastianbergmann/foal/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/sebastianbergmann/foal/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/sebastianbergmann/foal/compare/820e0c5e988a5f8bf09f38211174bd481d8e5dd9...0.1.0
