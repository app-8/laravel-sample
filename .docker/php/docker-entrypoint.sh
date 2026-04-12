#!/bin/bash
set -e

echo "[Docker Entrypoint] Starting PHP-FPM..."

exec php-fpm
