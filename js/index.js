document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Базовая валидация
        if (username.length < 3) {
            showError('Имя пользователя должно быть не менее 3 символов');
            return;
        }

        if (password.length < 6) {
            showError('Пароль должен быть не менее 6 символов');
            return;
        }

        // Отправка формы на сервер
        fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(loginForm))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'dashboard.php';
                } else {
                    showError(data.message || 'Ошибка входа');
                }
            })
            .catch(error => {
                showError('Произошла ошибка при входе');
            });
    });
});

function showError(message) {
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
}

function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const passwordIcon = document.querySelector('.toggle-password');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordIcon.textContent = "🙈";
    } else {
        passwordField.type = "password";
        passwordIcon.textContent = "👁️";
    }
}