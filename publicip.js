(function () {
  var CACHE_KEY = 'publicip_cache';
  var REFRESH_INTERVAL = 5 * 60 * 1000; // 5 minutes in ms

  function getFromCache() {
    try {
      var cached = localStorage.getItem(CACHE_KEY);
      if (cached) {
        var data = JSON.parse(cached);
        if (Date.now() - data.timestamp < REFRESH_INTERVAL) {
          return data.ip;
        }
      }
    } catch (e) {}
    return null;
  }

  function setCache(ip) {
    try {
      localStorage.setItem(CACHE_KEY, JSON.stringify({ ip: ip, timestamp: Date.now() }));
    } catch (e) {}
  }

  function updateDisplay(ip, error) {
    var el = document.getElementById('publicip-value');
    var sub = document.getElementById('publicip-updated');
    if (!el) return;

    if (error) {
      el.innerHTML = '<span style="color:#e74c3c;"><i class="fa fa-exclamation-circle"></i> Unavailable</span>';
      if (sub) sub.textContent = 'Could not reach ipify.org';
    } else {
      el.innerHTML = '<span style="color:#2ecc71;">' + ip + '</span>';
      if (sub) sub.textContent = 'Last updated: ' + new Date().toLocaleTimeString();
    }
  }

  function fetchPublicIP() {
    var cached = getFromCache();
    if (cached) {
      updateDisplay(cached, false);
      return;
    }

    fetch('https://api.ipify.org?format=json')
      .then(function (response) {
        if (!response.ok) throw new Error('Bad response');
        return response.json();
      })
      .then(function (data) {
        if (!data.ip) throw new Error('No IP in response');
        setCache(data.ip);
        updateDisplay(data.ip, false);
      })
      .catch(function () {
        updateDisplay(null, true);
      });
  }

  fetchPublicIP();
  setInterval(fetchPublicIP, REFRESH_INTERVAL);
})();
