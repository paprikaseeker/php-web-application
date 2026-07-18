// Logout functionality
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        fetch('inc/handle_auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=logout'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php';
            } else {
                alert('Logout failed: ' + data.message);
            }
        })
        .catch(error => {
            alert('An error occurred during logout.');
            console.error('Error:', error);
        });
    }
}