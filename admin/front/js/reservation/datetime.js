import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../../../../js/modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();
const ACTION_URL = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

let dates = document.querySelectorAll('input.date-reservation');
let times = document.querySelectorAll('input.time-reservation');

if (dates.length > 0) {
    Array.prototype.slice.call(dates).forEach(function (date) {
        date.addEventListener('input', function (element) {
            let data = new FormData();
            console.log(element.target.value, element.target.dataset.reservationId)
            data.append('date', element.target.value);
            data.append('id', element.target.dataset.reservationId);
            api.post(ACTION_URL + '/actions/update.php', data)
                .then(data => toaster.showNotification({
                    title: 'Успешно', message: data.description, type: 'success',
                }))
                .catch(error => toaster.showNotification({
                    title: 'Ошибка', message: error.description, type: 'danger',
                }));
        });
    });
}


if (times.length > 0) {
    Array.prototype.slice.call(times).forEach(function (time) {
        time.addEventListener('focusout', function (element) {
            let data = new FormData();
            data.append('time', element.target.value);
            data.append('id', element.target.dataset.reservationId);
            api.post(ACTION_URL + '/actions/update.php', data)
                .then(data => toaster.showNotification({
                    title: 'Успешно', message: data.description, type: 'success',
                }))
                .catch(error => toaster.showNotification({
                    title: 'Ошибка', message: error.description, type: 'danger',
                }));
        });
    });
}

