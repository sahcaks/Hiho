import Grid from "../../gridstack/gridstack.js";

const timeStartInput = document.getElementById('time-start');
const timeEndInput = document.getElementById('time-end');
const date = document.getElementById('date');

let timeStartSet, timeEndSet = false;

const today = new Date().toISOString().split('T')[0];
date.setAttribute('min', today);

function generateTimeOptions(startHour, endHour) {
    const times = [];
    const now = new Date();
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();

    for (let h = startHour; h < endHour; h++) {
        for (let m = 0; m < 60; m += 30) {
            if (
                h > currentHour ||
                (h === currentHour && m >= currentMinute)
            ) {
                const hour = String(h).padStart(2, '0');
                const minute = String(m).padStart(2, '0');
                times.push(`${hour}:${minute}`);
            }
        }
    }

    return times;
}

const startTimeOptions = generateTimeOptions(9, 22);
const endTimeOptions = generateTimeOptions(9, 23);

startTimeOptions.forEach((time) => {
    const option = document.createElement("option");
    option.value = time;
    option.textContent = time;
    timeStartInput.appendChild(option);
});

const selectedTimeIndex = startTimeOptions.indexOf(timeStartInput.value);
endTimeOptions.slice(selectedTimeIndex + 1).forEach((time) => {
    const option = document.createElement("option");
    option.value = time;
    option.textContent = time;
    timeEndInput.appendChild(option);
});

timeEndInput.disabled = false;
timeStartSet = timeEndSet = true;

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

date.addEventListener("change", async function () {
    if (timeStartSet && date.value.length !== 0) {
        await updateGrid(timeStartInput.value, timeEndInput.value, date.value);
    }
});

async function updateGrid(timeStart, timeEnd, date) {
    await Grid.updateGridByDateTime(timeStart, timeEnd, date).then(r => console.log('Grid is updated!'))
}