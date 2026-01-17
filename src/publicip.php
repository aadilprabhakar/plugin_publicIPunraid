<?php
// This script is called by the javascript to get the public ip
// It executes the shell script and returns the output.

$ip = shell_exec('/usr/local/emhttp/plugins/publicip/get_public_ip.sh');

echo trim($ip);
?>