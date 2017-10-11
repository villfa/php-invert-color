# php-invert-color

[![Build Status](https://secure.travis-ci.org/villfa/php-invert-color.png?branch=master)](http://travis-ci.org/villfa/php-invert-color)

invert hex color code

## Installation

```sh
composer require villfa/invert-color
```

## Usage

```php
<?php
// include composer autoload file

echo (new InvertColor\Inverter)->invert('#fff');
```

## Tests

To run the test suite:
```sh
./vendor/bin/phpunit
```

## License

[MIT](./LICENSE)

