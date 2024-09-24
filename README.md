<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Setup with Docker

This project can be run using Docker. Follow the steps below to set up and run the project.

### Prerequisites

- Docker installed on your system
- Docker Compose installed on your system

### Steps to Run the Project

1. **Clone the Repository**

    ```sh
    git clone https://github.com/your-repo/your-project.git
    cd your-project
    ```

2. **Copy the Example Environment File**

    ```sh
    cp .env.example .env
    ```

3. **Build and Run the Docker Containers**

    ```sh
    docker-compose up --build
    ```

4. **Run Migrations and Seeders**

    Once the containers are up and running, you need to run the migrations and seeders. This will also bring news from different APIs.

    ```sh
    docker-compose exec appnews php artisan migrate --seed
    ```

5. **Run the Scheduler**

    To have the news API sync into your system, you need to run the scheduler. This will automatically run migrations, seeders, and bring news from different APIs.

    ```sh
    docker-compose exec appnews php artisan schedule:work
    ```

### Accessing the Application

- The application should now be running at `http://localhost` (or the port specified in your Docker setup).

### Stopping the Containers

To stop the Docker containers, run:

```sh
    docker-compose down