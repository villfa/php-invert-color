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
/* include composer autoload file */

echo (new InvertColor\Inverter)->invert('#fff') // #000000;
```

### Inverter::invert(string $color[, bool $bw])

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000
- **`$bw`**: `bool`
Optional. A boolean value indicating whether the output should be amplified to black (`#000000`) or white (`#ffffff`), according to the luminance of the original color.


```php
$inverter = new InvertColor\Inverter;

$inverter->invert('#000'); // #ffffff
$inverter->invert('#282b35'); // #d7d4ca

// amplify to black or white
$inverter->invert('#282b35', true); // #ffffff

```

## Tests

To run the test suite:
```sh
./vendor/bin/phpunit
```

## Acknowledgement

This library is a port of the JS package [invert-color](https://github.com/onury/invert-color).

## License

[MIT](./LICENSE)

