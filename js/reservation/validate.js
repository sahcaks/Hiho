import Toaster from "../modules/notification/toaster.js";

const toaster = new Toaster();


(function () {
    'use strict';
    // Найти все формы, к которым нужно применить пользовательскую валидацию
    let forms = document.querySelectorAll('.needs-validation');

    // Перебор форм и предотвращение отправки
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                toaster.showNotification({
                    title: 'Ошибка',
                    message: 'Заполните все поля правильно!',
                    type: 'danger',
                });
                return false;
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
