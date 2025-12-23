@echo off
REM Quick Publishing Script for Ethereum Wallet Creator (Windows)
REM This script helps you publish your package to GitHub and Packagist

echo =========================================
echo   Ethereum Wallet Creator Publisher
echo =========================================
echo.

REM Check if git is initialized
if not exist .git (
    echo Initializing Git repository...
    git init
    echo Git initialized
) else (
    echo Git already initialized
)

REM Validate composer.json
echo.
echo Validating composer.json...
call composer validate
if errorlevel 1 (
    echo composer.json validation failed!
    pause
    exit /b 1
)
echo composer.json is valid

REM Run tests
echo.
echo Running Node.js tests...
call npm test
if errorlevel 1 (
    echo Node.js tests failed!
    pause
    exit /b 1
)
echo Node.js tests passed

REM Get GitHub username
echo.
set /p github_username="Enter your GitHub username: "

REM Get repository name
echo.
set /p repo_name="Enter repository name (default: eth-wallet-creator): "
if "%repo_name%"=="" set repo_name=eth-wallet-creator

REM Confirm
echo.
echo Repository will be created at:
echo https://github.com/%github_username%/%repo_name%
echo.
set /p confirm="Continue? (y/n): "

if /i not "%confirm%"=="y" (
    echo Publishing cancelled
    pause
    exit /b 0
)

REM Add all files
echo.
echo Adding files to git...
git add .

REM Commit
echo Creating initial commit...
git commit -m "Initial release v1.0.0 - Ethereum Wallet Creator for Laravel"

REM Add remote
echo Adding GitHub remote...
git remote add origin https://github.com/%github_username%/%repo_name%.git 2>nul
git branch -M main

REM Tag version
echo Creating version tag v1.0.0...
git tag -a v1.0.0 -m "Release version 1.0.0"

echo.
echo =========================================
echo   Local setup complete!
echo =========================================
echo.
echo Next steps:
echo.
echo 1. Create GitHub repository:
echo    - Go to https://github.com/new
echo    - Name: %repo_name%
echo    - Visibility: Public
echo    - Do NOT initialize with README
echo.
echo 2. Push your code:
echo    git push -u origin main
echo    git push --tags
echo.
echo 3. Register on Packagist:
echo    - Go to https://packagist.org
echo    - Sign in with GitHub
echo    - Submit: https://github.com/%github_username%/%repo_name%
echo.
echo 4. Users can install via:
echo    composer require %github_username%/%repo_name%
echo.
echo See PUBLISHING.md for detailed instructions.
echo.
pause
