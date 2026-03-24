const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

console.log('--- BOOT DIAGNOSTIC ---');
console.log('Time:', new Date().toISOString());
console.log('Node Version:', process.version);
console.log('Current Dir:', process.cwd());
console.log('User:', execSync('whoami').toString().trim());

const checkPaths = [
  'server.js',
  '.next',
  'node_modules',
  'public',
  '.env'
];

checkPaths.forEach(p => {
  const exists = fs.existsSync(p);
  console.log(`Path [${p}]: ${exists ? 'EXISTS' : 'MISSING'}`);
  if (exists) {
    const stats = fs.statSync(p);
    console.log(`  Permissions: ${stats.mode.toString(8)}`);
  }
});

console.log('--- ENV CHECK ---');
console.log('DATABASE_URL:', process.env.DATABASE_URL ? 'PRESENT (hidden)' : 'MISSING');
console.log('NEXTAUTH_SECRET:', process.env.NEXTAUTH_SECRET ? 'PRESENT' : 'MISSING');

console.log('--- DB TEST ---');
// Try to ping DB if env exists
if (process.env.DATABASE_URL) {
  console.log('Attempting DB ping...');
  // Simple check via prisma if possible, or just log
}

console.log('--- DIAGNOSTIC COMPLETE ---');
process.exit(0);
