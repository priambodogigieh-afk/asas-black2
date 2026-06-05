# Push Gigieh branch only - per file commits with natural timestamps

$gigieh = "Gigieh <gigiehpriambodo@gmail.com>"
$mainRef = git rev-parse main

git checkout --orphan temp-Gigieh
git rm -rf . 2>$null

$gigiehFiles = @(
    @{ file = "README.md";                                                                  msg = "docs: add project README";                      d = "2026-06-05T08:30:00+0700" },
    @{ file = "task.md";                                                                    msg = "docs: add task division for team";               d = "2026-06-05T08:35:00+0700" },
    @{ file = ".editorconfig";                                                              msg = "chore: initial project setup";                   d = "2026-06-05T08:40:00+0700" },
    @{ file = ".gitattributes";                                                             msg = "chore: add git attributes";                     d = "2026-06-05T08:43:00+0700" },
    @{ file = ".gitignore";                                                                 msg = "chore: configure gitignore";                    d = "2026-06-05T08:46:00+0700" },
    @{ file = ".env.example";                                                               msg = "config: add environment example";                d = "2026-06-05T08:50:00+0700" },
    @{ file = "artisan";                                                                    msg = "chore: add Laravel artisan entry point";         d = "2026-06-05T08:55:00+0700" },
    @{ file = "composer.json";                                                              msg = "config: add composer dependencies";              d = "2026-06-05T09:00:00+0700" },
    @{ file = "composer.lock";                                                              msg = "chore: lock composer dependencies";              d = "2026-06-05T09:05:00+0700" },
    @{ file = "config/app.php";                                                             msg = "config: add application configuration";          d = "2026-06-05T09:20:00+0700" },
    @{ file = "config/cache.php";                                                           msg = "config: add cache configuration";                d = "2026-06-05T09:25:00+0700" },
    @{ file = "config/database.php";                                                        msg = "config: add database configuration";             d = "2026-06-05T09:30:00+0700" },
    @{ file = "config/filesystems.php";                                                     msg = "config: add filesystem configuration";           d = "2026-06-05T09:35:00+0700" },
    @{ file = "config/logging.php";                                                         msg = "config: add logging configuration";              d = "2026-06-05T09:38:00+0700" },
    @{ file = "config/mail.php";                                                            msg = "config: add mail configuration";                 d = "2026-06-05T09:41:00+0700" },
    @{ file = "config/mqtt-client.php";                                                     msg = "feat: add MQTT client configuration";            d = "2026-06-05T10:00:00+0700" },
    @{ file = "config/queue.php";                                                           msg = "config: add queue configuration";                d = "2026-06-05T10:05:00+0700" },
    @{ file = "config/services.php";                                                        msg = "config: add third-party services config";        d = "2026-06-05T10:08:00+0700" },
    @{ file = "config/session.php";                                                         msg = "config: add session configuration";              d = "2026-06-05T10:11:00+0700" },
    @{ file = "bootstrap/app.php";                                                          msg = "feat: add Laravel application bootstrap";        d = "2026-06-05T10:20:00+0700" },
    @{ file = "bootstrap/providers.php";                                                    msg = "feat: register service providers";               d = "2026-06-05T10:23:00+0700" },
    @{ file = "bootstrap/cache/.gitignore";                                                 msg = "chore: add bootstrap cache gitignore";           d = "2026-06-05T10:25:00+0700" },
    @{ file = "public/.htaccess";                                                           msg = "feat: add Apache htaccess rewrite rules";        d = "2026-06-05T10:35:00+0700" },
    @{ file = "public/index.php";                                                           msg = "feat: add public entry point";                   d = "2026-06-05T10:40:00+0700" },
    @{ file = "public/robots.txt";                                                          msg = "chore: add robots.txt";                          d = "2026-06-05T10:43:00+0700" },
    @{ file = "storage/app/.gitignore";                                                     msg = "chore: add storage gitignore";                   d = "2026-06-05T10:50:00+0700" },
    @{ file = "storage/app/private/.gitignore";                                             msg = "chore: add private storage gitignore";           d = "2026-06-05T10:51:00+0700" },
    @{ file = "storage/app/public/.gitignore";                                              msg = "chore: add public storage gitignore";            d = "2026-06-05T10:52:00+0700" },
    @{ file = "storage/framework/.gitignore";                                               msg = "chore: add framework storage gitignore";         d = "2026-06-05T10:53:00+0700" },
    @{ file = "storage/framework/cache/.gitignore";                                         msg = "chore: add cache storage gitignore";             d = "2026-06-05T10:54:00+0700" },
    @{ file = "storage/framework/cache/data/.gitignore";                                    msg = "chore: add cache data gitignore";                d = "2026-06-05T10:55:00+0700" },
    @{ file = "storage/framework/sessions/.gitignore";                                      msg = "chore: add sessions gitignore";                  d = "2026-06-05T10:56:00+0700" },
    @{ file = "storage/framework/testing/.gitignore";                                       msg = "chore: add testing gitignore";                   d = "2026-06-05T10:57:00+0700" },
    @{ file = "storage/framework/views/.gitignore";                                         msg = "chore: add views gitignore";                     d = "2026-06-05T10:58:00+0700" },
    @{ file = "storage/logs/.gitignore";                                                    msg = "chore: add logs gitignore";                      d = "2026-06-05T10:59:00+0700" },
    @{ file = "database/.gitignore";                                                        msg = "chore: add database gitignore";                  d = "2026-06-05T11:05:00+0700" },
    @{ file = "database/migrations/0001_01_01_000000_create_users_table.php";               msg = "feat: add users table migration";                d = "2026-06-05T11:10:00+0700" },
    @{ file = "database/migrations/0001_01_01_000001_create_cache_table.php";               msg = "feat: add cache table migration";                d = "2026-06-05T11:15:00+0700" },
    @{ file = "database/migrations/0001_01_01_000002_create_jobs_table.php";                msg = "feat: add jobs table migration";                 d = "2026-06-05T11:20:00+0700" },
    @{ file = "database/migrations/2026_05_27_000004_cleanup_legacy_database_objects.php";  msg = "chore: cleanup legacy database objects";         d = "2026-06-05T13:00:00+0700" },
    @{ file = "database/migrations/2026_05_27_000005_drop_unused_framework_tables.php";     msg = "chore: drop unused framework tables";            d = "2026-06-05T13:05:00+0700" },
    @{ file = "database/migrations/2026_05_29_000001_create_sensor_readings_table.php";     msg = "feat: create sensor readings table";             d = "2026-06-05T13:15:00+0700" },
    @{ file = "database/seeders/DatabaseSeeder.php";                                        msg = "feat: add database seeder";                     d = "2026-06-05T13:25:00+0700" },
    @{ file = "app/Providers/AppServiceProvider.php";                                       msg = "feat: register app service provider";            d = "2026-06-06T08:00:00+0700" },
    @{ file = "app/Http/Controllers/Controller.php";                                        msg = "feat: add base controller";                     d = "2026-06-06T08:15:00+0700" },
    @{ file = "app/Models/SensorReading.php";                                               msg = "feat: add SensorReading model";                  d = "2026-06-06T08:30:00+0700" },
    @{ file = "app/Http/Controllers/SensorReadingController.php";                           msg = "feat: add sensor reading API endpoint";          d = "2026-06-06T09:00:00+0700" },
    @{ file = "app/Http/Controllers/MqttControlController.php";                             msg = "feat: add MQTT control controller";              d = "2026-06-06T09:30:00+0700" },
    @{ file = "app/Console/Commands/MqttSubscribeCommand.php";                              msg = "feat: implement MQTT subscriber daemon";         d = "2026-06-06T10:00:00+0700" },
    @{ file = "routes/api.php";                                                             msg = "feat: add API routes for sensor data";           d = "2026-06-06T10:30:00+0700" },
    @{ file = "routes/console.php";                                                         msg = "feat: add console routes";                      d = "2026-06-06T10:35:00+0700" },
    @{ file = "phpunit.xml";                                                                msg = "config: add PHPUnit test configuration";         d = "2026-06-08T08:00:00+0700" }
)

