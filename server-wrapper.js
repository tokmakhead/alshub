// server-wrapper.js
// This script ensures environment variables are loaded and then starts the Next.js server

const fs = require('fs');
const path = require('path');

console.log('--- WRAPPER STARTING ---');

// Simple .env parser to avoid extra dependencies
const envPath = path.join(__dirname, '.env');
if (fs.existsSync(envPath)) {
  const envConfig = fs.readFileSync(envPath, 'utf8');
  envConfig.split('\n').forEach(line => {
    const [key, ...valueParts] = line.split('=');
    if (key && valueParts.length > 0) {
      const value = valueParts.join('=').trim();
      process.env[key.trim()] = value;
    }
  });
  console.log('.env file loaded manually.');
}

// Start the real Next.js server
try {
  console.log('--- STARTING SERVER.JS ---');
  require('./server.js');
} catch (error) {
  console.error('--- CRITICAL REFRESH ERROR ---');
  console.error(error.message);
  console.error(error.stack);
  process.exit(1);
}
