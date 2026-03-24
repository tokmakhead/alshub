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
if (process.env.DATABASE_URL) {
  console.log('DATABASE_URL is found.');
  const { PrismaClient } = require('@prisma/client');
  const prisma = new PrismaClient();
  console.log('Attempting Prisma connection...');
  prisma.$connect()
    .then(() => {
      console.log('✅ DATABASE CONNECTED SUCCESSFULLY!');
      process.exit(0);
    })
    .catch(err => {
      console.error('❌ DATABASE CONNECTION FAILED!');
      console.error(err);
      process.exit(1);
    });
} else {
  console.log('DATABASE_URL is MISSING. Skipping DB test.');
  process.exit(0);
}
