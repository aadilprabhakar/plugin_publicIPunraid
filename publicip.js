/**
 * Public IP Address Plugin - Auto-refresh JavaScript
 * Fetches and updates the public IP address every 5 minutes
 */

function initPublicIP() {
    const refreshInterval = 5 * 60 * 1000; // 5 minutes in milliseconds
    const displayElement = document.getElementById('publicip-display');
    const timestampElement = document.getElementById('publicip-timestamp');
    
    if (!displayElement) {
        console.error('PublicIP: Display element not found');
        return;
    }
    
    function fetchIP() {
        // Show loading state
        displayElement.innerHTML = '<div class="publicip-loading">Loading...</div>';
        
        // Fetch IP from plugin endpoint
        fetch('/plugins/layzcrayz_publicip/publicip.php?action=getip')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    displayElement.innerHTML = '<div class="publicip-error">' + escapeHtml(data.error) + '</div>';
                    if (timestampElement) {
                        timestampElement.textContent = '';
                    }
                } else if (data.ip) {
                    displayElement.innerHTML = escapeHtml(data.ip);
                    if (timestampElement) {
                        timestampElement.textContent = 'Last updated: ' + data.timestamp;
                    }
                } else {
                    displayElement.innerHTML = '<div class="publicip-error">No IP address received</div>';
                }
            })
            .catch(error => {
                console.error('PublicIP: Error fetching IP:', error);
                displayElement.innerHTML = '<div class="publicip-error">Error: ' + escapeHtml(error.message) + '</div>';
                if (timestampElement) {
                    timestampElement.textContent = '';
                }
            });
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Fetch immediately on load
    fetchIP();
    
    // Set up auto-refresh interval
    setInterval(fetchIP, refreshInterval);
}

// Auto-initialize if DOM is already loaded, otherwise wait for DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPublicIP);
} else {
    initPublicIP();
}

