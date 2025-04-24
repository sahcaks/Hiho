import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../../../../js/modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();

let statuses = document.querySelectorAll('select.reservationSelect');

if (statuses.length > 0) {
    Array.prototype.slice.call(statuses).forEach(function (status) {
        status.addEventListener('change', function (element) {
            let data = new FormData();
            data.append('status', element.target.value);
            data.append('table_id', element.target.dataset.tableId);
            data.append('reservation_id', element.target.dataset.reservationId);
            api.post('admin/table_arrangement/update_status.php', data)
                .then(data => toaster.showNotification({
                    title: 'Успешно', message: data.description, type: 'success',
                }))
                .catch(error => toaster.showNotification({
                    title: 'Ошибка', message: error.description, type: 'danger',
                }));
        });
    });
}

