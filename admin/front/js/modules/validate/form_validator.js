export default class FormValidator {
    constructor(toaster) {
        this.toaster = toaster;
    }

    validateForm(form) {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                this.toaster.showNotification({
                    title: 'Ошибка',
                    message: 'Заполните все поля правильно!',
                    type: 'danger',
                });
                form.classList.add('was-validated');
                return false;
            }
        }, false);
    }

    init() {
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach((form) => {
            this.validateForm(form);
        });
    }
}