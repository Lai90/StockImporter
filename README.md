# Stock Importer

[![Build Status](https://travis-ci.org/Lai90/StockImporter.svg?branch=master)](https://travis-ci.org/Lai90/StockImporter)

Imports GPW (Warsaw Stock Exchange) stock rates from Bossa.pl.

  - Can import todays stock rates as well as historic rates
  - Saves rates to Firebase database

### Tech

Stock Importer uses a number of open source projects to work properly:

* [PhpMoney] - PHP implementation of Fowler's Money pattern
* [PhpSpec] - SpecBDD Framework for PHP
* [PhpUnit] - Unit Testing Framework for PHP
* [Firebase PHP] - Firebase PHP SDK
* [RespectValidation] - Validation library
* [Monolog] - Logging library

### Installation

Stock Importer requires [composer](https://getcomposer.org/) to install.

Install the dependencies.

```sh
$ cd stock-importer
$ composer install
```

Get application configuration from Firebase and place it in 
```sh
{project_root}/firebase_credentials.json
```

### Usage

##### Today Stock Rates
To import todays stock rates to Firebase database run:
```sh
$ php Run.php
```
##### Historic Stock Rates
To import historic stock rates first download files from
```
http://bossa.pl/pub/metastock/mstock/mstall.zip
```
unzip all *.mst files to:
```
{root}/var/stock_history/
```
and then run:
```sh
$ php Run-History.php
```

   [PhpMoney]: <https://github.com/moneyphp/money>
   [PhpSpec]: <https://github.com/phpspec/phpspec>
   [Firebase PHP]: <https://github.com/kreait/firebase-php>
   [PhpUnit]: <https://phpunit.de/>
   [RespectValidation]: <https://github.com/Respect/Validation>
   [Monolog]: <https://github.com/Seldaek/monolog>
