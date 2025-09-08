<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Timer</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let timer = null;
        let seconds = 0;

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

            let timerMsg = document.getElementById('timerMsg');
            if(timerMsg) {
                timerMsg.innerHTML = "Timer started";
                timerMsg.style.color = 'green';
            }
        }

        function stopTimer(){
            if(timer !== null){
                clearInterval(timer);
                timer = null;
                let timerMsg = document.getElementById('timerMsg');
                if(timerMsg){
                    timerMsg.innerHTML = "Timer stopped";
                    timerMsg.style.color = 'orange';
                }
            }
        }

        function resetTimer(){
            seconds = 0;
            updateTimerDisplay();
            let timerMsg = document.getElementById('timerMsg');
            if(timerMsg){
                timerMsg.innerHTML = "Timer reset";
                timerMsg.style.color = 'blue';
            }
        }
    </script>
</head>
<body id="antu">
    <h1 id="Header">Workout Timer</h1>
    
    <div style="text-align:center; margin-top:40px;">
        <div id="timeDisplay" style="font-size: 50px; font-weight: bold;">00:00</div>
        <div id="timerMsg" style="margin-top:10px; font-weight:bold;"></div>
        <button style="color: rgb(12, 99, 12);" onclick="startTimer()">Start</button>
        <button style="color: red;" onclick="stopTimer()">Stop</button>
        <button style="color: rgb(2, 2, 146);" onclick="resetTimer()">Reset</button>
    </div>

    <div style="text-align:center; margin-top:50px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>
</body>
</html>
