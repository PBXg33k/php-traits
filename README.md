[![Latest Stable Version](https://poser.pugx.org/pbxg33k/pbxg33k-traits/v/stable)](https://packagist.org/packages/pbxg33k/pbxg33k-traits) [![Total Downloads](https://poser.pugx.org/pbxg33k/pbxg33k-traits/downloads)](https://packagist.org/packages/pbxg33k/pbxg33k-traits) [![Latest Unstable Version](https://poser.pugx.org/pbxg33k/pbxg33k-traits/v/unstable)](https://packagist.org/packages/pbxg33k/pbxg33k-traits) [![License](https://poser.pugx.org/pbxg33k/pbxg33k-traits/license)](https://packagist.org/packages/pbxg33k/pbxg33k-traits) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PBXg33k/php-traits/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PBXg33k/php-traits/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/PBXg33k/php-traits/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PBXg33k/php-traits/?branch=master)

# PBXg33k's PHP Traits

This repository is a collection of traits to make life with PHP easier

## Installation

Add the package-skeleton package to your `composer.json` file.

``` json
{
    "require": {
        "pbxg33k/pbxg33k-traits": "1.0.*"
    }
}
```

Or via the command line in the root of your project's installation.

``` bash
$ composer require "pbxg33k/pbxg33k-traits*"
```

## Traits


- **HydratableTrait** Allows you to easily hydrate classes from arrays. An example is importing data from external APIs 
- **ReflectionTrait** Allows you to do extra things with Reflection (ie: get property class from @var block)
- **PropertyTrait** Set property values without worrying about property visibility or setters

## Usage
Click [here](http://php.net/manual/en/language.oop5.traits.php) to read about using traits on PHP's own manual.

### HydratableTrait ###
```php
class Foo 
{
    use Pbxg33k\Traits\HydratableTrait;
    // Rest of your class

    // Example property, imagine it has proper getter/setter
    protected $randomProperty;
}

// Somewhere else in code
$foo = new Foo();
$foo->hydrateClass(['randomProperty' => 'value']);

var_dump($foo->getRandomProperty()); // "value"
```

HydratableTrait trait allows you to hydrate your class properties easily by passing an array to hydrateClass().
This trait will automagically assign matching keys to properties and instantiate supported classes.


### ReflectionTrait ###
```php
Class Foo
{
    /**
     * @var DateTime
     */
    property $dateTime;
}

Class BlackMagic
{
    use Pbxg33k\Traits\ReflectionTrait;

    public static function getPropertyClass($class, $property)
    {
        // Wrapped following method because it's protected
        return $this->getClassFromClassProperty($class, $property);
    }
}

BlackMagic::getPropertyClass(Foo::class, 'dateTime'); // returns "DateTime"

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md)


## License

The MIT License (MIT)
Copyright (c) 2016 Oguzhan Uysal.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.