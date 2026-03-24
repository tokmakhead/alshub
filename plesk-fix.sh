#!/bin/bash
# Plesk Fix & Rebuild Script
echo "--- Starting Plesk Repair ---"

echo "1. Pulling latest code..."
git pull origin main

echo "2. Installing dependencies..."
npm install

echo "3. Building the project (This may take a few minutes)..."
npm run build

echo "4. Deploying Standalone files (Crucial for Plesk)..."
# We are in /var/www/vhosts/mioly.app/alshub.mioly.app/
# The build output is in apps/web/.next/standalone/

if [ -d "apps/web/.next/standalone" ]; then
    echo "Copying standalone server files..."
    cp -r apps/web/.next/standalone/. ./
    
    echo "Copying static assets..."
    mkdir -p public
    cp -r apps/web/public/. ./public/ 2>/dev/null || echo "No public folder found in apps/web, skipping..."
    
    mkdir -p .next/static
    cp -r apps/web/.next/static/. ./.next/static/ 2>/dev/null || echo "No static folder found, skipping..."
else
    echo "ERROR: Standalone folder not found! Build might have failed or output path is different."
fi

echo "5. Restarting the application..."
mkdir -p tmp
touch tmp/restart.txt

echo "--- Repair Complete! ---"
echo "Check: https://alshub.mioly.app/api/generate-drafts"
