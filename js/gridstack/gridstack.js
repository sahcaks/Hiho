import Toaster from "../modules/notification/toaster.js";

const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
const GET_TABLE_URL = MAIN_URL + "reservation/getTable.php";
const SET_RESERVE_URL = MAIN_URL + "reservation/reserve.php";
const toaster = new Toaster();
const submitButton = document.getElementById('save');

GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

let serializedData = [];

let grid = GridStack.init({
    minRow: 4,
    cellHeight: 125,
    staticGrid: true,
});

function getAllSelectedTables() {
    let data = [];
    let selectedTables = document.querySelectorAll('.reserve-table');
    selectedTables.forEach((value) => {
        data.push(value.dataset.tableId);
    });
    return data;
}

async function save() {
    let form = document.querySelector('.needs-validation');

    if (!form.checkValidity()) {
        submitButton.disabled = false;
        return false;
    }

    let data = new FormData(document.forms[1]);
    let selectedTables = getAllSelectedTables();
    if (selectedTables.length === 0) {
        toaster.showNotification({
            title: 'Ошибка',
            message: 'Выберите стол!',
            type: 'danger',
        });
        submitButton.disabled = false;
        return false;
    }
    data.set('tables_id', JSON.stringify(selectedTables));
    await fetch(SET_RESERVE_URL, {
        'method': 'post',
        'body': data
    }).then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.description);
        }
        return response.json();
    })
        .then(() => {
            toaster.showNotification({
                title: 'Успешно',
                message: 'Ваша бронь успешно создана, в скором времени с Вами свяжется наш менеджер.',
                type: 'success',
            });
            setTimeout(() => location.reload(), 3000);
        })
        .catch(error => {
            toaster.showNotification({
                title: 'Ошибка',
                message: error.message,
                type: 'danger',
            });
            submitButton.disabled = false;
        });
}

async function loadGrid() {
    serializedData = convertToGridStackObject(await getTables());

    serializedData = (await getTables()).map((value) => {
        let data = convertToGridStackObject(value);
        data.content += `<button data-table-id="${data.id}" class="btn ${data.status ? 'btn-danger table-number-reserved' : 'btn-outline-light table-number'}"><div>${data.status ? 'Reserved' : `№ ${data.id}`}</div></button> ${data.content ? data.content : ''}`;
        Object.assign(data, JSON.parse(data.others));
        delete data.others;
        return data;
    });
    grid.load(serializedData);
}

function convertToGridStackObject(data) {
    return {
        id: parseInt(data.id),
        status: !!parseInt(data.status),
        x: data.x_coordinate,
        y: data.y_coordinate,
        w: data.weight,
        h: data.height,
        content: data.content,
        others: data.others
    };
}

async function getTables() {
    return await fetch(GET_TABLE_URL, {
        'headers': {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    }).then(response => response.status === 200 ? response.json() : null);
}

loadGrid().then(r => console.log('Tables scheme load!')).then(() => {
    document.querySelectorAll('button.table-number').forEach((element) => {
        element.addEventListener('click', () => {
            element.classList.toggle('reserve-table');
        });
    });
});

document.forms[1].addEventListener('submit', async function (e) {
    e.preventDefault();

    submitButton.disabled = true;

    await save();
});
