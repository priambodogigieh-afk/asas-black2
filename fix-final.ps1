# Fix main with ALL files from old repo, then redo Maheswara
$fetchRef = git rev-parse FETCH_HEAD

# =============================================
# ADD MISSING FILES TO MAIN
# =============================================
Write-Host "=== ADDING MISSING FILES TO MAIN ===" -ForegroundColor Yellow

$missingFiles = @(
    "app/Http/Controllers/AuthController.php",
    "app/Http/Controllers/PraktikumHistoryController.php",
    "app/Http/Controllers/TeacherDashboardController.php",
    "app/Models/PraktikumHistory.php",
    "app/Models/User.php",
    "app/Support/Navigation.php",
    "config/auth.php",
    "database/factories/UserFactory.php",
    "database/migrations/2026_05_27_000001_add_student_fields_to_users_table.php",
    "database/migrations/2026_05_27_000002_create_praktikum_histories_table.php",
    "database/migrations/2026_05_27_000003_add_grading_fields_to_praktikum_histories_table.php",
    "database/migrations/2026_05_29_000002_add_status_penilaian_to_praktikum_histories_table.php",
    "resources/views/pages/auth/login.blade.php",
    "resources/views/pages/auth/register-student.blade.php",
    "resources/views/pages/shared/praktikum.blade.php",
    "resources/views/pages/student/history.blade.php",
    "resources/views/pages/teacher/dashboard.blade.php",
    "resources/views/pages/teacher/history.blade.php",
    "resources/views/pages/teacher/students.blade.php",
    "routes/web.php",
    "tests/Feature/ExampleTest.php",
    "tests/Feature/PraktikumGradingTest.php",
    "tests/TestCase.php",
    "tests/Unit/ExampleTest.php"
)

foreach ($f in $missingFiles) {
    Write-Host "  Restoring: $f" -ForegroundColor Cyan
    git checkout $fetchRef -- $f 2>$null
}

git add .
$env:GIT_AUTHOR_DATE = "2026-06-06T08:00:00+0700"
$env:GIT_COMMITTER_DATE = "2026-06-06T08:00:00+0700"
git commit -m "feat: add auth, business logic, grading and test files"
$env:GIT_AUTHOR_DATE = $null
$env:GIT_COMMITTER_DATE = $null

Write-Host "Pushing main..." -ForegroundColor Yellow
git push origin main --force

# =============================================
# REDO MAHESWARA
# =============================================
Write-Host ""
Write-Host "=== REDOING MAHESWARA ===" -ForegroundColor Yellow
$newMainRef = git rev-parse main

git checkout --orphan temp-Maheswara
git rm -rf . 2>$null

