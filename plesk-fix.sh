# Plesk Fix & Rebuild Script
echo "--- Starting Plesk Repair ---"

# Fix Permissions issue by using a local npm cache
export npm_config_cache="$(pwd)/.npm-cache"
mkdir -p "$npm_config_cache"

echo "Current Node Version in Terminal: $(node -v)"

# Attempt to find ANY Plesk Node 18 or higher
PLESK_NODE_BIN=$(find /opt/plesk/node/*/bin/node -type f | sort -V | tail -n 1)
if [ -z "$PLESK_NODE_BIN" ]; then
    PLESK_NODE_BIN=$(which node)
fi

PLESK_NODE_DIR=$(dirname "$PLESK_NODE_BIN")
echo "Using Node Directory: $PLESK_NODE_DIR"
export PATH="$PLESK_NODE_DIR:$PATH"
echo "Node Version to be used: $(node -v)"

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
