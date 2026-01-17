$(document).ready(function() {
    // Make an AJAX call to the php script to get the IP
    $.ajax({
        url: "/plugins/publicip/publicip.php",
        type: "GET",
        success: function(data) {
            // If the call is successful, add the IP to the footer
            if (data && data.trim() !== 'Unavailable') {
                $('#footer').find('.credits').prepend('<span style="margin-right: 20px;">Public IP: <strong>' + data.trim() + '</strong></span>');
            } else {
                 $('#footer').find('.credits').prepend('<span style="margin-right: 20px;">Public IP: <strong>Unavailable</strong></span>');
            }
        },
        error: function() {
            // If the call fails, show an error
            $('#footer').find('.credits').prepend('<span style="margin-right: 20px;">Public IP: <strong>Error</strong></span>');
        }
    });
});