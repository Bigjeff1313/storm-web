<?php
function getDatabaseConfig() {
    $json = file_get_contents('https://codewithbiggest.xyz/api/database_config.json');
    return json_decode($json, true);
}

$dbConfig = getDatabaseConfig();

define('DB_HOST', $dbConfig['HOST']);
define('DB_NAME', $dbConfig['DATABASE']);
define('DB_USER', $dbConfig['USER']);
define('DB_PASS', $dbConfig['PASSWORD']);

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Define other necessary constants or configuration settings
define('COMPOSER_PATH', __DIR__ . '/vendor/autoload.php');
