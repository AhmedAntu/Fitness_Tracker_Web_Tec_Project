let timer = null;
let seconds = 0;
let timerMsg = document.getElementById('timerMsg');

function updateTimerDisplay(){
    let minutes = Math.floor(seconds / 60);
    let sec = seconds % 60;
    let display = (minutes < 10 ? '0' : '') + minutes + ':' + (sec < 10 ? '0' : '') + sec;
    document.getElementById('timeDisplay').innerHTML = display;
}

function startTimer(){
    if(timer !== null) return;
    timer = setInterval(() => {
        seconds++;
        updateTimerDisplay();
    }, 1000);
    if(timerMsg) {
        timerMsg.innerHTML = "Timer started";
        timerMsg.style.color = 'green';
    }
}

function stopTimer(){
    if(timer !== null){
        clearInterval(timer);
        timer = null;
        if(timerMsg){
            timerMsg.innerHTML = "Timer stopped";
            timerMsg.style.color = 'orange';
        }
    }
}

function resetTimer(){
    seconds = 0;
    updateTimerDisplay();
    if(timerMsg){
        timerMsg.innerHTML = "Timer reset";
        timerMsg.style.color = 'blue';
    }
}
