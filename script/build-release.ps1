# Builds a production package in .\release  (mkmada-app\ + htdocs\)
$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$out  = Join-Path $root 'release'
$app  = Join-Path $out 'mkmada-app'
$web  = Join-Path $out 'htdocs'

Write-Host '1/6 Cleaning release folder...'
if (Test-Path $out) { Remove-Item $out -Recurse -Force }
New-Item -ItemType Directory -Path $app, $web | Out-Null

Write-Host '2/6 Building frontend assets...'
Push-Location $root
npm run build
if ($LASTEXITCODE -ne 0) { Pop-Location; throw 'npm run build failed' }
Pop-Location

Write-Host '3/6 Copying application code and the complete vendor tree...'
# Full paths in /XD on purpose: a bare name like "public" would also exclude app\Livewire\Public
robocopy $root $app /E `
    /XD "$root\.git" "$root\node_modules" "$root\release" "$root\release-infinityfree" "$root\scratch" "$root\tests" "$root\public" "$root\.idea" "$root\.vscode" `
    /XF .env phpunit.xml release-infinityfree.zip `
    /NFL /NDL /NJH /NJS /NP | Out-Null
if ($LASTEXITCODE -ge 8) { throw 'robocopy (app) failed' }

# Robocopy can include hidden files despite the relative /XF .env pattern.
# Production credentials must never be part of a distributable release.
$productionEnv = Join-Path $app '.env'
if (Test-Path -LiteralPath $productionEnv -PathType Leaf) {
    Remove-Item -LiteralPath $productionEnv -Force
}
if (Test-Path -LiteralPath $productionEnv) {
    throw 'A .env file was copied into the release application folder.'
}

Write-Host '4/6 Cleaning runtime files...'
Get-ChildItem (Join-Path $app 'bootstrap\cache') -File -Exclude '.gitignore' | Remove-Item -Force
foreach ($dir in 'storage\logs', 'storage\app', 'storage\framework\views', 'storage\framework\sessions', 'storage\framework\cache') {
    $path = Join-Path $app $dir
    if (Test-Path $path) {
        Get-ChildItem $path -Recurse -File -Exclude '.gitignore' | Remove-Item -Force
    }
}

Write-Host '5/6 Refreshing the complete Composer autoloader...'
Push-Location $app
composer dump-autoload --optimize --no-interaction --no-scripts
if ($LASTEXITCODE -ne 0) { Pop-Location; throw 'composer dump-autoload failed' }
Pop-Location

Write-Host '6/6 Preparing public files...'
robocopy (Join-Path $root 'public') $web /E /XF hot /NFL /NDL /NJH /NJS /NP | Out-Null
if ($LASTEXITCODE -ge 8) { throw 'robocopy (public) failed' }
# The public filesystem disk writes uploads here on the hosted site. Keep this
# directory in the release even when the local public/storage link is not copied.
$uploadStorage = Join-Path $web 'storage'
if (-not (Test-Path $uploadStorage -PathType Container)) {
    New-Item -ItemType Directory -Path $uploadStorage | Out-Null
}
Copy-Item (Join-Path $root 'deploy\index.php')              (Join-Path $web 'index.php') -Force
Copy-Item (Join-Path $root 'deploy\app.htaccess')           (Join-Path $app '.htaccess') -Force
Copy-Item (Join-Path $root 'deploy\env.production.example') (Join-Path $out 'env.production.example') -Force

$files = (Get-ChildItem $out -Recurse -File).Count
$dirs  = (Get-ChildItem $out -Recurse -Directory).Count
Write-Host "Done. Files: $files | Directories: $dirs | Inodes (approx): $($files + $dirs)"
$global:LASTEXITCODE = 0
