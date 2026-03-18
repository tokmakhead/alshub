#!/bin/bash
# ALS Hub Plesk Post-Deploy Script

echo "--- Starting Post-Deploy Tasks ---"

# 1. Install dependencies (only if needed)
npm install --omit=dev

# 2. Database Migration
echo "Running database migrations..."
npx prisma db push --schema=packages/database/prisma/schema.prisma

# 3. Seed basics (Roles, Sources)
echo "Ensuring seed data exists..."
npx prisma db seed --schema=packages/database/prisma/schema.prisma

echo "--- Post-Deploy Tasks Completed ---"
