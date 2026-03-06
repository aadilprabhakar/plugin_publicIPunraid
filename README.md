# Unraid Public IP Address Plugin

A plugin for Unraid 6.9+ that displays your server's public IP address as a tile on the dashboard, with automatic refresh every 5 minutes.

## Features

- Displays public IP address as a native Unraid dashboard tile
- Auto-refreshes every 5 minutes via `setInterval`
- Caches the result in `localStorage` for 5 minutes to reduce API calls
- Graceful error handling if the IP lookup fails

## Requirements

- Unraid 6.9.0 or later
- Internet connection (to reach `api.ipify.org`)

## Installation

1. In the Unraid web UI, go to the **Plugins** tab
2. Click **Install Plugin**
3. Enter the raw plugin URL:
   ```
   https://raw.githubusercontent.com/aadilprabhakar/plugin_publicIPunraid/main/publicip.plg
   ```
4. Click **Install**

The plugin will appear as a tile on your **Dashboard** after installation.

## How It Works

- `publicip.page` — Unraid dashboard tile definition. Unraid loads this automatically from `/usr/local/emhttp/plugins/publicip/` and renders it as a dashboard tile.
- `publicip.js` — Fetches the public IP from `https://api.ipify.org?format=json`, caches the result in `localStorage`, and refreshes every 5 minutes.

## Uninstallation

1. Go to the **Plugins** tab in the Unraid web UI
2. Find **Public IP Address** and click **Remove**

## Troubleshooting

- **Tile shows "Unavailable"** — Check that the server has internet access and can reach `api.ipify.org`
- **Tile not appearing on dashboard** — Verify the plugin is installed and the files exist at `/usr/local/emhttp/plugins/publicip/`
- **Stale IP shown** — Open browser DevTools and clear `localStorage` entry `publicip_cache`, then refresh

## Credits

- [ipify.org](https://www.ipify.org/) — Public IP address API
- [Unraid Plugin Development Docs](https://docs.unraid.net/unraid-os/using-unraid-to/customize-your-experience/plugins/)

## License

This plugin is provided as-is for the Unraid community.
