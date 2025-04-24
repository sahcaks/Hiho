import FetchAPI from "../../modules/fetch/fetch_api.js";
import Toaster from "../../../js/modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();
const ACTION_URL = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form#create');

    if (!!form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (form.checkValidity()) {
                let data = new FormData(form);
                api.post(ACTION_URL + '/actions/create.php', data)
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
                    });
            }
        });
    }
});