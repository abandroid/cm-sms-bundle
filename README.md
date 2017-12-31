# CM SMS Bundle

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/cm-sms-bundle.svg)](https://packagist.org/packages/endroid/cm-sms-bundle)
[![Build Status](http://img.shields.io/travis/endroid/cm-sms-bundle.svg)](http://travis-ci.org/endroid/cm-sms-bundle)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/cm-sms-bundle.svg)](https://packagist.org/packages/endroid/cm-sms-bundle)
[![Monthly Downloads](http://img.shields.io/packagist/dm/endroid/cm-sms-bundle.svg)](https://packagist.org/packages/endroid/cm-sms-bundle)
[![License](http://img.shields.io/packagist/l/endroid/cm-sms-bundle.svg)](https://packagist.org/packages/endroid/cm-sms-bundle)

This Symfony bundle enables sending SMS messages using the [CM Telecom SMS service](https://docs.cmtelecom.com/).

## Installation

Use [Composer](https://getcomposer.org/) to install the library. Symfony Flex
will set up the configuration and routing for you.

``` bash
$ composer require endroid/cm-sms-bundle
```

Now you can access the SMS dashboard via /cm-sms/dashboard and the SMS client
will be exposed as a service.

## Development

The production version makes use of built assets. When you make changes to the
assets use the following commands to install assets and create a new build.

``` bash
yarn
yarn build
```

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatibility
breaking changes will be kept to a minimum but be aware that these can occur.
Lock your dependencies for production and test your code when upgrading.

## License

This source code is subject to the MIT license bundled in the file LICENSE.