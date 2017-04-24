FCM (Firebase) is enabled by default from the 1.1.0 version.
You can still configure the bundle to work with the old GCM with the config below.

In your config.yml
```yaml
vlabs_notification:
    push:
        gcm: true
```