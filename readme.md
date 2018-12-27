# LaravelTwilio

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

A wrapper for Twilio SMS notification for Laravel. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require carropublic/laraveltwilio
```
Run the following vendor publish to publish Twillo config.

```bash
php artisan vendor:publish --tag=laraveltwilio.config
```

Update your `.env` for Twilio config in order to send out the SMS notification.

## Usage

For both version *1.0.0* and *2.0.0*. Easily can send out the SMS message like the following from the tinker.

	$toPhone = '+65......';
	LaravelTwilio::sendSMS($toPhone, $message='hello world');

In order to use as Notification channel, the version *1.0.0* need to create your own channel. For the version *2.0.0*. You don't need to create. The package create one for you. You can see the Channel [here](https://github.com/carro-public/laravel-twilio/blob/master/src/LaravelTwilio.php).


The following is the example usage of the package with Laravel's Notification.


	public function via($notifiable)
    {
        return [SMSChannel::class];
    }

    public function toSMS($notifiable)
    {
        $toPhone = $notifiable->routeNotificationForTwilio();
        $body 	 = 'Hello World';

        LaravelTwilio::sendSMS($toPhone, $body);
    }


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