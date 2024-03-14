 
let timerInterval;
let seconds = 0;
let minutes = 0;
let hours = 0;
let stopTimeString = '';

const hoursDisplay = document.getElementById('hours');
const minutesDisplay = document.getElementById('minutes');
const secondsDisplay = document.getElementById('seconds');
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const stopTimeDisplay = document.getElementById('stopTime');
const startTimeDisplay = document.getElementById('startTime');


function startTimer() {
    clearInterval(timerInterval); // Reset timer

    seconds = 0;
    minutes = 0;
    hours = 0;
    updateTimeDisplay();

    let startTime = new Date().getTime();
    console.log(startTime);
    startTimeDisplay.value = startTime;
    timerInterval = setInterval(incrementTimer, 1000);
    startBtn.disabled = true;

}

function stopTimer() {
    clearInterval(timerInterval);
    startBtn.disabled = false;

    const currentTime = new Date().getTime();
    console.log(startTimeDisplay.value);
    const timeDifference = currentTime - startTimeDisplay.value;

    stopTimeString = `Total lunch time: ${currentTime}`;

    const hourss = Math.floor(timeDifference / (1000 * 60 * 60));
    const minutess = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    const secondss = Math.floor((timeDifference % (1000 * 60)) / 1000);

    stopTimeDisplay.textContent = `Total Lunch Time: ${hourss}:${minutess}:${secondss}`;
    // console.log(`Total Lunch Time: ${hourss}:${minutess}:${secondss}`);

}

function incrementTimer() {
    seconds++;

    if (seconds >= 60) {
        seconds = 0;
        minutes++;

        if (minutes >= 60) {
minutes = 0;
hours++;
        }
    }

    updateTimeDisplay();
}

function updateTimeDisplay() {
    hoursDisplay.textContent = hours < 10 ? '0' + hours : hours;
    minutesDisplay.textContent = minutes < 10 ? '0' + minutes : minutes;
    secondsDisplay.textContent = seconds < 10 ? '0' + seconds : seconds;
}

function getCurrentTime() {
    const now = new Date();
    const currentTimeString = `${formatTimeUnit(now.getHours())}:${formatTimeUnit(now.getMinutes())}:${formatTimeUnit(now.getSeconds())}`;
    return currentTimeString;
}

function formatTimeUnit(timeUnit) {
    return timeUnit < 10 ? '0' + timeUnit : timeUnit;
}

startBtn.addEventListener('click', startTimer);
stopBtn.addEventListener('click', stopTimer);
      