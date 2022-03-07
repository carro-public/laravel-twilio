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

### LaravelNotification

The following is the example usage of the package with Laravel's Notification.

#### Create Notification Class

```
class ExampleNotification extends Notification
{
    // Which channel this notification should be sent to
    public function via($notifiable)
    {
        return [ SMSChannel::class, WhatsAppChannel::class ];
    }
    
    // Notification payload (content) will be sent
    public function toSMS($notifiable)
    {
        return new LaravelTwilioMessage("Message Content");
    }
    
    // Notification payload (content) will be sent
    public function toWhatsApp($notifiable)
    {
        return new LaravelTwilioMessage("Message Content");
    }
}
```

#### Create Notifiable Class

```
class Contact extends Model {

    use Notifiable;
    
    // Phone number to receive
    public function routeNotificationForSms()
    {
        return $this->phone;
    }
    
    // Phone number to receive
    public function routeNotificationForWhatsapp()
    {
        return $this->phone;
    }
}
```

##### Sending Notification from Notifiable Instance

```
$contact->notify(new ExampleNotification());
```

##### Sending Notification from Anonymous Notifiable Instance

```
Notification::route('sms')->notify(new ExampleNotification());
```

### SMS Message by helper function

Easily can send out the SMS message

```
send_sms($to, $message)
```

### WhatsApp Message by helper function

Can easily send out WhatsApp Message

```
send_whatsapp($to, $message)
```

### Check incoming messages from Twilio

When using webhook, you can validate the incoming request is from Twilio. `$token` is `config('laraveltwilio.auth_token')`. We are not using directly
becuase it might be dynamic.

```
use CarroPublic\LaravelTwilio\Request\ValidateTwilioIncomingRequestSignature;

ValidateSignatureOfRequest::isValidRequest($token, $request);
```

## Sandbox Mode

#### How to enable SandBox Mode

1. Register Closure to return if testing is enabled `\CarroPublic\LaravelTwilio\LaravelTwilioManager::registerTestingValidator`

Example:

```
LaravelTwilioManager::registerSandboxValidator(function () {
    return !is_production();
});
```

2. Otherwise, use`TWILIO_TESTING_ENABLE` to determine if running in sandbox mode. Default `false`

#### How to bypass sandbox $phone validator

- Register Closure to return if sandbox is enabled `\CarroPublic\LaravelTwilio\LaravelTwilioSender::registerValidPhoneForSandbox`

Example: 

```
LaravelTwilioSender::registerValidPhoneForSandbox(function ($phoneNumber) {
    return $phoneNumber == "+84111111111";
}
```

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