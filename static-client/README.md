Static client for Social Network

A professional, production-ready static frontend for the Social Network platform, built with Node.js, Express, and vanilla JavaScript. No PHP or Docker required.

## Features

- 📱 Responsive, modern UI with professional design
- 🔍 Search functionality across posts
- 👥 User directory with profiles
- 📢 Channel discovery and exploration
- ⚡ Fast performance with static assets
- 🎨 Clean, consistent design language

## Quick Start

Requires Node.js installed on your system.

```bash
cd "D:\ALL\Project\social network\static-client"
npm install
npm start
```

Server runs on `http://localhost:3000` by default.

To use a different port:
```bash
$env:PORT=4000; npm start
```

## Pages

- `/` - Home feed with posts
- `/profile.html` - User profile
- `/users.html` - Directory of users
- `/channels.html` - Channels explorer
- `/search.html` - Search posts
- `/post.html?id=<id>` - View individual post

## API Endpoints

- `GET /api/posts` - All posts
- `GET /api/profile` - Current user profile
- `GET /api/users` - Directory of users
- `GET /api/channels` - All channels

## Data Files

Mock data is stored in JSON files and can be easily edited:

- `data/posts.json` - Posts feed
- `data/profile.json` - User profile
- `data/users.json` - User directory
- `data/channels.json` - Channels directory

Edit these files to change displayed content without restarting the server.

## Features

- Static assets served from Laravel `public/` folder at `/assets`
- No backend dependencies
- Perfect for prototyping and demos
- Easy to extend with additional pages
