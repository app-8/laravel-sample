# laravel-sample

A portfolio project built with Laravel + Docker.

Japanese version: [README_ja.md](README_ja.md)

## Tech Stack

- PHP 8.4
- Laravel 12
- MySQL 8.4
- Apache
- Docker / Docker Compose

## Project Structure

```
.
├── .docker/                    # Docker configuration files
│   ├── apache/                 # Apache config
│   │   └── 000-default.conf    # HTTP config
│   └── php/                    # PHP config
│       ├── Dockerfile          # PHP container build definition
│       ├── docker-entrypoint.sh # Container init script
│       └── php.ini             # PHP settings
├── .github/                    # GitHub Actions workflows
├── appRoot/                    # Laravel application root (standard Laravel structure)
├── docker-compose.yml          # Docker Compose config for local environment
└── ...                         # Other config files
```

- `.docker/`: Docker container build configurations organized by service.
  - `apache/`: Apache configuration used as the web server (HTTP only).
  - `php/`: Apache + PHP container build definition and settings.
- `appRoot/`: Laravel application root. Mounted as `/app` inside the container.
- `docker-compose.yml`: For local environment. Contains two services: `web` (Apache + PHP) and `db` (MySQL).

## Local Environment Setup

### Prerequisites

- Docker and Docker Compose must be installed.

### Setup Steps

Run all commands from the **project root**.

#### 1. Start containers

```bash
docker compose up -d
```

#### 2. Install dependencies

```bash
docker compose exec web composer install -o
```

#### 3. Create environment configuration file

```bash
docker compose exec web cp .env.example .env
docker compose exec web php artisan key:generate
```

#### 4. Run database migrations

```bash
docker compose exec web php artisan migrate
```

### Access

| URL                   | Description |
|-----------------------|-------------|
| http://localhost:8080 | HTTP        |

### DB Connection (local)

| Field    | Value             |
|----------|-------------------|
| Host     | 127.0.0.1         |
| Port     | 3306              |
| Database | laravel_sample_db |
| User     | username          |
| Password | password          |

### Refresh DB container

To delete the DB volume and restart the container:

```bash
docker compose down -v && docker compose up -d
```

## Build & Test

No backend build step is needed for PHP (Laravel) — it uses JIT compilation at runtime.

All `php artisan` and `npm` commands must be run inside the container.

### Backend tests

```bash
docker compose exec web php artisan test
```

### Frontend build (if needed)

```bash
docker compose exec web npm run build
```

### Frontend tests (if needed)

```bash
docker compose exec web npm run test
```
