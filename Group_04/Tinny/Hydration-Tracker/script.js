let goal = 0;
    let progress = 0;
    let history = [];
    let reminderTimer = null;

   
    if ("Notification" in window) {
      if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission();
      }
    }

    function showPage(pageId) {
      document.querySelectorAll('section').forEach(function(sec) {
        sec.classList.remove('active');
      });
      document.getElementById(pageId).classList.add('active');
    }

    function setGoal() {
      let weight = document.getElementById('weight').value;
      let activity = document.getElementById('activity').value;
      let error = document.getElementById('errorMsg');
      error.innerText = ""; 

      if (weight === '' || activity === '') {
        error.innerText = "Please fill in weight and activity level.";
        return;
      }

      if (weight < 20) {
        error.innerText = "Weight must be at least 20 kg.";
        return;
      }

      let base = weight * 30;
      if (activity === 'moderate') base += 500;
      if (activity === 'high') base += 1000;

      goal = Math.round(base / 250);
      progress = 0;

      document.getElementById('goalDisplay').innerText = "Goal: " + goal + " glasses";
      document.getElementById('progressDisplay').innerText = "Progress: " + progress + "/" + goal;
      document.getElementById('reminderMsg').innerText = "Keep drinking water to reach your goal!";
    }

    function logWater() {
      let error = document.getElementById('errorMsg');
      error.innerText = "";

      if (goal === 0) {
        error.innerText = "Please set a goal first.";
        return;
      }

      if (progress >= goal) {
        error.innerText = "Goal already completed! Set a new goal.";
        return;
      }

      progress++;
      let time = new Date().toLocaleTimeString();
      history.push({ glass: progress, time: time });

      document.getElementById('progressDisplay').innerText = "Progress: " + progress + "/" + goal;

      if (progress < goal) {
        document.getElementById('reminderMsg').innerText = "You still need " + (goal - progress) + " glasses!";
      } else {
        error.innerText = "Congratulations! Goal completed.";
        document.getElementById('reminderMsg').innerText = "Goal completed! You can set a new goal now.";
        clearInterval(reminderTimer);
        reminderTimer = null;
      }

      updateHistory();
    }

    function updateHistory() {
      let historyDiv = document.getElementById('historyList');
      historyDiv.innerHTML = '';

      history.forEach(function(entry) {
        let div = document.createElement('div');
        div.className = 'history-log';
        div.innerText = "Glass " + entry.glass + " at " + entry.time;
        historyDiv.appendChild(div);
      });
    }

    function startReminder() {
      let error = document.getElementById('errorMsg');
      error.innerText = "";

      if (goal === 0) {
        error.innerText = "Please set a goal in the tracker first.";
        return;
      }

      let minutes = document.getElementById('reminderInterval').value;
      if (minutes === '' || minutes <= 0) {
        error.innerText = "Please enter a valid reminder interval in minutes.";
        return;
      }

      if (reminderTimer) clearInterval(reminderTimer);

      reminderTimer = setInterval(function() {
        if (progress < goal) {
          
          alert("You still need to drink " + (goal - progress) + " glasses of water!");
        } else {
          clearInterval(reminderTimer);
          reminderTimer = null;
        }
      }, minutes * 60000);

      document.getElementById('reminderMsg').innerText = "Reminder set every " + minutes + " minutes.";
    }

    function stopReminder() {
      if (reminderTimer) {
        clearInterval(reminderTimer);
        reminderTimer = null;
        document.getElementById('reminderMsg').innerText = "Reminder stopped.";
      }
    }