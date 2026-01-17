#!/bin/bash

# This script fetches the public IP address from a series of providers.
# It tries them in order until one succeeds.

IP=$(curl -s --max-time 5 ifconfig.me)
[ -z "$IP" ] && IP=$(curl -s --max-time 5 icanhazip.com)
[ -z "$IP" ] && IP=$(curl -s --max-time 5 ipinfo.io/ip)
[ -z "$IP" ] && IP=$(curl -s --max-time 5 api.ipify.org)
[ -z "$IP" ] && IP="Unavailable"

echo $IP