#!/bin/bash
set -e

echo "[Docker Entrypoint] Starting Apache..."

exec apache2-foreground
