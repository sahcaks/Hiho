import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../../../../js/modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();

let statuses = document.querySelectorAll('select#reservationSelect');

Array.prototype.slice.call(statuses).forEach(function (status) {
    status.addEventListener('change', function (element) {
        api.post('admin/table_arrangement/update_status.php', {
            status: element.target.value, id: element.target.dataset.tableId
        })
            .then(data => toaster.showNotification({
                title: 'Успешно', message: data.description, type: 'success',
            }))
            .catch(error => toaster.showNotification({
                title: 'Ошибка', message: error.description, type: 'danger',
            }));
    });
});

