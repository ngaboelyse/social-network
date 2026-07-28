const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;

// Serve Laravel public assets under /assets
const laravelPublic = path.join(__dirname, '..', 'social-network-platform', 'public');
if (!fs.existsSync(laravelPublic)) {
  console.error('Warning: could not find Laravel public folder at', laravelPublic);
}
app.use('/assets', express.static(laravelPublic));

// Serve static-client public as root
const clientPublic = path.join(__dirname, 'public');
app.use(express.static(clientPublic));

// Simple JSON API endpoints backed by local files in /data
const dataDir = path.join(__dirname, 'data');

app.get('/api/posts', (req, res) => {
  const file = path.join(dataDir, 'posts.json');
  if (fs.existsSync(file)) return res.json(require(file));
  return res.json([]);
});

app.get('/api/profile', (req, res) => {
  const file = path.join(dataDir, 'profile.json');
  if (fs.existsSync(file)) return res.json(require(file));
  return res.json({});
});

app.get('/api/users', (req, res) => {
  const file = path.join(dataDir, 'users.json');
  if (fs.existsSync(file)) return res.json(require(file));
  return res.json([]);
});

app.get('/api/users/:id', (req, res) => {
  const file = path.join(dataDir, 'users.json');
  if (fs.existsSync(file)) {
    const users = require(file);
    const user = users.find(u => String(u.id) === String(req.params.id));
    return res.json(user || {});
  }
  return res.json({});
});

app.get('/api/channels', (req, res) => {
  const file = path.join(dataDir, 'channels.json');
  if (fs.existsSync(file)) return res.json(require(file));
  return res.json([]);
});

app.get('/api/channels/:id', (req, res) => {
  const file = path.join(dataDir, 'channels.json');
  if (fs.existsSync(file)) {
    const channels = require(file);
    const channel = channels.find(c => String(c.id) === String(req.params.id));
    return res.json(channel || {});
  }
  return res.json({});
});

app.listen(PORT, () => {
  console.log(`\n🚀 Social Network Static Client`);
  console.log(`📍 Server running on http://localhost:${PORT}`);
  console.log(`📁 Serving Laravel assets from ${laravelPublic} at /assets\n`);
  console.log(`Available routes:`);
  console.log(`  GET / - Home page`);
  console.log(`  GET /profile.html - Profile page`);
  console.log(`  GET /users.html - Users directory`);
  console.log(`  GET /channels.html - Channels directory`);
  console.log(`  GET /search.html - Search posts`);
  console.log(`  GET /api/posts - Posts API`);
  console.log(`  GET /api/users - Users API`);
  console.log(`  GET /api/channels - Channels API\n`);
});
