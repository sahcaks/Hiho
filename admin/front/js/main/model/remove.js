import Toaster from "../../modules/notification/toaster.js";
import FetchAPI from "../../modules/fetch/fetch_api.js";

const api = new FetchAPI();
const toaster = new Toaster();
const URL_TO_REMOVE = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

document.addEventListener('DOMContentLoaded', function () {
    let targetButton = null;
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    const confirmationModal = document.getElementById('confirmDeleteModal');
    let id, url = null;
    if (!!confirmDeleteButton && !!confirmationModal) {
        confirmationModal.addEventListener('show.bs.modal', (event) => {
            targetButton = event.relatedTarget;

            id = targetButton.getAttribute('data-remove-id');
            url = targetButton.getAttribute('data-url');
        });

        confirmDeleteButton.addEventListener('click', function () {
            performDelete(URL_TO_REMOVE + '/' + url, id);
        });
    }
});

function performDelete(url, id) {
    const modalElement = document.getElementById('confirmDeleteModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    modal.hide();
    let data = new FormData();
    data.append('id', id);
    api.post(url, data)
        .then((data) => {
            toaster.showNotification({
                title: 'Успех', message: data.description, type: 'success',
            });
            setTimeout(function () {
                window.location.reload();
            }, 2500);
        })
        .catch(error => toaster.showNotification({
            title: 'Ошибка', message: error.description, type: 'danger',
        }));
}
