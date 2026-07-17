        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageBox = document.getElementById('messageBox');
            
            fetch('inc/handle_auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                messageBox.innerHTML = `<p class="${data.success ? 'success' : 'error'}">${data.message}</p>`;
                
                if (data.success) {
                    setTimeout(() => {
                        window.location.href = data.redirect || 'index.php';
                    }, 1500);
                }
            })
            .catch(error => {
                messageBox.innerHTML = '<p class="error">An error occurred. Please try again.</p>';
                console.error('Error:', error);
            });
        });