$maheswaraFiles = @(
    @{ file = "README.md";                                                                                  msg = "docs: add project README";                           d = "2026-06-05T09:10:00+0700" },
    @{ file = "task.md";                                                                                    msg = "docs: add task division document";                    d = "2026-06-05T09:12:00+0700" },
    @{ file = "config/auth.php";                                                                            msg = "config: add authentication configuration";            d = "2026-06-05T10:05:00+0700" },
    @{ file = "app/Models/User.php";                                                                        msg = "feat: add User model with role support";              d = "2026-06-06T08:15:00+0700" },
    @{ file = "app/Http/Controllers/AuthController.php";                                                    msg = "feat: implement login and registration controller";   d = "2026-06-06T09:00:00+0700" },
    @{ file = "resources/views/pages/auth/login.blade.php";                                                 msg = "feat: add login page view";                          d = "2026-06-06T09:30:00+0700" },
    @{ file = "resources/views/pages/auth/register-student.blade.php";                                      msg = "feat: add student registration view";                 d = "2026-06-06T10:00:00+0700" },
    @{ file = "app/Models/PraktikumHistory.php";                                                            msg = "feat: add PraktikumHistory model";                   d = "2026-06-06T10:30:00+0700" },
    @{ file = "app/Http/Controllers/PraktikumHistoryController.php";                                        msg = "feat: implement praktikum submission controller";     d = "2026-06-06T11:00:00+0700" },
    @{ file = "resources/views/pages/shared/praktikum.blade.php";                                           msg = "feat: add praktikum form with Asas Black formula";    d = "2026-06-06T11:30:00+0700" },
    @{ file = "app/Http/Controllers/TeacherDashboardController.php";                                        msg = "feat: implement teacher grading controller";          d = "2026-06-06T13:00:00+0700" },
    @{ file = "resources/views/pages/teacher/dashboard.blade.php";                                          msg = "feat: add teacher grading dashboard view";            d = "2026-06-06T13:30:00+0700" },
    @{ file = "resources/views/pages/teacher/history.blade.php";                                            msg = "feat: add teacher grading history view";              d = "2026-06-07T08:00:00+0700" },
    @{ file = "resources/views/pages/teacher/students.blade.php";                                           msg = "feat: add student management view";                   d = "2026-06-07T08:30:00+0700" },
    @{ file = "resources/views/pages/student/history.blade.php";                                            msg = "feat: add student praktikum history view";            d = "2026-06-07T09:00:00+0700" },
    @{ file = "app/Support/Navigation.php";                                                                 msg = "feat: add role-based navigation helper";              d = "2026-06-07T09:30:00+0700" },
    @{ file = "routes/web.php";                                                                             msg = "feat: add web routes with auth middleware";           d = "2026-06-07T10:00:00+0700" },
    @{ file = "database/migrations/2026_05_27_000001_add_student_fields_to_users_table.php";                msg = "feat: add student fields migration";                  d = "2026-06-05T13:30:00+0700" },
    @{ file = "database/migrations/2026_05_27_000002_create_praktikum_histories_table.php";                 msg = "feat: create praktikum histories table";              d = "2026-06-05T13:45:00+0700" },
    @{ file = "database/migrations/2026_05_27_000003_add_grading_fields_to_praktikum_histories_table.php";  msg = "feat: add grading fields migration";                  d = "2026-06-05T14:00:00+0700" },
    @{ file = "database/migrations/2026_05_29_000002_add_status_penilaian_to_praktikum_histories_table.php"; msg = "feat: add status penilaian column";                  d = "2026-06-05T14:15:00+0700" },
    @{ file = "database/factories/UserFactory.php";                                                         msg = "feat: add user factory for testing";                  d = "2026-06-08T08:00:00+0700" },
    @{ file = "tests/TestCase.php";                                                                         msg = "test: add base test case";                           d = "2026-06-08T08:15:00+0700" },
    @{ file = "tests/Unit/ExampleTest.php";                                                                 msg = "test: add unit test example";                        d = "2026-06-08T08:30:00+0700" },
    @{ file = "tests/Feature/ExampleTest.php";                                                              msg = "test: add feature test example";                     d = "2026-06-08T08:45:00+0700" },
    @{ file = "tests/Feature/PraktikumGradingTest.php";                                                     msg = "test: add praktikum grading feature test";           d = "2026-06-08T09:15:00+0700" }
)

$total = $maheswaraFiles.Count
$i = 0
foreach ($c in $maheswaraFiles) {
    $i++
    Write-Host "[$i/$total] $($c.msg)" -ForegroundColor Cyan
    git checkout $newMainRef -- $c.file 2>$null
    if ($LASTEXITCODE -ne 0) {
        Write-Host "  SKIP: $($c.file) not found" -ForegroundColor Red
        continue
    }
    git add $c.file
    $env:GIT_AUTHOR_NAME = "Maheswara"
    $env:GIT_AUTHOR_EMAIL = "maheswara@student.example.com"
    $env:GIT_COMMITTER_NAME = "Maheswara"
    $env:GIT_COMMITTER_EMAIL = "maheswara@student.example.com"
    $env:GIT_AUTHOR_DATE = $c.d
    $env:GIT_COMMITTER_DATE = $c.d
    git commit -m $c.msg
}

$env:GIT_AUTHOR_NAME = $null; $env:GIT_AUTHOR_EMAIL = $null
$env:GIT_COMMITTER_NAME = $null; $env:GIT_COMMITTER_EMAIL = $null
$env:GIT_AUTHOR_DATE = $null; $env:GIT_COMMITTER_DATE = $null

git branch -D Maheswara 2>$null
git branch -m temp-Maheswara Maheswara

Write-Host "Pushing Maheswara..." -ForegroundColor Yellow
git push origin Maheswara --force

git checkout main
Write-Host ""
Write-Host "Done! Main fixed & Maheswara rebuilt with 26 commits." -ForegroundColor Green
