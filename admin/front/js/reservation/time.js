const timeStartInput = document.querySelectorAll('.time-start');
const timeEndInput = document.querySelectorAll('.time-end');
const date = document.querySelectorAll('.date-reservation');

function generateTimeOptions(startHour, endHour) {
    const times = [];
    for (let h = startHour; h < endHour; h++) {
        for (let m = 0; m < 60; m += 30) {
            const hour = String(h).padStart(2, '0');
            const minute = String(m).padStart(2, '0');
            times.push(`${hour}:${minute}`);
        }
    }
    return times;
}

const startTimeOptions = generateTimeOptions(9, 21);
const endTimeOptions = generateTimeOptions(9, 23);

startTimeOptions.forEach((time) => {
    timeStartInput.forEach((item) => {
        const option = document.createElement("option");
        if (item.dataset.value === time) {
            option.selected = true;
        }
        option.value = time;
        option.textContent = time;
        item.appendChild(option);
    });
});

const selectedTimeIndex = startTimeOptions.indexOf(timeStartInput.value);
endTimeOptions.slice(selectedTimeIndex + 1).forEach((time) => {
    timeEndInput.forEach((item) => {
        const option = document.createElement("option");
        if (item.dataset.value === time) {
            option.selected = true;
        }
        option.value = time;
        option.textContent = time;
        item.appendChild(option);
    });
});

date.forEach((date) => {
    const today = new Date().toISOString().split('T')[0];
    date.setAttribute('min', today);
});