import Toaster from "../../modules/notification/toaster.js";
import FetchAPI from "../../modules/fetch/fetch_api.js";

document.addEventListener('DOMContentLoaded', () => {
    const toaster = new Toaster();
    const api = new FetchAPI();

    const ACTION_URL = window.location.href.substring(0, window.location.href.lastIndexOf('/'));
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');
    const addImageButton = document.getElementById('addImageButton');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');

    if (!!addImageButton) {
        addImageButton.addEventListener('click', () => {
            fileInput.click();
        });
    }
    if (!!updateButton && !!fileInput && !!imagePreview) {
        updateButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file && !!currentImage) {
                currentImage.classList.remove('d-none');
                const reader = new FileReader();
                reader.onload = (e) => {
                    currentImage.src = e.target.result;
                    let data = new FormData();
                    data.append('image', file);
                    data.append('id', updateButton.dataset.id)
                    api.post(ACTION_URL + '/actions/update_image.php', data).then(data => {
                        toaster.showNotification({
                            title: 'Успешно', message: data.description, type: 'success',
                        });
                    })
                        .catch(error => {
                            toaster.showNotification({
                                title: 'Ошибка', message: error.description, type: 'danger',
                            });
                        });
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('d-none');
                addImageButton.classList.add('d-none');
            }
        });
    }

    if (!!deleteButton && !!currentImage) {
        deleteButton.addEventListener('click', () => {
            currentImage.src = '';
            currentImage.classList.add('d-none');
            let data = new FormData();
            data.append('id', deleteButton.dataset.id);
            api.post(ACTION_URL + '/actions/remove_image.php', data)
                .then(data => toaster.showNotification({
                    title: 'Успешно', message: data.description, type: 'success',
                }))
                .catch(error => toaster.showNotification({
                    title: 'Ошибка', message: error.description, type: 'danger',
                }));
        });
    }

    const form = document.querySelector('form#update');

    if (!!form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (form.checkValidity()) {
                let data = new FormData(form);
                api.post(ACTION_URL + '/actions/update.php', data)
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