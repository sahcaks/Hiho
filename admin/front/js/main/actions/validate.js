import FormValidator from '../../modules/validate/form_validator.js';
import Toaster from "../../modules/notification/toaster.js";

const toaster = new Toaster();

document.addEventListener('DOMContentLoaded', () => {
    const formValidator = new FormValidator(toaster);
    formValidator.init();
});