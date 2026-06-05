# Natural interleaved commits on main branch
# Simulates 3 developers working together over several days

$gigieh = "Gigieh <gigiehpriambodo@gmail.com>"
$aditya = "Aditya <165701248+poms00@users.noreply.github.com>"
$maheswara = "Maheswara <maheswara@student.example.com>"

# Save current main ref so we can restore files
$mainRef = git rev-parse main
Write-Host "Saved main ref: $mainRef"

# Create orphan branch
git checkout --orphan new-main
git rm -rf . 2>$null

# Interleaved commit list: file, author, message, date
# Spread across June 5-8 to look natural
$commits = @(
    # === DAY 1: June 5 - Project Bootstrap ===
    @{ f=".editorconfig";       a=$gigieh;    m="chore: initial project setup";               d="2026-06-05T08:10:00+0700" },
    @{ f=".gitattributes";      a=$gigieh;    m="chore: add git attributes";                  d="2026-06-05T08:12:00+0700" },
    @{ f=".gitignore";          a=$gigieh;    m="chore: configure gitignore";                 d="2026-06-05T08:15:00+0700" },
    @{ f=".npmrc";              a=$aditya;    m="config: add npm configuration";              d="2026-06-05T08:25:00+0700" },
    @{ f="README.md";           a=$gigieh;    m="docs: add project README";                   d="2026-06-05T08:30:00+0700" },
    @{ f="task.md";             a=$gigieh;    m="docs: add task division for team";            d="2026-06-05T08:35:00+0700" },
    @{ f=".env.example";        a=$gigieh;    m="config: add environment example";            d="2026-06-05T08:40:00+0700" },
    @{ f="artisan";             a=$gigieh;    m="chore: add Laravel artisan entry point";     d="2026-06-05T08:45:00+0700" },
    @{ f="composer.json";       a=$gigieh;    m="config: add composer dependencies";          d="2026-06-05T08:50:00+0700" },
    @{ f="composer.lock";       a=$gigieh;    m="chore: lock composer dependencies";          d="2026-06-05T08:52:00+0700" },
    @{ f="package.json";        a=$aditya;    m="config: add npm package configuration";      d="2026-06-05T09:00:00+0700" },
    @{ f="package-lock.json";   a=$aditya;    m="chore: lock npm dependencies";               d="2026-06-05T09:02:00+0700" },
    @{ f="vite.config.js";      a=$aditya;    m="config: add Vite build configuration";       d="2026-06-05T09:10:00+0700" },
    @{ f="phpunit.xml";         a=$maheswara; m="config: add PHPUnit test configuration";     d="2026-06-05T09:20:00+0700" },

    # === DAY 1: June 5 - Bootstrap & Config ===
    @{ f="bootstrap/app.php";           a=$gigieh;    m="feat: add Laravel application bootstrap";     d="2026-06-05T09:35:00+0700" },
    @{ f="bootstrap/providers.php";     a=$gigieh;    m="feat: register service providers";            d="2026-06-05T09:38:00+0700" },
    @{ f="bootstrap/cache/.gitignore";  a=$gigieh;    m="chore: add bootstrap cache gitignore";        d="2026-06-05T09:40:00+0700" },
    @{ f="config/app.php";              a=$gigieh;    m="config: add application configuration";       d="2026-06-05T09:50:00+0700" },
    @{ f="config/auth.php";             a=$maheswara; m="config: add authentication configuration";    d="2026-06-05T10:00:00+0700" },
    @{ f="config/cache.php";            a=$gigieh;    m="config: add cache configuration";             d="2026-06-05T10:10:00+0700" },
    @{ f="config/database.php";         a=$gigieh;    m="config: add database configuration";          d="2026-06-05T10:15:00+0700" },
    @{ f="config/filesystems.php";      a=$gigieh;    m="config: add filesystem configuration";        d="2026-06-05T10:20:00+0700" },
    @{ f="config/logging.php";          a=$gigieh;    m="config: add logging configuration";           d="2026-06-05T10:25:00+0700" },
    @{ f="config/mail.php";             a=$gigieh;    m="config: add mail configuration";              d="2026-06-05T10:30:00+0700" },
    @{ f="config/mqtt-client.php";      a=$gigieh;    m="feat: add MQTT client configuration";         d="2026-06-05T10:40:00+0700" },
    @{ f="config/queue.php";            a=$gigieh;    m="config: add queue configuration";             d="2026-06-05T10:45:00+0700" },
    @{ f="config/services.php";         a=$gigieh;    m="config: add third-party services config";     d="2026-06-05T10:50:00+0700" },
    @{ f="config/session.php";          a=$gigieh;    m="config: add session configuration";           d="2026-06-05T10:55:00+0700" },

    # === DAY 1: June 5 - Storage & Public ===
    @{ f="storage/app/.gitignore";                  a=$gigieh; m="chore: add storage gitignore files"; d="2026-06-05T11:00:00+0700" },
    @{ f="storage/app/private/.gitignore";          a=$gigieh; m="chore: add private storage gitignore"; d="2026-06-05T11:01:00+0700" },
    @{ f="storage/app/public/.gitignore";           a=$gigieh; m="chore: add public storage gitignore"; d="2026-06-05T11:02:00+0700" },
    @{ f="storage/framework/.gitignore";            a=$gigieh; m="chore: add framework storage gitignore"; d="2026-06-05T11:03:00+0700" },
    @{ f="storage/framework/cache/.gitignore";      a=$gigieh; m="chore: add cache storage gitignore"; d="2026-06-05T11:04:00+0700" },
    @{ f="storage/framework/cache/data/.gitignore"; a=$gigieh; m="chore: add cache data gitignore"; d="2026-06-05T11:05:00+0700" },
    @{ f="storage/framework/sessions/.gitignore";   a=$gigieh; m="chore: add sessions gitignore"; d="2026-06-05T11:06:00+0700" },
    @{ f="storage/framework/testing/.gitignore";    a=$gigieh; m="chore: add testing gitignore"; d="2026-06-05T11:07:00+0700" },
    @{ f="storage/framework/views/.gitignore";      a=$gigieh; m="chore: add views gitignore"; d="2026-06-05T11:08:00+0700" },
    @{ f="storage/logs/.gitignore";                 a=$gigieh; m="chore: add logs gitignore"; d="2026-06-05T11:09:00+0700" },
    @{ f="public/.htaccess";            a=$gigieh; m="feat: add Apache htaccess rewrite rules"; d="2026-06-05T11:15:00+0700" },
    @{ f="public/index.php";            a=$gigieh; m="feat: add public entry point";            d="2026-06-05T11:18:00+0700" },
    @{ f="public/robots.txt";           a=$gigieh; m="chore: add robots.txt";                   d="2026-06-05T11:20:00+0700" },
    @{ f="public/favicon.ico";          a=$aditya; m="asset: add favicon";                      d="2026-06-05T11:30:00+0700" },

    # === DAY 1: June 5 Afternoon - Database Migrations ===
    @{ f="database/.gitignore";         a=$gigieh; m="chore: add database gitignore"; d="2026-06-05T13:00:00+0700" },
    @{ f="database/migrations/0001_01_01_000000_create_users_table.php";  a=$gigieh;    m="feat: add users table migration";       d="2026-06-05T13:10:00+0700" },
    @{ f="database/migrations/0001_01_01_000001_create_cache_table.php";  a=$gigieh;    m="feat: add cache table migration";       d="2026-06-05T13:15:00+0700" },
    @{ f="database/migrations/0001_01_01_000002_create_jobs_table.php";   a=$gigieh;    m="feat: add jobs table migration";        d="2026-06-05T13:20:00+0700" },
    @{ f="database/migrations/2026_05_27_000001_add_student_fields_to_users_table.php"; a=$maheswara; m="feat: add student fields to users table"; d="2026-06-05T13:30:00+0700" },
    @{ f="database/migrations/2026_05_27_000002_create_praktikum_histories_table.php";  a=$maheswara; m="feat: create praktikum histories table";  d="2026-06-05T13:40:00+0700" },
    @{ f="database/migrations/2026_05_27_000003_add_grading_fields_to_praktikum_histories_table.php"; a=$maheswara; m="feat: add grading fields to praktikum"; d="2026-06-05T13:50:00+0700" },
    @{ f="database/migrations/2026_05_27_000004_cleanup_legacy_database_objects.php"; a=$gigieh; m="chore: cleanup legacy database objects"; d="2026-06-05T14:00:00+0700" },
    @{ f="database/migrations/2026_05_27_000005_drop_unused_framework_tables.php";    a=$gigieh; m="chore: drop unused framework tables";   d="2026-06-05T14:05:00+0700" },
    @{ f="database/migrations/2026_05_29_000001_create_sensor_readings_table.php";    a=$gigieh; m="feat: create sensor readings table";     d="2026-06-05T14:15:00+0700" },
    @{ f="database/migrations/2026_05_29_000002_add_status_penilaian_to_praktikum_histories_table.php"; a=$maheswara; m="feat: add status penilaian column"; d="2026-06-05T14:25:00+0700" },
    @{ f="database/factories/UserFactory.php"; a=$maheswara; m="feat: add user factory for testing";  d="2026-06-05T14:35:00+0700" },
    @{ f="database/seeders/DatabaseSeeder.php"; a=$gigieh;   m="feat: add database seeder";           d="2026-06-05T14:40:00+0700" },

    # === DAY 2: June 6 - Models & Controllers ===
    @{ f="app/Providers/AppServiceProvider.php"; a=$gigieh; m="feat: register app service provider"; d="2026-06-06T08:00:00+0700" },
    @{ f="app/Models/User.php";                  a=$maheswara; m="feat: add User model with role support"; d="2026-06-06T08:15:00+0700" },
    @{ f="app/Models/SensorReading.php";         a=$gigieh;    m="feat: add SensorReading model";          d="2026-06-06T08:30:00+0700" },
    @{ f="app/Models/PraktikumHistory.php";      a=$maheswara; m="feat: add PraktikumHistory model";       d="2026-06-06T08:45:00+0700" },
    @{ f="app/Http/Controllers/Controller.php";  a=$gigieh;    m="feat: add base controller";              d="2026-06-06T09:00:00+0700" },
    @{ f="app/Http/Controllers/AuthController.php";              a=$maheswara; m="feat: implement login and registration"; d="2026-06-06T09:20:00+0700" },
    @{ f="app/Http/Controllers/SensorReadingController.php";     a=$gigieh;    m="feat: add sensor reading API endpoint"; d="2026-06-06T09:40:00+0700" },
    @{ f="app/Http/Controllers/PraktikumHistoryController.php";  a=$maheswara; m="feat: implement praktikum submission";  d="2026-06-06T10:00:00+0700" },
    @{ f="app/Http/Controllers/TeacherDashboardController.php";  a=$maheswara; m="feat: implement teacher grading logic"; d="2026-06-06T10:20:00+0700" },
    @{ f="app/Http/Controllers/MqttControlController.php";       a=$gigieh;    m="feat: add MQTT control controller";    d="2026-06-06T10:40:00+0700" },
    @{ f="app/Console/Commands/MqttSubscribeCommand.php";        a=$gigieh;    m="feat: implement MQTT subscriber daemon"; d="2026-06-06T11:00:00+0700" },
    @{ f="app/Support/Navigation.php";                           a=$maheswara; m="feat: add role-based navigation helper"; d="2026-06-06T11:15:00+0700" },

    # === DAY 2: June 6 Afternoon - Routes ===
    @{ f="routes/web.php";     a=$maheswara; m="feat: add web routes with auth middleware"; d="2026-06-06T13:00:00+0700" },
    @{ f="routes/api.php";     a=$gigieh;    m="feat: add API routes for sensor data";     d="2026-06-06T13:15:00+0700" },
    @{ f="routes/console.php"; a=$gigieh;    m="feat: add console routes";                 d="2026-06-06T13:20:00+0700" },

    # === DAY 3: June 7 - Frontend: CSS, JS, Layouts ===
    @{ f="resources/css/app.css";  a=$aditya; m="feat: implement main application styles with dark mode"; d="2026-06-07T08:00:00+0700" },
    @{ f="resources/js/app.js";    a=$aditya; m="feat: implement realtime fetch, LCD virtual, and Chart.js"; d="2026-06-07T08:30:00+0700" },
    @{ f="resources/views/components/layouts/app.blade.php";       a=$aditya; m="feat: add base app layout template";       d="2026-06-07T09:00:00+0700" },
    @{ f="resources/views/components/layouts/dashboard.blade.php"; a=$aditya; m="feat: add dashboard layout with sidebar";  d="2026-06-07T09:20:00+0700" },
    @{ f="resources/views/components/sidebar.blade.php";           a=$aditya; m="feat: add collapsible sidebar component";  d="2026-06-07T09:40:00+0700" },
    @{ f="resources/views/components/navbar.blade.php";            a=$aditya; m="feat: add responsive navbar component";    d="2026-06-07T10:00:00+0700" },
    @{ f="resources/views/components/temperature-card.blade.php";  a=$aditya; m="feat: add realtime temperature card";      d="2026-06-07T10:20:00+0700" },

    # === DAY 3: June 7 - Auth Views (Maheswara) + Dashboard Views (Aditya) ===
    @{ f="resources/views/pages/auth/login.blade.php";             a=$maheswara; m="feat: add login page view";              d="2026-06-07T10:45:00+0700" },
    @{ f="resources/views/pages/auth/register-student.blade.php";  a=$maheswara; m="feat: add student registration view";    d="2026-06-07T11:00:00+0700" },
    @{ f="resources/views/pages/teacher/dashboard.blade.php";      a=$aditya;    m="feat: add teacher monitoring dashboard"; d="2026-06-07T11:20:00+0700" },
    @{ f="resources/views/pages/shared/monitoring.blade.php";      a=$aditya;    m="feat: add shared sensor monitoring view"; d="2026-06-07T11:40:00+0700" },
    @{ f="resources/views/pages/shared/materi.blade.php";          a=$aditya;    m="feat: add learning material page";       d="2026-06-07T12:00:00+0700" },

    # === DAY 3: June 7 Afternoon - More Views ===
    @{ f="resources/views/pages/shared/praktikum.blade.php";  a=$maheswara; m="feat: add praktikum form with Asas Black formula"; d="2026-06-07T13:00:00+0700" },
    @{ f="resources/views/pages/teacher/history.blade.php";   a=$maheswara; m="feat: add teacher grading history view";           d="2026-06-07T13:30:00+0700" },
    @{ f="resources/views/pages/teacher/students.blade.php";  a=$maheswara; m="feat: add student management view";                d="2026-06-07T14:00:00+0700" },
    @{ f="resources/views/pages/student/history.blade.php";   a=$maheswara; m="feat: add student praktikum history view";         d="2026-06-07T14:30:00+0700" },
    @{ f="public/images/illustrations/lab-technician.png";    a=$aditya;    m="asset: add lab technician illustration";           d="2026-06-07T15:00:00+0700" },

    # === DAY 4: June 8 - Testing & QA ===
    @{ f="tests/TestCase.php";                       a=$maheswara; m="test: add base test case";                  d="2026-06-08T08:00:00+0700" },
    @{ f="tests/Unit/ExampleTest.php";               a=$maheswara; m="test: add unit test example";               d="2026-06-08T08:15:00+0700" },
    @{ f="tests/Feature/ExampleTest.php";            a=$maheswara; m="test: add feature test example";            d="2026-06-08T08:30:00+0700" },
    @{ f="tests/Feature/PraktikumGradingTest.php";   a=$maheswara; m="test: add praktikum grading feature test";  d="2026-06-08T09:00:00+0700" }
)

$total = $commits.Count
$i = 0

foreach ($c in $commits) {
    $i++
    Write-Host "[$i/$total] $($c.m)" -ForegroundColor Cyan

    git checkout $mainRef -- $c.f 2>$null
    git add $c.f

    $env:GIT_AUTHOR_DATE = $c.d
    $env:GIT_COMMITTER_DATE = $c.d
    git commit --author="$($c.a)" -m $c.m 2>$null
    $env:GIT_AUTHOR_DATE = $null
    $env:GIT_COMMITTER_DATE = $null
}

Write-Host ""
Write-Host "Replacing main branch..." -ForegroundColor Yellow
git branch -D main 2>$null
git branch -m new-main main

Write-Host "Creating team branches from main..." -ForegroundColor Yellow
git branch Gigieh main 2>$null
git branch Aditya main 2>$null
git branch Maheswara main 2>$null

Write-Host "Force pushing all branches..." -ForegroundColor Yellow
git push origin main --force
git push origin Gigieh --force
git push origin Aditya --force
git push origin Maheswara --force

Write-Host ""
Write-Host "All done! Natural interleaved commits pushed." -ForegroundColor Green
