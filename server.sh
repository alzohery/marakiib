#!/bin/bash

PORT=6000
HOST="0.0.0.0"
NGROK_WIN_PATH="C:\\ngrok\\ngrok.exe"

echo "Clearing Laravel cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "Starting Laravel server at $HOST:$PORT..."
php artisan serve --host=$HOST --port=$PORT > storage/logs/serve.log 2>&1 &
LARAVEL_PID=$!

# تشغيل Meilisearch
echo "🚀 Starting Meilisearch..."
./meilisearch > storage/logs/meilisearch.log 2>&1 &
MEILI_PID=$!

# تشغيل ngrok من Windows
cd /mnt/c/ngrok || exit 1
echo "🔗 Starting ngrok on port $PORT..."
cmd.exe /c start "" "$NGROK_WIN_PATH" http $PORT
cd - > /dev/null

echo "✅ ngrok is running"
echo "👉 افتح http://127.0.0.1:4040 عشان تشوف الرابط العام"

# دالة الإنهاء
cleanup() {
    echo ""
    echo "🛑 Shutting down Laravel and Meilisearch..."
    kill $LARAVEL_PID
    kill $MEILI_PID
    echo "✅ Done!"
    exit 0
}

trap cleanup INT
wait
