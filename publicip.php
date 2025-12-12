<?php
/**
 * Public IP Address Plugin for Unraid
 * Displays the server's public IP address on the dashboard
 */

$plugin = "layzcrayz_publicip";
$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';

// Hook to add dashboard widget
function publicip_dashboard_widget() {
    global $plugin;
    ?>
    <div id="publicip-widget" class="dashboard-widget">
        <div class="dashboard-widget-header">
            <span class="dashboard-widget-title">Public IP Address</span>
        </div>
        <div class="dashboard-widget-content">
            <div id="publicip-display">
                <div class="publicip-loading">Loading...</div>
            </div>
            <div id="publicip-timestamp" class="publicip-timestamp"></div>
        </div>
    </div>
    <style>
        #publicip-widget {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 10px;
            min-width: 200px;
        }
        .dashboard-widget-header {
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }
        .dashboard-widget-title {
            font-size: 14px;
            color: #333;
        }
        .dashboard-widget-content {
            text-align: center;
        }
        #publicip-display {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
            min-height: 30px;
        }
        .publicip-loading {
            color: #7f8c8d;
            font-style: italic;
        }
        .publicip-error {
            color: #e74c3c;
        }
        .publicip-timestamp {
            font-size: 11px;
            color: #95a5a6;
            margin-top: 8px;
        }
    </style>
    <script>
        // Load the auto-refresh script
        (function() {
            var script = document.createElement('script');
            script.src = '/plugins/<?php echo $plugin; ?>/publicip.js';
            script.onload = function() {
                if (typeof initPublicIP !== 'undefined') {
                    initPublicIP();
                }
            };
            document.head.appendChild(script);
        })();
    </script>
    <?php
}

// Register dashboard widget hook
if (function_exists('add_action')) {
    add_action('dashboard_widgets', 'publicip_dashboard_widget');
} else {
    // Fallback: directly output widget if hooks not available
    publicip_dashboard_widget();
}

// API endpoint for fetching IP
if (isset($_GET['action']) && $_GET['action'] === 'getip') {
    header('Content-Type: application/json');
    
    $script_path = "/usr/local/emhttp/plugins/{$plugin}/get_public_ip.sh";
    $ip = '';
    $error = '';
    
    if (file_exists($script_path) && is_executable($script_path)) {
        $output = shell_exec("{$script_path} 2>&1");
        $ip = trim($output);
        
        if ($ip === 'ERROR' || empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
            $error = 'Failed to fetch IP address';
            $ip = '';
        }
    } else {
        $error = 'Script not found or not executable';
    }
    
    $response = [
        'ip' => $ip,
        'error' => $error,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode($response);
    exit;
}
