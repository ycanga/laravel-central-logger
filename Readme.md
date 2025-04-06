Add this environment variables in your project.

# LOG_CHANNEL=central_logger
# LOG_ENDPOINT=[YOUR-CENTRAL-LOGGER-SERVER-ENDPOINT]/api/log
# LOG_API_KEY=[YOUR-PROJECT-API-KEY]

Add this line on logging.php file in project.

# 'channels' => [
#     'central_logger' => [
#         'driver' => 'central_logger',
#     ],
# ],

This command publish config file.

# php artisan vendor:publish --provider="ycanga\CentralLogger\CentralLoggerServiceProvider" --tag="config"