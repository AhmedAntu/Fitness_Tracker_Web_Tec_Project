const challengeForm = document.getElementById("challengeForm");
if (challengeForm) {
  challengeForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const friend = document.getElementById("friend").value.trim();
    const type = document.getElementById("type").value;
    const target = document.getElementById("target").value;
    const date = new Date().toLocaleDateString();

    
    const friendError = document.getElementById("friendError");
    const typeError = document.getElementById("typeError");
    const targetError = document.getElementById("targetError");

    
    friendError.textContent = "";
    typeError.textContent = "";
    targetError.textContent = "";

    let isValid = true;

    
if (!friend) {
  friendError.textContent = "Friend name is required.";
  isValid = false;
} else {
  for (let i = 0; i < friend.length; i++) {
    const char = friend[i].toLowerCase();
    if (!((char >= 'a' && char <= 'z') || char === ' ')) {
      friendError.textContent = "Friend name can only contain letters and spaces.";
      isValid = false;
      break;
    }
  }
}


    
    if (!type) {
      typeError.textContent = "Please select a challenge type.";
      isValid = false;
    }

   
    if (!target || target <= 0) {
      targetError.textContent = "Target number must be at least 1.";
      isValid = false;
    }

    if (!isValid) return;

    const newChallenge = { friend: friend, type: type, target: target, date: date };

    let challenges = JSON.parse(sessionStorage.getItem("challenges")) || [];
    challenges.push(newChallenge);
    sessionStorage.setItem("challenges", JSON.stringify(challenges));

    challengeForm.reset();
    alert("Challenge added!");
  });
}



const cheerForm = document.getElementById("cheerForm");
const cheerBoard = document.getElementById("cheerBoard");

if (cheerForm && cheerBoard) {
  cheerForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const message = document.getElementById("cheerMessage").value.trim();
    if (!message) return;

    const li = document.createElement("li");
    li.textContent = message;
    cheerBoard.appendChild(li);

    cheerForm.reset();
  });
}



const leaderboardBody = document.getElementById("leaderboardBody");
if (leaderboardBody) {
  function renderLeaderboard() {
    leaderboardBody.innerHTML = ""; 
    const challenges = JSON.parse(sessionStorage.getItem("challenges")) || [];

    challenges.forEach(function(ch) {
      if (ch.friend && ch.type && ch.target) {
        const row = document.createElement("tr");

        row.innerHTML =
          "<td>" + ch.friend + "</td>" +
          "<td>" + ch.type + "</td>" +
          "<td>" + ch.target + "</td>" +
          "<td>" + ch.date + "</td>";

        leaderboardBody.appendChild(row);
      }
    });
  }

  renderLeaderboard();
}
