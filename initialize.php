<?php

require_once 'config.php';

class Application
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function initialize()
    {
        $this->bootstrapEnvironment();

        // Setup Exception Handling
        $this->initializeExceptionHandling();

        // Run this check for manual installations
        if (!is_file(COMPOSER_PATH)) {
            $this->resolvePlatformExtensions(); // @codeCoverageIgnore
        }

        // Set default locale on the server
        locale_set_default($this->config['defaultLocale'] ?? 'en');

        // Set default timezone on the server
        date_default_timezone_set($this->config['appTimezone'] ?? 'UTC');
    }

    protected function bootstrapEnvironment()
    {
        // Logic to initialize environment variables and settings
        // For example, loading .env file, setting error reporting levels, etc.
    }

    protected function initializeExceptionHandling()
    {
        // Logic to setup global exception handling
        // Example: set_exception_handler('myExceptionHandlerFunction');
    }

    protected function resolvePlatformExtensions()
    {
        // Logic to handle platform-specific extensions or requirements
        // For example, checking for specific PHP extensions or configurations
    }
}

// Initialize the application
$config = [
    'defaultLocale' => 'en',
    'appTimezone' => 'UTC'
];

$app = new Application($config);
$app->initialize();
