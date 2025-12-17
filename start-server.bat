@echo off
title POSYCARE Server with ML
color 0A

echo.
echo =============================================
echo    POSYCARE - Starting All Services
echo =============================================
echo.

:: Check if Python is installed
python --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Python is not installed or not in PATH
    pause
    exit /b 1
)

:: Check if PHP is installed
php --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed or not in PATH
    pause
    exit /b 1
)

echo [1/3] Starting ML Prediction API (Flask)...
cd /d "%~dp0python_api"
start /B "ML_API" python predict_api.py

:: Wait for Flask to start
timeout /t 3 /nobreak >nul

:: Check if Flask is running
curl -s http://localhost:5000/health >nul 2>&1
if errorlevel 1 (
    echo [WARNING] ML API may not have started properly
) else (
    echo [OK] ML API running at http://localhost:5000
)

echo.
echo [2/3] Starting Laravel Development Server...
cd /d "%~dp0"

echo.
echo =============================================
echo    POSYCARE is ready!
echo =============================================
echo    Laravel:  http://localhost:8000
echo    Predict:  http://localhost:8000/predict
echo    ML API:   http://localhost:5000
echo =============================================
echo    Press Ctrl+C to stop the server
echo =============================================
echo.

php artisan serve

:: When Laravel stops, also stop Flask
echo.
echo [3/3] Stopping ML API...
taskkill /F /IM python.exe /FI "WINDOWTITLE eq ML_API*" >nul 2>&1
echo [OK] All services stopped.
pause
