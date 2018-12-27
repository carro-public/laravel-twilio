# LaravelTwilio

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

A wrapper for Twilio SMS notification for Laravel. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require carropublic/laraveltwilio
```

## Usage
	
	$toPhone = '+65......';
	LaravelTwilio::sendSMS($toPhone, $message='hello world');

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Carro][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/carropublic/laraveltwilio.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/carropublic/laraveltwilio.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/carropublic/laraveltwilio
[link-downloads]: https://packagist.org/packages/carropublic/laraveltwilio
[link-author]: https://github.com/carropublic
[link-contributors]: ../../contributors]