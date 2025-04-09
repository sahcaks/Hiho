const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
const GET_TABLE_URL = MAIN_URL + "reservation/getTable.php";
const SET_RESERVE_URL = MAIN_URL + "reservation/reserve.php";

GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

let serializedData = [];

let grid = GridStack.init({
    minRow: 4,
    cellHeight: 150,
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
    let data = new FormData(document.forms[1]);
    let selectedTables = getAllSelectedTables();
    if (selectedTables.length === 0) {
        return alert('LOL! Select min one seat, pls.');
    }
    data.set('tables_id', JSON.stringify(selectedTables));
    await fetch(SET_RESERVE_URL, {
        'method': 'post',
        'body': data
    }).then(response => console.log(response))
}

async function loadGrid() {
    serializedData = (await getTables()).map((value) => {
        value.settings = JSON.parse(value.settings);
        value.settings.id = String(value.table_number);
        value.settings.content += `<button data-table-id="${value.settings.id}" class="btn ${!!parseInt(value.status) ? 'btn-danger table-number-reserved' : 'btn-outline-light table-number'}"><div>${!!parseInt(value.status) ? 'Reserved' : `№ ${value.settings.id}`}</div></button> ${value.settings.content ? value.settings.content : ''}`;
        return value.settings;
    });
    grid.load(serializedData);
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
    console.log('start saving!');
    await save();
    console.log('end!');

});
