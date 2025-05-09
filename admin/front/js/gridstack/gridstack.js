import FetchAPI from "../modules/fetch/fetch_api.js";
import Toaster from "../modules/notification/toaster.js";

const api = new FetchAPI();
const toaster = new Toaster();
const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
const GET_TABLE_URL = MAIN_URL + "admin/table_arrangement/getTable.php";
const UPDATE_COORDINATES_URL = MAIN_URL + 'admin/table_arrangement/update_coordinates.php'
const saveGrid = document.getElementById('save-grid');
// Координаты "запрещенной зоны" (центр сетки)
const restrictedArea = {
    xStart: 2, // Начало по оси X
    xEnd: 9,   // Конец по оси X
    yStart: 0, // Начало по оси Y
    yEnd: 6,   // Конец по оси Y
};


GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

let serializedData = [];
let grid = GridStack.init({
    minRow: 4,
    maxRow: 4,
    column: 12,
    cellHeight: 125,
    float: false,
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
    items.forEach(item => {
        const isRestricted =
            item.x < restrictedArea.xEnd &&
            item.x + item.w > restrictedArea.xStart &&
            item.y < restrictedArea.yEnd &&
            item.y + item.h > restrictedArea.yStart;

        if (isRestricted) {
            const prevX = item._origX || 0;
            const prevY = item._origY || 0;
            grid.update(item.el, {x: prevX, y: prevY});
        } else {
            item._origX = item.x;
            item._origY = item.y;
            saveGrid.classList.remove('d-none');
        }
    });
});

saveGrid.addEventListener('click', function (e) {
   e.preventDefault();

    serializedData = grid.save();
    const blocks = grid.getGridItems().map((item) => ({
        id: item.gridstackNode.id,
        x: item.gridstackNode.x,
        y: item.gridstackNode.y,
        width: item.gridstackNode.w,
        height: item.gridstackNode.h,
    }));
    let data = new FormData();
    data.append('blocks', JSON.stringify(blocks));

    api.post(UPDATE_COORDINATES_URL, data)
        .then(data => toaster.showNotification({
            title: 'Успешно', message: data.description, type: 'success',
        }))
        .catch(error => toaster.showNotification({
            title: 'Ошибка', message: error.description, type: 'danger',
        }));
});

loadGrid().then(r => console.log('Tables grid is load!'));