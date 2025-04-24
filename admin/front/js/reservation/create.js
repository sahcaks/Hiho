import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../../../../js/modules/notification/toaster.js";
import {getFormValues} from '../main/helper.js';

const api = new FetchAPI();
const toaster = new Toaster();
const ACTION_URL = window.location.href.substring(0, window.location.href.lastIndexOf('/'));
const RESERVATION_CREATE_URL = ACTION_URL + '/create.php'

document.addEventListener('DOMContentLoaded', () => {
    const submitButton = document.getElementById('save');
    const form = document.querySelector('form');

    if (!!form) {

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            submitButton.disabled = true;

            let data = getFormValues(form);
            api.post(RESERVATION_CREATE_URL, data)
                .then(data => {
                    toaster.showNotification({
                        title: 'Успешно', message: data.description, type: 'success',
                    });
                    setTimeout(() => window.location.replace(ACTION_URL + '/list.php'), 2500)
                })
                .catch(error => {
                    toaster.showNotification({
                        title: 'Ошибка', message: error.description, type: 'danger',
                    });
                    submitButton.disabled = false;
                });
        });
    }
});