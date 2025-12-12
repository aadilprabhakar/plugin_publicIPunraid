# Unraid Public IP Address Plugin

A plugin for Unraid 7.2.2 that displays your server's public IP address on the dashboard with automatic refresh every 5 minutes.

## Features

- Displays public IP address on the Unraid dashboard
- Auto-refreshes every 5 minutes
- Caching mechanism to reduce API calls
- Error handling and graceful fallbacks

## Requirements

- Unraid 7.2.2
- Internet connection

## Installation

1. Copy the `publicip.plg` file to your Unraid server's `/boot/config/plugins/` directory
2. Go to the Unraid web interface
3. Navigate to **Plugins** tab
4. Click **Install Plugin**
5. Paste the path to `publicip.plg` or browse to it
6. Click **Install**

## Uninstallation

1. Go to **Plugins** tab in Unraid
2. Find "Public IP Address" plugin
3. Click **Remove**

## Troubleshooting

- If IP doesn't display, check that the script is executable: `chmod +x /usr/local/emhttp/plugins/layzcrayz_publicip/get_public_ip.sh`
- Check browser console for JavaScript errors
- Verify internet connectivity

## Credits

- **ipify.org** - Public IP address API service (https://www.ipify.org/)
- Unraid Plugin Development Documentation: https://docs.unraid.net/unraid-os/using-unraid-to/customize-your-experience/plugins/

## License

This plugin is provided as-is for the Unraid community.
