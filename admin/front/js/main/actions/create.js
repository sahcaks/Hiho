import FetchAPI from "../../modules/fetch/fetch_api.js";
import Toaster from "../../../js/modules/notification/toaster.js";
import '../../reservation/time.js';

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

    const timeStartInput = document.getElementById('time-start');
    const timeEndInput = document.getElementById('time-end');
    const date = document.getElementById('date');

    const today = new Date().toISOString().split('T')[0];
    date.setAttribute('min', today);

    function generateTimeOptions(startHour, endHour) {
        const times = [];
        for (let h = startHour; h < endHour; h++) {
            for (let m = 0; m < 60; m += 30) {
                const hour = String(h).padStart(2, '0');
                const minute = String(m).padStart(2, '0');
                times.push(`${hour}:${minute}`);
            }
        }
        return times;
    }

    const startTimeOptions = generateTimeOptions(9, 21);
    const endTimeOptions = generateTimeOptions(9, 23);

    startTimeOptions.forEach((time) => {
        const option = document.createElement("option");
        option.value = time;
        option.textContent = time;
        timeStartInput.appendChild(option);
    });

    const selectedTimeIndex = startTimeOptions.indexOf(timeStartInput.value);
    endTimeOptions.slice(selectedTimeIndex + 1).forEach((time) => {
        const option = document.createElement("option");
        option.value = time;
        option.textContent = time;
        timeEndInput.appendChild(option);
    });
});