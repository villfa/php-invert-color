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

### Inverter::invert(string $color[, bool $bw]): string

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

### Inverter::isValidColor(string $color): bool

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
$inverter = new InvertColor\Inverter;

$inverter->isValidColor('#000'); // true
$inverter->isValidColor('#282b35'); // true
$inverter->isValidColor('foo bar'); // false
```

### Inverter::hexToRGB(string $color): array

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
$inverter = new InvertColor\Inverter;

$inverter->hexToRGB('#00ff00'); // [0, 255, 0]
```

### Inverter::getLuminance(string $color): float

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
$inverter = new InvertColor\Inverter;

$inverter->getLuminance('#fff'); // 1
$inverter->getLuminance('#000'); // 0
```

### Inverter::isBright(string $color): bool

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
$inverter = new InvertColor\Inverter;

$inverter->isBright('#fff'); // true
$inverter->isBright('#000'); // false
```

### Inverter::isDark(string $color): bool

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
$inverter = new InvertColor\Inverter;

$inverter->isDark('#fff'); // false
$inverter->isDark('#000'); // true
```

## Tests

To run the test suite:
```sh
./vendor/bin/phpunit
```

## Acknowledgement

This library is a port of the JS package [invert-color](https://github.com/onury/invert-color).

More resources:
* https://stackoverflow.com/questions/35969656/how-can-i-generate-the-opposite-color-according-to-current-color
* https://stackoverflow.com/questions/3942878/how-to-decide-font-color-in-white-or-black-depending-on-background-color/3943023#3943023

## License

[MIT](./LICENSE)

