<?php include_once APPPATH . '/includes/modals/lunch_break/lunch.php'; ?>
<?php include_once APPPATH . '/includes/modals/lunch_break/break.php'; ?>


<script>
    const minutesDisplay = document.getElementById('minutes');
    const secondsDisplay = document.getElementById('seconds');
    const startBtn = document.getElementById('startBtn');
    minutesDisplay.textContent = "30";
    let countdownInterval;

    startBtn.addEventListener('click', startCountdown);

    function startCountdown() {
        $.ajax({
            url: '<?= home_path() ?>/action/lunch_break.php?do=lunch_allot',
            type: 'POST',
            data: {
                id: 1,
            },
            success: function(responseData) {
                console.log(responseData);
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch data:', error);

            }
        });
        startBtn.style.display = 'none';
        let totalSeconds = 30 * 60; // 30 minutes converted to seconds
        clearInterval(countdownInterval);

        countdownInterval = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(countdownInterval);
                // You can add additional actions when the countdown ends here
            } else {
                const minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;

                minutesDisplay.textContent = minutes < 10 ? '0' + minutes : minutes;
                secondsDisplay.textContent = seconds < 10 ? '0' + seconds : seconds;

                totalSeconds--;
            }
        }, 1000);
    }
</script>

<!-- for break -->
<script>
    let timerInterval;
    let seconds = 0;
    let minutes = 0;
    let hours = 0;
    let stopTimeString = '';

    const hourssDisplay = document.getElementById('hourss');
    const minutessDisplay = document.getElementById('minutess');
    const secondssDisplay = document.getElementById('secondss');
    const startBtnbreak = document.getElementById('startBtnbreak');
    const stopBtnbreak = document.getElementById('stopBtnbreak');
    const stopTimeDisplay = document.getElementById('stopTime');
    const startTimeDisplay = document.getElementById('startTime');
    const total_break_time = document.getElementById('total_break_time');
    const close_break = document.getElementById('close_break');
    stopBtnbreak.style.display = 'none';

    function startTimer() {
        startBtnbreak.style.display = 'none';
        stopBtnbreak.style.display = 'block';
        clearInterval(timerInterval); // Reset timer

        seconds = 0;
        minutes = 0;
        hours = 0;
        updateTimeDisplay();

        let startTime = new Date().getTime();
        console.log(startTime);
        startTimeDisplay.value = startTime;
        timerInterval = setInterval(incrementTimer, 1000);
        startBtnbreak.disabled = true;

    }

    function stopTimer() {

        clearInterval(timerInterval);
        startBtnbreak.disabled = false;
        stopBtnbreak.style.display = 'none';
        const currentTime = new Date().getTime();
        console.log(startTimeDisplay.value);
        console.log(currentTime);

        const timeDifference = currentTime - startTimeDisplay.value;

        stopTimeString = `Total lunch time: ${currentTime}`;
        // ss for reason
        const hourss = Math.floor(timeDifference / (1000 * 60 * 60));
        const minutess = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const secondss = Math.floor((timeDifference % (1000 * 60)) / 1000);

        $displayTime = `${hourss < 10 ? '0' + hourss : hourss}:${minutess < 10 ? '0' + minutess : minutess}:${secondss < 10 ? '0' + secondss : secondss}`;

        stopTimeDisplay.textContent = `Total Break Time: ${$displayTime}`;

        let sendtime = `${$displayTime}`;

        $.ajax({
            url: '<?= home_path() ?>/action/lunch_break.php?do=break_allot',
            type: 'POST',
            data: {
                time: sendtime,
            },
            success: function(response) {
                const responseData = JSON.parse(response);
                console.log(responseData);
                if (responseData.status == true) {
                    total_break_time.textContent = responseData.data;
                } else {
                    console.log(responseData.msg);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
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
        hourssDisplay.textContent = hours < 10 ? '0' + hours : hours;
        minutessDisplay.textContent = minutes < 10 ? '0' + minutes : minutes;
        secondssDisplay.textContent = seconds < 10 ? '0' + seconds : seconds;
    }

    function getCurrentTime() {
        const now = new Date();
        const currentTimeString = `${formatTimeUnit(now.getHours())}:${formatTimeUnit(now.getMinutes())}:${formatTimeUnit(now.getSeconds())}`;
        return currentTimeString;
    }

    function formatTimeUnit(timeUnit) {
        return timeUnit < 10 ? '0' + timeUnit : timeUnit;
    }

    function relodepage() {
        location.reload();
    }

    startBtnbreak.addEventListener('click', startTimer);
    stopBtnbreak.addEventListener('click', stopTimer);

    close_break.addEventListener('click', relodepage);
</script>

<script>
    function isJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }

    function sendAjaxRequest() {
        const d = new Date();
        let time = d.getTime();
        let working_timer = document.getElementById('working_timer');
        timeobj = new Date(time);
        $.ajax({
            url: '<?= home_path() ?>/action/lastlogin.php?do=update_last_login',
            method: 'POST',
            data: {
                time: time,
            },
            success: function(response) {
                if (isJSON(response)) {
                    const responseData = JSON.parse(response);
                    if (responseData.status == true) {
                        console.log('last login time:', response);
                        var hours = timeobj.getHours();
                        var minutes = timeobj.getMinutes();
                        var seconds = timeobj.getSeconds();
                        var formattedMinutes = minutes.toString().padStart(2, '0');
                        var formattedSeconds = seconds.toString().padStart(2, '0');
                        working_timer.innerHTML = hours + ':' + formattedMinutes + ':' + formattedSeconds;
                    } else if (responseData.status == false) {
                        console.log(responseData.msg);

                    }
                } else {
                    console.log('Not valid JSON');
                    location.reload();
                }
            },
            error: function(message) {
                console.error('Ajax request failed:', message);
            }
        })

    }

    // Call the function initially
    sendAjaxRequest();

    // Set interval to call the function every hour (3600000 milliseconds = 1 hour)
    setInterval(sendAjaxRequest, 180000);
</script>