# Vlabs Notification Bundle

## Installation

In your composer.json :

```json
{
    "require": {
        "vlabs/notification-bundle": "^2"
    },
    "config": {
        "secure-http": false  
    },
    "repositories": [  
        {
            "type": "vcs",  
            "url": "https://github.com/V-labs/contexts"  
        },
        {
            "type": "composer",  
            "url": "http://packages.v-labs.fr/"  
        }
    ]
}
```

## General configuration

The config of the Vlabs Notification Bundle should be in your config.yml if you don't use Symfony Flex, otherwise, you should rather have a packages/vlabs_notification.yaml config file.
  
## Notification root namespace

From the **2.1.0** version, you can define the root namespace where your notification messages are, **the default value is 'AppBundle\Notification'**. 
  
In your config file :

```yaml  
vlabs_notification:  
    config:
        root_namespace: "AppBundle\Notification"
 ```  
 
## SwiftMailer

Find below the configuration for the current version.  
  
In your config file :

```yaml  
vlabs_notification:  
    swiftmailer:
        enabled: true
        default_from_email: default@email.com
        default_from_name: Default Sender Name
 ```  

## Mailer

Find below the configuration for the current version.

In your config file :

```yaml
vlabs_notification:
    mailer:
        enabled: true
        default_from_email: default@email.com
        default_from_name: Default Sender Name
```
  
## OVH SMS

OVH SMS notifications is now handled by this bundle, from the **1.2.0** version.  
  
In your config file :

```yaml  
vlabs_notification:  
    sms:
        enabled: true
        app_key: "changeme"
        app_secret: "changeme"
        consumer_key: "changeme"
 ```  
 
In your composer.json :

```json
{
    "require": {
        "ovh/php-ovh-sms": "1.1"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/V-labs/php-ovh-sms.git"
        }
    ]
}
```
  
## GCM

FCM (Firebase) is enabled by default from the **1.1.0** version, find below the configuration for the current version.
You can still configure the bundle to work with the old GCM with the config below.  
  
In your config file :

```yaml  
vlabs_notification:  
    push:
        enabled: true
        gcm: true
 ```  
 
In your composer.json :

```json
{
    "require": {
        "richsage/rms-push-notifications-bundle": "dev-fcm"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/V-labs/RMSPushNotificationsBundle"
        }
    ]
}
```
  
## Slack

Slack message is now handled by this bundle, from the **1.2.4** version, find below the configuration for the current version.  
  
In your config file :

```yaml  
vlabs_notification:  
    slack:
        enabled: true
        app_endpoint: "https://hooks.slack.com/services/changeme"
 ```
 
In your composer.json :

```json
{
    "require": {
        "guzzlehttp/guzzle": ">=6.0"
    }
}
```

## MessageOptions

Since **2.2** version, in your class that extend AbstractMessage, you can set a value to the property **options** that will be used to add options to your message, here is a simple example :

```php
class MyCustomSwiftMailerMessage extends AbstractMessage  
{  
    public function build()  
    {
        $options = new SwiftMailerOptions();  
        $options->setValueForKey(SwiftMailerOptions::FROM_EMAIL, 'my@email.com');  
        $options->setValueForKey(SwiftMailerOptions::FROM_NAME, 'My Email');  
        $options->setValueForKey(SwiftMailerOptions::SUBJECT, 'My subject');  
        $options->setValueForKey(SwiftMailerOptions::CC, 'extra@email.com');
		
        $this->to = 'to@email.com';
        $this->body = 'Put your body here.';
        $this->options = $options;
    }
}
```

### SwiftMailerOptions

You will find below the options that you can set in a **SwiftMailerOptions**.

| Option      | Allowed Types    | Constant                        |
|-------------|------------------|---------------------------------|
| from_email  | string           | SwiftMailerOptions::FROM_EMAIL  |
| from_name   | string           | SwiftMailerOptions::FROM_NAME   |
| subject     | string           | SwiftMailerOptions::SUBJECT     |
| cc          | string, string[] | SwiftMailerOptions::CC          |
| bcc         | string, string[] | SwiftMailerOptions::BCC         |
| replyTo     | string, string[] | SwiftMailerOptions::REPLY_TO    |
| attachments | array            | SwiftMailerOptions::ATTACHMENTS |

### MailerOptions

You will find below the options that you can set in a **MailerOptions**.

| Option      | Allowed Types    | Constant                   |
|-------------|------------------|----------------------------|
| from_email  | string           | MailerOptions::FROM_EMAIL  |
| from_name   | string           | MailerOptions::FROM_NAME   |
| subject     | string           | MailerOptions::SUBJECT     |
| cc          | string, string[] | MailerOptions::CC          |
| bcc         | string, string[] | MailerOptions::BCC         |
| replyTo     | string, string[] | MailerOptions::REPLY_TO    |
| attachments | array            | MailerOptions::ATTACHMENTS |

### RmsPushOptions

You will find below the options that you can set in a **RmsPushOptions**.

| Option | Allowed Types | Constant               |
|--------|---------------|------------------------|
| data   | array         | RmsPushOptions::DATA   |
| gcm    | array         | RmsPushOptions::GCM    |
| fcm    | array         | RmsPushOptions::FCM    |
| webfcm | array         | RmsPushOptions::WEBFCM |

### FirebasePushOptions

You will find below the options that you can set in a **FirebasePushOptions**.

| Option          | Allowed Types | Constant                             |
|-----------------|---------------|--------------------------------------|
| title           | string        | FirebasePushOptions::TITLE           |
| image_url       | string        | FirebasePushOptions::IMAGE_URL       |
| data            | array         | FirebasePushOptions::DATA            |
| web_push_config | array         | FirebasePushOptions::WEB_PUSH_CONFIG |