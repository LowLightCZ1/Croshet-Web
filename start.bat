@echo off
cd /d "%~dp0"

set "PHP_BIN=C:\xampp\php\php.exe"
set "PORT=8000"
set "URL=http://localhost:%PORT%"

if not exist "%PHP_BIN%" (
    echo Zadanou cestu k PHP nelze nalezt, zkousim vychozi 'php'...
    set "PHP_BIN=php"
)

echo ========================================
echo Spoustim PHP webserver na %URL%
echo Pro ukonceni serveru stisknete Ctrl + C
echo ========================================

start "" "%URL%"
"%PHP_BIN%" -S localhost:%PORT%