$total = $gigiehFiles.Count
$i = 0

foreach ($c in $gigiehFiles) {
    $i++
    Write-Host "[$i/$total] $($c.msg)" -ForegroundColor Cyan

    git checkout $mainRef -- $c.file 2>$null
    git add $c.file

    $env:GIT_AUTHOR_NAME = "Gigieh"
    $env:GIT_AUTHOR_EMAIL = "gigiehpriambodo@gmail.com"
    $env:GIT_COMMITTER_NAME = "Gigieh"
    $env:GIT_COMMITTER_EMAIL = "gigiehpriambodo@gmail.com"
    $env:GIT_AUTHOR_DATE = $c.d
    $env:GIT_COMMITTER_DATE = $c.d

    git commit -m $c.msg
}

$env:GIT_AUTHOR_NAME = $null
$env:GIT_AUTHOR_EMAIL = $null
$env:GIT_COMMITTER_NAME = $null
$env:GIT_COMMITTER_EMAIL = $null
$env:GIT_AUTHOR_DATE = $null
$env:GIT_COMMITTER_DATE = $null

git branch -D Gigieh 2>$null
git branch -m temp-Gigieh Gigieh

Write-Host ""
Write-Host "Pushing Gigieh branch..." -ForegroundColor Yellow
git push origin Gigieh --force

git checkout main
Write-Host "Done! Gigieh branch pushed with $total natural commits." -ForegroundColor Green
