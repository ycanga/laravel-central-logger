# Central Logger for Laravel

A simple Laravel logging driver that sends logs to a central server.

---

## 🚀 Installation

1. **Install the package via Composer**
```bash  
   composer require ycanga/central-logger
```

3. **Publish the configuration file**

```bash
php artisan vendor:publish --provider="ycanga\CentralLogger\CentralLoggerServiceProvider" --tag="config"
```
## ⚙️ Configuration

1. **Add the following environment variables to your .env file:**
```bash 
LOG_CHANNEL=central_logger
LOG_ENDPOINT=[YOUR-CENTRAL-LOGGER-SERVER-ENDPOINT]/api/log
LOG_API_KEY=[YOUR-PROJECT-API-KEY]
```
2. **Register the logging channel in config/logging.php:**
```bash 
'channels' => [
    // Other channels...

    'central_logger' => [
        'driver' => 'central_logger',
    ],
],
```

## 📤 Usage
Once configured, Laravel will send all log messages to your central logger server via the central_logger channel.

You can also log manually using the channel:

```bash 
Log::channel('central_logger')->info('This is a test log from my project.');
```



### Developed with ❤️ by ycanga
