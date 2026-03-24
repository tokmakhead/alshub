// server-wrapper.js (Legacy compatible)
var fs = require('fs');
var path = require('path');

console.log('--- WRAPPER STARTING ---');
console.log('Detected Node Version: ' + process.version);

if (process.version.substring(1, 3) < 18) {
  console.error('❌ CRITICAL: Next.js 15 requires Node.js 18+. Currently running on ' + process.version);
  process.exit(1);
}

try {
  var envPath = path.join(__dirname, '.env');
  if (fs.existsSync(envPath)) {
    var envConfig = fs.readFileSync(envPath, 'utf8');
    var lines = envConfig.split('\n');
    for (var i = 0; i < lines.length; i++) {
        var line = lines[i];
        var parts = line.split('=');
        if (parts.length >= 2) {
            var key = parts[0].trim();
            var value = parts.slice(1).join('=').trim();
            process.env[key] = value;
        }
    }
    console.log('.env loaded.');
  }
  console.log('Starting server.js...');
  require('./server.js');
} catch (e) {
  console.error('Startup Error: ' + e.message);
  console.error(e.stack);
  process.exit(1);
}
