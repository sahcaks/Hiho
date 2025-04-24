document.addEventListener('DOMContentLoaded', function () {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    newPassword.addEventListener('input', function () {
        if (newPassword.value.trim() && newPassword.value.length <= 8) {
            newPassword.setCustomValidity('Пароли не совпадают.');
            newPassword.classList.add('is-invalid');
        } else {
            newPassword.setCustomValidity('');
            newPassword.classList.remove('is-invalid');
        }
    });

    confirmPassword.addEventListener('input', function () {
        if (newPassword.value.trim() && newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Пароли не совпадают.');
            confirmPassword.classList.add('is-invalid');
        } else {
            confirmPassword.setCustomValidity('');
            confirmPassword.classList.remove('is-invalid');
        }
    });
});