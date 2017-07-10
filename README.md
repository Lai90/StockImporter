# Stock Importer

[![Build Status](https://travis-ci.org/Lai90/StockImporter.svg?branch=master)](https://travis-ci.org/Lai90/StockImporter)

Imports GPW (Warsaw Stock Exchange) stock rates from Bossa.pl.

  - Currently only imports todays stock rates
  - Historic values imports in progress

### Tech

Stock Importer uses a number of open source projects to work properly:

* [PhpMoney] - PHP implementation of Fowler's Money pattern
* [PhpSpec] - SpecBDD Framework for PHP

### Installation

Stock Importer requires [composer](https://getcomposer.org/) to install.

Install the dependencies.

```sh
$ cd stock-importer
$ composer install
```

### Todos
* Add importing of historic stock data
* Add Firebase integration so data can be sent to Firebase database

   [PhpMoney]: <https://github.com/moneyphp/money>
   [PhpSpec]: <https://github.com/phpspec/phpspec>
