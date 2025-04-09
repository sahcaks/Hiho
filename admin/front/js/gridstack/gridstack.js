// NOTE: REAL apps would sanitize-html or DOMPurify before blinding setting innerHTML. see #2736
GridStack.renderCB = function (el, w) {
    el.innerHTML = w.content;
};

let serializedData = [
    {x: 0, y: 0, w: 2, content: '<div class="square"></div>', noResize: true},
    {x: 0, y: 1, w: 2, h: 2, content: '<div class="ractangle"></div>', noResize: true},
    {x: 0, y: 3, w: 2, content: '<div class="square"></div>', noResize: true},
    {x: 10, y: 0, w: 2, content: '<div class="square"></div>', noResize: true},
    {x: 10, y: 1, w: 2, h: 2, content: '<div class="ractangle"></div>', noResize: true},
    {x: 10, y: 3, w: 2, content: '<div class="square"></div>', noResize: true},
];
serializedData.forEach((n, i) => {
    n.id = String(++i);
    n.content = `<br> <div class="table-number">№${i}</div><br> ${n.content ? n.content : ''}`;
});
let serializedFull;

let grid = GridStack.init({
    minRow: 4, // don't let it collapse when empty
    cellHeight: 150,
    columnOpts: {
        breakpointForWindow: true,  // test window vs grid size
        breakpoints: [{w:700, c:1},{w:850, c:3},{w:950, c:6},{w:1100, c:8}]
    },
    float: true,
    draggable: {cancel: '.no-drag'} // example of additional custom elements to skip drag on
}).load(serializedData);
addEvents(grid);

// 2.x method - just saving list of widgets with content (default)
function loadGrid() {
    grid.load(serializedData);
}

// 2.x method
function saveGrid() {
    delete serializedFull;
    serializedData = grid.save();
    document.querySelector('#saved-data').value = JSON.stringify(serializedData, null, '  ');
}

function clearGrid() {
    grid.removeAll();
}

function removeWidget(el) {
    // TEST removing from DOM first like Angular/React/Vue would do
    el.remove();
    grid.removeWidget(el, false);
}

// setTimeout(() => loadGrid(), 1000); // TEST force a second load which should be no-op