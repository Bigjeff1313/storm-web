<?php
$this->bootstrapEnvironment();

// Setup Exception Handling
try {
    Services::exceptions()->initialize();
} catch (Exception $e) {
    // Handle the exception, log it, or display an error message
    // For instance: log_message('error', $e->getMessage());
}

// Run this check for manual installations
if (!is_file(COMPOSER_PATH)) {
    // Ensure the Composer path exists before attempting any operations
    // This check prevents errors in case the file doesn't exist
    try {
        $this->resolvePlatformExtensions(); // @codeCoverageIgnore
    } catch (Exception $e) {
        // Handle the exception, log it, or display an error message
        // For instance: log_message('error', $e->getMessage());
    }
}

// Set default locale on the server
$defaultLocale = $this->config->defaultLocale ?? 'en';
if (!setlocale(LC_ALL, $defaultLocale . '.UTF-8', $defaultLocale)) {
    // Handle the failure to set the default locale
    // For instance: log_message('error', 'Failed to set default locale');
}

// Set default timezone on the server
$defaultTimezone = $this->config->appTimezone ?? 'UTC';
if (!@date_default_timezone_set($defaultTimezone)) {
    // Suppress errors with '@' and handle the failure to set the default timezone
    // For instance: log_message('error', 'Failed to set default timezone');
}
?>
