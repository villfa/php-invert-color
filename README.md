# php-invert-color

[![Build Status](https://github.com/villfa/php-invert-color/workflows/Continuous%20Integration/badge.svg)](https://github.com/villfa/php-invert-color/actions)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=villfa_php-invert-color&metric=alert_status)](https://sonarcloud.io/dashboard?id=villfa_php-invert-color)
[![Latest Stable Version](https://poser.pugx.org/villfa/invert-color/v/stable)](https://packagist.org/packages/villfa/invert-color)
[![License](https://poser.pugx.org/villfa/invert-color/license)](./LICENSE)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)

invert hex color code

## Installation

```sh
composer require villfa/invert-color
```

## Usage

Here a basic example:
```php
<?php
require_once 'vendor/autoload.php';

use InvertColor\Color;
use InvertColor\Exceptions\InvalidColorFormatException;

try {
    echo Color::fromHex('#fff')->invert(); // #000000
} catch (InvalidColorFormatException $e) {
    echo 'Invalid color: ', $e->getValue();
}
```

### `Color::fromHex(string $color): Color - throws InvalidColorFormatException`

- **`$color`**: `string`
Color in HEX string. Accepted formats: #000000, #000, 000000, 000

```php
InvertColor\Color::fromHex('#fff')->invert(); // #000000
```

### `Color::fromRGB(array $rgb): Color - throws InvalidRGBException`

- **`$rgb`**: `array`
Color as an array of RGB values.

```php
InvertColor\Color::fromRGB([0, 255, 0])->invert(); // #ff00ff
```

### `Color::invert([bool $bw]): string`

- **`$bw`**: `bool`
Optional. A boolean value indicating whether the output should be amplified to black (`#000000`) or white (`#ffffff`), according to the luminance of the original color.


```php
InvertColor\Color::fromHex('#000')->invert(); // #ffffff
InvertColor\Color::fromHex('#282b35')->invert(); // #d7d4ca

// amplify to black or white
InvertColor\Color::fromHex('282b35')->invert(true); // #ffffff
```

### `Color::invertAsRGB([bool $bw]): array`

- **`$bw`**: `bool`
Optional. A boolean value indicating whether the output should be amplified to black or white, according to the luminance of the original color.


```php
InvertColor\Color::fromHex('#000')->invertAsRGB(); // [255, 255, 255]
InvertColor\Color::fromHex('#282b35')->invertAsRGB(); // [215, 212, 202]

// amplify to black or white
InvertColor\Color::fromHex('282b35')->invertAsRGB(true); // [255, 255, 255]
```

### `Color::invertAsObj([bool $bw]): Color`

- **`$bw`**: `bool`
Optional. A boolean value indicating whether the output should be amplified to black or white, according to the luminance of the original color.


```php
InvertColor\Color::fromHex('#000')->invertAsObj()->getHex(); // #ffffff
InvertColor\Color::fromHex('#282b35')->invertAsObj()->getRGB(); // [215, 212, 202]

// amplify to black or white
InvertColor\Color::fromHex('282b35')->invertAsObj(true)->getRGB(); // [255, 255, 255]

```

### `Color::getHex(): string`

```php
InvertColor\Color::fromHex('#FFF')->getHex(); // #ffffff
```

### `Color::getRGB(): array`

```php
InvertColor\Color::fromHex('#fff')->getRGB(); // [255, 255, 255]
```

### `Color::getLuminance(): float`

```php
InvertColor\Color::fromHex('#fff')->getLuminance(); // 1
InvertColor\Color::fromHex('#000')->getLuminance(); // 0
```

### `Color::isBright(): bool`

```php
InvertColor\Color::fromHex('#fff')->isBright(); // true
InvertColor\Color::fromHex('#000')->isBright(); // false
```

### `Color::isDark(): bool`

```php
InvertColor\Color::fromHex('#fff')->isDark(); // false
InvertColor\Color::fromHex('#000')->isDark(); // true
```

## Tests

To validate and test the library:
```sh
composer run-script test
```

## Acknowledgement

This library is a port of the JS package [invert-color](https://github.com/onury/invert-color).

More resources:
* https://stackoverflow.com/questions/35969656/how-can-i-generate-the-opposite-color-according-to-current-color
* https://stackoverflow.com/questions/3942878/how-to-decide-font-color-in-white-or-black-depending-on-background-color/3943023#3943023

## License

[MIT](./LICENSE)
