// Handle register form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const messageBox = document.getElementById('messageBox');
            
            // Client-side password validation
            if (password.length < 8) {
                messageBox.innerHTML = '<p class="error">Password must be at least 8 characters long</p>';
                return;
            }
            if (!/[A-Z]/.test(password)) {
                messageBox.innerHTML = '<p class="error">Password must contain at least one uppercase letter</p>';
                return;
            }
            if (!/[a-z]/.test(password)) {
                messageBox.innerHTML = '<p class="error">Password must contain at least one lowercase letter</p>';
                return;
            }
            if (!/[0-9]/.test(password)) {
                messageBox.innerHTML = '<p class="error">Password must contain at least one number</p>';
                return;
            }
            
            // If validation passes, submit
            const formData = new FormData(this);
            
            fetch('inc/handle_auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                messageBox.innerHTML = `<p class="${data.success ? 'success' : 'error'}">${data.message}</p>`;
                
                if (data.success) {
                    // Reset form
                    document.getElementById('registerForm').reset();
                    
                    // Redirect to login page after successful registration
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                }
            })
            .catch(error => {
                messageBox.innerHTML = '<p class="error">An error occurred. Please try again.</p>';
                console.error('Error:', error);
            });
        });