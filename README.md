The config of the Vlabs Notification Bundle should be in your config.yml if your Symfony version is under 4.0, from this one, you should rather have a packages/vlabs_notification.yaml config file.

From the 2.1.0 version, you can define the root namespace where notification messages are, the default value is 'AppBundle\Notification'.

In your config file :
```yaml
vlabs_notification:
    config:
        root_namespace: "AppBundle\Notification"
```

OVH SMS notifications is now handled by this bundle, from the 1.2.0 version.

In your config file :
```yaml
vlabs_notification:
    sms:
        app_key: "changeme"
        app_secret: "changeme"
        consumer_key: "changeme"
```

FCM (Firebase) is enabled by default from the 1.1.0 version.
You can still configure the bundle to work with the old GCM with the config below.

In your config file :
```yaml
vlabs_notification:
    push:
        gcm: true
```

Slack message is now handled by this bundle, from the 1.2.4 version.

In your config file :
```yaml
vlabs_notification:
    slack:
        app_endpoint: "https://hooks.slack.com/services/changeme"
```