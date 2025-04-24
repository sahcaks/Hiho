import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();
const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
const GET_TABLE_URL = MAIN_URL + "admin/table_arrangement/getTable.php";
const UPDATE_COORDINATES_URL = MAIN_URL + 'admin/table_arrangement/update_coordinates.php'


GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

let serializedData = [];
let grid = GridStack.init({
    minRow: 4,
    cellHeight: 125,
    float: true,
    draggable: {cancel: '.no-drag'}
});

async function loadGrid() {
    serializedData = (await getTables()).map((value) => {
        let data = convertToGridStackObject(value);
        data.content += `<div class="table-number">№ ${data.id}</div> ${data.content ? data.content : ''}`;
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
        w: data.width,
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

grid.on('change', function (event, items) {
    const blocks = items.map((item) => ({
        id: item.id,
        x: item.x,
        y: item.y,
        width: item.w,
        height: item.h,
    }));

    let data = new FormData();
    data.append('blocks', JSON.stringify(blocks));

    // Отправка данных на сервер
    api.post(UPDATE_COORDINATES_URL, data)
        .then(data => toaster.showNotification({
            title: 'Успешно', message: data.description, type: 'success',
        }))
        .catch(error => toaster.showNotification({
            title: 'Ошибка', message: error.description, type: 'danger',
        }));
});

loadGrid().then(r => console.log('Tables grid is load!'));