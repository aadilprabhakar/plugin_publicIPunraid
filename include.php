<?php
/**
 * Public IP Address Plugin - Dashboard Include
 * This file is automatically included by Unraid's plugin system
 */

$plugin = "layzcrayz_publicip";

// Add dashboard widget when dashboard is loaded
if (basename($_SERVER['PHP_SELF']) == 'webGui.php' || strpos($_SERVER['PHP_SELF'], 'Dashboard') !== false) {
    ?>
    <script>
    // Inject widget when dashboard loads
    (function() {
        function addPublicIPWidget() {
            // Check if widget already exists
            if (document.getElementById('publicip-widget')) {
                return;
            }
            
            // Find dashboard container (adjust selector based on Unraid version)
            var dashboard = document.querySelector('.dashboard') || document.querySelector('#dashboard') || document.body;
            
            if (!dashboard) {
                // Try again after a short delay
                setTimeout(addPublicIPWidget, 500);
                return;
            }
            
            // Create widget HTML
            var widget = document.createElement('div');
            widget.id = 'publicip-widget';
            widget.className = 'dashboard-widget';
            widget.innerHTML = `
                <div class="dashboard-widget-header">
                    <span class="dashboard-widget-title">Public IP Address</span>
                </div>
                <div class="dashboard-widget-content">
                    <div id="publicip-display">
                        <div class="publicip-loading">Loading...</div>
                    </div>
                    <div id="publicip-timestamp" class="publicip-timestamp"></div>
                </div>
            `;
            
            // Add styles
            var style = document.createElement('style');
            style.textContent = `
                #publicip-widget {
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 15px;
                    margin: 10px;
                    min-width: 200px;
                    display: inline-block;
                    vertical-align: top;
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
            `;
            document.head.appendChild(style);
            
            // Insert widget
            dashboard.appendChild(widget);
            
            // Load and initialize the auto-refresh script
            var script = document.createElement('script');
            script.src = '/plugins/<?php echo $plugin; ?>/publicip.js';
            script.onload = function() {
                if (typeof initPublicIP !== 'undefined') {
                    initPublicIP();
                }
            };
            document.head.appendChild(script);
        }
        
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', addPublicIPWidget);
        } else {
            addPublicIPWidget();
        }
    })();
    </script>
    <?php
}
