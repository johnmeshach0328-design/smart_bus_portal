@echo off
setlocal enabledelayedexpansion

echo Adding font-color-loader.js to all PHP files...
echo.

set count=0

for %%f in (*.php) do (
    findstr /C:"font-color-loader.js" "%%f" >nul
    if errorlevel 1 (
        findstr /C:"theme-manager.js" "%%f" >nul
        if not errorlevel 1 (
            echo Processing: %%f
            powershell -Command "(Get-Content '%%f' -Raw) -replace '(<script\s+src=\""assets/[jJ][sS]/theme-manager\.js[^>]*></script>)', '$1`r`n    <script src=\"\"assets/js/font-color-loader.js\"\"></script>' | Set-Content '%%f' -NoNewline"
            set /a count+=1
        )
    )
)

echo.
echo ======================================
echo Total files updated: %count%
echo ======================================
pause
