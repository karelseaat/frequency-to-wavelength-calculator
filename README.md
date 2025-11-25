# Frequency to Wavelength Calculator

This is a simple Laravel web application that allows for the conversion between frequency and wavelength.

## Features

*   Convert frequency to wavelength.
*   Convert wavelength to frequency.
*   Supports various units for both frequency (Hz, kHz, MHz, GHz) and wavelength (m, cm, mm).

## Setup and Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    ```
2.  **Navigate to the project directory:**
    ```bash
    cd frequency-to-wavelength-calculator
    ```
3.  **Install dependencies:**
    ```bash
    composer install
    ```
4.  **Create a copy of the `.env.example` file:**
    ```bash
    cp .env.example .env
    ```
5.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```
6.  **Run the database migrations:**
    ```bash
    php artisan migrate
    ```
7.  **Start the development server:**
    ```bash
    php artisan serve
    ```
8.  Open your browser and navigate to `http://127.0.0.1:8000/calculator`.