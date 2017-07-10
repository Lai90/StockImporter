# Stock Importer

[![Build Status](https://travis-ci.org/Lai90/StockImporter.svg?branch=master)](https://travis-ci.org/Lai90/StockImporter)

Imports GPW (Warsaw Stock Exchange) stock rates from Bossa.pl.

  - Currently only imports todays stock rates
  - Saves rates to Firebase database
  - Historic values imports in progress

### Tech

Stock Importer uses a number of open source projects to work properly:

* [PhpMoney] - PHP implementation of Fowler's Money pattern
* [PhpSpec] - SpecBDD Framework for PHP
* [Firebase PHP] - Firebase PHP SDK

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

```sh
$ php Run.php
```

### Todos
* Add importing of historic stock data

   [PhpMoney]: <https://github.com/moneyphp/money>
   [PhpSpec]: <https://github.com/phpspec/phpspec>
   [Firebase PHP]: <https://github.com/kreait/firebase-php>
