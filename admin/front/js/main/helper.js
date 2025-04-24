export function getFormValues(form) {
    const formData = new FormData(form); // Создаем объект FormData
    console.log(formData);
    const formObject = {};

    formData.forEach((value, key) => {
        // Проверяем, если ключ уже существует (например, для checkbox или множественного выбора)
        if (formObject[key]) {
            if (Array.isArray(formObject[key])) {
                formObject[key].push(value);
            } else {
                formObject[key] = [formObject[key], value];
            }
        } else {
            formObject[key] = value;
        }
    });

    return formObject;
}