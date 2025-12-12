#!/bin/bash
# Get Public IP Address Script
# Fetches the public IP address from ipify.org API

CACHE_FILE="/tmp/layzcrayz_publicip_cache.txt"
CACHE_AGE=120  # Cache for 2 minutes (120 seconds)
IPIFY_URL="https://api.ipify.org"
TIMEOUT=10

# Function to fetch IP from ipify.org
fetch_ip() {
    local ip=$(curl -s --max-time $TIMEOUT "$IPIFY_URL" 2>/dev/null)
    
    # Validate IP address format (basic validation)
    if [[ $ip =~ ^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$ ]]; then
        echo "$ip"
        return 0
    else
        return 1
    fi
}

# Check if cache exists and is still valid
if [ -f "$CACHE_FILE" ]; then
    cache_time=$(stat -f %m "$CACHE_FILE" 2>/dev/null || stat -c %Y "$CACHE_FILE" 2>/dev/null)
    current_time=$(date +%s)
    age=$((current_time - cache_time))
    
    if [ $age -lt $CACHE_AGE ]; then
        # Cache is still valid, return cached IP
        cat "$CACHE_FILE"
        exit 0
    fi
fi

# Fetch new IP
ip=$(fetch_ip)

if [ $? -eq 0 ] && [ -n "$ip" ]; then
    # Save to cache
    echo "$ip" > "$CACHE_FILE"
    echo "$ip"
    exit 0
else
    # If fetch failed but cache exists, return cached value even if expired
    if [ -f "$CACHE_FILE" ]; then
        cat "$CACHE_FILE"
        exit 0
    else
        echo "ERROR"
        exit 1
    fi
fi

