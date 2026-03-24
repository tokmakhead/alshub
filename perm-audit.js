const { execSync } = require('child_process');
const fs = require('fs');

console.log('--- PERMISSION AUDIT ---');
console.log('Current Process User:', execSync('whoami').toString().trim());

const paths = [
  '.',
  'server.js',
  'node_modules',
  '.next',
  'apps/web/.next',
  'package.json'
];

paths.forEach(p => {
  try {
    const stats = fs.statSync(p);
    const owner = execSync(`ls -ld ${p} | awk '{print $3 ":" $4}'`).toString().trim();
    console.log(`${p.padEnd(20)} | Owner: ${owner.padEnd(15)} | Mode: ${stats.mode.toString(8)}`);
  } catch (e) {
    console.log(`${p.padEnd(20)} | ERROR: ${e.message}`);
  }
});

console.log('--- END AUDIT ---');
