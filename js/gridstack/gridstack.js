import Toaster from "../modules/notification/toaster.js";

const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
const GET_TABLE_URL = MAIN_URL + "reservation/getTable.php";
const FILTER_TABLE_URL = MAIN_URL + "reservation/getTablesByTime.php";
const SET_RESERVE_URL = MAIN_URL + "reservation/reserve.php";
const STATUS_LIST = {
    'Open': 0,
    'Pending': 1,
    'Reserved': 2,
};
const toaster = new Toaster();
const submitButton = document.getElementById('save');
GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

class Grid {
    constructor() {
        this.grid = GridStack.init({
            minRow: 4,
            cellHeight: 125,
            staticGrid: true,
        });
        this.serializedData = [];
    }

    getAllSelectedTables() {
        let data = [];
        let selectedTables = document.querySelectorAll('.reserve-table');
        selectedTables.forEach((value) => {
            data.push(value.dataset.tableId);
        });
        return data;
    }

    async save() {
        let form = document.querySelector('.needs-validation');

        if (!form.checkValidity()) {
            submitButton.disabled = false;
            return false;
        }

        let data = new FormData(document.forms[1]);
        let selectedTables = this.getAllSelectedTables();
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

    async loadGrid() {
        this.serializedData = (await getTables()).map((value) => {
            let data = convertToGridStackObject(value);
            data.content += `<button disabled class="btn btn-outline-light table-number"><div>${'№ ' + data.id}</div></button>`;
            Object.assign(data, JSON.parse(data.others));
            delete data.others;
            return data;
        });
        this.grid.load(this.serializedData);
    }

    async updateGridByDateTime(timeStart, timeEnd, date) {
        this.serializedData = (await filterByDateTime(timeStart, timeEnd, date)).map((value) => {
            let data = convertToGridStackObject(value);
            data.content += `<button data-table-id="${data.id}" class="btn ${getClassForStatusButton(data.status)}"><div>${getTextForStatusButton(data.status, data.id)}</div></button> ${data.content ? data.content : ''}`;
            Object.assign(data, JSON.parse(data.others));
            delete data.others;
            return data;
        });
        this.grid.load(this.serializedData);
        addActionsToTables();
    }
}

async function getTables() {
    return await fetch(GET_TABLE_URL, {
        'headers': {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    }).then(response => response.status === 200 ? response.json() : null);
}

async function filterByDateTime(timeStart, timeEnd, date) {
    let data = new FormData();
    data.append('time_start', timeStart);
    data.append('time_end', timeEnd);
    data.append('date', date);
    return await fetch(FILTER_TABLE_URL, {
        method: 'POST',
        body: data
    }).then(response => response.status === 200 ? response.json() : null);
}

function convertToGridStackObject(data) {
    return {
        id: parseInt(data.id),
        status: parseInt(data.status),
        x: data.x_coordinate,
        y: data.y_coordinate,
        w: data.width,
        h: data.height,
        content: data.content,
        others: data.others
    };
}

function getClassForStatusButton(status) {
    switch (status) {
        case STATUS_LIST.Pending:
            return 'btn-warning table-number-reserve'
        case STATUS_LIST.Reserved:
            return 'btn-danger table-number-reserved'
        default:
            return 'btn-outline-light table-number'
    }
}

function getTextForStatusButton(status, id) {
    switch (status) {
        case STATUS_LIST.Pending:
            return 'Reserve'
        case STATUS_LIST.Reserved:
            return 'Reserved'
        default:
            return '№ ' + id
    }
}

function addActionsToTables() {
    document.querySelectorAll('button.table-number').forEach((element) => {
        element.addEventListener('click', () => {
            element.classList.toggle('reserve-table');
        });
    });
}

const grid = new Grid();
grid.loadGrid().then(r => console.log('Tables scheme load!')).then(() => {
    addActionsToTables();
});

document.forms[1].addEventListener('submit', async function (e) {
    e.preventDefault();

    submitButton.disabled = true;
    await grid.save();
});

export default grid;