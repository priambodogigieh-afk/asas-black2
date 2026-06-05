# Setup branches with per-file commits for natural GitHub graph

# =============================================
# GIGIEH - Backend & IoT Integration
# =============================================
git checkout --orphan temp-Gigieh
git rm -rf . 2>$null

$gigiehFiles = @(
    @{ file = "README.md"; msg = "docs: add project README" },
    @{ file = "task.md"; msg = "docs: add task division document" },
    @{ file = ".env.example"; msg = "config: add environment example" },
    @{ file = "config/mqtt-client.php"; msg = "feat: add MQTT client configuration" },
    @{ file = "app/Console/Commands/MqttSubscribeCommand.php"; msg = "feat: implement MQTT subscriber command" },
    @{ file = "app/Models/SensorReading.php"; msg = "feat: add SensorReading model" },
    @{ file = "app/Http/Controllers/SensorReadingController.php"; msg = "feat: add sensor reading API controller" },
    @{ file = "database/migrations/2026_05_29_000001_create_sensor_readings_table.php"; msg = "feat: add sensor readings migration" },
    @{ file = "routes/api.php"; msg = "feat: add API routes for sensor data" },
    @{ file = "app/Http/Controllers/MqttControlController.php"; msg = "feat: add MQTT control controller" },
    @{ file = "config/database.php"; msg = "config: add database configuration" },
    @{ file = "database/migrations/0001_01_01_000000_create_users_table.php"; msg = "feat: add users table migration" },
    @{ file = "database/migrations/0001_01_01_000001_create_cache_table.php"; msg = "feat: add cache table migration" },
    @{ file = "database/seeders/DatabaseSeeder.php"; msg = "feat: add database seeder" }
)

foreach ($f in $gigiehFiles) {
    git checkout main -- $f.file
    git add $f.file
    git commit -m $f.msg
}

git branch -D Gigieh 2>$null
git branch -m temp-Gigieh Gigieh

# =============================================
# ADITYA - Frontend & Realtime Visualization
# =============================================
git checkout --orphan temp-Aditya
git rm -rf . 2>$null

$adityaFiles = @(
    @{ file = "README.md"; msg = "docs: add project README" },
    @{ file = "task.md"; msg = "docs: add task division document" },
    @{ file = "package.json"; msg = "config: add npm package configuration" },
    @{ file = "vite.config.js"; msg = "config: add Vite build configuration" },
    @{ file = "resources/css/app.css"; msg = "feat: add main application styles" },
    @{ file = "resources/js/app.js"; msg = "feat: implement realtime fetch, LCD virtual, and Chart.js" },
    @{ file = "resources/views/components/layouts/dashboard.blade.php"; msg = "feat: add dashboard layout component" },
    @{ file = "resources/views/components/sidebar.blade.php"; msg = "feat: add sidebar navigation component" },
    @{ file = "resources/views/components/navbar.blade.php"; msg = "feat: add navbar component" },
    @{ file = "resources/views/components/temperature-card.blade.php"; msg = "feat: add realtime temperature card component" },
    @{ file = "resources/views/pages/teacher/dashboard.blade.php"; msg = "feat: add teacher dashboard monitoring view" },
    @{ file = "resources/views/pages/shared/monitoring.blade.php"; msg = "feat: add shared sensor monitoring view" },
    @{ file = "resources/views/components/layouts/app.blade.php"; msg = "feat: add base app layout" },
    @{ file = "public/images/illustrations/lab-technician.png"; msg = "asset: add lab technician illustration" }
)

foreach ($f in $adityaFiles) {
    git checkout main -- $f.file
    git add $f.file
    git commit -m $f.msg
}

git branch -D Aditya 2>$null
git branch -m temp-Aditya Aditya

# =============================================
# MAHESWARA - Auth, Business Logic & Grading
# =============================================
git checkout --orphan temp-Maheswara
git rm -rf . 2>$null

$maheswaraFiles = @(
    @{ file = "README.md"; msg = "docs: add project README" },
    @{ file = "task.md"; msg = "docs: add task division document" },
    @{ file = "config/auth.php"; msg = "config: add authentication configuration" },
    @{ file = "app/Models/User.php"; msg = "feat: add User model with role support" },
    @{ file = "app/Http/Controllers/AuthController.php"; msg = "feat: implement login and registration controller" },
    @{ file = "resources/views/pages/auth/login.blade.php"; msg = "feat: add login page view" },
    @{ file = "resources/views/pages/auth/register-student.blade.php"; msg = "feat: add student registration view" },
    @{ file = "app/Models/PraktikumHistory.php"; msg = "feat: add PraktikumHistory model" },
    @{ file = "app/Http/Controllers/PraktikumHistoryController.php"; msg = "feat: implement praktikum submission controller" },
    @{ file = "resources/views/pages/shared/praktikum.blade.php"; msg = "feat: add praktikum form with Asas Black calculation" },
    @{ file = "app/Http/Controllers/TeacherDashboardController.php"; msg = "feat: implement teacher grading controller" },
    @{ file = "resources/views/pages/teacher/dashboard.blade.php"; msg = "feat: add teacher grading dashboard view" },
    @{ file = "resources/views/pages/teacher/history.blade.php"; msg = "feat: add teacher grading history view" },
    @{ file = "resources/views/pages/teacher/students.blade.php"; msg = "feat: add student list management view" },
    @{ file = "resources/views/pages/student/history.blade.php"; msg = "feat: add student praktikum history view" },
    @{ file = "app/Support/Navigation.php"; msg = "feat: add role-based navigation helper" },
    @{ file = "routes/web.php"; msg = "feat: add web routes with auth middleware" },
    @{ file = "database/migrations/2026_05_27_000001_add_student_fields_to_users_table.php"; msg = "feat: add student fields migration" },
    @{ file = "database/migrations/2026_05_27_000002_create_praktikum_histories_table.php"; msg = "feat: add praktikum histories migration" },
    @{ file = "database/migrations/2026_05_27_000003_add_grading_fields_to_praktikum_histories_table.php"; msg = "feat: add grading fields migration" },
    @{ file = "database/migrations/2026_05_29_000002_add_status_penilaian_to_praktikum_histories_table.php"; msg = "feat: add status penilaian migration" },
    @{ file = "tests/Feature/PraktikumGradingTest.php"; msg = "test: add praktikum grading feature test" }
)

foreach ($f in $maheswaraFiles) {
    git checkout main -- $f.file
    git add $f.file
    git commit -m $f.msg
}

git branch -D Maheswara 2>$null
git branch -m temp-Maheswara Maheswara

# =============================================
# Push all branches
# =============================================
git push origin Gigieh --force
git push origin Aditya --force
git push origin Maheswara --force

# Switch back to main
git checkout main

Write-Host ""
Write-Host "Done! All branches pushed with per-file commits." -ForegroundColor Green
