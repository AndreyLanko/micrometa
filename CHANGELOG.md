# Changelog

All Notable changes to *jkphl/micrometa* will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [3.0.0] - Dendency update release 2018-12-25

### Changed

* Updated dependency versions ([#30](https://github.com/jkphl/micrometa/pull/30), [#31](https://github.com/jkphl/micrometa/pull/31))
* Bumped PHP version requirement to 7.1

### Fixed

* Microformats language parsing in accordance with [microformats/php-mf2#96](https://github.com/microformats/php-mf2/issues/96)

### [2.1.1] - Bugfix release 2018-12-15

### Fixed

* Add support for multiple JSON-LD documents ([#25](https://github.com/jkphl/micrometa/pull/25), [#28](https://github.com/jkphl/micrometa/issues/28))

## [2.1.0] - Feature release 2017-11-05

### Added

* Accessor for the internal DOM document

### [2.0.1] - Maintenance release 2017-06-14

### Fixed

* Updated faulty dom-document dependency

## [2.0.0] - Next generation release 2017-05-29

### Changed

* Complete rewrite using the [Clear Architecture](https://github.com/jkphl/clear-architecture)
* Improved JSON-LD parsing (#10)

### Added

* Support for nested Microformats (#15)
* Support for RDFa Lite 1.1 (#11)
* Support for logging & caching
* Tests for all formats (#7)
___

## v1.0.2: Feature release (2017-02-10)
1. Added support for JSON-LD value lists ([#10](https://github.com/jkphl/micrometa/issues/10))

## v1.0.1: Bugfix release (2017-01-04)
1. Fixed incorrect handling of relative base URLs ([#9](https://github.com/jkphl/micrometa/issues/9))

## v1.0.0: Feature release (2017-01-02)
1. JSON-LD support ([#6](https://github.com/jkphl/micrometa/issues/6))
2. Visually improved demo application

## v0.3.6: Bugfix release (2016-06-20)
1. Fixed broken Microdata parser code

## v0.3.5: Feature release (2016-06-20)
1. Added support for nested child microformats
2. Refactored to proper composer support (autoloading, etc.)

## v0.3.4: Maintenance release (2016-04-27)
1. Updated dependencies

## v0.3.3: Bugfix release (2015-11-17)
1. Changed detection of top-level Microdata items ([#3](https://github.com/jkphl/micrometa/issues/3))
2. Updated dependencies

## v0.3.2: Bugfix release (2015-08-18)
1. Updated dependencies & unit tests

## v0.3.1: Bugfix release (2015-05-10)
1. Fixed regression bug introduced by dependency removal

## v0.3.0: Feature release (2015-05-10)
1. Deprecated [Microdata parser](https://github.com/euskadi31/Microdata) dependency
2. Support for infinitely nested schema.org microdata

## v0.2.1: Bugfix release
1.	Fixed problem with camel-cased Microdata properties ([#1](https://github.com/jkphl/micrometa/issues/1))

## v0.2.0: IndieWebCamp authorship algorithm
1.	Implemented the [IndieWebCamp authorship algorithm](http://indiewebcamp.com/authorship)
2.	Added PHPUnit authorship tests
3.	Added Microformats 2 special features

## v0.1.0: Initial release (2013-12-14)
