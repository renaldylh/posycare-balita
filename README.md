# PosyCare Balita - Intelligent Posyandu Management System

PosyCare Balita is a comprehensive management system designed for Posyandu (Integrated Healthcare Center) in Indonesia, specifically focused on monitoring the growth and nutritional status of toddlers (balita). The system integrates a robust web application built with Laravel 12 and an intelligent Machine Learning component developed in Python to provide real-time nutritional status predictions based on anthropometric measurements.

## Project Overview

The primary objective of this project is to digitize and enhance the data management process in Posyandu. By leveraging Machine Learning technology, PosyCare Balita assists healthcare cadres in early detection of malnutrition, stunting, and other growth issues using accurate data analysis. The system provides an intuitive interface for managing toddler records, recording periodic measurements, and generating detailed health reports.

## System Architecture

The application utilizes a hybrid architecture combining a high-performance PHP framework with a dedicated Python data science service:

- **Web Application (Backend & Frontend)**: Built on **Laravel 12** (PHP 8.2+), serving as the core interface for users, data management, and business logic.
- **Machine Learning Service**: A **Python Flask API** that hosts a trained Random Forest Classifier model. This service processes anthropometric data (Age, Gender, Weight, Height, Head Circumference, and Upper Arm Circumference) to predict nutritional status.
- **Integration**: The Laravel application communicates with the Python Flask service via HTTP requests to retrieve prediction results seamlessly.

## Key Features

### 1. Dashboard and Analytics
- Provides a centralized view of key metrics.
- Displays summaries of registered toddlers and recent activities.

### 2. Balita Data Management
- Complete CRUD (Create, Read, Update, Delete) functionality for toddler profiles.
- Stores essential demographic data including name, date of birth, gender, and parents' details.

### 3. Anthropometric Measurements (Pengukuran)
- Records periodic health measurements:
  - Weight (Berat Badan)
  - Height (Tinggi Badan)
  - Head Circumference (Lingkar Kepala)
  - Upper Arm Circumference (LILA)
- Tracks historical growth data for each child.

### 4. Intelligent Nutritional Prediction (Prediksi Gizi)
- **Real-time Analysis**: Automatically calculates nutritional status upon data entry using the integrated Python ML model.
- **Multi-parameter Assessment**: Considers multiple variables simultaneously for high accuracy.
- **Status Classification**: Categorizes health status (e.g., Gizi Normal, Gizi Buruk) and provides probability scores.
- **BMI Calculation**: Auto-calculates Body Mass Index (BMI).

### 5. Dataset Management
- Allows management of training datasets used for the Machine Learning model.
- Supports dataset export features for further analysis or model retraining.

### 6. Comprehensive Reporting (Laporan)
- Generates printable reports for Posyandu records.
- Supports exporting data in various formats for offline archiving.

### 7. User Management
- Role-based access control to ensure secure data handling.
- Management of administrator and cadre accounts.

## Technical Requirements

To run this project, ensure your environment meets the following specifications:

- **PHP**: Version 8.2 or higher.
- **Composer**: For PHP dependency management.
- **Node.js & NPM**: For frontend asset compilation.
- **Python**: Version 3.8 or higher.
- **Database**: MySQL or MariaDB.
- **Web Server**: Apache or Nginx (or Laravel Sail/Artisan serve for local development).

## Installation and Setup Guide

Follow these steps to set up the project locally:

1.  **Clone the Repository**
    Clone the project files to your local machine.

2.  **Install PHP Dependencies**
    Navigate to the project root and run:
    ```bash
    composer install
    ```

3.  **Setup Environment Variables**
    Copy the example environment file and configure your database settings:
    ```bash
    cp .env.example .env
    ```
    Update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Database Migrations**
    Ensure your database server is running, then execute:
    ```bash
    php artisan migrate
    ```

6.  **Install Python Dependencies**
    Navigate to the `python_api` directory and install the required libraries:
    ```bash
    cd python_api
    pip install -r requirements.txt
    cd ..
    ```

7.  **Install Frontend Dependencies**
    ```bash
    npm install
    npm run build
    ```

## Running the Application

To start the application, you need to run both the Laravel server and the Python API.

1.  **Start the Python API**
    You can use the provided batch script or run it manually:
    ```bash
    # Using script (Windows)
    start_flask.bat
    
    # Or manual execution
    cd python_api
    python predict_api.py
    ```
    The API will start on `http://localhost:5000`.

2.  **Start the Laravel Server**
    Open a new terminal and run:
    ```bash
    php artisan serve
    ```
    The web application will be accessible at `http://localhost:8000`.

## Model Information

The core of the prediction module is a **Random Forest Classifier**.
- **Input Features**: Age (months), Gender, Weight (kg), Height (cm), Head Circumference (cm), Upper Arm Circumference (cm).
- **Model File**: Located at `storage/app/models/status_gizi_model.joblib`.
- **Accuracy**: The model is trained on validated datasets to ensure reliable predictions for early screening purposes.

## License

The PosyCare Balita web application is open-sourced software licensed under the MIT license.
