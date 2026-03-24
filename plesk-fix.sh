#!/bin/bash
# Plesk Fix & Rebuild Script
echo "--- Starting Plesk Repair ---"

echo "1. Pulling latest code..."
git pull origin main

echo "2. Installing dependencies..."
npm install

echo "3. Building the project (This may take a few minutes)..."
npm run build

echo "4. Restarting the application..."
# Depending on Plesk config, touching restart.txt or prying server.js might work
mkdir -p apps/web/tmp
touch apps/web/tmp/restart.txt

echo "--- Repair Complete! ---"
echo "Please try to visit https://alshub.mioly.app/api/generate-drafts directly in your browser."
