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

### SMS Message

Easily can send out the SMS message like the following from the tinker.

	$toPhone = '+65......';
	LaravelTwilio::sendSMS($toPhone, $message='hello world');

Also, you can add dynamic `$from` number like the following

    $toPhone = '+65......';
    $from = 'Carro';
	LaravelTwilio::sendSMS($toPhone, $message='hello world', $from);

### WhatsApp Message

Can easily send out WhatsApp Message like the following from the tinker.

    $toPhone = '+65......';
    $from = 'Carro';
	LaravelTwilio::sendWhatsAppSMS($toPhone, $message='hello world', $mediaUrl, $from);

### LaravelNotification

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

### Check incoming messages from Twilio

When using webhook, you can validate the incoming request is from Twilio. `$token` is `config('laraveltwilio.auth_token')`. We are not using directly
becuase it might be dynamic.

```
use CarroPublic\LaravelTwilio\Request\ValidateTwilioIncomingRequestSignature;

ValidateSignatureOfRequest::isValidRequest($token, $request);
```

## Testing

`TWILIO_TESTING_ENV` will determine if running in testing mode. Separated by `,`

`TWILIO_TESTING_WHITELIST` in case of testing mode, only whitelist will be sent. Separated by `,`

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

Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/carropublic/laraveltwilio.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/carropublic/laraveltwilio.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/carropublic/laraveltwilio
[link-downloads]: https://packagist.org/packages/carropublic/laraveltwilio
[link-author]: https://github.com/carropublic
[link-contributors]: ../../contributors]