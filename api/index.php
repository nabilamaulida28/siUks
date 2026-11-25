<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Entry point Laravel untuk Vercel (runtime vercel-php)
|--------------------------------------------------------------------------
| Filesystem Vercel read-only, hanya /tmp yang bisa ditulis. File ini:
|  1. membuat folder storage di /tmp
|  2. mengarahkan cache bootstrap Laravel ke /tmp
|  3. menulis sertifikat CA Aiven (dari env DB_SSL_CA) ke /tmp
|  4. menjalankan aplikasi
*/

function vercel_env(string $key, string $value, bool $force = false): void
{
    if (!$force && getenv($key) !== false) {
        return; // jangan timpa nilai dari Vercel Dashboard
    }
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 1. Storage sementara
$storage = "/tmp/storage";
foreach (["app/public", "framework/cache/data", "framework/sessions", "framework/views", "logs"] as $dir) {
    if (!is_dir("$storage/$dir")) {
        @mkdir("$storage/$dir", 0777, true);
    }
}

// 2. Default aman untuk produksi di Vercel (bisa ditimpa lewat Dashboard)
vercel_env("APP_ENV", "production");
vercel_env("APP_DEBUG", "false");
vercel_env("LOG_CHANNEL", "stderr");
vercel_env("SESSION_DRIVER", "database");
vercel_env("CACHE_STORE", "database");
vercel_env("QUEUE_CONNECTION", "sync");
vercel_env("VIEW_COMPILED_PATH", "$storage/framework/views");
vercel_env("APP_CONFIG_CACHE", "/tmp/config.php");
vercel_env("APP_EVENTS_CACHE", "/tmp/events.php");
vercel_env("APP_PACKAGES_CACHE", "/tmp/packages.php");
vercel_env("APP_ROUTES_CACHE", "/tmp/routes.php");
vercel_env("APP_SERVICES_CACHE", "/tmp/services.php");

// 3. Sertifikat CA Aiven (khusus MySQL)
$ca = getenv("DB_SSL_CA");
if ($ca) {
    $caPath = "/tmp/aiven-ca.pem";
    if (!file_exists($caPath)) {
        file_put_contents($caPath, str_replace("\\n", "\n", $ca));
    }
    vercel_env("MYSQL_ATTR_SSL_CA", $caPath, true);
}

// 4. Jalankan Laravel
define("LARAVEL_START", microtime(true));

require __DIR__ . "/../vendor/autoload.php";

$app = require_once __DIR__ . "/../bootstrap/app.php";
$app->useStoragePath($storage);
$app->handleRequest(Request::capture());
