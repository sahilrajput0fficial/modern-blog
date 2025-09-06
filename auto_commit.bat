@echo off
:loop
echo ============================================
echo Checking for changes... %date% %time%

REM 
git status --porcelain >nul 2>&1
if errorlevel 1 (
    echo Git repository not found here. Exiting...
    exit /b
)

for /f "delims=" %%i in ('git status --porcelain') do (
    set "changes=1"
)

if defined changes (
    echo Changes found! Committing...
    git add .
    git commit -m "Auto-commit at %date% %time%"
    git push origin auto-backup
    set changes=
) else (
    echo No changes. Skipping commit.
)

echo Waiting 900 seconds (1 hour)...
timeout /t 900 >nul
goto loop
