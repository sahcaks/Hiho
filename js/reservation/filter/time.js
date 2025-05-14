import Grid from "../../gridstack/gridstack.js";

const timeStartInput = document.getElementById('time-start');
const timeEndInput = document.getElementById('time-end');
const date = document.getElementById('date');

let timeStartSet, timeEndSet = false;

const today = new Date().toISOString().split('T')[0];
date.setAttribute('min', today);

function generateTimeOptions(startHour, endHour, date = new Date()) {
    const times = [];
    const currentHour = date.getHours();
    const currentMinute = date.getMinutes();

    for (let h = startHour; h < endHour; h++) {
        for (let m = 0; m < 60; m += 30) {
            if (h > currentHour || (h === currentHour && m >= currentMinute)) {
                const hour = String(h).padStart(2, '0');
                const minute = String(m).padStart(2, '0');
                times.push(`${hour}:${minute}`);
            }
        }
    }

    return times;
}

let startTimeOptions = generateTimeOptions(9, 22);
let endTimeOptions = generateTimeOptions(9, 23);

function buildTimeSelect() {
    timeStartInput.innerHTML = '';
    timeEndInput.innerHTML = '';
    startTimeOptions.forEach((time) => {
        const option = document.createElement("option");
        option.value = time;
        option.textContent = time;
        timeStartInput.appendChild(option);
    });

    if (startTimeOptions.length > 0) {
        const selectedTimeIndex = startTimeOptions.indexOf(timeStartInput.value);
        endTimeOptions.slice(selectedTimeIndex + 1).forEach((time) => {
            const option = document.createElement("option");
            option.value = time;
            option.textContent = time;
            timeEndInput.appendChild(option);
        });

        timeEndInput.disabled = false;
        timeStartSet = timeEndSet = true;
    }
}

timeStartInput.addEventListener("change", () => {
    timeEndInput.innerHTML = ""; //
    const selectedTimeIndex = startTimeOptions.indexOf(timeStartInput.value);
    if (selectedTimeIndex !== -1) {
        endTimeOptions.slice(selectedTimeIndex + 1).forEach((time) => {
            const option = document.createElement("option");
            option.value = time;
            option.textContent = time;
            timeEndInput.appendChild(option);
        });
        timeEndInput.disabled = false;
    } else {
        timeEndInput.disabled = true;
    }
});

timeStartInput.addEventListener("change", async function () {
    timeStartSet = true;
    if (timeEndSet && date.value.length !== 0) {
        await updateGrid(timeStartInput.value, timeEndInput.value, date.value);
    }
});

timeEndInput.addEventListener("change", async function () {
    timeEndSet = true;
    if (timeStartSet && date.value.length !== 0) {
        await updateGrid(timeStartInput.value, timeEndInput.value, date.value);
    }
});

date.addEventListener("change", async function (element) {
    startTimeOptions = generateTimeOptions(9, 22, addCurrentTimeToDate(element.target.value));
    endTimeOptions = generateTimeOptions(9, 23, addCurrentTimeToDate(element.target.value));
    buildTimeSelect();
    if (startTimeOptions.length > 0 && timeStartSet && date.value.length !== 0) {
        await updateGrid(timeStartInput.value, timeEndInput.value, date.value);
    } else {
        await Grid.loadGrid();
    }
});

async function updateGrid(timeStart, timeEnd, date) {
    await Grid.updateGridByDateTime(timeStart, timeEnd, date).then(r => console.log('Grid is updated!'))
}

function addCurrentTimeToDate(dateString) {
    const date = new Date(dateString);

    if (isNaN(date.getTime())) {
        throw new Error("Invalid date string provided");
    }
    const now = new Date();
    if (date.toDateString() === now.toDateString()) {
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        date.setHours(hours, minutes, seconds);
    }

    return date;
}

buildTimeSelect();