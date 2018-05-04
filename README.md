OVH SMS notifications is now handled by this bundle, from the 1.2.0 version.

In your config.yml
```yaml
vlabs_notification:
    sms:
        app_key: "changeme"
        app_secret: "changeme"
        consumer_key: "changeme"
```

FCM (Firebase) is enabled by default from the 1.1.0 version.
You can still configure the bundle to work with the old GCM with the config below.

In your config.yml
```yaml
vlabs_notification:
    push:
        gcm: true
```

Slack message is now handled by this bundle, from the 1.2.4 version.

In your config.yml
```yaml
vlabs_notification:
    slack:
        app_endpoint: "https://hooks.slack.com/services/changeme"
```