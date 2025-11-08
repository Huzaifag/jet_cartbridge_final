# PowerShell script to copy seller features to manufacturer
# This script copies files and replaces seller references with manufacturer

$sellerPath = "resources\views\seller"
$manufacturerPath = "resources\views\manufacturer"

# Define features to copy
$features = @(
    "categories\create.blade.php",
    "categories\edit.blade.php",
    "categories\show.blade.php",
    "order",
    "bulk-orders",
    "inquiries",
    "settings"
)

function Copy-AndReplace {
    param(
        [string]$sourcePath,
        [string]$destPath
    )
    
    # Create destination directory if it doesn't exist
    $destDir = Split-Path -Parent $destPath
    if (!(Test-Path $destDir)) {
        New-Item -ItemType Directory -Path $destDir -Force | Out-Null
    }
    
    # Read content
    $content = Get-Content $sourcePath -Raw
    
    # Replace seller with manufacturer
    $content = $content -replace 'seller\.', 'manufacturer.'
    $content = $content -replace "seller'", "manufacturer'"
    $content = $content -replace 'seller"', 'manufacturer"'
    $content = $content -replace 'Seller', 'Manufacturer'
    $content = $content -replace "seller/", "manufacturer/"
    $content = $content -replace "seller\\", "manufacturer\"
    
    # Write to destination
    Set-Content -Path $destPath -Value $content
    
    Write-Host "Copied: $sourcePath -> $destPath" -ForegroundColor Green
}

# Copy category files
Write-Host "`nCopying Category Files..." -ForegroundColor Cyan
Copy-AndReplace "$sellerPath\categories\create.blade.php" "$manufacturerPath\categories\create.blade.php"
Copy-AndReplace "$sellerPath\categories\edit.blade.php" "$manufacturerPath\categories\edit.blade.php"
Copy-AndReplace "$sellerPath\categories\show.blade.php" "$manufacturerPath\categories\show.blade.php"

# Copy order directory
Write-Host "`nCopying Order Files..." -ForegroundColor Cyan
if (!(Test-Path "$manufacturerPath\order")) {
    New-Item -ItemType Directory -Path "$manufacturerPath\order" -Force | Out-Null
}
Get-ChildItem "$sellerPath\order\*.blade.php" | ForEach-Object {
    $destFile = "$manufacturerPath\order\$($_.Name)"
    Copy-AndReplace $_.FullName $destFile
}

# Copy bulk-orders directory
Write-Host "`nCopying Bulk Orders Files..." -ForegroundColor Cyan
if (!(Test-Path "$manufacturerPath\bulk-orders")) {
    New-Item -ItemType Directory -Path "$manufacturerPath\bulk-orders" -Force | Out-Null
}
Get-ChildItem "$sellerPath\bulk-orders\*.blade.php" | ForEach-Object {
    $destFile = "$manufacturerPath\bulk-orders\$($_.Name)"
    Copy-AndReplace $_.FullName $destFile
}

# Copy inquiries directory
Write-Host "`nCopying Inquiries Files..." -ForegroundColor Cyan
if (!(Test-Path "$manufacturerPath\inquiries")) {
    New-Item -ItemType Directory -Path "$manufacturerPath\inquiries" -Force | Out-Null
}
Get-ChildItem "$sellerPath\inquiries\*.blade.php" | ForEach-Object {
    $destFile = "$manufacturerPath\inquiries\$($_.Name)"
    Copy-AndReplace $_.FullName $destFile
}

# Copy settings directory
Write-Host "`nCopying Settings Files..." -ForegroundColor Cyan
if (!(Test-Path "$manufacturerPath\settings")) {
    New-Item -ItemType Directory -Path "$manufacturerPath\settings" -Force | Out-Null
}
Get-ChildItem "$sellerPath\settings\*.blade.php" | ForEach-Object {
    $destFile = "$manufacturerPath\settings\$($_.Name)"
    Copy-AndReplace $_.FullName $destFile
}

Write-Host "`n✓ Phase 1 Core Features Copied Successfully!" -ForegroundColor Green
Write-Host "`nNext Steps:" -ForegroundColor Yellow
Write-Host "1. Update manufacturer routes in web.php"
Write-Host "2. Update manufacturer controller"
Write-Host "3. Update manufacturer sidebar navigation"
Write-Host "4. Test each feature"
