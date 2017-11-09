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

echo (new InvertColor\Inverter('#fff'))->invert() // #000000;
```

### Inverter::invert([bool $bw]): string

- **`$bw`**: `bool`
Optional. A boolean value indicating whether the output should be amplified to black (`#000000`) or white (`#ffffff`), according to the luminance of the original color.


```php
(new InvertColor\Inverter('#000'))->invert(); // #ffffff
(new InvertColor\Inverter('#282b35'))->invert(); // #d7d4ca

// amplify to black or white
(new InvertColor\Inverter('282b35'))->invert(); // #ffffff
```

### Inverter::getLuminance(): float

```php
(new InvertColor\Inverter('#fff'))->getLuminance(); // 1
(new InvertColor\Inverter('#000'))->getLuminance(); // 0
```

### Inverter::isBright(): bool

```php
(new InvertColor\Inverter('#fff'))->isBright(); // true
(new InvertColor\Inverter('#000'))->isBright(); // false
```

### Inverter::isDark(): bool

```php
(new InvertColor\Inverter('#fff'))->isDark(); // false
(new InvertColor\Inverter('#000'))->isDark(); // true
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

