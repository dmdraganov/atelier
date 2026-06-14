#!/usr/bin/env bash

set -euo pipefail

cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env from .env.example"
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate
fi

php artisan migrate --seed

if [ -d node_modules ]; then
    npm run dev &
    vite_pid=$!

    cleanup() {
        kill "$vite_pid" 2>/dev/null || true
    }

    trap cleanup EXIT INT TERM
else
    echo "node_modules not found; skipping Vite. Run npm install if frontend assets are missing."
fi

php artisan serve
