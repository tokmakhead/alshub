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
# Next.js standalone output moves to apps/web/.next/standalone
# We need to copy these to where Passenger is looking.
cp -r apps/web/.next/standalone/. ./
cp -r apps/web/public ./apps/web/
cp -r apps/web/.next/static ./apps/web/.next/

echo "5. Restarting the application..."
mkdir -p tmp
touch tmp/restart.txt

echo "--- Repair Complete! ---"
echo "Please try to visit https://alshub.mioly.app/api/generate-drafts directly in your browser."
